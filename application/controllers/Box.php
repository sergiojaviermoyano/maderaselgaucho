<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class box extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Boxs');
		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['list'] = $this->Boxs->Box_List();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('boxs/list', $data, true));
	}
	
	
	public function getCtaCte(){
		$data['data'] = $this->Boxs->getCtaCte($this->input->post());
		$response['html'] = $this->load->view('boxs/view_', $data, true);

		echo json_encode($response);
	}
	/*
	public function setWood(){
		$data = $this->Woods->setWood($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);	
		}
	}
	*/
	
}
