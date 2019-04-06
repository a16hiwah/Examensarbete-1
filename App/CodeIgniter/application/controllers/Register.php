<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('register_model');
		$this->load->helper('url_helper');
		$this->load->library('session');
	}

	public function index()
	{
		redirect('register/create_user');
	}

	public function create_user()
	{
		if ($this->session->user_signed_in)
		{
			redirect('my-account');
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
					'field' => 'form-username',
					'label' => 'Username',
					'rules' => array(
						'required',
						'min_length[3]',
						'max_length[64]',
						'is_unique[users.username]'
					),
					'errors' => array(
						'required' => '*Username cannot be empty',
						'min_length' => '*The username must be at least 3 characters in length',
						'max_length' => '*The username cannot be longer than 64 characters in length',
						'is_unique' => '*The username is already taken'
					)
				),
				array(
					'field' => 'form-password',
					'label' => 'Password',
					'rules' => array(
						'required',
						'min_length[6]',
						'max_length[255]'
					),
					'errors' => array(
						'required' => '*Password cannot be empty',
						'min_length' => '*The password must be at least 6 characters in length',
						'max_length' => '*The password cannot be longer than 255 characters in length'
					)
				),
				array(
					'field' => 'form-passconf',
					'label' => 'Confirm password',
					'rules' => array(
						'required',
						'matches[form-password]'

					),
					'errors' => array(
						'required' => '*Confirm password',
						'matches' => '*The passwords do not match'
					)
				),
			);

			$this->form_validation->set_rules($validation_config);
			
			// Begin validation
			if ($this->form_validation->run() === FALSE)
			{
				// First load, or problem with form
				$data['form_username'] = array(
					'name' => 'form-username',
					'id' => 'form-username',
					'value' => set_value('form-username', ''),
					'maxlength' => '64'
				);

				$data['form_password'] = array(
					'name' => 'form-password',
					'id' => 'form-password',
					'value' => set_value('form-password', ''),
					'maxlength' => '255'
				);

				$data['form_passconf'] = array(
					'name' => 'form-passconf',
					'id' => 'form-passconf',
					'value' => set_value('form-passconf', ''),
					'maxlength' => '255'
				);

				$data['title'] = 'Create user';

				$this->load->view('templates/header', $data);
				$this->load->view('register/create_user', $data);
				$this->load->view('templates/footer');
			}
			else
			{
				// Validation passed, now escape the data
				$data = array(
					'username' => $this->input->post('form-username'),
					'password' => password_hash(
						$this->input->post('form-password'),
						PASSWORD_DEFAULT
					)
				);

				if ($this->register_model->create_user($data))
				{
					redirect('my-account');
				}
				else
				{
					redirect('register/create_user');
				}
			}
		}
	}

}
