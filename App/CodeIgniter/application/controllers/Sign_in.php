<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sign_in extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url_helper');
		$this->load->library('session');
	}

	public function index()
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
						'max_length[64]'
					)
				),
				array(
					'field' => 'form-password',
					'label' => 'Password',
					'rules' => array(
						'required',
						'min_length[6]',
						'max_length[255]'
					)
				)
			);

			$this->form_validation->set_rules($validation_config);

			// Begin validation
			if ( ! $this->form_validation->run())
			{
				// First load, or problem with form
				$this->_load_sign_in_view();
			}
			else
			{
				$form_username = $this->input->post('form-username');
				$form_password = $this->input->post('form-password');

				$this->load->model('sign_in_model');
				$query = $this->sign_in_model->does_user_exist($form_username);
				
				if ($query->num_rows() === 1)
				{
					// One matching row found
					foreach ($query->result() as $row)
					{
						// Hashed password to verify against
						$hashed_password = $row->password;
						
						if ( ! password_verify($form_password, $hashed_password))
						{
							// Did not match, send back to sign-in page
							$this->_load_sign_in_view(TRUE);
						}
						else
						{
							// Save data to session
							$_SESSION['username'] = $row->username;
							$_SESSION['user_id'] = $row->id;
							$_SESSION['user_signed_in'] = TRUE;

							redirect('my-account');
						}
					}
				}
				else
				{
					// Username does not exist, send back to sign-in page
					$this->_load_sign_in_view(TRUE);
				}
			}
		}
	}

	// $validation_failed is TRUE when username does not exist OR when password
	// is incorrect.
	private function _load_sign_in_view($validation_failed = FALSE)
	{
		if ($validation_failed)
		{
			$data['auth_fail'] = TRUE;
		}
		$data['title'] = 'Sign in';

		$this->load->view('templates/header', $data);
		$this->load->view('sign_in/sign_in');
		$this->load->view('templates/footer');
	}

}
