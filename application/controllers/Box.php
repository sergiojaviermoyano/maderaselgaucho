<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class box extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Boxs');
		$this->load->model('Banks');
		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['list'] = $this->Boxs->Box_List();
		$data['bancos'] = $this->Banks->getActiveBanks();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('boxs/list', $data, true));
	}
	
	
	public function getCtaCte(){
		$data['data'] = $this->Boxs->getCtaCte($this->input->post());
		$response['html'] = $this->load->view('boxs/view_', $data, true);

		echo json_encode($response);
	}
	
	public function getFactura(){
		$data['data'] = $this->Boxs->getFactura($this->input->post());
		$response['html'] = $this->load->view('boxs/factura_', $data, true);

		echo json_encode($response);
	}
	
	public function setFactura(){
		$data = $this->Boxs->setFactura($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);	
		}
	}

	public function setPay(){
		$data = $this->Boxs->setPay($this->input->post());
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
