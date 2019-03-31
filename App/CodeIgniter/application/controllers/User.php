<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('url_helper');
	}

	public function index()
	{
		$data['title'] = 'My account';

		$this->load->view('templates/header', $data);
		$this->load->view('user/index');
		$this->load->view('templates/footer');
	}

	public function new_user()
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
				'field' => 'username',
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
				'field' => 'password',
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
				'field' => 'passconf',
				'label' => 'Confirm password',
				'rules' => array(
					'required',
					'matches[password]'

				),
				'errors' => array(
					'required' => '*Confirm password',
					'matches' => '*The passwords do not match'
				)
			),
		);

		$this->form_validation->set_rules($validation_config);
		
		// Begin validation
		if ($this->form_validation->run() == FALSE)
		{
			// First load, or problem with form
			$data['username'] = array(
				'name' => 'username',
				'id' => 'username',
				'value' => set_value('username', ''),
				'maxlength' => '64'
			);

			$data['password'] = array(
				'name' => 'password',
				'id' => 'password',
				'value' => set_value('password', ''),
				'maxlength' => '255'
			);

			$data['passconf'] = array(
				'name' => 'passconf',
				'id' => 'passconf',
				'value' => set_value('passconf', ''),
				'maxlength' => '255'
			);

			$data['title'] = 'Create account';

			$this->load->view('templates/header', $data);
			$this->load->view('user/new_user', $data);
			$this->load->view('templates/footer');
		}
		else
		{
			// Validation passed, now escape the data
			$data = array(
				'username' => $this->input->post('username'),
				'password' => password_hash(
					$this->input->post('password'),
					PASSWORD_DEFAULT
				)
			);

			if ($this->user_model->process_create_user($data))
			{
				redirect('user/');
			}
		}
	}

}
