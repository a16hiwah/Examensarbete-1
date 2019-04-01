<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_account extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('my_account_model');
		$this->load->helper('url_helper');
		$this->load->library('session');
	}

	public function index()
	{
		if ( ! $this->session->user_signed_in)
		{
			redirect('sign-in');
		}
		else
		{
			$data['title'] = 'My account';
			$this->load->view('templates/header', $data);
			$this->load->view('my_account/index');
			$this->load->view('templates/footer');
		}
	}

}
