<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Checks extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function Check_List(){

		$this->db->select('cheques.*, bancos.bancoDescripcion');
		$this->db->from('cheques');
		$this->db->join('bancos', 'bancos.bancoId = cheques.bancoId');
		$query= $this->db->get();
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{
			return false;
		}
	}

	function changeStatus($data = null){
		$id = $data['id'];
		$act = $data['act'];

		switch($act){
			
			case 'Deposit':
				$data = array(
					'cheEstado'	=> 'DP'
					);

				if($this->db->update('cheques', $data, array('cheId'=>$id)) == false) {
					return false;
				}
				break;
		}

		return true;
	}
	
	/*
	function getBook($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$id = $data['id'];

			$data = array();

			$query= $this->db->get_where('talonarios',array('idTalonario'=>$id));
			if ($query->num_rows() != 0)
			{
				$t = $query->result_array();
				$data['book'] = $t[0];
			} else {
				$book = array();
				$book['descTalonario'] = '';
				$book['pvTalonario'] = '';
				$book['numTaloario'] = '';
				$data['book'] = $book;
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
	
	function setBook($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$id = $data['id'];
			$act = $data['act'];
			$name = $data['name'];
			$pv   = $data['pv'];
			$num  = $data['num'];

			$data = array(
					   'descTalonario' 		=> $name,
					   'pvTalonario'		=> $pv,
					   'numTalonario'		=> $num
					);

			switch($act){
				
				case 'Edit':
					if($this->db->update('talonarios', $data, array('idTalonario'=>$id)) == false) {
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