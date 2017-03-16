<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->model('user_model');
    }
	
	
	/*==Login page===*/
	public function index()
	{
		
		$this->load->library('form_validation');
 
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
		 
		if($this->form_validation->run() == FALSE)
		{
			/*==Default Layout==*/
			$this->load->view('login');
		}
		else
		{
			//Go to private area
			$session_data = $this->session->userdata('logged_in');
			$user_type = $session_data['user_type'];
			if( $user_type == 'client' )
			{
				redirect('users/dashboard', 'refresh');
			}else{
				redirect('dashboard', 'refresh');
			}
		}
	}
	
	public function check_database($password)
	{
	
		//Field validation succeeded.  Validate against database
		$username = $this->input->post('username');

		//query the database
		$result = $this->user_model->login($username, $password);
		
		if($result)
		{
			$sess_array = array();
			foreach($result as $row)
			{
				$sess_array = array(
					'id' => $row->id,
					'username' => $row->username,
					'user_type' => $row->user_type
				);
				$this->session->set_userdata('logged_in', $sess_array);
			}
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false;
		}
	}
	
	/*==logout user==*/
	public function logout()
	{
		$newdata = array(
					'id'  =>'',
					'username' => '',
					'logged_in' => FALSE,
				   );

		 $this->session->unset_userdata($newdata);
		 $this->session->sess_destroy();

		 redirect('login','refresh');
	}
	
	
}
