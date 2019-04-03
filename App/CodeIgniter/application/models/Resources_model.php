<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resources_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function create_resource($data)
	{
		if ($this->db->insert('resources', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

}
