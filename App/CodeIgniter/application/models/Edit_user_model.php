<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_user_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function edit_profile($data)
	{
		$this->db->set($data);
		$this->db->where('id', $this->session->user_id);
		if ($this->db->update('users'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function get_all_profile_imgs()
	{
		$query = $this->db->get('profile_images');
		return $query->result();
	}

	public function get_usr_info($user_id)
	{
		$this->db->select('image, biography, created');
		$this->db->where('id', $user_id);
		$query = $this->db->get('users');
		return $query->result()[0];
	}

}
