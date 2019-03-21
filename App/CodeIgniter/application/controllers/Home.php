<?php
class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('home_model');
	}

	public function index()
	{
		$this->load->view('home/index');
	}

}