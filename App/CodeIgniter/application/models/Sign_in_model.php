<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sign_in_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function does_user_exist($username)
	{
		$this->db->where('username', $username);
		$query = $this->db->get('users');
		return $query;
	}
}
