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

}
