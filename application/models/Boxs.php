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
			$query = $this->db->query('
				Select * 
				From ordendetrabajo
				Join remito On remito.ordId = ordendetrabajo.ordId 
				Where cliId = '.$cliId.' 
				Order by remFecha desc');
			$data['remitos'] = $query->result_array();

			//Facturas
			$query = $this->db->get_where('cventa', array('cliId' => $cliId));
			$data['facturas'] = $query->result_array();		
			
			//Tipo
			$data['type'] = $type;

			//Ordenes de Pago

			return $data;
		}
	}
	
	/*
	function setWood($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$id = $data['id'];
			$act = $data['act'];
			$name = $data['name'];
			$pice = $data['price'];
			$pulg = $data['pulg'];
			$esta = $data['esta'];

			$data = array(
					   'madDescripcion' 	=> $name,
					   'madEstado'			=> $esta,
					   'madPrecio'			=> $pice,
					   'madPrecioPulgada'	=> $pulg
					);

			switch($act){
				case 'Add':
					if($this->db->insert('maderas', $data) == false) {
						return false;
					}
					break;

				case 'Edit':
					if($this->db->update('maderas', $data, array('madId'=>$id)) == false) {
						return false;
					}
					break;

				case 'Del':
					if($this->db->delete('maderas', $data, array('madId'=>$id)) == false) {
						return false;
					}
					
					break;
			}

			return true;

		}
	}
	*/
}
?>