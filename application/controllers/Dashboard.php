<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
		$this->load->model('dashboard_model');
		$this->load->model('location_model');
		$this->load->library('form_validation');
    }
	
	public function is_loggedIn()
    {
        if (! $this->session->userdata('logged_in')==TRUE)
		{
			redirect('login');
        }
    }
	
	/*==Showing total no of buildings, locations, materials and clients==*/
	public function index()
	{
		$session_data = $this->session->userdata('logged_in');
		$user_type = $session_data['user_type'];
		if( $user_type == 'admin' )
		{
			/*== default view to dashboard ==*/
			$data['total_building'] = $this->dashboard_model->get_total_building();
			$data['total_clients'] = $this->dashboard_model->get_total_clients();
			$data['total_locations'] = $this->dashboard_model->get_total_locations();
			$data['total_materials'] = $this->dashboard_model->get_total_materials_dash();
			$this->load->view('templates/header.php');
			$this->load->view('dashboard',$data);
			$this->load->view('templates/footer.php');
		}else{
			redirect('users/dashboard', 'refresh');
		}
	}
	
	
	/*============================Material Section==========================================*/
	
	public function materials( $id=NULL )
	{
		/*====condition for search and to show the list materials ====*/
		if($this->input->post('search') != '')
		{
			$keyword = $this->input->post('search');
			$data['list_materials'] = $this->dashboard_model->filter_materials( $keyword );
			$data['bid'] = $id;
			$this->load->view('templates/header.php');
			$this->load->view('materials/list_materials',$data);
			$this->load->view('templates/footer.php');
		}	
		
		
		$this->load->library('pagination');
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
			$limit = 10;
			$start = ($page-1)* $limit;
			$config['base_url'] = base_url().'dashboard/materials/'.$id;
			$config['total_rows'] = $this->dashboard_model->get_total_materials( $id );
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
			
				
		$data['list_materials'] = $this->dashboard_model->list_materials( $limit,$start,$id );
		
		$data['bid'] = $id;
		$this->load->view('templates/header.php');
		$this->load->view('materials/list_materials',$data);
		$this->load->view('templates/footer.php');
	}
	
	public function search_material( $id=NULL )
	{
		
	}
	
	
	/*==Add material===*/
	public function add_material( $id=NULL )
	{
		$this->load->library('form_validation');
 
		$this->form_validation->set_rules('material_name', 'Material Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('material_desc', 'Material Description', 'trim|required|xss_clean');
		 
		if($this->form_validation->run() == FALSE)
		{
			$data['bid'] = $id;
			$this->load->view('templates/header.php');
			$this->load->view('materials/add_material',$data);
			$this->load->view('templates/footer.php');
		}
		else
		{
			
			$material_name = $this->input->post('material_name');
			$material_desc = $this->input->post('material_desc');
			
			$material_data = array(
				'm_building_id' => $id,
				'material_name' => $material_name,
				'material_desc' => $material_desc,
				'added_date' 	=> date('y-m-d')
			);
			$this->dashboard_model->add_material( $material_data );
			redirect( 'dashboard/materials/'.$id );
			
		}
		
	}
	
	/*==Edit the Material page==*/
	public function edit_material( $bid=NULL,$id=NULL )
	{
		$this->load->library('form_validation');
 
		$this->form_validation->set_rules('material_name', 'Material Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('material_desc', 'Material Description', 'trim|required|xss_clean');
		 
		if( $this->form_validation->run() == FALSE )
		{
			$data['material_values'] = $this->dashboard_model->get_material_value( $id );
			$data['bid'] = $bid;
			$this->load->view('templates/header.php');
			$this->load->view('materials/edit_material',$data);
			$this->load->view('templates/footer.php');
		}
		else
		{
		
			$material_name = $this->input->post('material_name');
			$material_desc = $this->input->post('material_desc');
			
			$material_data = array(
				'material_name' => $material_name,
				'material_desc' => $material_desc,
				'added_date' 	=> date('y-m-d')
			);
			$this->dashboard_model->update_material( $material_data, $id );
			redirect( 'dashboard/materials/'.$bid );
		}
		
	}
	
	/*==Remove the material==*/
	public function remove_material( $bid=NULL, $id=NULL )
	{
		$this->dashboard_model->remove_material( $id );
		redirect('dashboard/materials/'.$bid);
	}
	
	/*==Delete the material trash listing==*/
	public function trashed( $id=NULL )
	{
		$this->load->library('pagination');
			$start = intval($this->uri->segment(4));
			$limit = 10;
			$config['base_url'] = base_url().'dashboard/trashed/'.$id;
			$config['total_rows'] = $this->dashboard_model->get_total_materials_trashed( $id );
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
			
				
		$data['list_materials'] = $this->dashboard_model->list_materials_trashed( $limit,$start,$id );
		$data['bid'] = $id;
		$this->load->view('templates/header.php');
		$this->load->view('materials/list_trashed',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*==Restore material==*/
	public function restore_material( $bid=NULL,$id=NULL )
	{
		$this->dashboard_model->restore_material( $id );
		redirect( 'dashboard/materials/'.$bid );
	}
	
	/*==Remove material trash==*/
	public function remove_material_trashed( $bid=NULL,$id=NULL )
	{
		$this->dashboard_model->remove_material_trashed( $id );
		redirect('dashboard/materials/'.$bid);
	}
	
	
	/*============================ / Material Section==========================================*/
	
	
	/*==================== Material Identification ========================*/
	
	public function material_identification( $id=NULL )
	{
		$data['list_mat_identy'] = $this->dashboard_model->list_mat_identy( $id );
		$data['bid'] = $id;
		$data['building_name'] = $this->location_model->get_building_data( $id );
		$this->load->view('templates/header.php');
		$this->load->view('materials/list_material_identification',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*==Add Material Identification==*/
	public function add_material_identification( $id=NULL )
	{
	
		$this->load->library('form_validation');
 
		$this->form_validation->set_rules('material_identification', 'Material Identification', 'trim|required|xss_clean');
		$this->form_validation->set_rules('material_identification_desc', 'Material Identification Description', 'trim|required|xss_clean');
		 
		if( $this->form_validation->run() == FALSE )
		{
			$data['material_list'] = $this->dashboard_model->list_materials_in_identification();
			$data['bid'] = $id;
			$data['system_list'] = $this->dashboard_model->list_system();
			$this->load->view('templates/header.php');
			$this->load->view('materials/add_material_identification',$data);
			$this->load->view('templates/footer.php');
		}
		else
		{
			
			$building_id 					= $this->input->post('building_id');
			$system 						= $this->input->post('system_id');
			$material_id 					= $this->input->post('material_id');
			$material_identification 		= $this->input->post('material_identification');
			$material_identification_desc 	= $this->input->post('material_identification_desc');
			
			$inserted_data = array(
				'building_id' 		=>  $building_id,
				'system' 	  		=>  $system,
				'material_id' 	  	=>  $material_id,
				'm_identification' 	=>  $material_identification,
				'm_description' 	=>  $material_identification_desc
			);
			
			$this->dashboard_model->insert_material_identification( $inserted_data );
			redirect( 'dashboard/material_identification/'.$id );
			
		}
		
	}
	
	/*==Edit Material Identification==*/
	public function edit_material_identy( $bid=NULL, $id=NULL )
	{
		$this->load->library('form_validation');
 
		$this->form_validation->set_rules('material_identification', 'Material Identification', 'trim|required|xss_clean');
		$this->form_validation->set_rules('material_identification_desc', 'Material Identification Description', 'trim|required|xss_clean');
		 
		if( $this->form_validation->run() == FALSE )
		{
			$data['get_mat_identy_info'] = $this->dashboard_model->get_mat_identy_info( $id );
			$data['building_list'] = $this->dashboard_model->list_building();
			$data['system_list'] = $this->dashboard_model->list_system();
			$data['material_list'] = $this->dashboard_model->list_materials_in_identification();
			$data['bid'] = $bid;
			$this->load->view('templates/header.php');
			$this->load->view('materials/edit_material_identification',$data);
			$this->load->view('templates/footer.php');
		}
		else
		{
			
			$building_id 					= $this->input->post('building_id');
			$system 						= $this->input->post('system_id');
			$material_id 					= $this->input->post('material_id');
			$material_identification 		= $this->input->post('material_identification');
			$material_identification_desc 	= $this->input->post('material_identification_desc');
			
			$updated_data = array(
				'building_id' 		=>  $building_id,
				'system' 	  		=>  $system,
				'material_id' 	  	=>  $material_id,
				'm_identification' 	=>  $material_identification,
				'm_description' 	=>  $material_identification_desc
			);
			
			$this->dashboard_model->update_material_identification( $updated_data, $id );
			redirect('dashboard/material_identification/'.$bid);
			
		}
	}
	
	/*==Remove Material Identification==*/
	public function remove_material_identy_trashed( $bid=NULL, $id=NULL )
	{
		$this->dashboard_model->trashed_mat_identy( $id );
		redirect( 'dashboard/material_identification/'.$bid );
	}
	
	/*==Trash list Material Identification==*/
	public function trash_material_identification( $id=NULL )
	{
		$data['list_mat_identy'] = $this->dashboard_model->list_mat_identy_trash( $id );
		$data['bid'] = $id;
		$this->load->view('templates/header.php');
		$this->load->view('materials/list_mat_identification_trash',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*==Remove Material Identification==*/
	public function remove_material_identy( $bid=NULL, $id=NULL )
	{
		$this->dashboard_model->mat_identy( $id );
		redirect('dashboard/material_identification/'.$bid);
	}
	
	/*==Restore Material Identification==*/
	public function restore_mat_identy( $bid=NULL, $id=NULL )
	{
		$this->dashboard_model->restore_mat_identy( $id );
		redirect('dashboard/material_identification/'.$bid);
	}
	
	
}
