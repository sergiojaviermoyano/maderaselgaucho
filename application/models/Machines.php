<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Machines extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function Machines_List(){

		$query= $this->db->get('maquinas');
		
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{
			return false;
		}
	}
	
	function getMachine($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$idMachine = $data['id'];

			$data = array();

			//Datos de la familia
			$query= $this->db->get_where('maquinas',array('idMaquina'=>$idMachine));
			if ($query->num_rows() != 0)
			{
				$f = $query->result_array();
				$data['machine'] = $f[0];
			} else {
				$famachinemily = array();
				$machine['descMaquina'] = '';
				$machine['estado'] = '';
				$data['machine'] = $machine;
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
	
	function setMachine($data = null){
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
					   'descMaquina' => $name,
					   'estado'		=> $esta
					);

			switch($act){
				case 'Add':
					//Agregar maquina
					if($this->db->insert('maquinas', $data) == false) {
						return false;
					}
					break;

				case 'Edit':
					//Actualizar maquina
					if($this->db->update('maquinas', $data, array('idMaquina'=>$id)) == false) {
						return false;
					}
					break;

				case 'Del':
					//Eliminar maquina
					if($this->db->delete('maquinas', $data, array('idMaquina'=>$id)) == false) {
						return false;
					}
					
					break;
			}

			return true;

		}
	}
}
?>