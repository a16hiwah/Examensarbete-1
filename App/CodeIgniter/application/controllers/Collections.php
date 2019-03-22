<?php
class Collections extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('collections_model');
	}

	public function index()
	{
		$this->load->view('collections/index');
	}

}