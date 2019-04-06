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

	// Redirect if user is not signed in
	private function _check_session()
	{
		if ( ! $this->session->user_signed_in)
		{
			redirect('sign-in');
		}
	}

	public function overview()
	{
		$this->_check_session();

		$data['title'] = 'Overview';

		$this->load->view('templates/header', $data);
		$this->load->view('templates/subheader');
		$this->load->view('my_account/overview');
		$this->load->view('templates/footer');
	}

	public function my_resources()
	{
		$this->_check_session();

		$data['title'] = 'My Resources';
		$data['user_resources'] = $this->my_account_model->get_user_resources(
			$this->session->user_id
		);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/subheader');
		$this->load->view('my_account/my_resources', $data);
		$this->load->view('templates/footer');
	}

	public function my_collections()
	{
		$this->_check_session();

		$data['title'] = 'My Collections';

		$this->load->view('templates/header', $data);
		$this->load->view('templates/subheader');
		$this->load->view('my_account/my_collections');
		$this->load->view('templates/footer');
	}

	public function my_comments()
	{
		$this->_check_session();
		
		$data['title'] = 'My Comments';
		$data['user_comments'] = $this->my_account_model->get_user_comments(
			$this->session->user_id
		);
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/subheader');
		$this->load->view('my_account/my_comments', $data);
		$this->load->view('templates/footer');
	}

}
