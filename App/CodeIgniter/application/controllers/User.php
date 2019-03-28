<?php
class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('url_helper');
	}

	public function index()
	{
		$data['title'] = 'Mina sidor';

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
				'label' => 'Användarnamn',
				'rules' => array(
					'required',
					'min_length[3]',
					'max_length[64]',
					'is_unique[users.username]'
				),
				'errors' => array(
					'required' => '*Ange ett användarnamn',
					'min_length' => '*Användarnamnet måste vara minst 3 tecken långt',
					'max_length' => '*Användarnamnet får vara max 64 tecken långt',
					'is_unique' => '*Användarnamnet är redan upptaget'
				)
			),
			array(
				'field' => 'password',
				'label' => 'Lösenord',
				'rules' => array(
					'required',
					'min_length[6]',
					'max_length[255]'
				),
				'errors' => array(
					'required' => '*Ange ett lösenord',
					'min_length' => '*Lösenordet måste vara minst 6 tecken långt',
					'max_length' => '*Lösenordet får vara max 255 tecken långt'
				)
			),
			array(
				'field' => 'passconf',
				'label' => 'Bekräfta lösenord',
				'rules' => array(
					'required',
					'matches[password]'

				),
				'errors' => array(
					'required' => '*Bekräfta lösenordet',
					'matches' => '*Lösenorden matchar inte varandra'
				)
			),
		);

		$this->form_validation->set_rules($validation_config);
		
		// Begin validation
		if($this->form_validation->run() == FALSE)
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

			$data['title'] = 'Skapa konto';

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
					$this->input->post('password'), PASSWORD_DEFAULT
				)
			);

			if($this->user_model->process_create_user($data))
			{
					redirect('mina-sidor/');
			}
		}
	}

}
