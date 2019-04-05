<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Search extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('search_model');
		$this->load->helper('url_helper');
	}

	public function find_resources()
	{
		$search_term = $this->input->post('search-box');
		$stop_search = FALSE;

		if ($search_term !== NULL)
		{
			if (strlen($search_term) > 0 && strlen($search_term) < 256)
			{
				$data['title'] = "Search results";
				$data['center_content'] = FALSE;
				$data['search_results'] = $this->search_model->find_resources($search_term);

				$this->load->view('templates/header', $data);
				$this->load->view('search/search_results', $data);
				$this->load->view('templates/footer');
			}
			else
			{
				$stop_search = TRUE;
			}
		}
		else
		{
			$stop_search = TRUE;
		}

		if ($stop_search)
		{
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

}
