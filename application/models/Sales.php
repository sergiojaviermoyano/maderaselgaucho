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

			//Facturas
			$query = $this->db->query('
				Select cc.*
				From ccompra as cc
				Where prvId = '.$prvId.' 
				Order by cc.ccFecha desc');
			$data['facturas'] = $query->result_array();		
			
			//Ordenes de Pago
			$query = $this->db->query('
				Select *
				From opagoc
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

			$data = array(
					'prvId'			=> $prvId,
					'opObservacion' => $obsv
				);

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
}
?>