<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Show_user_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	// Get user and profile image info based on username
	public function get_user($username)
	{
		$this->db->select('username, image, biography, created, profile_images.img_src');
		$this->db->join('profile_images', 'users.image = profile_images.id', 'inner');
		$this->db->where('username', $username);
		$query = $this->db->get('users');
		return $query;
	}

	// Get user and profile image info based on user id
	public function get_resrc_creator($user_id)
	{
		$this->db->select('username, image, created, profile_images.img_src');
		$this->db->join('profile_images', 'users.image = profile_images.id', 'inner');
		$this->db->where('users.id', $user_id);
		$query = $this->db->get('users');
		return $query;
	}
}
