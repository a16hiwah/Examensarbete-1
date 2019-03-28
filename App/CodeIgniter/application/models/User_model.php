<?php
class User_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function process_create_user($data)
	{
		if ($this->db->insert('users', $data))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

