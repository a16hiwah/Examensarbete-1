<?php
class Resources extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('resources_model');
		$this->load->helper('url_helper');
	}

	public function index()
	{
		$data['title'] = 'Resurser';

		$this->load->view('templates/header', $data);
		$this->load->view('resources/index');
		$this->load->view('templates/footer');
	}

}
