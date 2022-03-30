<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class stock extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Articles');
		$this->load->model('Deposits');
		$this->load->model('Stocks');
		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['articles'] = $this->Articles->searchByAllNotSingle();
		$data['deposits'] = $this->Deposits->Deposit_List();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('stocks/list', $data, true));
	}

	public function getStockByArtId(){
		$data['data'] = $this->Stocks->getStockByArtId($this->input->post());
		$response['html'] = $this->load->view('stocks/view_', $data, true);
		echo json_encode($response);
	}

	public function getFitByArtId(){
		$data['articles'] = $this->Articles->Articles_List();
		$data['deposits'] = $this->Deposits->Deposit_List();
		$response['html'] = $this->load->view('stocks/fit_', $data, true);
		echo json_encode($response);
	}

	public function setFit(){
		$data = $this->Stocks->setFit($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);	
		}
	}

	public function getStock(){
		$data = $this->Stocks->getStock($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode($data);	
		}	
	}

	/*
	public function pagination()
	{
		echo json_encode($this->Boxs->Box_List($this->input->post()));
	}
	
	
	public function getBox(){
		$data['data'] = $this->Boxs->getBox($this->input->post());
		$response['html'] = $this->load->view('boxs/view_', $data, true);
		echo json_encode($response);
	}
	
	public function setBox(){
		$data = $this->Boxs->setBox($this->input->post());
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