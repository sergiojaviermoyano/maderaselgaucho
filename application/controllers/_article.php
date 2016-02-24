<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class article extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Articles');
	}

	public function index($permission)
	{
		$data['list'] = $this->Articles->Articles_List();
		$data['permission'] = $permission;
		$this->load->view('articles/list', $data);
	}
	
	public function getArticle(){
		$data['data'] = $this->Articles->getArticle($this->input->post());
		$response['html'] = $this->load->view('articles/view_', $data, true);

		echo json_encode($response);
	}
	
	public function setArticle(){
		$data = $this->Articles->setArticle($this->input->post());
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