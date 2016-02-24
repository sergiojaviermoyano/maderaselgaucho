<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Providers extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function Providers_List(){

		$this->db->order_by('razon_social', 'asc');
		
		$query= $this->db->get('proveedores');

		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{	
			return false;
		}
	}
	
	function getProvider($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$idPro = $data['id'];

			$data = array();

			//Datos del proveedor
			$query= $this->db->get_where('proveedores',array('id_proveedor'=>$idPro));
			if ($query->num_rows() != 0)
			{
				$p = $query->result_array();
				$data['provider'] = $p[0];
			} else {
				$Pro = array();
				$Pro['razon_social'] = '';
				$Pro['direccion'] = '';
				$Pro['telefono'] = '';
				$Pro['mail'] = '';
				$Pro['web'] = '';
				$Pro['observacion'] = '';
				$Pro['telefono2'] = '';
				$Pro['telefono3'] = '';
				$Pro['envios'] = '';
				$Pro['rv_Nombre'] = '';
				$Pro['rv_telefono'] = '';
				$Pro['rv_mail'] = '';
				$Pro['rp1_nombre'] = '';
				$Pro['rp2_nombre'] = '';
				$Pro['rp3_nombre'] = '';
				$Pro['rp1_telefono'] = '';
				$Pro['rp2_telefono'] = '';
				$Pro['rp3_telefono'] = '';
				$Pro['rp1_mail'] = '';
				$Pro['rp2_mail'] = '';
				$Pro['rp3_mail'] = '';
				$data['provider'] = $Pro;
			}

			//Readonly
			$readonly = false;
			if($action == 'Del' || $action == 'View'){
				$readonly = true;
			}
			$data['read'] = $readonly;

			//Products
			/*
			$query= $this->db->get_where('admproducts',array('prodStatus'=>'AC'));
			if ($query->num_rows() != 0)
			{
			 	$data['products'] = $query->result_array();	
			}
			*/
			return $data;
		}
	}
	
	function setProvider($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$id = $data['id'];
            $act = $data['act'];
            $rz = $data['rz'];
            $dir = $data['dir'];
            $env = $data['env'];
            $tel = $data['tel'];
            $tel2 = $data['tel2'];
            $tel3 = $data['tel3'];
            $mai = $data['mai'];
            $web = $data['web'];
            $obs = $data['obs'];
            $rvn = $data['rvn'];
            $rvt = $data['rvt'];
            $rvc = $data['rvc'];
            $rpt1 = $data['rpt1'];
            $rpc1 = $data['rpc1'];
            $rpn1 = $data['rpn1'];
            $rpn2 = $data['rpn2'];
            $rpt2 = $data['rpt2'];
            $rpc2 = $data['rpc2'];
            $rpn3 = $data['rpn3'];
            $rpt3 = $data['rpt3'];
            $rpc3 = $data['rpc3'];

			$data = array(
				   'razon_social' 	=> $rz,
				   'direccion' 		=> $dir,
				   'envios' 		=> $env,
				   'telefono' 		=> $tel,
				   'telefono2' 		=> $tel2,
				   'telefono3'		=> $tel3,
				   'mail'			=> $mai,
				   'web'			=> $web,
				   'observacion'	=> $obs, 
				   'rv_Nombre'		=> $rvn,
				   'rv_telefono'	=> $rvt,
				   'rv_mail'		=> $rvc,
				   'rp1_nombre'		=> $rpn1,
				   'rp1_telefono'	=> $rpt1,
				   'rp1_mail'		=> $rpc1,
				   'rp2_nombre'		=> $rpn2,
				   'rp2_telefono'	=> $rpt2,
				   'rp2_mail'		=> $rpc2,
				   'rp3_nombre'		=> $rpn3,
				   'rp3_telefono'	=> $rpt3,
				   'rp3_mail'		=> $rpc3
				);

			switch($act){
				case 'Add':
					//Agregar Proveedor 
					if($this->db->insert('proveedores', $data) == false) {
						return false;
					} 
					break;
				
				case 'Edit':
				 	//Actualizar Proveedor
				 	if($this->db->update('proveedores', $data, array('id_proveedor'=>$id)) == false) {
				 		return false;
				 	}
				 	break;
					
				case 'Del':
				 	//Eliminar Proveedor
				 	if($this->db->delete('proveedores', array('id_proveedor'=>$id)) == false) {
				 		return false;
				 	}
				 	break;
			}
			return true;

		}
	}
	
}
?>