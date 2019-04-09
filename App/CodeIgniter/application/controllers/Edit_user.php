<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_user extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('edit_user_model');
		$this->load->helper('url_helper');
		$this->load->library('session');
	}

	public function edit_profile()
	{
		// Only signed in users can edit their profiles
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
					'field' => 'form-biography',
					'label' => 'Biography',
					'rules' => array(
						'max_length[255]'
					),
					'errors' => array(
						'max_length' => '*The biography cannot be longer than 255 characters in length'
					)
				)
			);

			$this->form_validation->set_rules($validation_config);
			
			// Begin validation
			if ($this->form_validation->run() === FALSE)
			{
				// Get data for view
				$data['usr_info'] = $this->edit_user_model->get_usr_info(
					$this->session->user_id
				);
				$data['profile_images'] = $this->edit_user_model->get_all_profile_imgs();

				// First load, or problem with form
				$data['form_biography'] = array(
					'name' => 'form-biography',
					'id' => 'form-biography',
					'value' => ($data['usr_info']->biography === NULL)
						? set_value('form-biography', '')
						: set_value('form-biography', $data['usr_info']->biography),
					'maxlength' => '255'
				);

				$data['title'] = 'Edit profile';

				$this->load->view('templates/header', $data);
				$this->load->view('edit_user/edit_user', $data);
				$this->load->view('templates/footer');
			}
			else
			{
				// Validation passed, now escape the data
				$data = array(
					'image' => $this->input->post('form-image'),
					'biography' => ($this->input->post('form-biography') !== '') // if
						? $this->input->post('form-biography') // condition met
						: NULL // else
				);

				if ($this->edit_user_model->edit_profile($data))
				{
					redirect('my-account');
				}
			}
		}
	}

}
