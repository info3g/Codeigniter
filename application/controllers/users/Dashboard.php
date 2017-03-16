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
		$this->load->model('building_model');
		$this->load->model('dashboard_model');
		$this->load->library('form_validation');
    }
	
	public function is_loggedIn()
    {
        if (! $this->session->userdata('logged_in')==TRUE)
		{
			redirect('login');
        }
    }
	
	public function index()
	{
		error_reporting(0);
		$session_data = $this->session->userdata('logged_in');
		$user_type = $session_data['user_type'];
		$user_id = $session_data['id'];
		//$data['total_buildings'] = $this->dashboard_model->get_total_building_c( $user_id );
		$data['client_info'] = $this->dashboard_model->get_client_info( $user_id );
		
		/*================all filter figures======================*/
			$client_assigned_buildings = $this->building_model->get_all_building_for_client( $user_id );
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

		
		$building_id = $data['client_info']->assigned_buildings;
		$building_ids = explode( ',', $building_id );
		$data['total_buildings'] = count($building_ids);
		foreach( $building_ids as $building_idss){
			$rst[] = $this->dashboard_model->get_buildings_info( $building_idss );
		}
		
		/*==================Added Location into map====================================*/
			$location_b = $this->building_model->get_location_building( $building_id );
			foreach($location_b as $location_bs){
				$rst[] = $location_bs;
			}
		/*================== / Added Location into map====================================*/
		
		/*=====================Maps=========================*/
		
			$this->load->library('googlemaps');

			/* $config['center'] = '49.6924486, -112.3670821'; */
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
						/* $marker['position'] = $latitude.','.$longitude; */
						$marker['position'] = $rsts->latitude.','.$rsts->longitude;
						$marker['infowindow_content'] = '<ul><li>'.$rsts->portfolio.'</li><li>District'.$rsts->district.'</li><li>'.$rsts->development.'</li><li>'.$rsts->address.'</li><li>'.$rsts->city.', '.$rsts->region.'</li><li>'.$rsts->building_type.'</li><ul><li><a href="'.base_url().'reports/samples/'.$rsts->id.'">Reports</a></li><li><a href="'.base_url().'building/list_documents/'.$rsts->id.'">Drawing</a></li></ul></ul>';
						$marker['animation'] = 'DROP';
						$marker['title'] = $rsts->portfolio.' - District'.$rsts->district.' - '.$rsts->address.' - '.$rsts->city;
						$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='.$name.'|F75448|000000';
						$this->googlemaps->add_marker($marker);
						$name++;
						
					}else{
					
						$marker = array();
						$get_rst_address = $this->building_model->get_building_data($rsts->building_id);
						
						$marker['position'] = $rsts->latitude.','.$rsts->longitude;
						$marker['infowindow_content'] = '<ul><li>'.$get_rst_address->portfolio.'</li><li>District'.$get_rst_address->district.'</li><li>'.$get_rst_address->development.'</li><li>'.$rsts->l_address.'</li><li>'.$get_rst_address->city.', '.$get_rst_address->region.'</li><li>'.$get_rst_address->building_type.'</li><ul><li><a href="'.base_url().'reports/samples/'.$rsts->building_id.'">Reports</a></li><li><a href="'.base_url().'building/list_documents/'.$rsts->building_id.'">Drawing</a></li></ul></ul>';
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
		$this->load->view('templates/header.php');
		$this->load->view('building/map_view',$data);
		$this->load->view('templates/footer.php');
		
	}
		
		
	
	
}
