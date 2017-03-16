<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller {

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
		$this->load->library('form_validation');
		$this->load->model('location_model');
		$this->load->model('dashboard_model');
		$this->load->model('sample_model');
    }
	
	public function is_loggedIn()
    {
        if ( ! $this->session->userdata('logged_in') == TRUE )
		{
			redirect('login');
        }
    }
	
	
	/*==Listing locations==*/
	public function index( $id=Null )
	{
		
		/*=======List location ========*/
		$this->load->library('pagination');
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
		$limit = 10;
		$start = ($page-1)* $limit;
		$config['base_url'] = base_url().'location/index/'.$id;
		$config['total_rows'] = $this->location_model->get_total_locations( $id );
		$config['per_page'] = $limit;
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] = 4;
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
		
		$data['list_locations'] = $this->location_model->list_location_p( $limit,$start,$id );
		
		$data['client_id'] = $this->location_model->get_client_id( $id );
		$client_id = $data['client_id']->client_building_id;
		$data['total_buildings'] = $this->dashboard_model->get_total_building_c( $client_id );
		$data['client_info'] = $this->dashboard_model->get_client_info( $client_id );
		$data['building_name'] = $this->location_model->get_building_data( $id );
		$data['building_id'] = $id;
		$this->load->view('templates/header.php');
		$this->load->view('location/list_location',$data);
		$this->load->view('templates/footer.php');
			
	}
	
	/*==Simple Search locations==*/
	public function search_location( $id=NULL )
	{
		/*===Search Locations===*/	
		$search_keyword = $this->input->post( 'search' );
		$data['list_locations'] = $this->location_model->get_search_result( $search_keyword, $id );
		$data['building_name'] = $this->location_model->get_building_data( $id );
		
		$data['client_id'] = $this->location_model->get_client_id( $id );
		$client_id = $data['client_id']->client_building_id;
		$data['total_buildings'] = $this->dashboard_model->get_total_building_c( $client_id );
		$data['client_info'] = $this->dashboard_model->get_client_info( $client_id );
		$data['building_name'] = $this->location_model->get_building_data( $id );
		$data['building_id'] = $id;
		$this->load->view('templates/header.php');
		$this->load->view('location/list_location',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*==Advanced search locations==*/
	public function filter_location( $id=NULL )
	{
		/*===Advanced search for location==*/
		$filter = $this->input->post( 'filter' );
			
		if($filter == "f_asc"){
			$condition = "asc";
			$field_name = "floor";
			$data['list_locations'] = $this->location_model->get_filter_result( $id, $condition, $field_name);
		}else if($filter == "f_desc"){
			$condition = "desc";
			$field_name = "floor";
			$data['list_locations'] = $this->location_model->get_filter_result( $id, $condition, $field_name);
		}else if($filter == "l_asc"){
			$condition = "asc";
			$field_name = "location_name";
			$data['list_locations'] = $this->location_model->get_filter_result( $id, $condition, $field_name);
		}else if($filter == "l_desc"){
			$condition = "desc";
			$field_name = "location_name";
			$data['list_locations'] = $this->location_model->get_filter_result( $id, $condition, $field_name);
		}else if($filter == "ln_asc"){
			$condition = "asc";
			$field_name = "location_id";
			$data['list_locations'] = $this->location_model->get_filter_result( $id, $condition, $field_name);
		}else if($filter == "ln_desc"){
			$condition = "desc";
			$field_name = "location_id";
			$data['list_locations'] = $this->location_model->get_filter_result( $id, $condition, $field_name);
		}
		$data['client_id'] = $this->location_model->get_client_id( $id );
		$data['building_id'] = $id;
		$this->load->view('templates/header.php');
		$this->load->view('location/list_location',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*==Check locations validation==*/
	public function locationid_check( )
	{		
		$location_id = $this->input->post('location_id');
		$bid = $this->input->post('bid');
		if( $this->location_model->locationid_check( $location_id, $bid ) == false ) {
			$this->form_validation->set_message('locationid_check', 'This location Number is already taken.');
			return false;
		}else{
			return true;
		}
	}
	
	/*==Add locations==*/
	public function add_location( $id=NULL )
	{
		$this->load->library('form_validation');
 
		$this->form_validation->set_rules('location_name', 'Location Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('floor', 'Floor', 'trim|required|xss_clean|numeric');
		$this->form_validation->set_rules('location_id', 'Location', 'trim|required|xss_clean|callback_locationid_check');
		 
		if($this->form_validation->run() == FALSE)
		{
			/*==Default View of loations add form==*/
			$data['building_data'] = $this->location_model->get_building_data( $id );
			$this->load->view('templates/header.php');
			$this->load->view('location/location', $data );
			$this->load->view('templates/footer.php');
		}
		else
		{
			/*==Posted data==*/
			$survey_date 		= $this->input->post('survey_date');
			$consultant_name 	= $this->input->post('consultant_name');
			$reassessment_date 	= $this->input->post('reassessment_date');
			$floor 				= $this->input->post('floor');
			$square_feet 		= $this->input->post('square_feet');
			$room_prefix 		= $this->input->post('room_prefix');
			$room_no 			= $this->input->post('room_no');
			$location_name 		= $this->input->post('location_name');
			$location_id 		= $this->input->post('location_id');
			$note 				= $this->input->post('note');
			$validated 			= $this->input->post('validated');
			$latitude = "";
			$longitude = "";			
			
			$l_address 			= $this->input->post('l_address');
			
			/*==Finding Longitude and latitide==*/
			$addr = $l_address.' Canada' ;
			$geo1 = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($addr).'&key=AIzaSyDEapfu8jsUUkYLpRpwPG7wFZDy54uq4hw';
				$ch = curl_init();
				curl_setopt ($ch, CURLOPT_URL, $geo1 );
				curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
				$contents = curl_exec($ch);
				if (curl_errno($ch)) {
				  echo curl_error($ch);
				  echo "\n<br />";
				  $contents = '';
				} else {
				  curl_close($ch);
				  
				}

				if (!is_string($contents) || !strlen($contents)) {
					echo "Failed to get contents.";
					$contents = '';
				}
				
			$geo = json_decode($contents, true);
			if ($geo['status'] = 'OK') {
				$latitude = $geo['results'][0]['geometry']['location']['lat'];
				$longitude = $geo['results'][0]['geometry']['location']['lng'];
			}
			
			if(!isset($validated)){
				$validated = 0;
			}
			$no_access = $this->input->post('no_access');
			if(!isset($no_access)){
				$no_access = 0;
			}
			$no_survey = $this->input->post('no_survey');
			if(!isset($no_survey)){
				$no_survey = 0;
			}
			
			$location_data = array(
				'building_id' 		=> 	$id,
				'location_name' 	=> 	$location_name,
				'location_id' 		=> 	$location_id,
				'floor' 			=> 	$floor,
				'square_feet' 		=> 	$square_feet,
				'room_prefix' 		=> 	$room_prefix,
				'room_no' 			=> 	$room_no,
				'note' 				=> 	$note,
				'validated' 		=> 	$validated,
				'no_access' 		=> 	$no_access,
				'no_survey' 		=> 	$no_survey,
				'consultant_name' 	=> 	$consultant_name,
				'l_address' 		=> 	$l_address,
				'latitude' 			=> 	$latitude,
				'longitude' 		=> 	$longitude,
				'last_reassessment' => 	$reassessment_date,
				'survey_date' 		=> 	$survey_date,
				'location_added' 	=>  date('y-m-d')
			);
			
			$this->location_model->add_location( $location_data );
			redirect('location/index/'.$id);
			
		}
		
	}
	
	/*==Remove locations==*/
	public function remove_location( $id = NULL,$bid=NULL )
	{
		$this->location_model->remove_location( $id );
		redirect('location/index/'.$bid);
	}
	
	/*==Location id check validation==*/
	public function location_id_check( )
	{
		$location_id = $this->input->post('location_id');
		$id = $this->input->post('lid');
		$bid = $this->input->post('bid');
		if( $this->location_model->locationid_check_edit( $location_id, $id, $bid ) == true ) {
			return true;
		}else{
			if( $this->location_model->locationid_check( $location_id, $bid ) == false ) {
				$this->form_validation->set_message('location_id_check', 'This location Number is already taken.');
				return false;
			}else{
				return true;
			}
		}
	}
	
	/*==Edit Location==*/
	public function edit_location( $id=NULL )
	{
		$this->load->library('form_validation');
 
		$this->form_validation->set_rules('location_name', 'Location Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('location_id', 'Location', 'trim|required|xss_clean|callback_location_id_check');
		 
		if( $this->form_validation->run() == FALSE )
		{
			$session_data_enter = $this->session->userdata('enter_in');
			$client_id_enter = $session_data_enter['client_id'];
			
			
			/*== default view of edit location ===*/
			$data['location_data'] = $this->location_model->get_location_data( $id );
			$data['building_data'] = $this->location_model->get_building_list( $id );
			$bid = $data['building_data']->id;
			/*====This is for room by room data====*/
			$data['materials_data'] = $this->location_model->get_material_list( );
			$data['system_data'] = $this->location_model->get_system_data( );
			$data['sample_list'] = $this->location_model->sample_list( $bid );
			$data['access_list'] = $this->location_model->access_list();
			$data['action_list'] = $this->location_model->action_list( $client_id_enter );
			$data['list_system'] = $this->sample_model->list_system();
			$data['list_layers'] = $this->sample_model->list_layers();
			$data['units_list'] = $this->location_model->units_list();
			$data['list_room_by_room_data'] = $this->location_model->list_room_by_room_data( $id );
			$data['get_all_locations'] = $this->location_model->get_all_locations_bid( $bid,$id );
			/*=====================================*/
			$this->load->view('templates/header.php');
			$this->load->view('location/edit_location', $data );
			$this->load->view('templates/footer.php');
		}
		else
		{
			
			/*==posted data to insert into DB==*/
			$survey_date 		= $this->input->post('survey_date');
			$consultant_name 	= $this->input->post('consultant_name');
			$reassessment_date 	= $this->input->post('reassessment_date');
			$floor 				= $this->input->post('floor');
			$square_feet 		= $this->input->post('square_feet');
			$room_prefix 		= $this->input->post('room_prefix');
			$room_no 			= $this->input->post('room_no');
			$location_name 		= $this->input->post('location_name');
			$location_id 		= $this->input->post('location_id');
			$note 				= $this->input->post('note');
			$bid 				= $this->input->post('bid');
			
			$latitude = "";
			$longitude = "";
			
			$validated = $this->input->post('validated');
			if(!isset($validated)){
				$validated = 0;
			}
			$no_access = $this->input->post('no_access');
			if(!isset($no_access)){
				$no_access = 0;
			}
			$no_survey = $this->input->post('no_survey');
			if(!isset($no_survey)){
				$no_survey = 0;
			}
			
			$l_address 			= $this->input->post('l_address');
			
			if($l_address != "")
			{
				
				$addr = $l_address.' Canada' ;
				$geo1 = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($addr).'&key=AIzaSyDEapfu8jsUUkYLpRpwPG7wFZDy54uq4hw';
				$ch = curl_init();
				curl_setopt ($ch, CURLOPT_URL, $geo1 );
				curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
				$contents = curl_exec($ch);
				if (curl_errno($ch)) {
				  echo curl_error($ch);
				  echo "\n<br />";
				  $contents = '';
				} else {
				  curl_close($ch);
				}

				if (!is_string($contents) || !strlen($contents)) {
				echo "Failed to get contents.";
				$contents = '';
				}
				$geo = json_decode($contents, true);	
				if ($geo['status'] = 'OK') {
					$latitude = $geo['results'][0]['geometry']['location']['lat'];
				        $longitude = $geo['results'][0]['geometry']['location']['lng'];
				}
				
				$update_location_data = array(
					'location_name' 	=> 	$location_name,
					'location_id' 		=> 	$location_id,
					'floor' 			=> 	$floor,
					'square_feet' 		=> 	$square_feet,
					'room_prefix' 		=> 	$room_prefix,
					'room_no' 			=> 	$room_no,
					'note' 				=> 	$note,
					'consultant_name' 	=> 	$consultant_name,
					'validated' 		=> 	$validated,
					'no_access' 		=> 	$no_access,
					'no_survey' 		=> 	$no_survey,
					'l_address' 		=> 	$l_address,
					'latitude' 			=> 	$latitude,
					'longitude' 		=> 	$longitude,
					'last_reassessment' => 	$reassessment_date,
					'survey_date' 		=> 	$survey_date,
					'location_updated' 	=>  date('y-m-d')
				);
				
			}else{
				
                $update_location_data 	= array(
					'location_name' 	=> 	$location_name,
					'location_id' 		=> 	$location_id,
					'floor' 			=> 	$floor,
					'square_feet' 		=> 	$square_feet,
					'room_prefix' 		=> 	$room_prefix,
					'room_no' 			=> 	$room_no,
					'note' 				=> 	$note,
					'consultant_name' 	=> 	$consultant_name,
					'validated' 		=> 	$validated,
					'no_access' 		=> 	$no_access,
					'no_survey' 		=> 	$no_survey,
					'l_address' 		=> 	$l_address,
					'last_reassessment' => 	$reassessment_date,
					'survey_date' 		=> 	$survey_date,
					'location_updated' 	=>  date('y-m-d')
				);
			}
			
			$this->location_model->update_location( $update_location_data, $id );
			redirect( 'location/index/'.$bid );
			
		}
		
	}
	
	
		
	
	
	/*==Get Location notes from view file==*/
	public function get_location_notes()
	{
		$location_id = $this->input->post('location_id');
		$rst = $this->location_model->get_location_notes( $location_id );
		echo $rst->note;
	}
	
	/*==Remove location from trash==*/
	public function remove_location_trash( $id=NULL, $bid=NULL )
	{
		$this->location_model->remove_location_trash( $id );
		redirect( 'location/index/'.$bid );
	}
	
	/*==trashed listing locations==*/
	public function trash_location( $id=NULL )
	{
		/*==Trash location list with pagination code==*/
		$this->load->library('pagination');
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
			$limit = 10;
			$start = ($page-1)* $limit;
			$config['base_url'] = base_url().'location/trash_location/'.$id;
			$config['total_rows'] = $this->location_model->get_total_locations_t( $id );
			$config['per_page'] = $limit;
			$config['use_page_numbers'] = TRUE;
			$config['uri_segment'] = 4;
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
		
		$data['list_locations'] = $this->location_model->list_location_trash( $limit,$start,$id );
		$data['building_id'] = $id;
		$this->load->view('templates/header.php');
		$this->load->view('location/list_location_trash',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*==Restore Locations==*/	
	public function restore_location( $id=NULL, $bid=NULL )
	{
		/*==Update Query to restore Location==*/
		$this->location_model->restore_location( $id );
		redirect('location/index/'.$bid);
	}
	
	
	/*=======================Units============================*/
	
	public function units()
	{
		/*=Get all units list from DB==*/
		$data['list_unit'] = $this->location_model->get_list_unit();
		$this->load->view('templates/header.php');
		$this->load->view('units/list_units',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*==Add unit==*/
	public function add_unit()
	{
		$this->load->library('form_validation');
 
		$this->form_validation->set_rules('unit_code', 'Unit Code', 'trim|required|xss_clean');
		 
		if($this->form_validation->run() == FALSE)
		{
			/*=Add unit form default page==*/
			$this->load->view('templates/header.php');
			$this->load->view('units/add_unit');
			$this->load->view('templates/footer.php');
		}else{
			
			/*==Posted data from form and save into the DB=*/
			$unit_code = $this->input->post('unit_code');
			$unit_name = $this->input->post('unit_name');
			
			$data = array(
				'unit_code' => $unit_code,
				'unit_name' => $unit_name
			);
			
			$this->location_model->units_added( $data );
			redirect('location/units');
		}
	}
	
	/*==Edit unit==*/
	public function edit_unit( $id=NULL )
	{
		$this->load->library('form_validation');
 
		$this->form_validation->set_rules('unit_code', 'Unit Code', 'trim|required|xss_clean');
		 
		if($this->form_validation->run() == FALSE)
		{
			/*==Get the Instered value from DB and defalt layout==*/
			$data['get_unit_values'] = $this->location_model->get_unit_values( $id );
			$this->load->view('templates/header.php');
			$this->load->view('units/edit_unit', $data);
			$this->load->view('templates/footer.php');
		}else{
			
			/*==Posted values==*/
			$unit_code = $this->input->post('unit_code');
			$unit_name = $this->input->post('unit_name');
			
			$data = array(
				'unit_code' => $unit_code,
				'unit_name' => $unit_name
			);
			
			$this->location_model->units_updated( $data, $id );
			redirect('location/units');
		}
	}
	
	/*==Remove unit==*/
	public function remove_unit( $id=NULL )
	{
		$this->location_model->units_remove( $id );
		redirect('location/units');
	}
	
	/*=========================Actions==================================*/
	
	/*==Listing for actions list==*/
	public function location_action( $id=NULL )
	{
		/*==Getting all actions from DB to list==*/
		if( $id != "" ){
			$data['list_action'] = $this->location_model->get_list_action( $id );
		}else{
			$data['list_action'] = $this->location_model->get_list_actions( );
		}
		$this->load->view('templates/header.php');
		$this->load->view('actions/list_action',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*==Add action form==*/
	public function add_action()
	{
		$this->load->library('form_validation');
 
		$this->form_validation->set_rules('action_name', 'Action Name', 'trim|required|xss_clean');
		 
		if($this->form_validation->run() == FALSE)
		{
			/*==Default action view page==*/
			$this->load->view('templates/header.php');
			$this->load->view('actions/add_action');
			$this->load->view('templates/footer.php');
		}else{
			
			$action_number = $this->input->post('action_number');
			$action_name = $this->input->post('action_name');
			$uid = $this->input->post('uid');
			
			if( $uid =="" ){
				$data = array(
					'action_number' => $action_number,
					'action_name' => $action_name
				);
			}else{
				$data = array(
					'action_number' => $action_number,
					'action_name' => $action_name,
					'u_id' => $uid
				);				
			}
			
			/* echo "<pre>";print_r($data); */
			$this->location_model->action_added( $data );
			redirect('location/location_action');
		}
	}
	
	/*==Edit Action section==*/
	public function edit_action( $id=NULL )
	{
		$this->load->library('form_validation');
 
		$this->form_validation->set_rules('action_name', 'Action Name', 'trim|required|xss_clean');
		 
		if($this->form_validation->run() == FALSE)
		{
			/*==Edit form defalt layout==*/
			$data['get_action_values'] = $this->location_model->get_action_values( $id );
			$this->load->view('templates/header.php');
			$this->load->view('actions/edit_action',$data);
			$this->load->view('templates/footer.php');
		}else{
			
			$action_number = $this->input->post('action_number');
			$action_name = $this->input->post('action_name');
			
			$data = array(
				'action_number' => $action_number,
				'action_name' => $action_name
			);
			
			$this->location_model->actions_updated( $data, $id );
			redirect('location/location_action');
		}
	}
	
	/*==Reomve action==*/
	public function remove_action( $id=NULL )
	{
		$this->location_model->actions_remove( $id );
		redirect('location/location_action');
	}
	
	/*======================= Obeservation ===============================*/
	
	/*==Get material Identification list==*/
	public function get_material_identy_list( $id=NULL )
	{
		/*==Ajax Request from view to get the mat identy list==*/
		$result = $this->location_model->get_material_identy_list( $id );
		$d = '<option>Please Select</option>';
		
		if(!empty($result)) {			
			foreach($result as $material_identy) {
				$d .=  '<option value="'.$material_identy->m_id.'">'.$material_identy->m_identification.'</option>';
			}
		}else{
			$d .=  '<option value="5">N/A</option>';
		}
		echo $d;
		
	}
	
	/*==Get database sample results==*/
	public function get_db_sample_rst()
	{
		/*==cases to check the sample result===*/
		$dbsample_id = $this->input->post('dbsample');
		if( $dbsample_id == '1' || $dbsample_id == '2' || $dbsample_id == '3' )
		{
			if($dbsample_id==1){
				$rst = "None Detected";
				$rsts = "None Detected";
			}
			if($dbsample_id==2){
				$rst = "Confirmed Asbestos";
				$rsts = "Visually Confirmed";
			}
			if($dbsample_id==3){
				$rst = "Presumed Asbestos";
				$rsts = "Presumed Asbestos";
			}
			$arr = array(
				'rst' => $rst,
				'rst_both' => $rsts,
				'type' => 'r_hazzard'
			);
			echo json_encode($arr);
		}
		else
		{
			/*==Condition to get the sample result from DB==*/
			if( $dbsample_id != 'Please Select' )
			{
				$rsts = $this->location_model->get_s_rst( $dbsample_id );
				if(!empty($rsts))
				{
					$id = $rsts->s_id;
					$max_val = $this->location_model->get_max_rst( $id );
					$layer_type=$layer_percent=0;
					
					foreach($max_val as $max_vals)
					{					
						
											
						if( is_numeric($max_vals->layer_one_percent) && is_numeric($max_vals->layer_two_percent) ){
							if($max_vals->layer_one_percent > $max_vals->layer_two_percent){
								if($max_vals->layer_one_percent > $layer_percent){
									$layer_percent = $max_vals->layer_one_percent;
									$layer_type = $max_vals->layer_one_type;
								}
							} else {
								if($max_vals->layer_two_percent > $layer_percent){
									$layer_percent = $max_vals->layer_two_percent;
									$layer_type = $max_vals->layer_two_type;
								}
							}
						} elseif(is_numeric($max_vals->layer_one_percent) && !is_numeric($max_vals->layer_two_percent)){
							if($max_vals->layer_one_percent > $layer_percent){
								$layer_percent = $max_vals->layer_one_percent;
								$layer_type = $max_vals->layer_one_type;
							}
						} elseif(!is_numeric($max_vals->layer_one_percent) && is_numeric($max_vals->layer_two_percent)){
							if($max_vals->layer_two_percent > $layer_percent){
								$layer_percent = $max_vals->layer_two_percent;
								$layer_type = $max_vals->layer_two_type;
							}
						} else {
							continue;
						}
						
					}
					
					if($rsts->s_result == 'L.O.D'){
						$rsts->s_result = '&lt;L.O.D';
					}
					
					if($layer_percent == '0'){
						$rst =  $rsts->s_result;
						$arr = array(
							'rst' => $rst,
							'hzd' => $rsts->s_result,
							'type' => 's_rst'
						);
					}else{
						$layer_name = $this->location_model->get_layer_name( $layer_type );
						$layer_type = $layer_name->layer_type;
						
						$rst =  $layer_type.' '.$layer_percent.'%';
						$arr = array(
							'rst' => $rst,
							'hzd' => $rsts->s_result,
							'type' => 's_rst'
						);
					}
					
					echo json_encode($arr);
				}
			}
		}	
		
	}
	
	
	
	/*================== add_rmr_data =====================*/
	
	/*===Add Room by Room data====*/
	public function add_rmr_data()
	{
		
		$building_ID 		= $this->input->post('building_ID');
		$location_ID 		= $this->input->post('location_ID');
		$system_ID 			= $this->input->post('system_ID');
		$material_ID 		= $this->input->post('material_ID');
		$material_ident 	= $this->input->post('material_ident');
		$friability 		= $this->input->post('friability');
		$access 			= $this->input->post('access');
		$good 				= $this->input->post('good');
		$fair 				= $this->input->post('fair');
		$poor 				= $this->input->post('poor');
		$total 				= $this->input->post('total');
		$units 				= $this->input->post('units');
		$debris 			= $this->input->post('debris');
		$unit 				= $this->input->post('unit');
		$sample_rst 		= $this->input->post('sample_rst');
		$s_number 			= $this->input->post('s_number');
		$rst 				= $this->input->post('rst');
		$r_hazard 			= $this->input->post('r_hazard');
		$action 			= $this->input->post('action');
		
		if($units=='Please Select')
		{
			$units="";
		}
		if($unit=='Please Select')
		{
			$unit="";
		}
		if( $s_number == "Please Select" ){
			$s_number = "4";
		}
		if( $rst == "" ){
			$rst = "No Asbestos";
		}
		if( $r_hazard == "" ){
			$r_hazard = "No Asbestos";
		}
		if( $action == "Please Select" ){
			$action = "1";
		}
		if( $material_ident == "Please select" ){
			$material_ident = "5";
		}
		
		$room_by_room_data = array(
			'building_ID' 		=> $building_ID,
			'location_ID' 		=> $location_ID,
			'system_ID' 		=> $system_ID,
			'material_ID' 		=> $material_ID,
			'material_identi' 	=> $material_ident,
			'friability' 		=> $friability,
			'access' 			=> $access,
			'good' 				=> $good,
			'fair' 				=> $fair,
			'poor' 				=> $poor,
			'total' 			=> $total,
			'units' 			=> $units,
			'debris' 			=> $debris,
			'unit' 				=> $unit,
			'sample_rst' 		=> $sample_rst,
			's_number' 			=> $s_number,
			'rst' 				=> $rst,
			'r_hazard' 			=> $r_hazard,
			'action' 			=> $action,
			'date_added' 		=> date('y-m-d')
		);
		
		$this->location_model->add_room_by_room_data_samples( $room_by_room_data );
		
		echo "success";
		
	}
	
	/*===Get unit code for reporting section for samples===*/
	public function get_units_code( $units=NULL )
	{
		$rst = $this->location_model->get_units_code( $units );
		echo $rst->unit_code;
	}
	
	/*==Adding Room By Room data child data==*/
	public function add_rmr_data_child()
	{
		$building_ID 		= $this->input->post('building_ID');
		$location_ID 		= $this->input->post('location_ID');
		$system_ID 			= $this->input->post('system_ID');
		$material_ID 		= $this->input->post('material_ID');
		$material_ident 	= $this->input->post('material_ident');
		$friability 		= $this->input->post('friability');
		$access 			= $this->input->post('access');
		$good 				= $this->input->post('good');
		$fair 				= $this->input->post('fair');
		$poor 				= $this->input->post('poor');
		$total 				= $this->input->post('total');
		$units 				= $this->input->post('units');
		$debris 			= $this->input->post('debris');
		$unit 				= $this->input->post('unit');
		$sample_rst 		= $this->input->post('sample_rst');
		$s_number 			= $this->input->post('s_number');
		$rst 				= $this->input->post('rst');
		$r_hazard 			= $this->input->post('r_hazard');
		$action 			= $this->input->post('action');
		$parent 			= $this->input->post('parent');
		
		if($units=='Please Select')
		{
			$units="";
		}
		if($unit=='Please Select')
		{
			$unit="";
		}
		if( $s_number == "Please Select" ){
			$s_number = "4";
		}
		if( $rst == "" ){
			$rst = "No Asbestos";
		}
		if( $r_hazard == "" ){
			$r_hazard = "No Asbestos";
		}
		if( $action == "Please Select" ){
			$action = "1";
		}
		if( $material_ident == "Please select" ){
			$material_ident = "5";
		}
		
		
		$room_by_room_data = array(
			'building_ID' 		=> $building_ID,
			'location_ID' 		=> $location_ID,
			'system_ID' 		=> $system_ID,
			'material_ID' 		=> $material_ID,
			'material_identi' 	=> $material_ident,
			'friability' 		=> $friability,
			'access' 			=> $access,
			'good' 				=> $good,
			'fair' 				=> $fair,
			'poor' 				=> $poor,
			'total' 			=> $total,
			'units' 			=> $units,
			'debris' 			=> $debris,
			'unit' 				=> $unit,
			'sample_rst' 		=> $sample_rst,
			's_number' 			=> $s_number,
			'rst' 				=> $rst,
			'r_hazard' 			=> $r_hazard,
			'action' 			=> $action,
			'parent' 			=> $parent,
			'date_added' 		=> date('y-m-d')
		);
		
		$this->location_model->add_room_by_room_data_samples( $room_by_room_data );
		
		echo "success";
		
	}
	
	/*===Lising room by room child data according to parent value==*/
	public function list_room_by_room_data_child( $id=NULL, $lid=NULL, $i=NULL )
	{
		/*====Creating the table view to show the child data show====*/
		$list_room_by_room_data_child = $this->location_model->list_room_by_room_data_child( $id );
		
		if( !empty( $list_room_by_room_data_child ) )
		{
			$k = 1;
			foreach( $list_room_by_room_data_child as $list_room_by_room_data_childs )
			{ ?>
				<tr>
					<td><?php echo $i.'.'.$k;?></td>
					<td>
						<a data-type="system_ID" data-id="<?php echo $list_room_by_room_data_childs->r_id;?>" data-value="<?php echo $list_room_by_room_data_childs->system_name;?>" ondblclick="dbl_list_function(this);"><?php echo $list_room_by_room_data_childs->system_name;?></a>
					</td>
					<td>
						<a data-type="material_ID" data-id="<?php echo $list_room_by_room_data_childs->r_id;?>" data-value="<?php echo $list_room_by_room_data_childs->material_name;?>" ondblclick="dblfunction(this);"><?php echo $list_room_by_room_data_childs->material_name;?></a>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<a href="javascript:void(0);" data-type="material_identi" data-mat="<?php echo $list_room_by_room_data_childs->m_id;?>" data-id="<?php echo $list_room_by_room_data_childs->r_id;?>" id="<?php echo $list_room_by_room_data_childs->material_ID;?>" data-value="<?php echo $list_room_by_room_data_childs->m_identification;?>" ondblclick="dblfunction(this);"><?php echo $list_room_by_room_data_childs->m_identification;?></a>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<?php if($list_room_by_room_data_childs->m_description == "" ){ echo $list_room_by_room_data_childs->material_desc;}else{echo $list_room_by_room_data_childs->m_description;}?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<a data-type="friability" data-id="<?php echo $list_room_by_room_data_childs->r_id;?>" data-value="<?php echo $list_room_by_room_data_childs->friability;?>" ondblclick="dblfunction(this);"><?php if( !empty($list_room_by_room_data_childs->friability)){echo ucfirst($list_room_by_room_data_childs->friability);}else{echo "Add Friability";}?></a>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<a data-type="access" data-id="<?php echo $list_room_by_room_data_childs->r_id;?>" data-value="<?php echo $list_room_by_room_data_childs->access;?>" ondblclick="dblfunction(this);" ><?php if( !empty($list_room_by_room_data_childs->access)){ echo ucfirst($list_room_by_room_data_childs->access);}else{echo "Add Access";}?></a>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<a data-type="good" data-id="<?php echo $list_room_by_room_data_childs->r_id;?>" data-value="<?php echo $list_room_by_room_data_childs->good;?>" ondblclick="dblfunction(this);"><?php if( !empty($list_room_by_room_data_childs->good)){ echo $list_room_by_room_data_childs->good;}else{echo "Add Good";}?></a>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<a data-type="fair" data-id="<?php echo $list_room_by_room_data_childs->r_id;?>" data-value="<?php echo $list_room_by_room_data_childs->fair;?>" ondblclick="dblfunction(this);"><?php if( !empty($list_room_by_room_data_childs->fair)){ echo $list_room_by_room_data_childs->fair;}else{echo "Add Fair";}?></a>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<a data-type="poor" data-id="<?php echo $list_room_by_room_data_childs->r_id;?>" data-value="<?php echo $list_room_by_room_data_childs->poor;?>" ondblclick="dblfunction(this);"><?php if( !empty($list_room_by_room_data_childs->poor)){ echo $list_room_by_room_data_childs->poor;}else{echo "Add Poor";}?></a>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_data_childs->total;?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<a data-type="units" data-id="<?php echo $list_room_by_room_data_childs->r_id;?>" data-value="<?php echo $list_room_by_room_data_childs->units;?>" ondblclick="dblfunction(this);"><?php if(!empty($list_room_by_room_data_childs->units)) {$this->get_units_code( $list_room_by_room_data_childs->units);}else{echo "Add Units";}?></a>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<a data-type="debris" data-id="<?php echo $list_room_by_room_data_childs->r_id;?>" data-value="<?php echo $list_room_by_room_data_childs->debris;?>" ondblclick="dblfunction(this);"><?php if(!empty($list_room_by_room_data_childs->debris)) { echo $list_room_by_room_data_childs->debris;}else{echo "Add Debris";}?></a>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<a data-type="unit" data-id="<?php echo $list_room_by_room_data_childs->r_id;?>" data-value="<?php echo $list_room_by_room_data_childs->unit;?>" ondblclick="dblfunction(this);"><?php if(!empty($list_room_by_room_data_childs->unit)) {$this->get_units_code( $list_room_by_room_data_childs->unit);}else{echo "Add Unit";}?></a>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<a data-type="sample_rst" data-id="<?php echo $list_room_by_room_data_childs->r_id;?>" data-value="<?php echo $list_room_by_room_data_childs->sample_rst;?>" ondblclick="dblfunction(this);"><?php if(!empty($list_room_by_room_data_childs->sample_rst)) {echo $list_room_by_room_data_childs->sample_rst;}else{echo "Add sample Result";}?></a>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<a data-type="s_number" data-id="<?php echo $list_room_by_room_data_childs->r_id;?>" data-value="<?php echo $list_room_by_room_data_childs->s_number;?>" ondblclick="dblfunction(this);"><?php if(!empty($list_room_by_room_data_childs->db_sample)) {echo $list_room_by_room_data_childs->db_sample;}else{echo "Add DB Sample";}?></a>
						<?php } ?>
					</td>
					<td><?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{ echo $list_room_by_room_data_childs->rst; }?></td>
					<td><?php echo $list_room_by_room_data_childs->r_hazard;?></td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<a data-type="action" data-id="<?php echo $list_room_by_room_data_childs->r_id;?>" data-value="<?php echo $list_room_by_room_data_childs->action;?>" ondblclick="dblfunction(this);" data-toggle="tooltip" title="<?php echo $list_room_by_room_data_childs->action_name; ?>" ><?php if(!empty($list_room_by_room_data_childs->action_number)) { echo $list_room_by_room_data_childs->action_number;}else{echo "Add Action";}?></a>
						<?php } ?>
					</td>
					<td>
						<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="javascript:void(0)" onclick="delete_room_data(<?php echo $list_room_by_room_data_childs->r_id;?>, <?php echo $lid; ?>);" title="Delete"><i class="btn-icon-only icon-remove"> </i></a>
					</td>
					<td></td>
				</tr>	
			<?php $k++;
			}
		}
		
	}
	
	/*=====Ajax Request for saving the system field=====*/
	public function update_sytem_field( )
	{
		$roomID 		= $this->input->post('roomID');
		$field_name 	= $this->input->post('field_name');
		$field_value 	= $this->input->post('field_value');
		
		if($field_name=='good'){
			
			$other_values = $this->location_model->get_fair_poor_values( $roomID );
			$fair = $other_values->fair;
			$poor = $other_values->poor;
			$total = $fair + $poor + $field_value;
			
			$this->location_model->update_total( $total, $roomID, $field_value, $field_name );
			echo "success";			
		}else if($field_name=='fair'){
			
			$other_values = $this->location_model->get_fair_poor_values( $roomID );
			$good = $other_values->good;
			$poor = $other_values->poor;
			$total = $good + $poor + $field_value;
			
			$this->location_model->update_total( $total, $roomID, $field_value, $field_name );
			echo "success";			
		}else if($field_name=='poor'){
			
			$other_values = $this->location_model->get_fair_poor_values( $roomID );
			$good = $other_values->good;
			$fair = $other_values->fair;
			$total = $good + $fair + $field_value;
			
			$this->location_model->update_total( $total, $roomID, $field_value, $field_name );
			echo "success";			
		}else{
			$this->location_model->update_system_id( $roomID, $field_name, $field_value );
			echo "success";
		}	
	}
	
	/*=====Doble click function to edit the material=======*/
	public function list_material_fn_edit( )
	{
		$keyword = $this->input->post('keyword');
		$id="0";
		$result = $this->sample_model->get_material_like( $keyword, $id );
		if(!empty($result)) {
			echo '<ul id="material_id_l">';
			foreach($result as $material) {
				echo '<li onClick="selectmaterial_edit(\''.$material->material_name.'\', \''.$material->id.'\')">'.$material->material_name.'</li>';
			}
			echo "</ul>";
		}
		
	}
	
	/*=updateing the mat field==*/
	public function update_field_materail()
	{
		$roomID 		= $this->input->post('roomID');
		$field_name 	= $this->input->post('field_name');
		$field_value 	= $this->input->post('field_value');
		$mat_id 		= $this->input->post('mat_id');
		
		$this->location_model->update_material_id( $roomID, $field_name, $mat_id );
		echo "success";
	}
	
	/*==Getting the material identification list==*/
	public function get_identity_list_from_mat()
	{
		$roomID 		= $this->input->post('roomID');
		$field_name 	= $this->input->post('field_name');
		$field_value 	= $this->input->post('field_value');
		$material_id 	= $this->input->post('material_id');
		$bid 			= $this->input->post('bid');
		
		/*=====Select option view=====*/
		$list_system = $this->location_model->get_identity_list_from_mat( $material_id, $bid );
		
		$options = '<option value="">Please Select</option>';
		if(!empty($list_system))
		{
			foreach( $list_system as $list_systems )
			{
			
				$options .= '<option '.(($list_systems->m_id == $material_id) ? 'selected' : '' ).' value="'.$list_systems->m_id.'">'.$list_systems->m_identification.'</option>';
			}
		}else{
			$options .= '<option value="5">N/A</option>';
		}	
		
		echo $options;
		
	}
	
	/*===Ajax Getting the identification===*/
	public function get_identity_friablity()
	{
		$field_value = $this->input->post('field_value');
		
		$options =  '<option value="">Please Select</option>';
		$options .=  '<option '.(( $field_value == 'y') ? "selected" : "").' value="y">Yes</option>';
		$options .=  '<option '.(( $field_value == 'n') ? "selected" : "").' value="n">No</option>';
		
		echo $options;
	}
	
	/*=====update system field sample id=======*/
	public function update_sytem_field_sample_id()
	{
		$roomID 		= $this->input->post('roomID');
		$field_name 	= $this->input->post('field_name');
		$field_value 	= $this->input->post('field_value');
		$rst 			= $this->input->post('rst');
		
		$dbsample_id = $field_value;
		
			/*======Getting result from sample ID=========*/	
			$rsts = $this->location_model->get_s_rst( $dbsample_id );
				if(!empty($rsts))
				{
					$id = $rsts->s_id;
					$max_val = $this->location_model->get_max_rst( $id );
					$layer_type=$layer_percent=0;
					
					if(!empty($max_val))
					{
						foreach($max_val as $max_vals)
						{						
												
							if( is_numeric($max_vals->layer_one_percent) && is_numeric($max_vals->layer_two_percent) ){
								if($max_vals->layer_one_percent > $max_vals->layer_two_percent){
									if($max_vals->layer_one_percent > $layer_percent){
										$layer_percent = $max_vals->layer_one_percent;
										$layer_type = $max_vals->layer_one_type;
									}
								} else {
									if($max_vals->layer_two_percent > $layer_percent){
										$layer_percent = $max_vals->layer_two_percent;
										$layer_type = $max_vals->layer_two_type;
									}
								}
							} elseif(is_numeric($max_vals->layer_one_percent) && !is_numeric($max_vals->layer_two_percent)){
								if($max_vals->layer_one_percent > $layer_percent){
									$layer_percent = $max_vals->layer_one_percent;
									$layer_type = $max_vals->layer_one_type;
								}
							} elseif(!is_numeric($max_vals->layer_one_percent) && is_numeric($max_vals->layer_two_percent)){
								if($max_vals->layer_two_percent > $layer_percent){
									$layer_percent = $max_vals->layer_two_percent;
									$layer_type = $max_vals->layer_two_type;
								}
							} else {
								continue;
							}
							
							
						}
											
						if($rsts->s_result == 'L.O.D'){
							$rsts->s_result = '&lt;L.O.D';
						}
						
						if($layer_percent == '0'){
							$rst =  $rsts->s_result;
							$hzd = $rsts->s_result;
							$this->location_model->update_sample_and_rst( $roomID, $field_name, $field_value, $rst, $hzd );
							
						}else{
							$layer_name = $this->location_model->get_layer_name( $layer_type );
							$layer_type = $layer_name->layer_type;
							
							$rst =  $layer_type.' '.$layer_percent .'%';
							$hzd = $rsts->s_result;
							$this->location_model->update_sample_and_rst( $roomID, $field_name, $field_value, $rst, $hzd );
							
						}
						
					}
				else{
					
						/*=====DB sample condition for result======*/
						if( $dbsample_id == '1' || $dbsample_id == '2' || $dbsample_id == '3' )
						{
							if($dbsample_id==1){
								$rst = "None Detected";
								$hzd = "None Detected";
							}
							if($dbsample_id==2){
								$rst = "Confirmed Asbestos";
								$hzd = "Visually Confirmed";
							}
							if($dbsample_id==3){
								$rst = "Presumed Asbestos";
								$hzd = "Presumed Asbestos";
							}
							$this->location_model->update_sample_and_rst( $roomID, $field_name, $field_value, $rst, $hzd );
						}
						
					}	
						
						echo "success";
				}
		
	}
	
	/*=====Copy the room by room data to another location======*/
	public function copy_room_by_room_data( $lid=NULL )
	{
		
		$location_id = $this->input->post('location_id');
		$get_room_by_room_data = $this->location_model->get_room_by_room_data( $location_id );
		
			foreach($get_room_by_room_data as $get_room_by_room_datas)
			{
				
				$room_by_room_data_copy = array(
					'building_ID' 		=> $get_room_by_room_datas->building_ID,
					'location_ID' 		=> $lid,
					'system_ID' 		=> $get_room_by_room_datas->system_ID,
					'material_ID' 		=> $get_room_by_room_datas->material_ID,
					'material_identi' 	=> $get_room_by_room_datas->material_identi,
					'friability' 		=> $get_room_by_room_datas->friability,
					'access' 			=> $get_room_by_room_datas->access,
					'good' 				=> $get_room_by_room_datas->good,
					'fair' 				=> $get_room_by_room_datas->fair,
					'poor' 				=> $get_room_by_room_datas->poor,
					'total' 			=> $get_room_by_room_datas->total,
					'units' 			=> $get_room_by_room_datas->units,
					'debris' 			=> $get_room_by_room_datas->debris,
					'unit' 				=> $get_room_by_room_datas->unit,
					'sample_rst' 		=> $get_room_by_room_datas->sample_rst,
					's_number' 			=> $get_room_by_room_datas->s_number,
					'rst' 				=> $get_room_by_room_datas->rst,
					'r_hazard' 			=> $get_room_by_room_datas->r_hazard,
					'action' 			=> $get_room_by_room_datas->action,
					'parent' 			=> '0',
					'date_added' 		=> date('y-m-d')
				);
				
				$update = $this->location_model->update_room_by_room_data( $room_by_room_data_copy );
				$parentTemp = $this->db->insert_id();
				
				
				$r_id = $get_room_by_room_datas->r_id;
				$l_id = $get_room_by_room_datas->location_ID;
				$get_child_room_data = $this->location_model->get_child_room_data( $r_id, $l_id );
				
				foreach($get_child_room_data as $get_child_room_datas){					
					
						$room_by_room_data_copy_child = array(
						'building_ID' 		=> $get_child_room_datas->building_ID,
						'location_ID' 		=> $lid,
						'system_ID' 		=> $get_child_room_datas->system_ID,
						'material_ID' 		=> $get_child_room_datas->material_ID,
						'material_identi' 	=> $get_child_room_datas->material_identi,
						'friability' 		=> $get_child_room_datas->friability,
						'access' 			=> $get_child_room_datas->access,
						'good' 				=> $get_child_room_datas->good,
						'fair' 				=> $get_child_room_datas->fair,
						'poor' 				=> $get_child_room_datas->poor,
						'total' 			=> $get_child_room_datas->total,
						'units' 			=> $get_child_room_datas->units,
						'debris' 			=> $get_child_room_datas->debris,
						'unit' 				=> $get_child_room_datas->unit,
						'sample_rst' 		=> $get_child_room_datas->sample_rst,
						's_number' 			=> $get_child_room_datas->s_number,
						'rst' 				=> $get_child_room_datas->rst,
						'r_hazard' 			=> $get_child_room_datas->r_hazard,
						'action' 			=> $get_child_room_datas->action,
						'parent' 			=> $parentTemp,
						'date_added' 		=> date('y-m-d')
					);
					
					$this->location_model->insert_child_room_data( $room_by_room_data_copy_child );
					
					
				}
				
			}
		
	}
	
	/*===Remove the rmr data===*/
	public function remove_room_by_room_data( $id=NULL, $lid=NULL )
	{
		
		$this->location_model->remove_room_by_room_data( $id );
		redirect( 'location/edit_location/'.$lid );
	}
	
	
	
	
}