<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sale extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Sales');
		$this->load->model('Banks');
		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['list'] = $this->Sales->Sale_List();
		$data['bancos'] = $this->Banks->getActiveBanks();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('sales/list', $data, true));
	}
	
	
	public function getCtaCte(){
		$data['data'] = $this->Sales->getCtaCte($this->input->post());
		$response['html'] = $this->load->view('sales/view_', $data, true);

		echo json_encode($response);
	}

	function getExtracto(){
		$data['data'] = $this->Sales->calcularExtracto($this->input->post());
		$response['html'] = $this->load->view('sales/extracto_', $data, true);

		echo json_encode($response);
	}

	public function loadFactura(){
		$data['data'] = $this->Sales->loadFactura($this->input->post());
		$response['html'] = $this->load->view('sales/factura', $data, true);

		echo json_encode($response);
	}

	public function getChequesActivos(){
		echo json_encode($this->Sales->getChequesActivos($this->input->post()));
	}

	public function getFactura_(){
		$data['data'] = $this->Sales->getFactura_($this->input->post());
		$response['html'] = $this->load->view('sales/facturaview_', $data, true);

		echo json_encode($response);
	}
	
	public function setFactura(){
		$data = $this->Sales->setFactura($this->input->post());
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
		$data = $this->Sales->setPay($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);	
		}
	}

	function getPago(){
		$data['data'] = $this->Sales->getPago($this->input->post());
		$response['html'] = $this->load->view('sales/pago_', $data, true);

		echo json_encode($response);
	}
}
