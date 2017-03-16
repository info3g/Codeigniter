<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

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
		$this->is_loggedIn();
		$this->load->model('user_model');
		$this->load->model('building_model');
		$this->load->library('form_validation');
    }
	
	public function is_loggedIn()
    {
        if ( ! $this->session->userdata('logged_in')==TRUE )
		{
			redirect('client');
        }
    }
	
	/*==List clients and simple search clients section===*/
	public function index( )
	{
		/*=== condtion to check  ==*/
		if(isset($_POST['submit'])){
			$search_keyword = $this->input->post( 'search' );
			$data['list_clients'] = $this->user_model->get_search_result( $search_keyword );
			$this->load->view('templates/header.php');
			$this->load->view('client/client',$data);
			$this->load->view('templates/footer.php');
		}else{
			
			
			$this->load->library('pagination');
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
			$limit = 10;
			$start = ($page-1)* $limit;
			$config['base_url'] = base_url().'client/index/';
			$config['total_rows'] = $this->user_model->get_total_clients( );
			$config['per_page'] = $limit;
			$config['use_page_numbers'] = TRUE;
			$config['uri_segment'] = 3;
			$config['num_links'] = 5;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);
			
			$data['pagination'] = $this->pagination->create_links();
			
			$data['list_clients'] = $this->user_model->list_clients( $limit,$start );
			$this->load->view('templates/header.php');
			$this->load->view('client/client',$data);
			$this->load->view('templates/footer.php');
		}
	}
	
	/*==Building count===*/
	public function get_building_cnt( $id=NULL )
	{
		echo $rst = $this->user_model->get_total_cnt_building( $id );
	}
	
	/*==For email check validation==*/
	public function email_check()
	{
		$email = $this->input->post('email');
		if( $this->user_model->email_check( 'email', $email ) == false ) {
			$this->form_validation->set_message('email_check', 'This email is already taken');
			return false;
		}else{
			return true;
		}
	}
	
	/*==Username check validation==*/
	public function username_check()
	{
		$username = $this->input->post('username');
		if( $this->user_model->username_check( 'username', $username ) == false ) {
			$this->form_validation->set_message('username_check', 'This Username is already taken');
			return false;
		}else{
			return true;
		}
	}
	
	/*==add client==*/
	public function add_client( )
	{
		$this->load->library('form_validation');
 
		$this->form_validation->set_rules('client_name', 'Client Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('username', 'UserName', 'trim|required|xss_clean|callback_username_check');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|xss_clean|htmlspecialchars|required|valid_email|min_length[5]|max_length[100]|callback_email_check');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|xss_clean|required|min_length[8]|matches[password]');
		 
		if($this->form_validation->run() == FALSE)
		{
			/*== Add client page default page ==*/
			$data['all_building'] = $this->building_model->get_building_list();	
			$this->load->view('templates/header.php');
			$this->load->view('client/add_client',$data);
			$this->load->view('templates/footer.php');
		}
		else
		{
			
			/*== Upload the client Image  ==*/
			$path = $_SERVER['DOCUMENT_ROOT']."/ecohca/uploads/client/";
			$small_thumb = $_SERVER['DOCUMENT_ROOT']."/ecohca/uploads/client/small_thumb/";
			$config['upload_path'] = $path;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '1000000';
			/* $config['max_width']  = '1024';
			$config['max_height']  = '768'; */

			$this->load->library('upload', $config);
			
			/*== condition for upload the file or not ==*/
			if ( ! $this->upload->do_upload())
			{
				$data['error'] = array('error' => $this->upload->display_errors());
				$data['all_building'] = $this->building_model->get_building_list();	
				$this->load->view('templates/header.php');
				$this->load->view('client/add_client',$data);
				$this->load->view('templates/footer.php');
			}else{
				
				/*== upload file ==*/
				$data = array('upload_data' => $this->upload->data());
				$this->smallest_thumb($path.$data['upload_data']['file_name'],$small_thumb.$data['upload_data']['raw_name'].
				$data['upload_data']['file_ext']);
				if(!$this->image_lib->resize())
				echo $this->image_lib->display_errors();
				$thumb_small = $data['upload_data']['raw_name'].'_thumb'.$data['upload_data']['file_ext'];
			
			
				$client_name 		= $this->input->post('client_name');
				$client_address 	= $this->input->post('client_address');
				$city 				= $this->input->post('city');
				$province 			= $this->input->post('province');
				$postal_code 		= $this->input->post('postal_code');
				$c_project_number 	= $this->input->post('c_project_number');
				$username 			= $this->input->post('username');
				$email 				= $this->input->post('email');
				$password 			= md5($this->input->post('password'));
				$permission 		= $this->input->post('permission');
				
				
				$assigned_buildingss = $this->input->post('all_building');
				$assigned_buildings = implode( ',', $assigned_buildingss );
				
				$user = array(
					'client_name' 			=> $client_name,
					'client_address'		=> $client_address,
					'city'					=> $city,
					'province'				=> $province,
					'postal_code'			=> $postal_code,
					'assigned_buildings'	=> $assigned_buildings,
					'c_project_number'		=> $c_project_number,
					'username' 				=> $username,
					'email' 				=> $email,
					'password' 				=> $password,
					'client_logo' 			=> $thumb_small,
					'user_activation' 		=> '1',
					'permission' 			=> $permission,
					'user_type' 			=> 'client',
					'created_date' 			=> date('y-m-d')
				);
				$this->user_model->add_client( $user );
				redirect( 'client' );
			}
		}
		
	}
	
	/*==Password matches validation==*/
	public function matches( )
	{
		if($_POST['password'] != $_POST['cpassword'])
		{
			return false;
		}else{
			return true;
		}
	}
	
	
	/*==Doing client edit section==*/
	public function edit_client( $id=NULL )
	{
		$this->load->library('form_validation');
 
		$this->form_validation->set_rules('client_name', 'Client Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('client_address', 'Client Address', 'trim|required|xss_clean');
		$this->form_validation->set_rules('username', 'UserName', 'trim|required|xss_clean|callback_username_check');
		$this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|callback_matches');
		 
		if($this->form_validation->run() == FALSE)
		{
			/*=== Default view ==*/
			$data['client_info'] = $this->user_model->get_client_info( $id ); 
			$data['all_building'] = $this->building_model->get_building_list();	
			$this->load->view('templates/header.php');
			$this->load->view('client/edit_client',$data);
			$this->load->view('templates/footer.php');
		}
		else
		{
			$path = $_SERVER['DOCUMENT_ROOT']."/ecohca/uploads/client/";
			$small_thumb = $_SERVER['DOCUMENT_ROOT']."/ecohca/uploads/client/small_thumb/";
			$config['upload_path'] = $path;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '100';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';

			$this->load->library('upload', $config);
			
			//echo $this->upload->do_upload();die;
			if( $this->upload->do_upload() != "" )
			{

				if ( ! $this->upload->do_upload())
				{
					$data['error'] = array('error' => $this->upload->display_errors());
		
					$data['client_info'] = $this->user_model->get_client_info( $id ); 
					$this->load->view('templates/header.php');
					$this->load->view('client/edit_client',$data);
					$this->load->view('templates/footer.php');
				}else{
				
					$data = array('upload_data' => $this->upload->data());
					$this->smallest_thumb($path.$data['upload_data']['file_name'],$small_thumb.$data['upload_data']['raw_name'].
					$data['upload_data']['file_ext']);
					if(!$this->image_lib->resize())
					echo $this->image_lib->display_errors();
					$thumb_small = $data['upload_data']['raw_name'].'_thumb'.$data['upload_data']['file_ext'];
				
				
					$client_name 	= $this->input->post('client_name');
					$client_address = $this->input->post('client_address');
					$username 		= $this->input->post('username');
					$permission 	= $this->input->post('permission');
					/* $client_logo 	= $this->input->post('client_logo'); */
					
					$assigned_buildingss = $this->input->post('all_building');
					$assigned_buildings = implode( ',', $assigned_buildingss );
					
					if($this->input->post('password') != "" ){
						$password 		= md5($this->input->post('password'));
					
						$user_update = array(
							'client_name' 			=> $client_name,
							'client_address' 		=> $client_address,
							'username' 				=> $username,
							'password' 				=> $password,
							'assigned_buildings'	=> $assigned_buildings,
							'permission' 			=> $permission,
							'client_logo'			=> $thumb_small
						);
					}else{
						$user_update = array(
							'client_name' 			=> $client_name,
							'client_address' 		=> $client_address,
							'username' 				=> $username,
							'assigned_buildings'	=> $assigned_buildings,
							'permission' 			=> $permission,
							'client_logo'			=> $thumb_small
						);				
					}	
					
					$this->user_model->update_client( $user_update, $id );
					redirect( 'client' );
				}	
				
			}else{
					
					$client_name 	= $this->input->post('client_name');
					$client_address = $this->input->post('client_address');
					$username 		= $this->input->post('username');
					$permission 	= $this->input->post('permission');
					
					/* $client_logo 	= $this->input->post('client_logo'); */
					
					$assigned_buildingss = $this->input->post('all_building');
					$assigned_buildings = implode( ',', $assigned_buildingss );
					
					if($this->input->post('password') != "" ){
						$password 		= md5($this->input->post('password'));
					
						$user_update = array(
							'client_name' 			=> $client_name,
							'client_address' 		=> $client_address,
							'username' 				=> $username,
							'password' 				=> $password,
							'assigned_buildings'	=> $assigned_buildings,
							'permission' 			=> $permission
						);
					}else{
						$user_update = array(
							'client_name' 			=> $client_name,
							'client_address' 		=> $client_address,
							'username' 				=> $username,
							'assigned_buildings'	=> $assigned_buildings,
							'permission' 			=> $permission
						);				
					}	
					
					$this->user_model->update_client( $user_update, $id );
					redirect( 'client' );
			}	
		}
		
	}
	
	/*==thumbnails creater function===*/
	public function smallest_thumb($path,$small_thumb)
	{
		$this->load->library('image_lib');
		$config['image_library'] = 'gd2';
		$config['source_image'] = $path;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = FALSE;
		$config['width'] = '86';
		$config['height'] = '106';
		$new = $config['new_image'] = $small_thumb;

		return	$this->image_lib->initialize($config);	
		
	}
	
	/*==Remove the Client from trash==*/
	public function remove_client_trash( $id=NULL )
	{
		$this->user_model->remove_client_trash( $id );
		redirect( 'client' );
	}
	
	/*==List the Client for trash==*/
	public function list_client_trash(  )
	{
		/**/
		$data['list_clients'] = $this->user_model->list_clients_trashed( );
		$this->load->view('templates/header.php');
		$this->load->view('client/trash_client',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*==Remove the Client==*/
	public function remove_client( $id=NULL )
	{
		$this->user_model->remove_client( $id );
		redirect( 'client' );
	}
	
	/*==Restore the Client from trash==*/
	public function restore_client( $id )
	{
		$this->user_model->restore_client( $id );
		redirect( 'client' );
	}
	
	
	
}	