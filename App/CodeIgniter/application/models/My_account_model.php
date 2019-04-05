<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_account_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_user_resources($user_id)
	{
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('resources');
		return $query;
	}

	// Get all comments for a user based on the user id and get information
	// about the resources the comments are a part of.
	public function get_user_comments($user_id)
	{
		$this->db->select('comments.body, comments.created, resources.title, resources.slug');
		$this->db->join('resources', 'resources.id = comments.resource_id', 'inner');
		$this->db->where('comments.user_id', $user_id);
		$query = $this->db->get('comments');
		return $query;
	}

}
