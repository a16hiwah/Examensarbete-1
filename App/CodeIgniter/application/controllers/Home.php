<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('home_model');
		$this->load->helper('url_helper');
	}

	public function index()
	{
		// The amount of resources to get
		$get_resrc_limit = 10;
		
		$data['title'] = 'Home';
		$data['center_content'] = FALSE;
		$data['latest_resources'] = $this->home_model->get_latest_resources($get_resrc_limit);

		$this->load->view('templates/header', $data);
		$this->load->view('home/index', $data);
		$this->load->view('templates/footer');
	}

}
