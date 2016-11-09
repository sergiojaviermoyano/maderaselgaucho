<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class fiscal extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Fiscals');
		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['list'] = $this->Fiscals->Fiscal_List();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('fiscals/list', $data, true));
	}
	
	public function getFiscal(){
		$data['data'] = $this->Fiscals->getFiscal($this->input->post());
		$response['html'] = $this->load->view('fiscals/view_', $data, true);

		echo json_encode($response);
	}
	
	public function setFiscal(){
		$data = $this->Fiscals->setFiscal($this->input->post());
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
