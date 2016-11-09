<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Fiscals extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function Fiscal_List(){

		$query= $this->db->get('fiscal');
		
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{
			return false;
		}
	}
	
	function getFiscal($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$id = $data['id'];

			$data = array();

			$query= $this->db->get_where('fiscal',array('fisId'=>$id));
			if ($query->num_rows() != 0)
			{
				$f = $query->result_array();
				$data['fiscal'] = $f[0];
			} else {
				$fiscal = array();
				$fiscal['fisDescripcion'] = '';
				$fiscal['fisCodigo'] = '';
				$data['fiscal'] = $fiscal;
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
	
	function setFiscal($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$id = $data['id'];
			$act = $data['act'];
			$name = $data['name'];
			$por   = $data['por'];

			$data = array(
					   'fisDescripcion'		=> $name,
					   'fisCodigo'		=> $por
					);

			switch($act){
				case 'Add':
					if($this->db->insert('fiscal', $data) == false) {
						return false;
					}
					break;

				case 'Edit':
					if($this->db->update('fiscal', $data, array('fisId'=>$id)) == false) {
						return false;
					}
					break;

				case 'Del':
					if($this->db->delete('fiscal', $data, array('fisId'=>$id)) == false) {
						return false;
					}
					
					break;
			}


			return true;

		}
	}
}
?>