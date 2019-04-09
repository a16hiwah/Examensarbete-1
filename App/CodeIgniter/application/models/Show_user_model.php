<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Show_user_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	// Get user and profile image info
	public function get_user($username)
	{
		$this->db->select('username, image, biography, created, profile_images.img_src');
		$this->db->join('profile_images', 'users.image = profile_images.id', 'inner');
		$this->db->where('username', $username);
		$query = $this->db->get('users');
		return $query;
	}
}
