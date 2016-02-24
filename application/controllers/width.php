<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class width extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Widths');
		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['list'] = $this->Widths->Width_List();
		$data['permission'] = $permission;
		$this->load->view('widths/list', $data);
	}
	
	public function getWidth(){
		$data['data'] = $this->Widths->getWidth($this->input->post());
		$response['html'] = $this->load->view('widths/view_', $data, true);

		echo json_encode($response);
	}
	
	public function setWidth(){
		$data = $this->Widths->setWidth($this->input->post());
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
