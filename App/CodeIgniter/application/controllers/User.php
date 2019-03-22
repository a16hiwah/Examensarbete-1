<?php
class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('url_helper');
	}

	public function index()
	{
		$data['title'] = 'Mina sidor';

		$this->load->view('templates/header', $data);
		$this->load->view('user/index');
		$this->load->view('templates/footer');
	}

}