<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Building extends CI_Controller {

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
		$this->load->model('building_model');
		$this->load->model('location_model');
		$this->load->model('dashboard_model');
		$this->load->helper(array('form', 'url'));
    }
	
	public function is_loggedIn()
    {
        if (! $this->session->userdata('logged_in')==TRUE)
		{
			redirect('login');
        }
    }
	
	/*==List Building and search building code with condition===*/
	public function index( $id=NULL ) 
	{
		/*=== Condition to check the search ===*/
		if(isset($_POST['submit']))
		{
			$search_keyword = $this->input->post( 'search' );
			
			/*==== Get Total Number of client ===*/
			$client_assigned_buildings = $this->building_model->get_all_building_for_client( $id );
			$building_idss = $client_assigned_buildings->assigned_buildings;
			$building_ids = explode( ',',$building_idss );
			$already_in_buildings = count( $building_ids );
			
			/*=== To get the search Result ===*/
			$data['list_building'] = $this->building_model->get_search_result( $building_idss,$search_keyword,$id );
			
			/*=== Get Total number of building ===*/
			$data['total_buildings'] = $this->dashboard_model->get_total_building_c( $id );
			
			
			foreach($building_ids as $building_id)
			{
				$develop[] = $this->building_model->get_all_develop( $building_id );
				$address[] = $this->building_model->get_all_address( $building_id );
				$city[] = $this->building_model->get_all_city( $building_id );
				$building_type[] = $this->building_model->get_all_building_type( $building_id );
			}
			
			
			$data['develop'] = $develop;
			$data['address'] = $address;
			$data['city'] = $city;
			$data['building_type'] = $building_type;
		
			/*=== get client information to show on header ===*/
			$data['client_info'] = $this->dashboard_model->get_client_info( $id );
			$data['client_id'] = $id;
			/*----------------------client id to session----------------------------------------*/	
				
				$sess_e_array = array(
					'client_id' => $id
				);
				$this->session->set_userdata('enter_in', $sess_e_array);
				
			/*----------------------------------------------------------------------------------*/
			$this->load->view('templates/header.php');
			$this->load->view('building/list_building',$data);
			$this->load->view('templates/footer.php');
		}else{
			
			$client_assigned_buildings = $this->building_model->get_all_building_for_client( $id );
			$building_idss = $client_assigned_buildings->assigned_buildings;
			$building_ids = explode( ',',$building_idss );
			$already_in_buildings = count( $building_ids );
			
			$this->load->library('pagination');
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
			$limit = 10;
			$start = ($page-1)* $limit;
			$config['base_url'] = base_url().'building/index/'.$id;
			$config['total_rows'] = $already_in_buildings;
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
			
			$data['list_building'] = $this->building_model->get_building_list_client_new($id,$limit,$start);
			
			
			foreach( $building_ids as $building_id )
			{
				$develop[] = $this->building_model->get_all_develop( $building_id );
				$address[] = $this->building_model->get_all_address( $building_id );
				$city[] = $this->building_model->get_all_city( $building_id );
				$building_type[] = $this->building_model->get_all_building_type( $building_id );
			}
			
			$data['develop'] = $develop;
			$data['address'] = $address;
			$data['city'] = $city;
			$data['building_type'] = $building_type;
		

			$data['total_buildings'] = $this->dashboard_model->get_total_building_c( $id );
			$data['client_info'] = $this->dashboard_model->get_client_info( $id );
			$data['client_id'] = $id;
			/*----------------------client id to session----------------------------------------*/	
				
				$sess_e_array = array(
					'client_id' => $id
				);
				$this->session->set_userdata('enter_in', $sess_e_array);
				
			/*----------------------------- Load View ----------------------------------------*/
			$this->load->view('templates/header.php');
			$this->load->view('building/list_building',$data);
			$this->load->view('templates/footer.php');
		}	
	}
	
	/*=== Advanced search filter Resluts =====*/
	public function filter_result( $id=NULL )
	{
		if( isset( $_POST['submit']  )== 'Filter' )
		{			
			
			/*================all filter figures======================*/
			$client_assigned_buildings = $this->building_model->get_all_building_for_client( $id );
			$building_idss = $client_assigned_buildings->assigned_buildings;
			$building_ids = explode( ',',$building_idss );
			
			foreach($building_ids as $building_id)
			{
				$develop[] = $this->building_model->get_all_develop( $building_id );
				$address[] = $this->building_model->get_all_address( $building_id );
				$city[] = $this->building_model->get_all_city( $building_id );
				$building_type[] = $this->building_model->get_all_building_type( $building_id );
			}
			
			$data['develop'] = $develop;
			$data['address'] = $address;
			$data['city'] = $city;
			$data['building_type'] = $building_type;
			/*===================/all filter figures==============================*/
			
			$port = $_POST;
			$data['client_id'] = $id;
			$data['list_building'] = $this->building_model->get_filter_result( $port,$building_idss,$id );
			
			$data['client_info'] = $this->dashboard_model->get_client_info( $id );
			
			$this->load->view('templates/header.php');
			$this->load->view('building/filter_building',$data);
			$this->load->view('templates/footer.php');
		}
	}
	
	/*===list building according to clients====*/
	public function list_building_client( $id=NULL )
	{
		/*=== get all building according to client ===*/	
		$client_assigned_buildings = $this->building_model->get_all_building_for_client( $id );
		$building_ids = $client_assigned_buildings->assigned_buildings;	
		$data['list_building'] = $this->building_model->get_building_list_client( $building_ids );
		$this->load->view('templates/header.php');
		$this->load->view('building/list_building',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*===To add Building====*/
	public function add_building( $id=NULL )
	{
		$this->load->library('form_validation');
 
		$this->form_validation->set_rules('building_name', 'Building Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
		$this->form_validation->set_rules('postal_code', 'Postal Code', 'trim|required|xss_clean');
		 
		if($this->form_validation->run() == FALSE)
		{
			/*=== Default view the form ===*/
			$data['all_clients'] = $id;
			$data['all_province'] = $this->building_model->get_all_province();
			$data['client_id'] = $id;
			$this->load->view('templates/header.php');
			$this->load->view('building/building',$data);
			$this->load->view('templates/footer.php');
		}
		else
		{
			/*== After getting the post data ===*/
			
			$user_id_s 		= $this->session->userdata('logged_in');
			$user_id 		= $user_id_s['id'];
			
			$building_name 	= $this->input->post('building_name');
			$building_desc 	= $this->input->post('building_desc');
			$address 		= $this->input->post('address');
			$city 			= $this->input->post('city');			
			$region 		= $this->input->post('region');
			$postal_code 	= $this->input->post('postal_code');
			
			$portfolio 			= $this->input->post('portfolio');
			$district 			= $this->input->post('district');
			$development 		= $this->input->post('development');
			$building_type 		= $this->input->post('building_type');
			$construction_year 	= $this->input->post('construction_year');		
			
			$location_as_building 	= $this->input->post('location_as_building');
			if(isset($location_as_building)){
				$location_as_building 	= $this->input->post('location_as_building');
			}else{
				$location_as_building 	= 0;
			}
			
			
			$building_id 	= $this->input->post('building_id');
			$square_feet 	= $this->input->post('square_feet');
			$surveyor 		= $this->input->post('surveyor');
			$survey_date 	= $this->input->post('survey_date');
			$validated 	    = $this->input->post('validated');
			$project_number = $this->input->post('project_number');
			$region 		= $this->input->post('region');
			
			/*=== Getting the map section using google map api ====*/
			$addr = $address.','.$postal_code.' Canada' ;
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
			
			$client_assigned_buildings = $this->building_model->get_all_building_for_client( $id );
			$already_in_building = $client_assigned_buildings->assigned_buildings;
			$already_in_buildings = count( explode( ',',$already_in_building ) );
			
			/*== Creating the array for fields to be inserted ===*/
			$add_building = array(
				 	'building_name' 		=> $building_name,
				 	'building_desc' 		=> $building_desc,
					'address' 				=> $address,
					'user_id' 				=> $user_id,
					'city' 					=> $city,
					'region' 				=> $region,
					'postal_code' 			=> $postal_code,
					'portfolio' 			=> $portfolio,
					'district' 				=> $district,
					'development' 			=> $development,
					'building_type' 		=> $building_type,
					'construction_year' 	=> $construction_year,
					'location_as_building' 	=> $location_as_building,
					'latitude' 				=> $latitude,
					'longitude' 			=> $longitude,
					'client_building_id'	=> $building_id,
					'square_feet' 			=> $square_feet,
					'surveyor' 				=> $surveyor,
					'survey_date' 			=> $survey_date,
					'validated' 			=> $validated,
					'project_number' 		=> $project_number,
					'building_added_date' 	=> date('Y-m-d')
			); 
			
			/*===Insert building to database==*/	 
			$data = $this->building_model->add_building($add_building);
			/*=====Getting the Last insert Id from db====*/
			$last_insert_id = $this->db->insert_id();
			
			if( $already_in_buildings > 0 ){
				$client_building_update = $already_in_building.','.$last_insert_id;
			}else{
				$client_building_update = $last_insert_id;				
			}
			
			/*== updating the client's buildings ==*/
			$this->building_model->update_client_buildings( $id, $client_building_update );
			redirect('building/index/'.$id);
		}
	}
	
	/*=====Remove Building====*/
	public function remove_building( $id = NULL, $cid=NULL )
	{
		/*== Query to remove the building to trash==*/	
		$this->building_model->remove_building( $id );
		redirect('building/index/'.$cid);
	}
	
	/*==Edit Building page ==*/
	public function edit_building( $id=NULL )
	{
		$this->load->library('form_validation');
 
		$this->form_validation->set_rules('building_name', 'Building Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('postal_code', 'Postal Code', 'trim|required|xss_clean');
		 
		if($this->form_validation->run() == FALSE)
		{
			/*==List building edit form default view==*/
			$data['list_building'] = $this->building_model->get_building_data( $id );
			$data['client_id'] = $this->location_model->get_client_id( $id );
			$this->load->view('templates/header.php');
			$this->load->view('building/edit_building',$data);
			$this->load->view('templates/footer.php');
		}
		else
		{
			
			/*== Getting post data from form ==*/
			$user_id_s = $this->session->userdata('logged_in');
			$user_id = $user_id_s['id'];
			
			$building_name 	= $this->input->post('building_name');
			$building_desc 	= $this->input->post('building_desc');
			$address 		= $this->input->post('address');
			$postal_code 	= $this->input->post('postal_code');
			$square_feet 	= $this->input->post('square_feet');
			$surveyor 		= $this->input->post('surveyor');
			$survey_date 	= $this->input->post('survey_date');
			$project_number = $this->input->post('project_number');
			
			$portfolio 			= $this->input->post('portfolio');
			$district 			= $this->input->post('district');
			$development 		= $this->input->post('development');
			$building_type 		= $this->input->post('building_type');
			$construction_year 	= $this->input->post('construction_year');
			
			$location_as_building 	= $this->input->post('location_as_building');
			if(isset($location_as_building)){
				$location_as_building 	= $this->input->post('location_as_building');
			}else{
				$location_as_building 	= 0;
			}
			$client_id 	= $this->input->post('client_id');
			
			/*=== Getting Longitude & latitude from google api to store in DB ==*/
			
			$addr = $address.','.$postal_code.' Canada' ;
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
			
			/*== array to insert the data ==*/
			$data = array(
				 	'building_name' 		=> $building_name,
				 	'building_desc' 		=> $building_desc,
				 	'address' 				=> $address,
				 	'postal_code' 			=> $postal_code,
				 	'user_id'				=> $user_id,
					'portfolio' 			=> $portfolio,
					'district' 				=> $district,
					'latitude' 				=> $latitude,
					'longitude' 			=> $longitude,
					'development' 			=> $development,
					'building_type' 		=> $building_type,
					'construction_year' 	=> $construction_year,
					'location_as_building' 	=> $location_as_building,
					'square_feet' 			=> $square_feet,
					'surveyor' 				=> $surveyor,
					'survey_date' 			=> $survey_date,
					'project_number' 		=> $project_number,
					'building_update' 	    => date('Y-m-d')
			);
			
			$this->building_model->update_building( $id, $data );
			redirect('building/index/'.$client_id);
			
			
		}	
	}
	
	/*===Get total location count=====*/
	public function abc($id=NULL)
	{
		echo $this->building_model->get_total_location( $id );
	}
	
	/*===List Document according to building==*/
	public function list_documents( $id=NULL )
	{
		/*== Default Layout to list the document ==*/	
		$data['list_documents'] = $this->building_model->get_total_documents( $id );
		$data['building_name'] = $this->building_model->get_building_data( $id );
		$data['client_id'] = $this->location_model->get_client_id( $id );
		$data['building_id'] = $id;
		$this->load->view('templates/header.php');
		$this->load->view('building/list_documents',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*===Add DOCUMENT section==*/
	public function add_document( $id=NULL )
	{
		$this->load->library('form_validation');
 
		$this->form_validation->set_rules('document_title', 'Document Title', 'trim|required|xss_clean');
		 
		if($this->form_validation->run() == FALSE)
		{
			/*== Default layout for document==*/	
			$data['building_id'] = $id;
			$this->load->view('templates/header.php');
			$this->load->view('building/document',$data);
			$this->load->view('templates/footer.php');
		}
		else
		{
			
			/*===Getting post data from form uploading it on server ==*/
			$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/building/documents/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|xml|csv|doc|xlsx';
			$config['max_size']	= '1000000000';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/*== Condition to check the file is uploaded or not ==*/
			if ( ! $this->upload->do_upload('document_upload'))
			{
				$data['building_id'] = $id;
				$data['error'] = array('error' => $this->upload->display_errors());
				$this->load->view('templates/header.php');
				$this->load->view('building/document',$data);
				$this->load->view('templates/footer.php');
			}
			else
			{
				/*== Upload files section ==*/
				$data = array('document_upload' => $this->upload->data());
				$file_name = $data['document_upload']['file_name'];
				$file_type = $data['document_upload']['file_type'];
				$file_ext = $data['document_upload']['file_ext']; /*=== eg: .png ===*/
				$file_size = $data['document_upload']['file_size'];
				
				$document_path = 'building/documents/'.$file_name;
				$document_title = $this->input->post('document_title');
				$document_desc = $this->input->post('document_desc');
				
				$data_doc = array(
					'buildingID' 	=> $id,
					'document_name' => $document_title,
					'document_desc' => $document_desc,
					'document_path' => $document_path,
					'date_uploaded' => date('y-m-d')
				);		
				/*== Document inserted to DB ==*/
				$this->building_model->document_upload( $data_doc );
				redirect('building/list_documents/'.$id);
				
			}
			
		}
	}
	
	/*===Download document===*/
	public function download( $id=NULL )
	{
		/*== Download code to download the files you had uploaded ==*/
		$this->load->helper('download');
		$data = $this->building_model->get_document_path( $id );		
		$path = $data->document_path;
		$rst = explode('.',$path);
		$filename = $data->document_name.'.'.$rst[1];
		$data = file_get_contents(base_url()."uploads/".$path);					
		force_download($filename, $data); 
	}
	
	/*===Remove doucment==*/
	public function remove_document( $id=NULL,$bID=NULL )
	{
		/*== Getting document path to remove it from server ==*/
		$data = $this->building_model->get_document_path( $id );		
		$file_name = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/'.$data->document_path;
		$this->building_model->remove_document( $id );
		unlink($file_name);
		redirect('building/list_documents/'.$bID);
	}
	
	/*===Remove building from trash===*/
	public function remove_building_trash( $id=NULL, $cid=NULL )
	{
		/*=== Removing building from trash ===*/
		$this->building_model->remove_building_trash( $id );
		$this->building_model->update_user_buildings( $id, $cid );
		redirect('building/index/'.$cid);
	}
	
	/*== Trash building list===*/
	public function trashed_building( $cid=NULL )
	{
		/*== Getting trashed building list ==*/
		$data['list_building'] = $this->building_model->get_building_list_trash();
		$data['cid'] = $cid;
		$this->load->view('templates/header.php');
		$this->load->view('building/buildings_trash',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*===Restore Building==*/
	public function restore_building( $id=NULL,$cid=NULL )
	{
		/*== Restore the building which is delted from List ==*/
		$this->building_model->restore_building( $id );
		$assigned_b = $this->building_model->get_assigned_b( $cid );
		$cc = $assigned_b->assigned_buildings;
		$assigned_buildings = $cc.','.$id;
		$this->building_model->restore_building_users( $cid, $assigned_buildings );
		redirect('building/index/'.$cid);
	}
	
	/*==Map view sectioni for building==*/
	public function map_view( $id=NULL )
	{
		
		error_reporting(0);
		$user_id  =$id;
		$data['client_info'] = $this->dashboard_model->get_client_info( $user_id );
		
		/*================all filter figures======================*/
		
			$client_assigned_buildings = $this->building_model->get_all_building_for_client( $id );
			$building_idss = $client_assigned_buildings->assigned_buildings;
			
			/*======================Get Location Buildings==================================*/
			
			$building_ids = explode( ',',$building_idss );
			
			foreach($building_ids as $building_id)
			{
				$develop[] = $this->building_model->get_all_develop( $building_id );
				$address[] = $this->building_model->get_all_address( $building_id );
				$city[] = $this->building_model->get_all_city( $building_id );
				$building_type[] = $this->building_model->get_all_building_type( $building_id );
			}
			
			$data['develop'] = $develop;
			$data['address'] = $address;
			$data['city'] = $city;
			$data['building_type'] = $building_type;
			
			/*===================/all filter figures==============================*/
		
			$building_id = $data['client_info']->assigned_buildings;
			$building_ids = explode( ',', $building_id );
			$data['total_buildingss'] = count($building_ids);
			foreach( $building_ids as $building_idss){
				$rst[] = $this->dashboard_model->get_buildings_info( $building_idss );				
			}
			
			
			/*==================Added Location into map====================================*/
			$location_b = $this->building_model->get_location_building( $building_id );
			foreach($location_b as $location_bs){
				$rst[] = $location_bs;
			}
			/* echo "<pre>";print_r($rst); */
			foreach( $building_ids as $building_idss){
				$total_build[] = $this->dashboard_model->get_buildings_info( $building_idss );				
			}
			$data['total_buildings'] = count(array_filter($total_build));
			$data['grand_total_buildings'] = count(array_filter($rst));
			/*================== / Added Location into map====================================*/
			
			/*=====================Maps=========================*/
			
			$this->load->library('googlemaps');

			$config['center'] = '50.842672, -130.2464989';
			$config['zoom'] = 'auto';
			$config['cluster'] = false;
			
			$this->googlemaps->initialize($config);
			
			$name = "A";
			foreach( $rst as $rsts )
			{
				
				if(!empty($rsts))
				{
					if(isset($rsts->id))
					{
						$marker = array();
						if( $rsts->latitude != "" )
						{
							$marker['position'] = $rsts->latitude.','.$rsts->longitude;
							/*=========As of now I am renaming the drawing to document as per client===========*/
							$marker['infowindow_content'] = '<ul><li>'.$rsts->portfolio.'</li><li>District'.$rsts->district.'</li><li>'.$rsts->development.'</li><li>'.$rsts->address.'</li><li>'.$rsts->city.', '.$rsts->region.'</li><li>'.$rsts->building_type.'</li><ul><li><a href="'.base_url().'reports/samples/'.$rsts->id.'">Reports</a></li><li><a href="'.base_url().'building/list_documents/'.$rsts->id.'">Documents</a></li></ul></ul>';
							$marker['animation'] = 'DROP';
							$marker['title'] = $rsts->portfolio.' - District'.$rsts->district.' - '.$rsts->address.' - '.$rsts->city;
							$marker['style'] = $markers;		
							$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='.$name.'|F75448|000000';
							$this->googlemaps->add_marker($marker);
							$name++;
						}
					}else{
					
						$marker = array();
						$get_rst_address = $this->building_model->get_building_data($rsts->building_id);
						
						if( $rsts->latitude != "" )
						{
							$marker['position'] = $rsts->latitude.','.$rsts->longitude;
							/*=========As of now I am renaming the drawing to document as per client===========*/
							$marker['infowindow_content'] = '<ul><li>'.$get_rst_address->portfolio.'</li><li>District'.$get_rst_address->district.'</li><li>'.$get_rst_address->development.'</li><li>'.$rsts->l_address.'</li><li>'.$get_rst_address->city.', '.$get_rst_address->region.'</li><li>'.$get_rst_address->building_type.'</li><ul><li><a href="'.base_url().'reports/samples/'.$rsts->building_id.'">Reports</a></li><li><a href="'.base_url().'building/list_documents/'.$rsts->building_id.'">Documents</a></li></ul></ul>';
							$marker['animation'] = 'DROP';
							$marker['title'] = $rsts->l_address;
							$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='.$name.'|F75448|000000';
							$this->googlemaps->add_marker($marker);
							$name++;
						}
					}	
				}
			}
			
			$data['map'] = $this->googlemaps->create_map();
			
			/*===================/Maps===========================*/
			
			/*----------------------client id to session----------------------------------------*/	
				
				$sess_e_array = array(
					'client_id' => $id
				);
				$this->session->set_userdata('enter_in', $sess_e_array);
				
			/*----------------------------------------------------------------------------------*/
			
			
			$this->load->view('templates/header.php');
			$this->load->view('building/map_view',$data);
			$this->load->view('templates/footer.php');
		
	}
	
	/*==building search on map===*/
	public function map_search( $id=NULL )
	{
		if(isset($_POST['submit']))
		{
			
			$client_assigned_buildings = $this->building_model->get_all_building_for_client( $id );
			$building_idss = $client_assigned_buildings->assigned_buildings;
			$building_ids = explode( ',',$building_idss );
			$already_in_buildings = count( $building_ids );
			
			$search_keyword = $this->input->post( 'search' );
			$rst = $this->building_model->get_search_result( $building_idss, $search_keyword, $id );
			$data['get_search_parameterss'] = $search_keyword;
			
			foreach($rst as $reslt)
			{
				$bd_ids[] = $reslt->id;
			}
			
			$full_buildings = implode(',',$bd_ids);
			
			$location_b = $this->building_model->get_location_building( $full_buildings );
			if(!empty($location_b))
			{
				foreach($location_b as $location_bs){
					$rst[] = $location_bs;
				}
			}
			
			/*=====================Maps=========================*/
				
				$this->load->library('googlemaps');

				$config['center'] = '49.6924486, -112.3670821';
				$config['zoom'] = 'auto';
				$config['cluster'] = False;
				$this->googlemaps->initialize($config);
				$data['total_count_rst'] = count($rst);
				
				$name = "A";
				foreach( $rst as $rsts)
				{
					if(!empty($rsts))
					{
						if(isset($rsts->id))
						{
					
							$marker = array();
							$marker['position'] = $rsts->latitude.','.$rsts->longitude;
							/*=========As of now I am renaming the drawing to document as per client===========*/
							$marker['infowindow_content'] = '<ul><li>'.$rsts->portfolio.'</li><li>District'.$rsts->district.'</li><li>'.$rsts->development.'</li><li>'.$rsts->address.'</li><li>'.$rsts->city.', '.$rsts->region.'</li><li>'.$rsts->building_type.'</li><ul><li><a href="'.base_url().'reports/samples/'.$rsts->id.'">Reports</a></li><li><a href="'.base_url().'building/list_documents/'.$rsts->id.'">Documents</a></li></ul></ul>';
							$marker['animation'] = 'DROP';
							$marker['title'] = $rsts->portfolio.' - District'.$rsts->district.' - '.$rsts->address.' - '.$rsts->city;
							$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='.$name.'|F75448|000000';
							$this->googlemaps->add_marker($marker);
							$name++;
						
						}else{
						
							$marker = array();
							$get_rst_address = $this->building_model->get_building_data($rsts->building_id);
							
							$marker['position'] = $rsts->latitude.','.$rsts->longitude;
							/*=========As of now I am renaming the drawing to document as per client===========*/
							$marker['infowindow_content'] = '<ul><li>'.$get_rst_address->portfolio.'</li><li>District'.$get_rst_address->district.'</li><li>'.$get_rst_address->development.'</li><li>'.$rsts->l_address.'</li><li>'.$get_rst_address->city.', '.$get_rst_address->region.'</li><li>'.$get_rst_address->building_type.'</li><ul><li><a href="'.base_url().'reports/samples/'.$rsts->building_id.'">Reports</a></li><li><a href="'.base_url().'building/list_documents/'.$rsts->building_id.'">Documents</a></li></ul></ul>';
							$marker['animation'] = 'DROP';
							$marker['title'] = $rsts->l_address;
							$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='.$name.'|F75448|000000';
							$this->googlemaps->add_marker($marker);
							$name++;
						}	
					}
					
			}
				
			$data['map'] = $this->googlemaps->create_map();
				
			/*===================/Maps===========================*/
			
			/*----------------------client id to session----------------------------------------*/	
				
				$sess_e_array = array(
					'client_id' => $id
				);
				$this->session->set_userdata('enter_in', $sess_e_array);
				
			/*----------------------------------------------------------------------------------*/
				
				$data['total_buildings'] = $this->dashboard_model->get_total_building_c( $id );
			
			
			
				foreach( $building_ids as $building_id )
				{
					$develop[] = $this->building_model->get_all_develop( $building_id );
					$address[] = $this->building_model->get_all_address( $building_id );
					$city[] = $this->building_model->get_all_city( $building_id );
					$building_type[] = $this->building_model->get_all_building_type( $building_id );
				}
				
				$data['develop'] = $develop;
				$data['address'] = $address;
				$data['city'] = $city;
				$data['building_type'] = $building_type;
			
				$user_id = $id;
				$data['client_info'] = $this->dashboard_model->get_client_info( $user_id );
				$data['client_id'] = $id;
				$this->load->view('templates/header.php');
				$this->load->view('building/map_search',$data);
				$this->load->view('templates/footer.php');
		}
	}
	
	/*==Advanced result for map view==*/
	public function filter_result_map( $id=NULL )
	{
		
		if(isset($_POST['submit']))
		{
			
			$client_assigned_buildings = $this->building_model->get_all_building_for_client( $id );
			$building_idss = $client_assigned_buildings->assigned_buildings;
			$building_ids = explode( ',',$building_idss );
			$already_in_buildings = count( $building_ids );
			
			$data['get_search_parameters'] = $_POST;
			$port = $_POST;
			$data['client_id'] = $id;
			$rst = $this->building_model->get_filter_result( $port,$building_idss,$id );
			
			/*=================Get location building search============================*/
			
			/*----------------------client id to session----------------------------------------*/	
				
				$sess_e_array = array(
					'client_id' => $id
				);
				$this->session->set_userdata('enter_in', $sess_e_array);
				
			/*----------------------------------------------------------------------------------*/
			
			$buildings = $this->building_model->get_building_as_location( $port,$building_idss );
			if(!empty($buildings))
			{
				
				foreach( $buildings as $building ){
					$ids = implode( ',', array($building->id) );
					$rstt[] = $this->building_model->get_location_building( $ids );
				}
				
			}
			if(!empty($rstt[0])){
				$rst = array_merge($rst,$rstt[0] );
				/* echo "<pre>";print_r($rst);die; */
			}
			
			
			/*=======================================================================*/
			
			if( $rst != "" )
			{
			/*=====================Maps=========================*/
				
				$this->load->library('googlemaps');

				$config['center'] = '49.6924486, -112.3670821';
				$config['zoom'] = 'auto';
				$config['cluster'] = false;
				$this->googlemaps->initialize($config);
				$data['total_count_rst'] = count($rst);
				
				$name = "A";
				foreach( $rst as $rsts)
				{
					
					if(isset($rsts->id))
					{
						$marker = array();
						$marker['position'] = $rsts->latitude.','.$rsts->longitude;
						/*=========As of now I am renaming the drawing to document as per client===========*/
						$marker['infowindow_content'] = '<ul><li>'.$rsts->portfolio.'</li><li>District'.$rsts->district.'</li><li>'.$rsts->development.'</li><li>'.$rsts->address.'</li><li>'.$rsts->city.', '.$rsts->region.'</li><li>'.$rsts->building_type.'</li><ul><li><a href="'.base_url().'reports/samples/'.$rsts->id.'">Reports</a></li><li><a href="'.base_url().'building/list_documents/'.$rsts->id.'">Documents</a></li></ul></ul>';
						$marker['animation'] = 'DROP';
						$marker['title'] = $rsts->portfolio.' - District'.$rsts->district.' - '.$rsts->address.' - '.$rsts->city;
						$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='.$name.'|F75448|000000';
						$this->googlemaps->add_marker($marker);
						$name++;
						
					}else{
						
						$marker = array();
						$get_rst_address = $this->building_model->get_building_data($rsts->building_id);
						
						$marker['position'] = $rsts->latitude.','.$rsts->longitude;
						/*=========As of now I am renaming the drawing to document as per client===========*/
						$marker['infowindow_content'] = '<ul><li>'.$get_rst_address->portfolio.'</li><li>District'.$get_rst_address->district.'</li><li>'.$get_rst_address->development.'</li><li>'.$rsts->l_address.'</li><li>'.$get_rst_address->city.', '.$get_rst_address->region.'</li><li>'.$get_rst_address->building_type.'</li><ul><li><a href="'.base_url().'reports/samples/'.$rsts->building_id.'">Reports</a></li><li><a href="'.base_url().'building/list_documents/'.$rsts->building_id.'">Documents</a></li></ul></ul>';
						$marker['animation'] = 'DROP';
						$marker['title'] = $rsts->l_address;
						$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='.$name.'|F75448|000000';
						$this->googlemaps->add_marker($marker);
						$name++;
					}	
					
				}
				
				$data['map'] = $this->googlemaps->create_map();
			}	
			/*===================/Maps===========================*/
				
				
			$data['total_buildings'] = $this->dashboard_model->get_total_building_c( $id );
			
			
			
			foreach($building_ids as $building_id)
			{
				$develop[] = $this->building_model->get_all_develop( $building_id );
				$address[] = $this->building_model->get_all_address( $building_id );
				$city[] = $this->building_model->get_all_city( $building_id );
				$building_type[] = $this->building_model->get_all_building_type( $building_id );
			}
			
			$data['develop'] = $develop;
			$data['address'] = $address;
			$data['city'] = $city;
			$data['building_type'] = $building_type;
		
			$user_id = $id;
			$data['client_info'] = $this->dashboard_model->get_client_info( $user_id );
			$data['client_id'] = $id;
			$this->load->view('templates/header.php');
			$this->load->view('building/map_search',$data);
			$this->load->view('templates/footer.php');
		}
	}
	
	
	
}
