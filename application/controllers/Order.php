<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class order extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Orders');
		$this->Users->updateSession(true);
	}

	public function reception($permission)
	{
		$data['list'] = $this->Orders->Reception_List();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('orders/listR', $data, true));
	}

	public function reception_pagination()
	{
		echo json_encode($this->Orders->Reception_List($this->input->post()));
	}

	public function production($permission)
	{
		$data['list'] = $this->Orders->Production_List();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('orders/listP', $data, true));
	}

	public function production_pagination()
	{
		echo json_encode($this->Orders->Production_List($this->input->post()));
	}
	
	public function getOrder(){
		$data['data'] = $this->Orders->getOrder($this->input->post());
		$response['html'] = $this->load->view('orders/view_', $data, true);

		echo json_encode($response);
	}
	
	public function setOrder(){
		$data = $this->Orders->setOrder($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode($data);	
		}
	}

	public function getLog(){
		$data['data'] = $this->Orders->getLog($this->input->post());
		$response['html'] = $this->load->view('orders/log_', $data, true);

		echo json_encode($response);
	}

	public function setReserve(){
		$data = $this->Orders->setReserve($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);	
		}	
	}	

	public function setEntregue(){
		$data = $this->Orders->setEntregue($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);	
		}
	}

	public function printOrder(){
		echo json_encode($this->Orders->printOrder($this->input->post()));
	}

	public function printRemite(){
		echo json_encode($this->Orders->printRemite($this->input->post()));
	}

	public function getProduction(){
		$data['data'] = $this->Orders->getProduction($this->input->post());
		$response['html'] = $this->load->view('orders/logProduction_', $data, true);

		echo json_encode($response);
	}
}