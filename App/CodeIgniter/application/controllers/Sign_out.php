<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sign_out extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url_helper');
		$this->load->library('session');
	}

	public function index()
	{
		if ($this->session->user_signed_in)
		{
			$this->session->sess_destroy();
			redirect('sign-in');
		}
	}

}
