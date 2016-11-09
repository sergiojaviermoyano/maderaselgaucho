<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Ivas extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function IVA_List(){

		$query= $this->db->get('ivas');
		
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{
			return false;
		}
	}
	
	function getIVA($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$id = $data['id'];

			$data = array();

			$query= $this->db->get_where('ivas',array('ivaId'=>$id));
			if ($query->num_rows() != 0)
			{
				$f = $query->result_array();
				$data['iva'] = $f[0];
			} else {
				$iva = array();
				$iva['ivaCode'] = '';
				$iva['ivaDescription'] = '';
				$iva['ivaPorcent'] = '';
				$data['iva'] = $iva;
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
	
	function setIVA($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$id = $data['id'];
			$act = $data['act'];
			$name = $data['name'];
			$code = $data['code'];
			$por   = $data['por'];

			$data = array(
					   'ivaDescription'	=> $name,
					   'ivaCode'		=> $code,
					   'ivaPorcent'		=> $por
					);

			switch($act){
				case 'Add':
					if($this->db->insert('ivas', $data) == false) {
						return false;
					}
					break;

				case 'Edit':
					if($this->db->update('ivas', $data, array('ivaId'=>$id)) == false) {
						return false;
					}
					break;

				case 'Del':
					if($this->db->delete('ivas', $data, array('ivaId'=>$id)) == false) {
						return false;
					}
					
					break;
			}


			return true;

		}
	}
}
?>