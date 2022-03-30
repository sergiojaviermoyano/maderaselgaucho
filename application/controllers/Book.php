<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class book extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Books');
		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['list'] = $this->Books->Book_List();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('books/list', $data, true));
	}
	
	public function getBook(){
		$data['data'] = $this->Books->getBook($this->input->post());
		$response['html'] = $this->load->view('books/view_', $data, true);

		echo json_encode($response);
	}
	
	public function setBook(){
		$data = $this->Books->setBook($this->input->post());
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
