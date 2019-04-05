<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function find_resources($search_term)
	{
		$this->db->like('title', $search_term);
		$query = $this->db->get('resources');
		return $query;
	}

}

