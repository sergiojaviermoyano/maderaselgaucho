<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Boxs extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function Box_List(){

		$this->db->select('cliId, cliNombre, cliApellido, cliDocumento, cliDomicilio, cliTipo');
		$this->db->from('clientes');
		$this->db->order_by('cliApellido','cliNombre');
		$this->db->where(array('cliEstado'=>'AC'));
		$query = $this->db->get();
		
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{
			return false;
		}
	}
	
	
	function getCtaCte($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$cliId 	= $data['cliId'];
			$type 	= $data['type'];

			$data = array();

			//Orden de Trabajo
			if($type == 'BL'){ //+ (b.artPrecio * (d.ivaPorcent / 100))
			$query = $this->db->query('
			Select r.*,
				(select sum((od.artPrecio * rd.remdCantidad) * 1.21) 
				from remitodetalle as rd 
				join ordendetrabajodetalle as od on od.orddId = rd.orddId 
				where rd.remId = r.remId) as total
			From remito as r
			Join ordendetrabajo as o On o.ordId = r.ordId 
			Where o.cliId = '.$cliId.'
			Order by r.remFecha desc');
			} else {
				$query = $this->db->query('
				Select r.*,
					(select sum(od.artPrecio * rd.remdCantidad) 
					from remitodetalle as rd 
					join ordendetrabajodetalle as od on od.orddId = rd.orddId 
					where rd.remId = r.remId) as total
				From remito as r
				Join ordendetrabajo as o On o.ordId = r.ordId 
				Where o.cliId = '.$cliId.'
				Order by r.remFecha desc');
			}
			$data['remitos'] = $query->result_array();

			//Facturas
			$query = $this->db->query('
				Select cv.*,  tl.descTalonario,
				(select sum((a.cvdCantidad * a.cvdPrecio) * 1.21) from cventadetalle as a where a.cvId = cv.cvId) as total
				From cventa as cv
				Join talonarios as tl On tl.idTalonario = cv.idTalonario 
				Where cliId = '.$cliId.' 
				Order by cv.cvFecha desc');
			$data['facturas'] = $query->result_array();		
			
			//Tipo
			$data['type'] = $type;

			//Ordenes de Pago
			$query = $this->db->query('
				Select a.*, (select sum(opImportePago) from opagodetalle as b where b.opId = a.opId ) as total
				From opago as a
				Where a.cliId = '.$cliId.' 
				Order by a.opFecha desc');
			$data['ordenes'] = $query->result_array();

			//Bancos
			$query = $this->db->query('
				Select *
				From bancos
				Where bancoEstado = \'AC\'
				Order by bancoDescripcion');
			$data['bancos'] = $query->result_array();	

			//Estado
			$estado = array();
			//Total de Pagos
			$query = $this->db->query('
				Select sum(opImportePago) as pagos 
				From opago
				join opagodetalle on opagodetalle.opId = opago.opId 
				Where cliId = '.$cliId); 
			$pagos = $query->result_array();
			$estado['pagos'] = $pagos[0]['pagos'];

			//Total deuda
			if($type == 'BL'){
				//Calcular sobre los comprobantes de venta
				$query = $this->db->query('
					Select sum(cvd.cvdCantidad * (cvd.cvdPrecio + (cvd.cvdPrecio * (cvd.cvdIvaPorcentaje / 100)))) as deuda
					From cventa as cv
					Join cventadetalle as cvd On cvd.cvId = cv.cvId
					Where cliId = '.$cliId);
				$deuda = $query->result_array();
				$estado['deuda'] = $deuda[0]['deuda'];
			} else {
				//Calcular sobre los remitos
				$query = $this->db->query('
					Select sum(remitodetalle.remdCantidad * ordendetrabajodetalle.artPrecio ) as deuda
					From ordendetrabajo
					Join remito On remito.ordId = ordendetrabajo.ordId 
					Join remitodetalle On remitodetalle.remId = remito.remId
					Join ordendetrabajodetalle On ordendetrabajodetalle.orddid = remitodetalle.orddId
					Where cliId = '.$cliId);
				$deuda = $query->result_array();
				$estado['deuda'] = $deuda[0]['deuda'];
			}

			$data['estado'] = $estado;

			return $data;
		}
	}

	function getFactura($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$list 	= $data['list'];
			$cliId  = $data['cliId'];
			
			$data = array();

			//Datos del Cliente
			$query = $this->db->get_where('clientes', array('cliId' => $cliId));
			$c = $query->result_array();
			$data['cliente'] = $c[0];

			//numero de remitos y detalle
			$articles = array();
			foreach ($list as $l) {
				$query = $this->db->query('
					Select r.remNumero, otd.artId, otd.artDescripcion, otd.artPrecio, rd.remdCantidad, otd.artIva 
					From remito as r 
					Join remitodetalle As rd On r.remId = rd.remId
					Join ordendetrabajodetalle As otd On rd.orddid = otd.orddid
					where r.remId = '.$l);

				foreach($query->result_array() as $a){
					$articles[] = $a;
				}
			}

			$data['list'] = $list;
			$data['cliId'] = $cliId;
			$data['articles'] = $articles;

			return $data;
		}
	}
	
	function setFactura($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$list 	= $data['list'];
			$cliId  = $data['cliId'];
			$fecha  = $data['fecha'];
			
			$info = $this->getFactura($data);
			$data = array();

			$this->db->trans_begin();

			$factura = array(
				'cvNumero' 		=> '',
				'idTalonario' 	=> '',
				'cliId'			=> $cliId,
				'cvRazonSocial' => $info['cliente']['cliApellido'].', '.$info['cliente']['cliNombre']
			);
			if($fecha != ''){
				$fecha = explode('-',$fecha);
				$factura['cvFecha'] = $fecha[2].'-'.$fecha[1].'-'.$fecha[0].' 01:00:00'; 
			}

			//Obtener numero de talonario 
			$query = $this->db->get_where('fiscal', array('fisId' => $info['cliente']['fisId']));
			$f = $query->result_array();
			$fiscal = $f[0];
			switch($fiscal['fisCodigo']){
				case 'RI':
					//Factura A
					$this->db->set('numTalonario', '`numTalonario`+ 1', FALSE);
					$this->db->where('descTalonario', 'Factura A');
					$this->db->update('talonarios');

					$query= $this->db->get_where('talonarios',array('descTalonario'=>'Factura A'));
					if ($query->num_rows() != 0) {
						$r = $query->result_array();
						$factura['cvNumero'] = str_pad($r[0]['pvTalonario'], 4, "0", STR_PAD_LEFT).'-'.str_pad($r[0]['numTalonario'], 8, "0", STR_PAD_LEFT);
						$factura['idTalonario'] = $r[0]['idTalonario'];
					}
					break;

				case 'CF':
					//Factura B
					$this->db->set('numTalonario', '`numTalonario`+ 1', FALSE);
					$this->db->where('descTalonario', 'Factura B');
					$this->db->update('talonarios');

					$query= $this->db->get_where('talonarios',array('descTalonario'=>'Factura B'));
					if ($query->num_rows() != 0) {
						$r = $query->result_array();
						$factura['cvNumero'] = str_pad($r[0]['pvTalonario'], 4, "0", STR_PAD_LEFT).'-'.str_pad($r[0]['numTalonario'], 8, "0", STR_PAD_LEFT);
						$factura['idTalonario'] = $r[0]['idTalonario'];
					}
					break;
			}

			//Insertar cabecera
			if($this->db->insert('cventa', $factura) == false) {
				return false;
			} 
			//Id del comprobante de venta
			$id = $this->db->insert_id();

			//Insertar cabeceras
			$detalle = array();
			foreach ($info['articles'] as $art) {
				if($art['remdCantidad'] > 0 ){

					//Buscar el porcentaje de iva para el articulo seleccionado
					$query = $this->db->query('
						Select i.* from ivas as i
						Join articulos As art On art.ivaId = i.ivaId
						where art.artId = '.$art['artId']);
					$iva = $query->result_array();

					$facDetalle = array(
							'cvId'				=> $id,
							'artId'				=> $art['artId'], 
							'artDescripcion'	=> $art['artDescripcion'], 
							'cvdCantidad'		=> $art['remdCantidad'], 
							'cvdPrecio'			=> $art['artPrecio'], 
							'cvdIvaPorcentaje'	=> $iva[0]['ivaPorcent']
						);

					$detalle[] = $facDetalle;

					if($this->db->insert('cventadetalle', $facDetalle) == false) {
						return false;
					} 
				}
			}

			//Calcular Ivas
			$query = $this->db->get_where('ivas', array('ivaEstado' => 'AC'));
			$ivas_ = array();
			foreach ($query->result_array() as $i) {
				$ivas_[] = array(
						'cvId'				=> $id,
						'cvIvaImporte'		=> 0, 
						'cvIvaDescripcion'	=> $i['ivaDescription'],
						'cvdIvaPorcentaje'	=> $i['ivaPorcent']
					);
			}

			foreach ($detalle as $d) {
				$ivaValor =  (($d['cvdCantidad'] * $d['cvdPrecio']) * $d['cvdIvaPorcentaje']) / 100;
				foreach ($ivas_ as &$i) {
					if($i['cvdIvaPorcentaje'] === $d['cvdIvaPorcentaje']){
						$i['cvIvaImporte'] = $i['cvIvaImporte'] + $ivaValor;
					}
				}
			}

			foreach ($ivas_ as $i__) {
				if($i__['cvIvaImporte'] > 0){
					$ivaDetalle = array(
						'cvId'				=> $i__['cvId'],
						'cvIvaImporte'		=> $i__['cvIvaImporte'],
						'cvIvaDescripcion' 	=> $i__['cvIvaImporte']
						);
					if($this->db->insert('cventaiva', $ivaDetalle) == false) {
						return false;
					} 	
				}
			}

			//Cambiar el estado de los remitos 
			$data = array('remEstado' => 'FA');
			foreach ($list as $l) {
					if($this->db->update('remito', $data, array('remId'=>$l)) == false) {
						return false;
					}

					$cvRem = array(
							'cvId'	=> $id,
							'remId'	=> $l
						);

					//Asociar el remito a el detalle del comprobante de venta
					if($this->db->insert('cventaremitos', $cvRem) == false) {
						return false;
					} 	
			}


			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
			        return false;
			}
			else
			{
			        $this->db->trans_commit();
			        return true;
			}
		}
	}

	function setPay($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$type 	= $data['type'];
			$cliId  = $data['cliId'];
			$obsv	= $data['obsv'];
			$efect	= $data['efect'];
            $cheq	= isset($data['cheq']) ? $data['cheq'] : array();
			$fecha 	= $data['fecha'];

			$data = array(
					'cliId'			=> $cliId,
					'opObservacion' => $obsv, 
					'opType'	=> $type
				);
				
			if($fecha != ''){
				$fecha = explode('-',$fecha);
				$data['opFecha'] = $fecha[2].'-'.$fecha[1].'-'.$fecha[0].' 01:00:00'; 
			}

			$this->db->trans_begin();

			//Insertar orden de pago
			if($this->db->insert('opago', $data) == false) {
				return false;
			} 	
			//Id de la orden de pago
			$id = $this->db->insert_id();

			//Pago con efectivo ?
			if($efect != ''){
				$detail = array(
						'opId'		=> $id, 
						'opMedPago'	=> 'EF',
						'opImportePago'	=> $efect
					);

				//Insertar detalla de pago con efectivo
				if($this->db->insert('opagodetalle', $detail) == false) {
					return false;
				}
			}

			//Hay cheques ?
			if(count($cheq) > 0){
				foreach ($cheq as $ch) {
					$date = explode('-', $ch[1]);
					$banco = explode('#', $ch[3]);
					$insertCh = array(
							'cheNumero'			=> $ch[0], 
							'cheImporte'		=> $ch[2],
							'cheVencimiento'	=> $date[2].'-'.$date[1].'-'.$date[0],
							'bancoId'			=> $banco[0],
							'cheType'			=> $type
						);

					if($this->db->insert('cheques', $insertCh) == false) {
						return false;
					} else {
						//Id del cheque insertado
						$idC = $this->db->insert_id();
						$detail = array(
								'opId'			=> $id, 
								'opMedPago'		=> 'CH',
								'opImportePago'	=> $ch[2],
								'chequeId'		=> $idC 
							);

						//Insertar detalla de pago con efectivo
						if($this->db->insert('opagodetalle', $detail) == false) {
							return false;
						}
					}

				}
			}


			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
			        return false;
			}
			else
			{
			        $this->db->trans_commit();
			        return true;
			}
		}

		return true;
	}

	function getPago($data){
		if($data == null)
		{
			return false;
		}
		else
		{
			$oPago = array();
			$opId = $data['opId'];
			$this->db->select('*');
			$this->db->from('opago');
			$this->db->where(array('opId' => $opId));
			$query = $this->db->get();
			
			$orden = $query->result_array();
			$oPago['orden'] = $orden[0];

			$this->db->select('*')
			->from('opagodetalle')
			->join('cheques', 'cheques.cheId = opagodetalle.chequeId', 'left')
			->join('bancos', 'bancos.bancoId = cheques.bancoId', 'left')
			->where(array('opId' => $opId));
			$query = $this->db->get();
		
			$oPago['ordenDetalle'] = $query->result_array();
			
			return $oPago;
			//var_dump($oPago);
		}
	}

	function getFactura_($data){
		if($data == null)
		{
			return false;
		}
		else
		{
			$cventa = array();
			$cvId = $data['cvId'];
			$this->db->select('cventa.*, talonarios.descTalonario')
			->from('cventa')
			->join('talonarios', 'talonarios.idTalonario = cventa.idTalonario ')
			->where(array('cvId' => $cvId));
			$query = $this->db->get();
			
			$comprobante = $query->result_array();
			$cventa['comprobante'] = $comprobante[0];

			$this->db->select('*')
			->from('cventadetalle')
			->where(array('cvId' => $cvId));
			$query = $this->db->get();
		
			$cventa['detalle'] = $query->result_array();
			
			return $cventa;
			//var_dump($oPago);
		}
	}
}
?>