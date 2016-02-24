<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Widths extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function Width_List(){

		$query= $this->db->get('espesor');
		
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{
			return false;
		}
	}
	
	function getWidth($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$idWidth = $data['id'];

			$data = array();

			//Datos del usuario
			$query= $this->db->get_where('espesor',array('idEspesor'=>$idWidth));
			if ($query->num_rows() != 0)
			{
				$u = $query->result_array();
				$data['width'] = $u[0];
			} else {
				$width = array();
				$width['descEspesor'] = '';
				$width['estado'] = '';
				$data['width'] = $width;
			}

			//Readonly
			$readonly = false;
			if($action == 'Del' || $action == 'View'){
				$readonly = true;
			}
			$data['read'] = $readonly;

			return $data;
		}
	}
	
	function setWidth($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$id = $data['id'];
			$act = $data['act'];
			$name = $data['name'];
			$esta = $data['esta'];

			$data = array(
					   'descEspesor' => $name,
					   'estado'		=> $esta
					);

			switch($act){
				case 'Add':
					//Agregar espesor
					if($this->db->insert('espesor', $data) == false) {
						return false;
					}
					break;

				case 'Edit':
					//Actualizar espesor
					if($this->db->update('espesor', $data, array('idEspesor'=>$id)) == false) {
						return false;
					}
					break;

				case 'Del':
					//Eliminar espesor
					if($this->db->delete('espesor', $data, array('idEspesor'=>$id)) == false) {
						return false;
					}
					
					break;
			}

			return true;

		}
	}
}
?>