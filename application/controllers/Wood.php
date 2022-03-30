<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class wood extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Woods');
		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['list'] = $this->Woods->Wood_List();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('woods/list', $data, true));
	}
	
	public function getWood(){
		$data['data'] = $this->Woods->getWood($this->input->post());
		$response['html'] = $this->load->view('woods/view_', $data, true);
		echo json_encode($response);
	}
	
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
	
}
