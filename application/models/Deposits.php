<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Deposits extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function Deposit_List(){

		$query= $this->db->get('depositos');
		
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{
			return false;
		}
	}
	
	function getDeposit($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$id = $data['id'];

			$data = array();

			$query= $this->db->get_where('depositos',array('depId'=>$id));
			if ($query->num_rows() != 0)
			{
				$m = $query->result_array();
				$data['deposit'] = $m[0];
			} else {
				$deposit = array();
				$deposit['depNombre'] = '';
				$deposit['depEstado'] = '';
				$data['deposit'] = $deposit;
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
	
	function setDeposit($data = null){
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
					   'depNombre' 		=> $name,
					   'depEstado'		=> $esta
					);

			switch($act){
				case 'Add':
					if($this->db->insert('depositos', $data) == false) {
						return false;
					}
					break;

				case 'Edit':
					if($this->db->update('depositos', $data, array('depId'=>$id)) == false) {
						return false;
					}
					break;

				case 'Del':
					if($this->db->delete('depositos', $data, array('depId'=>$id)) == false) {
						return false;
					}
					
					break;
			}

			return true;

		}
	}
}
?>