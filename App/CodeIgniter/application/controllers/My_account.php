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
			redirect('my-account/overview');
		}
	}

	public function overview()
	{
		$data['title'] = 'Overview';
		$data['center_content'] = FALSE;

		$this->load->view('templates/header', $data);
		$this->load->view('templates/my_account_nav');
		$this->load->view('my_account/overview');
		$this->load->view('templates/footer');
	}

	public function my_resources()
	{
		$data['title'] = 'My Resources';
		$data['center_content'] = FALSE;
		$data['user_resources'] = $this->my_account_model->get_user_resources(
			$this->session->user_id
		);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/my_account_nav');
		$this->load->view('my_account/my_resources', $data);
		$this->load->view('templates/footer');
	}

	public function my_collections()
	{
		$data['title'] = 'My Collections';
		$data['center_content'] = FALSE;

		$this->load->view('templates/header', $data);
		$this->load->view('templates/my_account_nav');
		$this->load->view('my_account/my_collections');
		$this->load->view('templates/footer');
	}

	public function my_comments()
	{
		$data['title'] = 'My Comments';
		$data['center_content'] = FALSE;
		$data['user_comments'] = $this->my_account_model->get_user_comments(
			$this->session->user_id
		);
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/my_account_nav');
		$this->load->view('my_account/my_comments', $data);
		$this->load->view('templates/footer');
	}

}
