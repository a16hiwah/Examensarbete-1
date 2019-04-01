<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function create_user($data)
	{
		if ($this->db->insert('users', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}
