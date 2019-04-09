<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Show_user extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('show_user_model');
		$this->load->helper('url_helper');
	}

	public function show_user($username)
	{
		$data['title'] = "User overview";
		$data['username_search'] = $username;
		$data['user_info'] = $this->show_user_model->get_user($username);

		$this->load->view('templates/header', $data);
		$this->load->view('show_user/show_user', $data);
		$this->load->view('templates/footer');
	}

}
