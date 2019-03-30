<?php
class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('home_model');
		$this->load->helper('url_helper');
	}

	public function index()
	{
		$data['title'] = 'Hem';

		$this->load->view('templates/header', $data);
		$this->load->view('home/index');
		$this->load->view('templates/footer');
	}

}
