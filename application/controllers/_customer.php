<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class customer extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Customers');
	}

	public function index($permission)
	{
		$data['list'] = $this->Customers->Customers_List();
		$data['permission'] = $permission;
		$this->load->view('customers/list', $data);
	}
	
	public function getCustomer(){
		$data['data'] = $this->Customers->getCustomer($this->input->post());
		$response['html'] = $this->load->view('customers/view_', $data, true);

		echo json_encode($response);
	}
	
	public function setCustomer(){
		$data = $this->Customers->setCustomer($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);	
		}
	}

	public function visits(){
		$data = $this->Customers->visits($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode($data);	
		}
	}

	public function status(){
		$data['data'] = $this->Customers->status($this->input->post());
		$response['html'] = $this->load->view('calendar/status_', $data, true);

		echo json_encode($response);
	}
}