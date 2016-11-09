<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Woods extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function Wood_List(){

		$query= $this->db->get('maderas');
		
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{
			return false;
		}
	}
	
	function getWood($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$id = $data['id'];

			$data = array();

			$query= $this->db->get_where('maderas',array('madId'=>$id));
			if ($query->num_rows() != 0)
			{
				$m = $query->result_array();
				$data['wood'] = $m[0];
			} else {
				$wood = array();
				$wood['madDescripcion'] = '';
				$wood['madEstado'] = '';
				$wood['madPrecio'] = '';
				$wood['madPrecioPulgada'] = '';
				$data['wood'] = $wood;
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
}
?>