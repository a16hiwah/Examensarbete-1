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
		$data['title'] = 'Resources';
		$data['center_content'] = FALSE;

		$this->load->view('templates/header', $data);
		$this->load->view('resources/index');
		$this->load->view('templates/footer');
	}

	public function create_resource()
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

			// Begin validation
			if ( ! $this->form_validation->run())
			{
				// First load, or problem with form
				$data['form_title'] = array(
					'name' => 'form-title',
					'id' => 'form-title',
					'value' => set_value('form-title', ''),
					'maxlength' => '255'
				);

				$data['form_description'] = array(
					'name' => 'form-description',
					'id' => 'form-description',
					'value' => set_value('form-description', ''),
					'maxlength' => '255'
				);

				$data['form_body'] = array(
					'name' => 'form-body',
					'id' => 'form-body',
					'value' => set_value('form-body', '')
				);

				$data['title'] = 'Create resource';
				$data['center_content'] = TRUE;

				$this->load->view('templates/header', $data);
				$this->load->view('resources/create_resource', $data);
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

				if ($this->resources_model->create_resource($data))
				{
					redirect('my-account/my-resources');
				}
				else
				{
					redirect('my-account/my-resources/create-resource');
				}
			}
		}
	}

	// Get unique slug by appending Unix timestamp and user id
	private function _get_unique_slug($str)
	{
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

}
