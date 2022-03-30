<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class deposit extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Deposits');
		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['list'] = $this->Deposits->Deposit_List();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('deposits/list', $data, true));
	}
	
	
	public function getDeposit(){
		$data['data'] = $this->Deposits->getDeposit($this->input->post());
		$response['html'] = $this->load->view('deposits/view_', $data, true);
		echo json_encode($response);
	}
	
	public function setDeposit(){
		$data = $this->Deposits->setDeposit($this->input->post());
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