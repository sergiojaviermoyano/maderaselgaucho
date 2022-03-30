<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Stocks extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function getStockByArtId($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			//Fecha 
			$df = $data['dtFrm'];
			$dt = $data['dtTo'];

			$artId = $data['artId'];
			$depId = $data['depId'];

			$dtFrm = explode('-', $df);
			$dtFrm = $dtFrm[2].'-'.$dtFrm[1].'-'.$dtFrm[0];
			$dtTo = explode('-', $dt);
			$dtTo = $dtTo[2].'-'.$dtTo[1].'-'.$dtTo[0];
			$fecha = date($dtTo);
			$nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
			$dtTo = date ('Y-m-j' , $nuevafecha );

			$data = array();


			//Fecha 
			$data['dateF'] = $df;
			$data['dateT'] = $dt;

			//Movimientos
			$this->db->select('*');
			$this->db->from('stock');
			if($depId == -1)
				$this->db->where(array('stkFecha >=' => $dtFrm, 'stkFecha <= ' => $dtTo, 'artId' => $artId));
			else
				$this->db->where(array('stkFecha >=' => $dtFrm, 'stkFecha <= ' => $dtTo, 'artId' => $artId, 'depId' => $depId));
			$query= $this->db->get();
			$data['mov'] = $query->result_array();

			//Stock Filtro
			$this->db->select('sum(stkCant) as cant');
			$this->db->from('stock');
			if($depId == -1)
				$this->db->where(array('stkFecha >=' => $dtFrm, 'stkFecha <= ' => $dtTo, 'artId' => $artId));
			else
				$this->db->where(array('stkFecha >=' => $dtFrm, 'stkFecha <= ' => $dtTo, 'artId' => $artId, 'depId' => $depId));
			$query= $this->db->get();
			$data['stkF'] = $query->result_array();

			//Stock Actual
			$stk = array(
						'artId' => $artId,
						'depId' => $depId
						);
			$data['stk'] = $this->getStock($stk);

			//Articulo
			$this->db->select('artDescripcion, artId');
			$this->db->from('articulos');
			$this->db->where(array('artId' => $artId));
			$query= $this->db->get();
			$data['art'] = $query->result_array();

			return $data;
		}


	}

	function getStock($data = null){
		if($data == null){
			return false;
		} else {
			$this->db->select('sum(stkCant) as cant');
			$this->db->from('stock');
			if($data['depId'] == -1)
				$this->db->where(array('artId' => $data['artId']));
			else
				$this->db->where(array('artId' => $data['artId'], 'depId' => $data['depId']));
			$query= $this->db->get();
			return $query->result_array();
		}
	}

	function setFit($data = null){
		if($data == null) {
			return false;
		} else {
			$dep = $data['depId'];
			$art = $data['artId'];
			$cnt = $data['cant'];

			//Agregar Ajuste
			$data = array(
			   'depId'			=> $dep,
			   'artId' 			=> $art,
			   'stkCant'		=> $cnt,
			   'stkOrigen'		=> 'AJ'
			);

			if($this->db->insert('stock', $data) == false) {
				return false;
			}

			return true;
		}
	}
}
?>