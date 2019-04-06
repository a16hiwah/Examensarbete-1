<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	// Get the latest resources; $limit decides how many
	public function get_latest_resources($limit)
	{
		$this->db->select('resources.title, resources.slug, resources.created');
		$this->db->order_by('created', 'DESC');
		$this->db->limit($limit);
		$query = $this->db->get('resources');
		return $query;
	}

}
