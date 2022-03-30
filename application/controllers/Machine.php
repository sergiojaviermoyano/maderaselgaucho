<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class machine extends CI_Controller {
	function __construct()
        {
		parent::__construct();
		$this->load->model('Machines');
		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['list'] = $this->Machines->Machines_List();
		$data['permission'] = $permission;
		$this->load->view('machines/list', $data);
	}
	
	public function getMachine(){
		$data['data'] = $this->Machines->getMachine($this->input->post());
		$response['html'] = $this->load->view('machines/view_', $data, true);

		echo json_encode($response);
	}
	
	public function setMachine(){
		$data = $this->Machines->setMachine($this->input->post());
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
