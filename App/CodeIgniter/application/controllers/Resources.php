<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resources extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('resources_model');
		$this->load->helper('url_helper');
	}

	public function index()
	{
		redirect('resources/view/A');
	}

	public function create_edit_resource($edit = FALSE, $id = NULL, $user_id = NULL)
	{
		$this->load->library('session');

		if ( ! $this->session->user_signed_in)
		{
			redirect('sign-in');
		}
		else
		{
			// Load support assets
			$this->load->library('form_validation');

			$this->form_validation->set_error_delimiters(
				'<span class="validation-error">',
				'</span>'
			);

			// Set validation rules
			$validation_config = array(
				array(
					'field' => 'form-title',
					'label' => 'Title',
					'rules' => array(
						'required',
						'min_length[1]',
						'max_length[255]'
					),
					'errors' => array(
						'required' => '*Title cannot be empty',
						'min_length' => '*The title must be at least 1 character in length',
						'max_length' => '*The title cannot be longer than 255 characters in length'
					)
				),
				array(
					'field' => 'form-description',
					'label' => 'Description',
					'rules' => array(
						'required',
						'min_length[1]',
						'max_length[255]'
					),
					'errors' => array(
						'required' => '*Description cannot be empty',
						'min_length' => '*The description must be at least 1 character in length',
						'max_length' => '*The description cannot be longer than 255 characters in length'
					)
				),
				array(
					'field' => 'form-body',
					'label' => 'Body',
					'rules' => array(
						'required'
					),
					'errors' => array(
						'required' => '*Body cannot be empty'
					)
				)
			);

			$this->form_validation->set_rules($validation_config);

			// Get data from the resource that should be edited
			if ($edit)
			{
				$resource = $this->resources_model->get_resource_by_ids($id, $user_id);
				$title = $resource[0]->title;
				$description = $resource[0]->description;
				$body = $resource[0]->body;
			}

			// Begin validation
			if ( ! $this->form_validation->run())
			{
				// First load, or problem with form
				$data['form_title'] = array(
					'name' => 'form-title',
					'id' => 'form-title',
					'value' => ( ! $edit)
						? set_value('form-title', '')
						: set_value('form-title', $title),
					'maxlength' => '255'
				);

				$data['form_description'] = array(
					'name' => 'form-description',
					'id' => 'form-description',
					'value' => ( ! $edit)
						? set_value('form-description', '')
						: set_value('form-description', $description),
					'maxlength' => '255'
				);

				$data['form_body'] = array(
					'name' => 'form-body',
					'id' => 'form-body',
					'value' => ( ! $edit)
						? set_value('form-body', '')
						: set_value('form-body', $body),
				);

				$data['title'] = 'Create resource';
				$data['center_content'] = TRUE;
				$data['edit'] = $edit;

				$this->load->view('templates/header', $data);
				$this->load->view('resources/create_edit_resource', $data);
				$this->load->view('templates/footer');
			}
			else
			{
				// Validation passed, now escape the data
				$slug = $this->_get_unique_slug($this->input->post('form-title'));
				$data = array(
					'user_id' => $this->session->user_id,
					'title' => $this->input->post('form-title'),
					'slug' => $slug,
					'description' => $this->input->post('form-description'),
					'body' => $this->input->post('form-body')
				);

				// Either create or update row in database
				if ( ! $edit)
				{
					if ($this->resources_model->create_resource($data))
					{
						$query_success = TRUE;
					}
					else
					{
						$query_success = FALSE;
					}
				}
				else
				{
					if ($this->resources_model->edit_resource($id, $user_id, $data))
					{
						$query_success = TRUE;
					}
					else
					{
						$query_success = FALSE;
					}
				}

				if ($query_success)
				{
					redirect('my-account/my-resources');
				}
				
			}
		}
	}

	// Get unique slug by appending Unix timestamp and user id
	private function _get_unique_slug($str)
	{
		$str = str_replace('å', 'a', $str);
		$str = str_replace('ä', 'a', $str);
		$str = str_replace('ö', 'o', $str);
		$str = str_replace('Å', 'a', $str);
		$str = str_replace('Ä', 'a', $str);
		$str = str_replace('Ö', 'o', $str);

		$this->load->library('session');
		$slug = url_title($str, 'dash', TRUE)
			.'-'
			.strtotime(date('Y-m-d H:i:s'))
			.'-'
			.$this->session->user_id;
		return $slug; 
	}

	public function delete_resource($id, $user_id)
	{
		$this->load->library('session');

		// Only allow deletion if it is the user's own resource
		if ($user_id === $this->session->user_id)
		{
			if ($this->resources_model->delete_resource($id, $user_id))
			{
				redirect('my-account/my-resources');
			}
		}
		else
		{
			redirect('my-account/my-resources');
		}
	}

	// Show resources based on filter settings set by the user
	public function view($filter)
	{
		// Load support assets
		$this->load->library('form_validation');

		$data['title'] = 'Resources - '.$filter;
		$data['center_content'] = FALSE;
		$data['resources'] = $this->resources_model->get_resources_by_filter($filter);

		$this->load->view('templates/header', $data);
		$this->load->view('resources/index');
		$this->load->view('templates/footer');
	}

	// Open resource based on slug
	public function open($slug)
	{
		// Load support assets
		$this->load->library('session');
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters(
			'<span class="validation-error">',
			'</span>'
		);
		
		// Set validation rules
		$validation_config = array(
			array(
				'field' => 'form-comment',
				'label' => 'Comment',
				'rules' => array(
					'required',
					'min_length[1]',
					'max_length[2000]'
				),
				'errors' => array(
					'required' => '*Empty comments cannot be created',
					'min_length' => '*Empty comments cannot be created',
					'max_length' => '*The comment cannot be longer than 2000 characters in length'
				)
			)
		);
		$this->form_validation->set_rules($validation_config);

		$data['title'] = 'Resource - opened';
		$data['center_content'] = FALSE;
		$data['resource_id'] = NULL;
		
		// Only show form for creating comments in the view if user is signed in
		$data['show_create_comment'] = $this->session->user_signed_in;

		if ( ! $this->form_validation->run())
		{
			// First load, or problem with form
			$data['form_comment'] = array(
				'name' => 'form-comment',
				'id' => 'form-comment',
				'value' => set_value('form-comment', ''),
				'maxlength' => '2000'
			);

			// Get resource based on its slug
			$data['resource'] = $this->resources_model->get_resource_by_slug($slug);

			// Get comments and their creator's information
			$data['comments'] = $this->resources_model->get_comments(
				$data['resource']->result()[0]->id
			);

			$this->load->view('templates/header', $data);
			$this->load->view('resources/opened_resource', $data);
			$this->load->view('templates/footer');
		}
		else
		{
			// Validation passed, now escape the data
			$data = array(
				'user_id' => $this->session->user_id,
				'resource_id' => $this->input->post('form-resource-id'),
				'body' => $this->input->post('form-comment')
			);

			if ($this->resources_model->create_comment($data))
			{
				// Go back to current page
				redirect(uri_string());
			}
		}
	}

}
