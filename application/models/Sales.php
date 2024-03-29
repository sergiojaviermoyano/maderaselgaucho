<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Sales extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function Sale_List(){

		$this->db->select('prvId, prvNombre, prvApellido, prvRazonSocial, prvDocumento, prvDomicilio');
		$this->db->from('proveedores');
		$this->db->order_by('prvRazonSocial', 'prvApellido','prvNombre');
		$this->db->where(array('prvEstado'=>'AC'));
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
			$prvId 	= $data['prvId'];

			$data = array();
			$data['prvId'] = $prvId;

			//Facturas
			$query = $this->db->query('
				Select cc.*, (select sum(cd.ccdCantidad * cd.ccdPrecio) from ccompradetalle as cd where cd.ccId = cc.ccId) as total
				From ccompra as cc
				Where prvId = '.$prvId.' 
				Order by cc.ccFecha desc');
			$data['facturas'] = $query->result_array();		
			
			//Ordenes de Pago
			$query = $this->db->query('
				Select op.*, (select sum(opd.opImportePago) from opagocdetalle as opd where opd.opId = op.opId) as total 
				From opagoc as op
				Where prvId = '.$prvId.' 
				Order by opFecha desc');
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
				From opagoc
				join opagocdetalle on opagocdetalle.opId = opagoc.opId 
				Where prvId = '.$prvId); 
			$pagos = $query->result_array();
			$estado['pagos'] = $pagos[0]['pagos'];

			//Total deuda
			//Calcular sobre los comprobantes de venta
			$query = $this->db->query('
				Select sum(ccd.ccdPrecio) as deuda
				From ccompra as cc
				Join ccompradetalle as ccd On ccd.ccId = cc.ccId
				Where prvId = '.$prvId);
			$deuda = $query->result_array();
			$estado['deuda'] = $deuda[0]['deuda'];

			$data['estado'] = $estado;

			return $data;
		}
	}

	function loadFactura($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$prvId  = $data['prvId'];
			
			$data = array();
			
			//Datos del Proveedor
			$query = $this->db->get_where('proveedores', array('prvId' => $prvId));
			$c = $query->result_array();
			$data['proveedor'] = $c[0];

			$data['prvId'] = $prvId;
			
			//Ivas
			$query = $this->db->query('
				Select *
				From ivas
				Where ivaEstado = \'AC\'
				Order by ivaDescription');
			$data['ivas'] = $query->result_array();	
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
			$prvId  = $data['prvId'];
			$tipo 	= $data['tipo'];
			$nro 	= $data['nro'];
			$fecha	= $data['fecha'];
			
			$data = array();

			//Datos del Proveedor
			$query = $this->db->get_where('proveedores', array('prvId' => $prvId));
			$c = $query->result_array();
			$proveedor = $c[0];

			$this->db->trans_begin();

			$factura = array(
				'ccNumero' 		=> $nro,
				'ccTipo' 		=> $tipo,
				'prvId'			=> $prvId,
				'ccRazonSocial' => $proveedor['prvRazonSocial']
			);

			if($fecha != ''){
				$fecha = explode('-',$fecha);
				$factura['ccFecha'] = $fecha[2].'-'.$fecha[1].'-'.$fecha[0].' 02:00:00'; 
			}

			//Insertar cabecera
			if($this->db->insert('ccompra', $factura) == false) {
				return false;
			} 
			//Id del comprobante de venta
			$id = $this->db->insert_id();

			//Insertar detalle
			$detalle = array();
			// var obj = [detalle , iva, importe];
			foreach ($list as $art) {
				if($art[2] > 0 ){

					$facDetalle = array(
							'ccId'				=> $id,
							'artDescripcion'	=> $art[0], 
							'ccdCantidad'		=> 1, 
							'ccdPrecio'			=> $art[2], 
							'ccdIvaPorcentaje'	=> $art[1]
						);

					$detalle[] = $facDetalle;

					if($this->db->insert('ccompradetalle', $facDetalle) == false) {
						return false;
					} 
				}
			}

			//Calcular Ivas
			$query = $this->db->get_where('ivas', array('ivaEstado' => 'AC'));
			$ivas_ = array();
			foreach ($query->result_array() as $i) {
				$ivas_[] = array(
						'ccId'				=> $id,
						'ccIvaImporte'		=> 0, 
						'ccIvaDescripcion'	=> $i['ivaDescription'],
						'ccdIvaPorcentaje'	=> $i['ivaPorcent']
					);
			}

			foreach ($detalle as $d) {
				$ivaValor =  ($d['ccdPrecio'] * $d['ccdIvaPorcentaje']) / 100;
				foreach ($ivas_ as &$i) {
					if($i['ccdIvaPorcentaje'] === $d['ccdIvaPorcentaje']){
						$i['ccIvaImporte'] = $i['ccIvaImporte'] + $ivaValor;
					}
				}
			}

			foreach ($ivas_ as $i__) {
				if($i__['ccIvaImporte'] > 0){
					$ivaDetalle = array(
						'ccId'				=> $i__['ccId'],
						'ccIvaImporte'		=> $i__['ccIvaImporte'],
						'ccIvaDescripcion' 	=> $i__['ccIvaDescripcion']
						);
					if($this->db->insert('ccompraiva', $ivaDetalle) == false) {
						return false;
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
	}

	function getChequesActivos(){
		$this->db->select('cheques.*, bancos.bancoDescripcion');
		$this->db->from('cheques');
		$this->db->join('bancos', 'bancos.bancoId = cheques.bancoId');
		$this->db->order_by('cheVencimiento');
		$this->db->where(array('cheEstado'=>'AC'));
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
	
	function setPay($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$prvId  = $data['prvId'];
			$obsv	= $data['obsv'];
			$efect	= $data['efect'];
            $cheq	= isset($data['cheq']) ? $data['cheq'] : array();
			$fecha	= $data['fecha'];

			$data = array(
					'prvId'			=> $prvId,
					'opObservacion' => $obsv
				);

			if($fecha != ''){
				$fecha = explode('-',$fecha);
				$data['opFecha'] = $fecha[2].'-'.$fecha[1].'-'.$fecha[0].' 02:00:00'; 
			}

			$this->db->trans_begin();

			//Insertar orden de pago
			if($this->db->insert('opagoc', $data) == false) {
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
				if($this->db->insert('opagocdetalle', $detail) == false) {
					return false;
				}
			}

			//Hay cheques ?
			//var obj = [id, nro , vto, importe, banco, tipo];
			if(count($cheq) > 0){
				foreach ($cheq as $ch) {

					$date = explode('-', $ch[2]);
					$banco = explode('#', $ch[4]);
					if($ch[5] == 'P'){
						$insertCh = array(
								'cheNumero'			=> $ch[1], 
								'cheImporte'		=> $ch[3],
								'cheVencimiento'	=> $date[2].'-'.$date[1].'-'.$date[0],
								'bancoId'			=> $banco[0],
								'cheTipo'			=> 'PR',
								'cheEstado'			=> 'UT'
							);

						if($this->db->insert('cheques', $insertCh) == false) {
							return false;
						} else {
							//Id del cheque insertado
							$idC = $this->db->insert_id();
							$detail = array(
									'opId'			=> $id, 
									'opMedPago'		=> 'CH',
									'opImportePago'	=> $ch[3],
									'chequeId'		=> $idC 
								);

							//Insertar detalla de pago con cheque propio
							if($this->db->insert('opagocdetalle', $detail) == false) {
								return false;
							}
						}
					} else {
						$detail = array(
								'opId'			=> $id, 
								'opMedPago'		=> 'CH',
								'opImportePago'	=> $ch[3],
								'chequeId'		=> $ch[0] 
							);

						//Insertar detalla de pago con cheque de tercero
						if($this->db->insert('opagocdetalle', $detail) == false) {
							return false;
						} else{
							//Actualizar el estado del cheque a utilizado
							$che = array(
								'cheEstado' => 'UT'
								);
							if($this->db->update('cheques', $che, array('cheId'=>$ch[0])) == false) {
								return false;
							}
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

	function getFactura_($data){
		if($data == null)
		{
			return false;
		}
		else
		{
			$ccompra = array();
			$ccId = $data['ccId'];
			$this->db->select('ccompra.*')
			->from('ccompra')
			->where(array('ccId' => $ccId));
			$query = $this->db->get();
			
			$comprobante = $query->result_array();
			$ccompra['comprobante'] = $comprobante[0];

			$this->db->select('*')
			->from('ccompradetalle')
			->where(array('ccId' => $ccId));
			$query = $this->db->get();
		
			$ccompra['detalle'] = $query->result_array();
			
			return $ccompra;
		}
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
			$this->db->from('opagoc');
			$this->db->where(array('opId' => $opId));
			$query = $this->db->get();
			
			$orden = $query->result_array();
			$oPago['orden'] = $orden[0];

			$this->db->select('*')
			->from('opagocdetalle')
			->join('cheques', 'cheques.cheId = opagocdetalle.chequeId', 'left')
			->join('bancos', 'bancos.bancoId = cheques.bancoId', 'left')
			->where(array('opId' => $opId));
			$query = $this->db->get();
		
			$oPago['ordenDetalle'] = $query->result_array();
			
			return $oPago;
			//var_dump($oPago);
		}
	}

	function calcularExtracto($data){
		$prvId 	= $data['prvId']; 
		$desde	= $data['from'];
		$hasta	= $data['to'];

		$desde = explode('-',$desde);
		$desde = $desde[2].'-'.$desde[1].'-'.$desde[0].' 00:00:00'; 

		$hasta = explode('-',$hasta);
		$hasta = $hasta[2].'-'.$hasta[1].'-'.$hasta[0].' 23:59:59'; 
		//Calcular el saldo
		$data= array();
		//Saldo debe
		//Facturas
		$query = $this->db->query('
		Select (select sum(cd.ccdCantidad * cd.ccdPrecio) from ccompradetalle as cd where cd.ccId = cc.ccId) as total
			From ccompra as cc
			Where prvId = '.$prvId.' and cc.ccFecha < \''.$desde.'\' ');

		$data['saldoDebe'] = 0;
		foreach($query->result_array() as $item){
			$data['saldoDebe'] += $item['total'];

		}
	
		//Saldo haber
		$query = $this->db->query('
				Select (select sum(opd.opImportePago) from opagocdetalle as opd where opd.opId = op.opId) as total 
				From opagoc as op
				Where prvId = '.$prvId.'  and op.opFecha < \''.$desde.'\' ');

		$data['saldoHaber'] = 0;
		foreach($query->result_array() as $item){
			$data['saldoHaber'] += $item['total'];
		}

		
		//---------------------------------------------------------------------------------------
		$query1 = '
				Select 
					cc.ccNumero as id, 
					cc.ccTipo as tipoComp, 
					(select sum(cd.ccdCantidad * cd.ccdPrecio) from ccompradetalle as cd where cd.ccId = cc.ccId) as total,
					cc.ccFecha as fecha,
					1 as tipo
				From ccompra as cc
				Where prvId = '.$prvId.' and cc.ccFecha between \''.$desde.'\' and \''.$hasta.'\' ';
		
		$query2 = '
				Select 
					op.opId as id,
					1 as tipoComp, 
					(select sum(opd.opImportePago) from opagocdetalle as opd where opd.opId = op.opId) as total,
					opFecha as fecha,
					0 as tipo 
				From opagoc as op
				Where prvId = '.$prvId.' and opFecha between \''.$desde.'\' and \''.$hasta.'\' ';
	
		$query = $this->db->query('( ' .$query1. ' ) union (' .$query2 .' ) order by fecha asc ');
		$data['debe'] = $query->result_array();
		//---------------------------------------------------------------------------------------

		return $data;
	}
}
?>