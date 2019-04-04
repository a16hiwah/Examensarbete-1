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

	public function delete_resource($id, $user_id)
	{
		$this->db->where('id', $id);
		$this->db->where('user_id', $user_id);
		
		if ($this->db->delete('resources'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function get_resources_by_filter($filter)
	{
		if ($filter === '0-9')
		{
			$this->db->where('title REGEXP "^[0-9]"');
		}
		else
		{
			$this->db->where('title LIKE', $filter.'%');
		}
		$query = $this->db->get('resources');
		return $query;
	}

}
