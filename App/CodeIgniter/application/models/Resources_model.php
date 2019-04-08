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

	public function edit_resource($id, $user_id, $data)
	{
		$this->db->set($data);
		$this->db->where('id', $id);
		$this->db->where('user_id', $user_id);
		if ($this->db->update('resources'))
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
		if ($this->_delete_resrc_comments($id))
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
	}

	// Delete comments from resource before deleting it because of foreign key constraint
	private function _delete_resrc_comments($resrc_id)
	{
		$this->db->where('comments.resource_id', $resrc_id);
		
		if ($this->db->delete('comments'))
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

	// Get resource based on its slug
	public function get_resource_by_slug($slug)
	{
		$this->db->where('slug', $slug);
		$query = $this->db->get('resources');
        return $query;
	}

	// Get resource based on its id and user id
	public function get_resource_by_ids($id, $user_id)
	{
		$this->db->where('id', $id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('resources');
        return $query->result();
	}

	public function create_comment($data)
	{
		// Add comment to database
		if ($this->db->insert('comments', $data))
		{
			// Update resource to reflect the total amount of comments it has
			$this->db->set('num_of_comments', 'num_of_comments+1', FALSE);
			$this->db->where('resources.id', $data['resource_id']);
			if ($this->db->update('resources'))
			{
				return TRUE;
			}
		}
		else
		{
			return FALSE;
		}
	}

	// Get all comments for a resource based on the resource id and information
	// about the creators of the comments.
	public function get_comments($resource_id)
	{
		$this->db->select('comments.body, comments.created, users.username, users.image');
		$this->db->join('users', 'users.id = comments.user_id', 'inner');
		$this->db->where('resource_id', $resource_id);
		$query = $this->db->get('comments');
        return $query;
	}

}
