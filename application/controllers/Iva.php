<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class iva extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Ivas');
		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['list'] = $this->Ivas->IVA_List();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('ivas/list', $data, true));
	}
	
	public function getIVA(){
		$data['data'] = $this->Ivas->getIVA($this->input->post());
		$response['html'] = $this->load->view('ivas/view_', $data, true);

		echo json_encode($response);
	}
	
	public function setIVA(){
		$data = $this->Ivas->setIVA($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);	
		}
	}
	
}
