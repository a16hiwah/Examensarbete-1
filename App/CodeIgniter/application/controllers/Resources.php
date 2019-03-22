<?php
class Resources extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('resources_model');
	}

	public function index()
	{
		$this->load->view('resources/index');
	}

}