<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

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
		$this->load->model('sample_model');
		$this->load->model('building_model');
		$this->load->model('user_model');
    }
	
	public function is_loggedIn()
    {
        if ( ! $this->session->userdata( 'logged_in' ) == TRUE )
		{
			redirect('login');
        }
    }
	
	/*===Report list page===*/
	public function all_list_report( $cid=NULL )
	{
		$data['client_id'] = $cid;	
		$this->load->view('templates/header.php');
		$this->load->view('reports/all_report_list', $data);
		$this->load->view('templates/footer.php');
	}
	
	/*===================== Room By Room Report =================================*/
	
	public function room_by_room_b( $cid=NULL )
	{
		$bidds = $this->building_model->get_building_list_clientt( $cid );
		$bids = $bidds->assigned_buildings;
		$data['all_buildings'] = $this->building_model->get_building_lists( $bids );
		$data['client_id'] = $cid;
		$this->load->view('templates/header.php');
		$this->load->view('reports/room_by_room_report_b',$data);
		$this->load->view('templates/footer.php');
	}
	
	public function room_by_room( $bid=NULL )
	{
		$data['all_clients'] = $this->building_model->get_all_clients();
		$data['client_id'] = $this->building_model->get_client_id( $bid );
		$data['all_locations'] = $this->building_model->get_all_locations( $bid );
		$data['bid'] = $bid;
		$this->load->view('templates/header.php');
		$this->load->view('reports/room_by_room_report',$data);
		$this->load->view('templates/footer.php');
	}
	
	public function get_buildings()
	{
		$id = $this->input->post('client_id');
		$bidds = $this->building_model->get_building_list_clientt( $id );
		$bids = $bidds->assigned_buildings;
		$list_building = $this->building_model->get_building_lists( $bids );
		
		$d = '<option>Please Select</option>';
		
		if( !empty( $list_building ) )
		{
			foreach( $list_building as $list_buildings ) 
			{
				
				$d .=  '<option value="'.$list_buildings->id.'">'.$list_buildings->building_name.'</option>';
			}
		}
		echo $d;
		
	}
	
	/*==Ajax request for getting building==*/
	public function get_buildings_district()
	{
		$id = $this->input->post('client_id');
		$dist = $this->input->post('district_id');
		
		$bidds = $this->building_model->get_building_list_clientt( $id );
		$bids = $bidds->assigned_buildings;
		$list_building = $this->building_model->get_building_list_clientt_dis( $dist, $bids );
				
		$d = '';
		
		if( !empty( $list_building ) )
		{
			foreach( $list_building as $list_buildings ) 
			{
				
				$d .=  '<option value="'.$list_buildings->id.'">'.$list_buildings->building_name.'</option>';
			}
		}
		$d;
		
		$e = '';
		
		if( !empty( $list_building ) )
		{
			foreach( $list_building as $list_buildings ) 
			{
				
				$e .=  $list_buildings->id.',';
			}
			$es = rtrim($e,',');
			$ess = '<input type="hidden" name="building_ids" id="building_ids" value="'.$es.'">';
		}
		$ess;
		echo json_encode(array("d"=>$d,"e"=>$ess));
		
	}
	
	/*==getting Locations==*/
	public function get_locations()
	{
		$id = $this->input->post('building_id');
		$list_location = $this->location_model->list_location_psa( $id );
		
		$d = '<option>Please Select</option>';
		
		if(!empty($list_location))
		{
			foreach($list_location as $list_locations)
			{
				$d .=  '<option value="'.$list_locations->l_id.'">'.$list_locations->location_id.' : '.$list_locations->location_name.'</option>';
			}
		}
		echo $d;
	}
	
	/*================Validations for export room by room report================*/
	
	function check_client($post_string)
	{
	  return $post_string == 'Please Select' ? FALSE : TRUE;
	}
	
	function check_building($post_string)
	{
	  return $post_string == 'Please Select' ? FALSE : TRUE;
	}
	
	function check_location($post_string)
	{
	  return $post_string == 'Please Select' ? FALSE : TRUE;
	}
	
	/*=============End==================*/
	
	public function export_report()
	{
		$this->form_validation->set_rules('location_id', 'Locations', 'trim|required|xss_clean|callback_check_location');
		$this->form_validation->set_message('check_location', 'You need to select something from Location.');
		 
		if($this->form_validation->run() == FALSE)
		{
			/*==Default room by room report==*/
			$data['all_clients'] = $this->building_model->get_all_clients();
			$data['client_id'] = $this->building_model->get_client_id( $bid );
			$data['all_locations'] = $this->building_model->get_all_locations( $bid );
			$data['bid'] = $bid;
			$this->load->view('templates/header.php');
			$this->load->view('reports/room_by_room_report',$data);
			$this->load->view('templates/footer.php');
			
		}else{
			
			$client_id 		= $this->input->post('client_id');
			$building_id 	= $this->input->post('building_id');
			$location_id 	= $this->input->post('location_id');
			$report_type 	= $this->input->post('report_type');
			
			$client_info     = $this->user_model->get_client_info( $client_id );
			$list_building   = $this->building_model->get_building_data( $building_id ); 
			$location_data   = $this->location_model->get_location_data( $location_id );
			$room_by_room 	 = $this->location_model->get_room_by_room( $location_id );
			
				
			$client_name 	 = $client_info->client_name;
			
			$building_detail = "";
			$building_name 	 = $list_building->building_name;
			$building_desc 	 = $list_building->building_desc;
			
			$location_name 	 = $location_data->location_name;
			$location_number = $location_data->location_id;
			$location_area   = $location_data->square_feet;
			
			$consultant_name 	= $location_data->consultant_name;
			$survey_date 		= $location_data->survey_date;
			$reassessment_date  = $location_data->last_reassessment;
			
			$floor 			 = $location_data->floor;
			$notes 			 = $location_data->note;
			$location_id 	 = $location_data->l_id;
			
			if( $report_type == "excel" )
			{
				
				/*==Report in Excel===*/
				$heading1 = array('Client Name', 'Building Detail', 'Building Name', 'Building Description');
				$heading2 = array('Location Name', 'Location Number', 'Area of Location','Floor');
				$heading4 = array('Consultant Name', 'Last Survey Date', 'Last Reassessment Date');
				$heading5 = array('Comments');
				$heading  = array( 'SN','System','Material','Material ID','Material identification','Friability (Y/N)','Access','Good','Fair','poor','Total','Units','Debris','Units','Sample Number', 'Results','Hazard','Action' );
				
				
				$this->load->library( 'excel' );																					
				                                        
				$objPHPExcel = new PHPExcel( );
				$objPHPExcel->getActiveSheet( )->setTitle( 'Room_By_Room' );
				
				/*================ For Client and Building Info layout=========================*/
				
				$rowNumberH = 1;
				$colH = 'A';
				
				foreach($heading1 as $h){
					$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
					$colH++;
				}
					$rownumber = 2;
					$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$client_name );
					$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$building_detail );
					$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$rownumber,$building_name );
					$objPHPExcel->getActiveSheet()->setCellValue( 'D'.$rownumber,$building_desc );
				
				/*================ For Location Info =========================*/
				
				$rowNumberH = 3;
				$colH = 'A';
				
				foreach($heading2 as $h){
					$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
					$colH++;
				}
				
					$rownumber = 4;
					$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$location_name );
					$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$location_number );
					$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$rownumber,$location_area );
					$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$rownumber,$floor );
				
				/*================ For consultant Info =========================*/
				
				$rowNumberH = 5;
				$colH = 'A';
				
				foreach($heading4 as $h){
					$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
					$colH++;
				}
				
					$rownumber = 6;
					$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$consultant_name );
					$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$survey_date );
					$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$rownumber,$reassessment_date );
				
				/*================ For Room By Room Info =========================*/
				
				$rowNumberH = 7;
				$colH = 'A';
				
				foreach($heading as $h){
					$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
					$colH++;
				}
				
				$room_by_room_data = $this->location_model->list_room_by_room_data( $location_id );
				$get_all_data_cnt = $this->location_model->get_all_data_count( $location_id );
				
				$cnt = count($get_all_data_cnt);
				if(!empty($room_by_room_data))
				{	
					$j=8;
					$i=1;
					foreach( $room_by_room_data as $room_by_room_datas )
					{
						
							if($room_by_room_datas->m_description == "" ){
								$material_desc = $room_by_room_datas->material_desc;
							}else{
								$material_desc =  $room_by_room_datas->m_description;
							}
							
							$friability = ucfirst( $room_by_room_datas->friability );
						
							$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$j,$i );
							$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$j,$room_by_room_datas->system_name );
							$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$j,$room_by_room_datas->material_name );
							
							if($room_by_room_datas->db_sample != "dash00"){
								$objPHPExcel->getActiveSheet()->setCellValue( 'D'.$j,$room_by_room_datas->m_identification );
							}else{
								$objPHPExcel->getActiveSheet()->setCellValue( 'D'.$j,'-' );
							}
							$objPHPExcel->getActiveSheet()->setCellValue( 'E'.$j,$material_desc );
																	
							if($room_by_room_datas->db_sample != "dash00"){
								$objPHPExcel->getActiveSheet()->setCellValue( 'F'.$j, $friability );
							}else{
								$objPHPExcel->getActiveSheet()->setCellValue( 'F'.$j,'-' );
							}
							
							if($room_by_room_datas->db_sample != "dash00"){
								$objPHPExcel->getActiveSheet()->setCellValue( 'G'.$j,$room_by_room_datas->access );
							}else{
								$objPHPExcel->getActiveSheet()->setCellValue( 'G'.$j,'-' );
							}
							
							if($room_by_room_datas->db_sample != "dash00"){
								$objPHPExcel->getActiveSheet()->setCellValue( 'H'.$j,$room_by_room_datas->good );
							}else{
								$objPHPExcel->getActiveSheet()->setCellValue( 'H'.$j,'-' );
							}
							
							if($room_by_room_datas->db_sample != "dash00"){
								$objPHPExcel->getActiveSheet()->setCellValue( 'I'.$j,$room_by_room_datas->fair );
							}else{
								$objPHPExcel->getActiveSheet()->setCellValue( 'I'.$j,'-' );
							}
							
							if($room_by_room_datas->db_sample != "dash00"){
								$objPHPExcel->getActiveSheet()->setCellValue( 'J'.$j,$room_by_room_datas->poor );
							}else{
								$objPHPExcel->getActiveSheet()->setCellValue( 'J'.$j,'-' );
							}
							
							if($room_by_room_datas->db_sample != "dash00"){
								$objPHPExcel->getActiveSheet()->setCellValue( 'K'.$j,$room_by_room_datas->total );
							}else{
								$objPHPExcel->getActiveSheet()->setCellValue( 'K'.$j,'-' );
							}
							
							if($room_by_room_datas->db_sample != "dash00"){
								$objPHPExcel->getActiveSheet()->setCellValue( 'L'.$j,$room_by_room_datas->units );
							}else{
								$objPHPExcel->getActiveSheet()->setCellValue( 'L'.$j,'-' );
							}	
							
							if($room_by_room_datas->db_sample != "dash00"){
								$objPHPExcel->getActiveSheet()->setCellValue( 'M'.$j,$room_by_room_datas->debris );
							}else{
								$objPHPExcel->getActiveSheet()->setCellValue( 'M'.$j,'-' );
							}
							
							if($room_by_room_datas->db_sample != "dash00"){
								$objPHPExcel->getActiveSheet()->setCellValue( 'N'.$j,$room_by_room_datas->unit );
							}else{
								$objPHPExcel->getActiveSheet()->setCellValue( 'N'.$j,'-' );
							}
							
							if($room_by_room_datas->db_sample != "dash00"){
								$objPHPExcel->getActiveSheet()->setCellValue( 'O'.$j,$room_by_room_datas->db_sample );
							}else{
								$objPHPExcel->getActiveSheet()->setCellValue( 'O'.$j,'-' );
							}
							
							$objPHPExcel->getActiveSheet()->setCellValue( 'P'.$j,$room_by_room_datas->rst );
							$objPHPExcel->getActiveSheet()->setCellValue( 'Q'.$j,$room_by_room_datas->r_hazard );
							
							if($room_by_room_datas->db_sample != "dash00"){
								$objPHPExcel->getActiveSheet()->setCellValue( 'R'.$j,$room_by_room_datas->action_number );
							}else{
								$objPHPExcel->getActiveSheet()->setCellValue( 'R'.$j,'-' );
							}
						
							$id = $room_by_room_datas->r_id;
							$list_room_by_room_data_child = $this->location_model->list_room_by_room_data_child( $id );
		
								if(isset($list_room_by_room_data_child))
								{
									$j++;
									$i++;
									foreach( $list_room_by_room_data_child as $list_room_by_room_data_childs )
									{
										if($list_room_by_room_data_childs->m_description == "" ){
											$material_desc = $list_room_by_room_data_childs->material_desc;
										}else{
											$material_desc =  $list_room_by_room_data_childs->m_description;
										}
										
										$friability = ucfirst( $list_room_by_room_data_childs->friability );
									
										$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$j,$i );
										$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$j,$list_room_by_room_data_childs->system_name );
										$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$j,$list_room_by_room_data_childs->material_name );
										
										if($list_room_by_room_data_childs->db_sample != "dash00"){
											$objPHPExcel->getActiveSheet()->setCellValue( 'D'.$j,$list_room_by_room_data_childs->m_identification );
										}else{
											$objPHPExcel->getActiveSheet()->setCellValue( 'D'.$j,'-' );
										}
										$objPHPExcel->getActiveSheet()->setCellValue( 'E'.$j,$material_desc );
																				
										if($list_room_by_room_data_childs->db_sample != "dash00"){
											$objPHPExcel->getActiveSheet()->setCellValue( 'F'.$j, $friability );
										}else{
											$objPHPExcel->getActiveSheet()->setCellValue( 'F'.$j,'-' );
										}
										
										if($list_room_by_room_data_childs->db_sample != "dash00"){
											$objPHPExcel->getActiveSheet()->setCellValue( 'G'.$j,$list_room_by_room_data_childs->access );
										}else{
											$objPHPExcel->getActiveSheet()->setCellValue( 'G'.$j,'-' );
										}
										
										if($list_room_by_room_data_childs->db_sample != "dash00"){
											$objPHPExcel->getActiveSheet()->setCellValue( 'H'.$j,$list_room_by_room_data_childs->good );
										}else{
											$objPHPExcel->getActiveSheet()->setCellValue( 'H'.$j,'-' );
										}
										
										if($list_room_by_room_data_childs->db_sample != "dash00"){
											$objPHPExcel->getActiveSheet()->setCellValue( 'I'.$j,$list_room_by_room_data_childs->fair );
										}else{
											$objPHPExcel->getActiveSheet()->setCellValue( 'I'.$j,'-' );
										}
										
										if($list_room_by_room_data_childs->db_sample != "dash00"){
											$objPHPExcel->getActiveSheet()->setCellValue( 'J'.$j,$list_room_by_room_data_childs->poor );
										}else{
											$objPHPExcel->getActiveSheet()->setCellValue( 'J'.$j,'-' );
										}
										
										if($list_room_by_room_data_childs->db_sample != "dash00"){
											$objPHPExcel->getActiveSheet()->setCellValue( 'K'.$j,$list_room_by_room_data_childs->total );
										}else{
											$objPHPExcel->getActiveSheet()->setCellValue( 'K'.$j,'-' );
										}
										
										if($list_room_by_room_data_childs->db_sample != "dash00"){
											$objPHPExcel->getActiveSheet()->setCellValue( 'L'.$j,$list_room_by_room_data_childs->units );
										}else{
											$objPHPExcel->getActiveSheet()->setCellValue( 'L'.$j,'-' );
										}	
										
										if($list_room_by_room_data_childs->db_sample != "dash00"){
											$objPHPExcel->getActiveSheet()->setCellValue( 'M'.$j,$list_room_by_room_data_childs->debris );
										}else{
											$objPHPExcel->getActiveSheet()->setCellValue( 'M'.$j,'-' );
										}
										
										if($list_room_by_room_data_childs->db_sample != "dash00"){
											$objPHPExcel->getActiveSheet()->setCellValue( 'N'.$j,$list_room_by_room_data_childs->unit );
										}else{
											$objPHPExcel->getActiveSheet()->setCellValue( 'N'.$j,'-' );
										}
										
										if($list_room_by_room_data_childs->db_sample != "dash00"){
											$objPHPExcel->getActiveSheet()->setCellValue( 'O'.$j,$list_room_by_room_data_childs->db_sample );
										}else{
											$objPHPExcel->getActiveSheet()->setCellValue( 'O'.$j,'-' );
										}
										
										$objPHPExcel->getActiveSheet()->setCellValue( 'P'.$j,$list_room_by_room_data_childs->rst );
										$objPHPExcel->getActiveSheet()->setCellValue( 'Q'.$j,$list_room_by_room_data_childs->r_hazard );
										
										if($list_room_by_room_data_childs->db_sample != "dash00"){
											$objPHPExcel->getActiveSheet()->setCellValue( 'R'.$j,$list_room_by_room_data_childs->action_number );
										}else{
											$objPHPExcel->getActiveSheet()->setCellValue( 'R'.$j,'-' );
										}
									
									}
								}
						
						$j++;
						$i++;
					}
				}
				/*================ For consultant Info =========================*/
				
				$rowNumberH = 8+$cnt;
				$colH = 'A';
				
				foreach($heading5 as $h){
					$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
					$colH++;
				}
				
					$rownumber = 8+$cnt+1;
					$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$notes );
						
				$objPHPExcel->getActiveSheet()->freezePane('A2');
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');

				$fname =  $location_name.'.xls';
					$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/roombyroom/';
					
					$download_link = 'uploads/reports/roombyroom/'.$fname;
				
					$objWriter->save($path.$fname);
					echo $download_link;
				
			}else{
				/*===Report in PDF==*/
				$data['list_room_by_room_data'] = $this->location_model->list_room_by_room_data( $location_id );
				$data['client_info'] 			= $this->user_model->get_client_info( $client_id );
				$data['list_building']  		= $this->building_model->get_building_data( $building_id ); 
				$data['location_data']  		= $this->location_model->get_location_data( $location_id );
				$data['room_by_room'] 	 		= $this->location_model->get_room_by_room( $location_id );
				
				
				$pth = str_replace('.','-',$location_name);
				$pdfFilePath = $pth.".pdf";
				
				$html=$this->load->view('reports/room_by_room_pdf_export', $data, true);
				//load mPDF library
				$this->load->library('m_pdf');
				//$this->m_pdf->pdf->setHeader("Location {$location_name}");
				$this->m_pdf->pdf->setFooter("Page {PAGENO} of {nb}");
			   //generate the PDF from the given html
				$this->m_pdf->pdf->WriteHTML($html);

				//download it.
				$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/locations/';
				
				$this->m_pdf->pdf->Output($path.$pdfFilePath, "F");
				
				$download_link = 'uploads/reports/locations/'.$pdfFilePath;
				echo $download_link;
			}	
				
		}
	}
	
	public function get_units_code( $units=NULL )
	{
		$rst = $this->location_model->get_units_code( $units );
		echo $rst->unit_code;
	}
	
	/*==List the room by room data child in report for PDF==*/
	public function list_room_by_room_data_child( $id=NULL, $lid=NULL, $i=NULL )
	{
		$list_room_by_room_data_child = $this->location_model->list_room_by_room_data_child( $id );
		
		if( !empty( $list_room_by_room_data_child ) )
		{
			$k=1;
			foreach( $list_room_by_room_data_child as $list_room_by_room_data_childs )
			{ ?>
				<tr>
					<td><?php echo $i.'.'.$k;?></td>
					<td>
						<?php echo $list_room_by_room_data_childs->system_name;?>
					</td>
					<td>
						<?php echo $list_room_by_room_data_childs->material_name;?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_data_childs->m_identification;?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<?php if($list_room_by_room_data_childs->m_description == "" ){ echo $list_room_by_room_data_childs->material_desc;}else{echo $list_room_by_room_data_childs->m_description;}?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<?php echo ucfirst($list_room_by_room_data_childs->friability);?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<?php echo ucfirst($list_room_by_room_data_childs->access);?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_data_childs->good;?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_data_childs->fair;?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_data_childs->poor;?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_data_childs->total;?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<?php if(!empty($list_room_by_room_data_childs->units)) {$this->get_units_code( $list_room_by_room_data_childs->units);}?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_data_childs->debris;?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<?php if(!empty($list_room_by_room_data_childs->unit)) {$this->get_units_code( $list_room_by_room_data_childs->unit);}?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_data_childs->sample_rst;?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_data_childs->db_sample;?></a>
						<?php } ?>
					</td>
					<td><?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{ echo $list_room_by_room_data_childs->rst; }?></td>
					<td><?php echo $list_room_by_room_data_childs->r_hazard;?></td>
					<td>
						<?php if($list_room_by_room_data_childs->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_data_childs->action_number;?>
						<?php } ?>
					</td>
					<td></td>
				</tr>	
			<?php $k++;
			}
		}
		
	}
	
	
	/*=========================Report for Samples===================================*/
	
	public function samples( $bid=Null )
	{		
		$data['all_clients'] = $this->building_model->get_all_clients();
		$data['client_id'] = $this->building_model->get_client_id( $bid );
		$data['bid'] = $bid;
		$this->load->view('templates/header.php');
		$this->load->view('reports/samples_report',$data);
		$this->load->view('templates/footer.php');
	}
	
	public function samples_b( $cid=NULL )
	{
		$bidds = $this->building_model->get_building_list_clientt( $cid );
		$bids = $bidds->assigned_buildings;
		$data['all_buildings'] = $this->building_model->get_building_lists( $bids );
		$data['client_id'] = $cid;
		$this->load->view('templates/header.php');
		$this->load->view('reports/samples_report_b',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*==Export the sample Report in excel format and PDF format==*/
	public function export_samples_report( )
	{
		
		$this->form_validation->set_rules('building_id', 'Buildings', 'trim|required|xss_clean');
		 
		if($this->form_validation->run() == FALSE)
		{
			
			$data['all_clients'] = $this->building_model->get_all_clients();
			$data['client_id'] = $this->building_model->get_client_id( $bid );
			$data['bid'] = $bid;
			$this->load->view('templates/header.php');
			$this->load->view('reports/room_by_room_report',$data);
			$this->load->view('templates/footer.php');
			
		}else{
		
			$client_id 		= $this->input->post('client_id');
			$bid 			= $this->input->post('building_id');
			$report_type 	= $this->input->post('report_type');
			
			$client_info     = $this->user_model->get_client_info( $client_id );
			$list_building   = $this->building_model->get_building_data( $bid );
				
			$client_name 	 = $client_info->client_name;
			
			$building_name 	 = $list_building->building_name;
			$building_desc 	 = $list_building->building_desc;
			$building_address= $list_building->address;
			
			
			
			if( $report_type == "excel" )
			{
				/*==Report in excel===*/	
				$heading  = array( 'Reference Sample Number','Sample Number','Location Number','System', 'Material', 'Material identification', 'Material Description','layer1 Type','layer1 Percent','layer2 Type','layer2 Percent','Hazard','Comments');
				$heading1 = array( 'Client Name', 'Building Name', 'Building Description' );
				
				$this->load->library( 'excel' );																					
				                                        
				$objPHPExcel = new PHPExcel( );
				$objPHPExcel->getActiveSheet( )->setTitle( 'Samples' );
				
				$rowNumberH = 1;
				$colH = 'A';
				
				foreach($heading1 as $h){
					$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
					$colH++;
				}
					$rownumber = 2;
					$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$client_name );
					$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$building_name );
					$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$rownumber,$building_desc );
				
				$rowNumberH = 3;
				$colH = 'A';
				
				foreach($heading as $h){
					$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
					$colH++;
				}
				
				$list_samples = $this->sample_model->list_samples_export_all_new( $bid );
				
				if(!empty($list_samples))
				{	
					$j=4;
					$i=1;
					foreach( $list_samples as $list_sample )
					{
						
							if($list_sample->m_description == "" ){
								$material_desc = $list_sample->material_desc;
							}else{
								$material_desc =  $list_sample->m_description;
							}
							
							$l2 = $list_sample->layer_one_type;
							$l2_type = $this->sample_model->get_layer_two_name( $l2 );
							
							if($list_sample->s_result == 'L.O.D'){
								$list_sample->s_result = '<L.O.D';
							}
							
							$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$j,$list_sample->db_sample );
							$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$j,$list_sample->sample_number );
							$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$j,$list_sample->locationID );
							$objPHPExcel->getActiveSheet()->setCellValue( 'D'.$j,$list_sample->system_name );
							$objPHPExcel->getActiveSheet()->setCellValue( 'E'.$j,$list_sample->material_name );
							$objPHPExcel->getActiveSheet()->setCellValue( 'F'.$j,$list_sample->m_identification );
							$objPHPExcel->getActiveSheet()->setCellValue( 'G'.$j,$material_desc );
							$objPHPExcel->getActiveSheet()->setCellValue( 'H'.$j,$list_sample->layer_type );
							$objPHPExcel->getActiveSheet()->setCellValue( 'I'.$j,$list_sample->layer_one_percent );
							$objPHPExcel->getActiveSheet()->setCellValue( 'J'.$j,$l2_type->layer_type );
							$objPHPExcel->getActiveSheet()->setCellValue( 'K'.$j,$list_sample->layer_two_percent );
							$objPHPExcel->getActiveSheet()->setCellValue( 'L'.$j,$list_sample->s_result );
							$objPHPExcel->getActiveSheet()->setCellValue( 'M'.$j,$list_sample->comments );
						
						$j++;
						$i++;
					}
				}
				/*================ For consultant Info =========================*/
				
				$objPHPExcel->getActiveSheet()->freezePane('A2');
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');

				$fname =  $building_name.'.xls';
					$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/samples/';
					
					$download_link = 'uploads/reports/samples/'.$fname;
					
					$objWriter->save($path.$fname);
					echo $download_link;
				
			}else{
				//echo "PDF";
				$data['list_samples'] 	= $this->sample_model->list_samples( $bid );
				$data['client_info'] 	= $this->user_model->get_client_info( $client_id );
				$data['list_building']  = $this->building_model->get_building_data( $bid ); 
				
				$pdfFilePath = $building_name.".pdf";
				
				$html=$this->load->view('reports/samples_pdf_export', $data, true);
				$this->load->library('m_pdf');
				
				$this->m_pdf->pdf->setHeader("Location {$building_address} (Page {PAGENO})");
				
			   //generate the PDF from the given html
				$this->m_pdf->pdf->WriteHTML($html);

				//download it.
				$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/samples/';
				
				$this->m_pdf->pdf->Output($path.$pdfFilePath, "F");
				
				$download_link = 'uploads/reports/samples/'.$pdfFilePath;
				echo $download_link;
			}	
				
		}		
	}
	
	/*=====Get sample Report PDF view=======*/
	public function get_sample_data( $id=NULL )
	{
		$data = $this->sample_model->list_sample_data_sid( $id );
		$tempdata = $this->sample_model->list_sample_data_sid( $id );
		$list_layers = $this->sample_model->list_layers( );
		$hazard_conditions = $this->sample_model->get_all_hazard( );
		$db_sample_rst = $this->sample_model->db_sample_rst( $id );
		$j=1;
		$cnt = count($data);
		foreach($data as $list_sample_datas)
		{ ?>
		<tr class="<?php if($j==$cnt){ echo "last";}?>" id="sample-data-<?php echo $list_sample_datas->id;?>">
		
			<td><?php echo $list_sample_datas->sample_number;?></td>
			
			<td><?php echo $list_sample_datas->locationID;?></td>
			
			<td><?php echo $list_sample_datas->system_name;?></td>
			
			<td><?php echo $list_sample_datas->material_name;?></td>
			
			<td><?php echo $list_sample_datas->m_identification;?></td>
			
			<td><?php if($list_sample_datas->m_description == "" ){ echo $list_sample_datas->material_desc;}else{echo $list_sample_datas->m_description;}?></td>
			
			<td><?php if(isset($list_layers)){ foreach($list_layers as $list_layer){ if($list_sample_datas->layer_one_type == $list_layer->layer_id){echo $list_layer->layer_type;} } } ?></td>		
			
			<td><?php echo $list_sample_datas->layer_one_percent;?></td>
			
			<td><?php if(isset($list_layers)){ foreach($list_layers as $list_layer){ if($list_sample_datas->layer_two_type == $list_layer->layer_id){echo $list_layer->layer_type;} } } ?></td>
			
			<td><?php echo $list_sample_datas->layer_two_percent;?></td>
			
			<?php if( $j==1 )
			{?>			
				<td style="border-bottom:1px solid #333;" rowspan="<?php echo $this->get_sample_data_count_last_row( $id);?>" class="td-actions">
					<?php if($db_sample_rst->s_result=='L.O.D'){echo "&lt;L.O.D";}else{echo $db_sample_rst->s_result;}?>
				</td>
			<?php 
			} ?>
			
			<td><?php if( $list_sample_datas->comments != ""){echo $list_sample_datas->comments;} ?></td>
			
		</tr>
		<?php $j++; 
		}
		
	}
	
	/*===sample Data count====*/
	public function get_sample_data_count( $id=NULL )
	{
		$rst = $this->sample_model->get_sample_data_count( $id );
		echo $rst->cnt+1;
	}
	
	public function get_sample_data_count_last_row( $id=NULL )
	{
		$rst = $this->sample_model->get_sample_data_count( $id );
		echo $rst->cnt;
	}
	
	
	/*=====================All Locations Reports===============================*/
	
	public function all_location_report( $bid=Null )
	{
		$data['client_id'] = $this->building_model->get_client_id( $bid );
		$data['bid'] = $bid;
		$this->load->view('templates/header.php');
		$this->load->view('reports/location_report',$data);
		$this->load->view('templates/footer.php');
	}
	
	public function all_location_report_b( $cid=NULL )
	{
		$bidds = $this->building_model->get_building_list_clientt( $cid );
		$bids = $bidds->assigned_buildings;
		$data['all_buildings'] = $this->building_model->get_building_lists( $bids );
		$data['client_id'] = $cid;
		$this->load->view('templates/header.php');
		$this->load->view('reports/location_report_b',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*==Export all locations in excel and PDF format===*/
	public function export_all_location_report( )
	{
			error_reporting(0);
		
			$client_id 		= $this->input->post('client_id');
			$building_id 	= $this->input->post('building_id');
			$report_type 	= $this->input->post('report_type');
			
			$client_info     = $this->user_model->get_client_info( $client_id );
			$list_building   = $this->building_model->get_building_data( $building_id ); 
			$location_datas   = $this->location_model->get_all_location_data( $building_id );
			
			$client_name 	 = $client_info->client_name;
			
			$building_detail = "";
			$building_id 	 = $list_building->id;
			$building_name 	 = $list_building->building_name;
			$building_desc 	 = $list_building->building_desc;
			
			/*==Excel report==*/
			if( $report_type == "excel" )
			{
				$this->load->library( 'excel' );	
				$objPHPExcel = new PHPExcel( );
				$objPHPExcel->getActiveSheet( )->setTitle( 'Room_By_Room' );
				
				$sd = 1;
				foreach($location_datas as $location_data)
				{
					
					$location_name 	 	 = $location_data->location_name;
					$location_number 	 = $location_data->location_id;
					$location_area   	 = $location_data->square_feet;
					
					$consultant_name 	= $location_data->consultant_name;
					$survey_date 		= $location_data->survey_date;
					$reassessment_date  = $location_data->last_reassessment;
					
					$floor 			 = $location_data->floor;
					$notes 			 = $location_data->note;
					$location_id 	 = $location_data->l_id;
				
					
					$heading1 = array('Client Name', 'Building Detail', 'Building Name', 'Building Description');
					$heading2 = array('Location Name', 'Location Number', 'Area of Location','Floor');
					$heading4 = array('Consultant Name', 'Last Survey Date', 'Last Reassessment Date');
					$heading5 = array('Comments');
					$heading  = array( 'SN','System','Material','Material ID','Material identification','Friability (Y/N)','Access','Good','Fair','poor','Total','Units','Debris','Units','Sample Number', 'Results','Hazard','Action' );

					
					/*==================== For Client and Building Info =========================*/
					
					$rowNumberH = $sd;
					$colH = 'A';
					
					foreach($heading1 as $h){
						$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
						$colH++;
					}
						$sd = $sd+1;
						$rownumber = $sd;
						$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$client_name );
						$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$building_detail );
						$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$rownumber,$building_name );
						$objPHPExcel->getActiveSheet()->setCellValue( 'D'.$rownumber,$building_desc );
					
					/*================ For Location Info =========================*/
					
					$sd = $sd+1;
					$rowNumberH = $sd;
					$colH = 'A';
					
					foreach($heading2 as $h){
						$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
						$colH++;
					}
					
						$sd = $sd+1;
						$rownumber = $sd;
						$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$location_name );
						$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$location_number );
						$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$rownumber,$location_area );
						$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$rownumber,$floor );
					
					/*================ For consultant Info =========================*/
					
					$sd = $sd+1;
					$rowNumberH = $sd;
					$colH = 'A';
					
					foreach($heading4 as $h){
						$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
						$colH++;
					}
						
						$sd = $sd+1;
						$rownumber = $sd;
						$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$consultant_name );
						$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$survey_date );
						$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$rownumber,$reassessment_date );
					
					/*================ For Room By Room Info =========================*/
					
					$sd = $sd+1;
					$rowNumberH = $sd;
					$colH = 'A';
					
					foreach($heading as $h){
						$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
						$colH++;
					}
					
					$room_by_room_data = $this->location_model->list_room_by_room_data_report( $location_id );
					
					$get_all_data_cnt = $this->location_model->get_all_data_count( $location_id );
					
					$cnt = count($get_all_data_cnt);
					if(!empty($room_by_room_data))
					{	
						$sd = $sd+1;
						$j=$sd;
						$i=1;
						foreach( $room_by_room_data as $room_by_room_datas )
						{
							
								if($room_by_room_datas->m_description == "" ){
									$material_desc = $room_by_room_datas->material_desc;
								}else{
									$material_desc =  $room_by_room_datas->m_description;
								}
								
								$friability = ucfirst( $room_by_room_datas->friability );
							
								$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$j,$i );
								$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$j,$room_by_room_datas->system_name );
								$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$j,$room_by_room_datas->material_name );
								
								if($room_by_room_datas->db_sample != "dash00"){
									$objPHPExcel->getActiveSheet()->setCellValue( 'D'.$j,$room_by_room_datas->m_identification );
								}else{
									$objPHPExcel->getActiveSheet()->setCellValue( 'D'.$j,'-' );
								}
								$objPHPExcel->getActiveSheet()->setCellValue( 'E'.$j,$material_desc );
																		
								if($room_by_room_datas->db_sample != "dash00"){
									$objPHPExcel->getActiveSheet()->setCellValue( 'F'.$j, $friability );
								}else{
									$objPHPExcel->getActiveSheet()->setCellValue( 'F'.$j,'-' );
								}
								
								if($room_by_room_datas->db_sample != "dash00"){
									$objPHPExcel->getActiveSheet()->setCellValue( 'G'.$j,$room_by_room_datas->access );
								}else{
									$objPHPExcel->getActiveSheet()->setCellValue( 'G'.$j,'-' );
								}
								
								if($room_by_room_datas->db_sample != "dash00"){
									$objPHPExcel->getActiveSheet()->setCellValue( 'H'.$j,$room_by_room_datas->good );
								}else{
									$objPHPExcel->getActiveSheet()->setCellValue( 'H'.$j,'-' );
								}
								
								if($room_by_room_datas->db_sample != "dash00"){
									$objPHPExcel->getActiveSheet()->setCellValue( 'I'.$j,$room_by_room_datas->fair );
								}else{
									$objPHPExcel->getActiveSheet()->setCellValue( 'I'.$j,'-' );
								}
								
								if($room_by_room_datas->db_sample != "dash00"){
									$objPHPExcel->getActiveSheet()->setCellValue( 'J'.$j,$room_by_room_datas->poor );
								}else{
									$objPHPExcel->getActiveSheet()->setCellValue( 'J'.$j,'-' );
								}
								
								if($room_by_room_datas->db_sample != "dash00"){
									$objPHPExcel->getActiveSheet()->setCellValue( 'K'.$j,$room_by_room_datas->total );
								}else{
									$objPHPExcel->getActiveSheet()->setCellValue( 'K'.$j,'-' );
								}
								
								if($room_by_room_datas->db_sample != "dash00"){
									$objPHPExcel->getActiveSheet()->setCellValue( 'L'.$j,$room_by_room_datas->units );
								}else{
									$objPHPExcel->getActiveSheet()->setCellValue( 'L'.$j,'-' );
								}	
								
								if($room_by_room_datas->db_sample != "dash00"){
									$objPHPExcel->getActiveSheet()->setCellValue( 'M'.$j,$room_by_room_datas->debris );
								}else{
									$objPHPExcel->getActiveSheet()->setCellValue( 'M'.$j,'-' );
								}
								
								if($room_by_room_datas->db_sample != "dash00"){
									$objPHPExcel->getActiveSheet()->setCellValue( 'N'.$j,$room_by_room_datas->unit );
								}else{
									$objPHPExcel->getActiveSheet()->setCellValue( 'N'.$j,'-' );
								}
								
								if($room_by_room_datas->db_sample != "dash00"){
									$objPHPExcel->getActiveSheet()->setCellValue( 'O'.$j,$room_by_room_datas->db_sample );
								}else{
									$objPHPExcel->getActiveSheet()->setCellValue( 'O'.$j,'-' );
								}
								
								$objPHPExcel->getActiveSheet()->setCellValue( 'P'.$j,$room_by_room_datas->rst );
								$objPHPExcel->getActiveSheet()->setCellValue( 'Q'.$j,$room_by_room_datas->r_hazard );
								
								if($room_by_room_datas->db_sample != "dash00"){
									$objPHPExcel->getActiveSheet()->setCellValue( 'R'.$j,$room_by_room_datas->action_number );
								}else{
									$objPHPExcel->getActiveSheet()->setCellValue( 'R'.$j,'-' );
								}
							
								$id = $room_by_room_datas->r_id;
								$list_room_by_room_data_child = $this->location_model->list_room_by_room_data_child( $id );
			
									if(isset($list_room_by_room_data_child))
									{
										$j++;
										$i++;
										foreach( $list_room_by_room_data_child as $list_room_by_room_data_childs )
										{
											//echo "<pre>";print_r($list_room_by_room_data_childs);
											if($list_room_by_room_data_childs->m_description == "" ){
												$material_desc = $list_room_by_room_data_childs->material_desc;
											}else{
												$material_desc =  $list_room_by_room_data_childs->m_description;
											}
											
											$friability = ucfirst( $list_room_by_room_data_childs->friability );
										
											$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$j,$i );
											$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$j,$list_room_by_room_data_childs->system_name );
											$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$j,$list_room_by_room_data_childs->material_name );
											
											if($list_room_by_room_data_childs->db_sample != "dash00"){
												$objPHPExcel->getActiveSheet()->setCellValue( 'D'.$j,$list_room_by_room_data_childs->m_identification );
											}else{
												$objPHPExcel->getActiveSheet()->setCellValue( 'D'.$j,'-' );
											}
											$objPHPExcel->getActiveSheet()->setCellValue( 'E'.$j,$material_desc );
																					
											if($list_room_by_room_data_childs->db_sample != "dash00"){
												$objPHPExcel->getActiveSheet()->setCellValue( 'F'.$j, $friability );
											}else{
												$objPHPExcel->getActiveSheet()->setCellValue( 'F'.$j,'-' );
											}
											
											if($list_room_by_room_data_childs->db_sample != "dash00"){
												$objPHPExcel->getActiveSheet()->setCellValue( 'G'.$j,$list_room_by_room_data_childs->access );
											}else{
												$objPHPExcel->getActiveSheet()->setCellValue( 'G'.$j,'-' );
											}
											
											if($list_room_by_room_data_childs->db_sample != "dash00"){
												$objPHPExcel->getActiveSheet()->setCellValue( 'H'.$j,$list_room_by_room_data_childs->good );
											}else{
												$objPHPExcel->getActiveSheet()->setCellValue( 'H'.$j,'-' );
											}
											
											if($list_room_by_room_data_childs->db_sample != "dash00"){
												$objPHPExcel->getActiveSheet()->setCellValue( 'I'.$j,$list_room_by_room_data_childs->fair );
											}else{
												$objPHPExcel->getActiveSheet()->setCellValue( 'I'.$j,'-' );
											}
											
											if($list_room_by_room_data_childs->db_sample != "dash00"){
												$objPHPExcel->getActiveSheet()->setCellValue( 'J'.$j,$list_room_by_room_data_childs->poor );
											}else{
												$objPHPExcel->getActiveSheet()->setCellValue( 'J'.$j,'-' );
											}
											
											if($list_room_by_room_data_childs->db_sample != "dash00"){
												$objPHPExcel->getActiveSheet()->setCellValue( 'K'.$j,$list_room_by_room_data_childs->total );
											}else{
												$objPHPExcel->getActiveSheet()->setCellValue( 'K'.$j,'-' );
											}
											
											if($list_room_by_room_data_childs->db_sample != "dash00"){
												$objPHPExcel->getActiveSheet()->setCellValue( 'L'.$j,$list_room_by_room_data_childs->units );
											}else{
												$objPHPExcel->getActiveSheet()->setCellValue( 'L'.$j,'-' );
											}	
											
											if($list_room_by_room_data_childs->db_sample != "dash00"){
												$objPHPExcel->getActiveSheet()->setCellValue( 'M'.$j,$list_room_by_room_data_childs->debris );
											}else{
												$objPHPExcel->getActiveSheet()->setCellValue( 'M'.$j,'-' );
											}
											
											if($list_room_by_room_data_childs->db_sample != "dash00"){
												$objPHPExcel->getActiveSheet()->setCellValue( 'N'.$j,$list_room_by_room_data_childs->unit );
											}else{
												$objPHPExcel->getActiveSheet()->setCellValue( 'N'.$j,'-' );
											}
											
											if($list_room_by_room_data_childs->db_sample != "dash00"){
												$objPHPExcel->getActiveSheet()->setCellValue( 'O'.$j,$list_room_by_room_data_childs->db_sample );
											}else{
												$objPHPExcel->getActiveSheet()->setCellValue( 'O'.$j,'-' );
											}
											
											$objPHPExcel->getActiveSheet()->setCellValue( 'P'.$j,$list_room_by_room_data_childs->rst );
											$objPHPExcel->getActiveSheet()->setCellValue( 'Q'.$j,$list_room_by_room_data_childs->r_hazard );
											
											if($list_room_by_room_data_childs->db_sample != "dash00"){
												$objPHPExcel->getActiveSheet()->setCellValue( 'R'.$j,$list_room_by_room_data_childs->action_number );
											}else{
												$objPHPExcel->getActiveSheet()->setCellValue( 'R'.$j,'-' );
											}
									
										
										}									
									}
							
							$j++;
							$i++;
						}
					}
					/*================ For consultant Info =========================*/
					
					$sd = $sd+$cnt;
					$rowNumberH = $sd;
					$colH = 'A';
					
					foreach($heading5 as $h){
						$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
						$colH++;
					}
					
						$sd = $sd+1;
						$rownumber = $sd;
						$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$notes );
					
					$sd++;
				}		
					$objPHPExcel->getActiveSheet()->freezePane('A2');
					
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
					
					$fname =  $building_id.'.xls';
					$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/locations/';
					
					$download_link = 'uploads/reports/locations/'.$fname;
					
					$objWriter->save($path.$fname);
					echo $download_link;
					
			}else{
				
				/*===List PDF ==*/
				$data['client_info'] 		= $this->user_model->get_client_info( $client_id );
				$data['list_building']  	= $this->building_model->get_building_data( $building_id );				
				$data['location_data']  	= $this->location_model->get_all_location_data( $building_id );
				
				$pdfFilePath = "Room_by_room_all_locations.pdf";
				$html = $this->load->view('reports/all_locations_pdf_export', $data, true);
				
				$this->load->library('m_pdf');
				$this->m_pdf->pdf->setFooter("Page {PAGENO} of {nb}");
				$this->m_pdf->pdf->WriteHTML($html);
				
				$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/locations/';
				
				$this->m_pdf->pdf->Output($path.$pdfFilePath, "F");
				
				$download_link = 'uploads/reports/locations/'.$pdfFilePath;
				echo $download_link;
			}	
			
	}
	
	/*===PDF View for location data==*/
	public function get_location_data_listed( $location_id, $d )
	{
		$location_data1  = $this->location_model->get_location_data( $location_id );
		
		echo '<tr>
				<td style="background-color:#fff !important;text-align:left !important;" rowspan="1" colspan="2"><b>Location Name:</b> '.$location_data1->location_name.'</td>
				<td style="background-color:#fff !important;text-align:left !important;" rowspan="1" colspan="2"><b>Location Number:</b> '.$location_data1->location_id.'</td>
				<td style="background-color:#fff !important;text-align:left !important;" rowspan="1" colspan="2"><b>Area of Location:</b> '.$location_data1->square_feet.'</td>
				<td style="background-color:#fff !important;text-align:left !important;" rowspan="1" colspan="1"><b>Floor:</b> '.$location_data1->floor.'</td></tr><tr>
				<td rowspan="1" colspan="2" style="text-align:left !important;"><b>Consultant Name:</b> '.$location_data1->consultant_name.'</td>
				<td rowspan="1" colspan="2" style="text-align:left !important;"><b>Last Survey Date:</b> '.$location_data1->survey_date.'</td>
				<td rowspan="1" colspan="3" style="text-align:left !important;"><b>Last Re-assessment Date:</b> '.$location_data1->last_reassessment.'</td>
			</tr>';		
	}
	
	/*===all location rbr view in PDF====*/
	public function list_room_by_room_all_location( $location_id )
	{
		
		$id = $location_id;
		$list_room_by_room_data = $this->location_model->list_room_by_room_data( $id );
			if(!empty($list_room_by_room_data))
			{
				
				$i=1.0;
				foreach( $list_room_by_room_data as $list_room_by_room_datas ){
				?>
				<tr id="room_by-id-<?php echo $list_room_by_room_datas->r_id; ?>">
					<td><?php echo $i.'.0'; ?></td>
					<td>
						<?php echo $list_room_by_room_datas->system_name;?>
					</td>
					<td>
						<?php echo $list_room_by_room_datas->material_name;?>
					</td>
					<td>
					<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{ ?>
						<?php echo $list_room_by_room_datas->m_identification;?>
					<?php } ?>	
					</td>
					<td>
						<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
						<?php if($list_room_by_room_datas->m_description == "" ){ echo $list_room_by_room_datas->material_desc;}else{echo $list_room_by_room_datas->m_description;}?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
						<?php echo ucfirst($list_room_by_room_datas->friability);?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
						<?php echo ucfirst($list_room_by_room_datas->access);?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_datas->good;?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_datas->fair;?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_datas->poor;?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_datas->total;?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
						<?php if(!empty($list_room_by_room_datas->units)) {$this->get_units_code( $list_room_by_room_datas->units);}?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_datas->debris;?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
						<?php if(!empty($list_room_by_room_datas->unit)) {$this->get_units_code( $list_room_by_room_datas->unit);}?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_datas->sample_rst;?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_datas->db_sample;?>
						<?php } ?>
					</td>
					<td>
						<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_datas->rst;?>
						<?php } ?>
					</td>													
					<td><?php echo $list_room_by_room_datas->r_hazard;?></td>
					<td>
						<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
						<?php echo $list_room_by_room_datas->action_number;?>
						<?php } ?>
					</td>
					<td></td>
				</tr>
				
				<!--============Child List==============-->
					<?php $this->list_room_by_room_data_child( $list_room_by_room_datas->r_id, $id, $i );?>
				<?php 
				
				$i++;			
				}
			}else{ ?>	<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
			</tr>											
			<?php }
			
	}
	
	public function get_notes( $location_id )
	{
		$notes = $this->location_model->get_notes( $location_id );
		echo nl2br($notes->note);
	}
	
	
	/*====================== Building Summary =================================*/
	
	public function building_summary( $cid=NULL )
	{
		$bidds = $this->building_model->get_building_list_clientt( $cid );
		$bids = $bidds->assigned_buildings;		
		$data['all_buildings'] = $this->building_model->get_building_lists( $bids );
		$data['bids'] = $bids;
		$data['client_id'] = $cid;
		$this->load->view('templates/header.php');
		$this->load->view('reports/building_summary',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*===Get building summary====*/
	public function export_building_summary_all()
	{
		
		$client_id 			= $this->input->post('client_id');
		$building_ids 		= $this->input->post('building_id');
		$bids 				= $this->input->post('bids');
		$report_type 		= $this->input->post('report_type');
		
		if( isset( $bids ) )
		{
			$building_ids = explode(',',$bids);
		}
		
		$client_info     	= $this->user_model->get_client_info( $client_id );
		$client_name 		= $client_info->client_name;
		
		/*===In Excel Format layout==*/
		if( $report_type == "excel" )
		{

			$this->load->library( 'excel' );	
			$objPHPExcel = new PHPExcel( );
			$objPHPExcel->getActiveSheet( )->setTitle( 'Building_Summary' );
				
			
			$sd=1;
			foreach( $building_ids as $building_id )
			{
				
				$system_material = $this->building_model->get_system_and_midentification( $building_id );
				$building_detail = $this->building_model->get_building_data( $building_id );
				
				$building_address 		= $building_detail->address;
				$building_developement 	= $building_detail->development;
				$building_district 		= $building_detail->district;
				
				if($system_material != "")
				{
					$material_identification='';
					$system='';
					
					foreach($system_material as $system_materials)
					{
						$material_identification  	.= $system_materials->m_id.',';
						$system 					.= $system_materials->system.',';
					}
					
					$material_identification_comma = rtrim($material_identification,',');
					$system_comma = rtrim($system,',');
					
					$rst = $this->building_model->get_final_b_report_rst( $material_identification_comma, $system_comma, $building_id );
					
					if(!empty($rst))
					{
					
						$heading1 = array('Client Name', 'Building Address');
						$heading2 = array('Development', 'District');
						$heading  = array( 'System','Material Name','Material Identification','Material Description','Locations','Friability','Accessibility','Total Quantity','Units','Results','Hazard','Priority','Estimated Cost' );
						
						/*==================== For Client and Building Info =========================*/
					
						$rowNumberH = $sd;
						$colH = 'A';
						
						foreach($heading1 as $h){
							$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
							$colH++;
						}
							$sd = $sd+1;
							$rownumber = $sd;
							$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$client_name );
							$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$building_address );
							
					/*==================== For Client and Building Info ==================*/		
					/*==================== For Building Sub Info =========================*/
					
						$sd = $sd+1;
						$rowNumberH = $sd;
						$colH = 'A';
						
						foreach($heading2 as $h){
							$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
							$colH++;
						}
						
							$sd = $sd+1;
							$rownumber = $sd;
							$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$building_developement );
							$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$building_district );		
							
					/*==================== For Building Sub Info =========================*/
										
						
						$sd = $sd+1;
						$rowNumberH = $sd;
						$colH = 'A';
						
						foreach($heading as $h){
							$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
							$colH++;
						}
						
						
						$cnt = count($rst);	
						if($rst != "")
						{
								
							$sd = $sd+1;
							$j=$sd;
							$i=0;
							foreach($rst as $rsts)
							{
								if($i=1){
									
									$location_ids = $this->building_model->get_location_ids($rsts->location_ids);
									$l='';
									foreach($location_ids as $location_idss){
										$l .= $location_idss->location_id.' ,';
									}
									$location_ids = rtrim($l,' ,');
									
								}
								
								$system 				= $rsts->system_name;
								$material_name 			= $rsts->material_name;							
								$m_identification 		= $rsts->m_identification;
								
								if($rsts->m_description == '')
								{
									$material_desc 			= $rsts->material_desc;
								}else{	
									$material_desc 			= $rsts->m_description;
								}
								
								$friability 			= ucfirst( $rsts->friability);
								$access 				= $rsts->access;
								$total 					= $rsts->grand;
								
								$unit 					= $rsts->unit;
								
								$result 				= $rsts->rst;
								$r_hazard 				= $rsts->r_hazard;
								$action 				= $rsts->action_number;
								$estimated_cost 		= "";
								
								
								/*================ For Room By Room Info =========================*/
									
								
									$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$j,$system );
									$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$j,$material_name );
									$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$j,$m_identification );
									$objPHPExcel->getActiveSheet()->setCellValue( 'D'.$j,$material_desc );
									$objPHPExcel->getActiveSheet()->setCellValue( 'E'.$j,$location_ids );
									$objPHPExcel->getActiveSheet()->setCellValue( 'F'.$j,$friability );
									$objPHPExcel->getActiveSheet()->setCellValue( 'G'.$j,$access );
									$objPHPExcel->getActiveSheet()->setCellValue( 'H'.$j,$total );
									$objPHPExcel->getActiveSheet()->setCellValue( 'I'.$j,$unit );
									$objPHPExcel->getActiveSheet()->setCellValue( 'J'.$j,$result );
									$objPHPExcel->getActiveSheet()->setCellValue( 'K'.$j,$r_hazard );
									$objPHPExcel->getActiveSheet()->setCellValue( 'L'.$j,$action );
									$objPHPExcel->getActiveSheet()->setCellValue( 'M'.$j,$estimated_cost );
								$j++;
								$i++;
							}
									
						} 
						/*================ For consultant Info =========================*/
						if(empty($rst)){
							$sd = $sd-1;
						}else{
							$sd = $sd+$cnt;
						}
					}
				}
				
				$sd++;
				
			}
						
				$objPHPExcel->getActiveSheet()->freezePane('A2');
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
				
				$fname =  'test.xls';
				$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/building_summary/';
				
				$download_link = 'uploads/reports/building_summary/'.$fname;				
				
				$objWriter->save($path.$fname);
				
				echo $download_link;	
				
		}else{
				/*==PDF layout===*/
			
				$data['client_info'] 		= $this->user_model->get_client_info( $client_id );
				$data['building_ids']		= $building_ids;
				
				$pdfFilePath = "building_summary.pdf";
				$html = $this->load->view('reports/building_summary_pdf_export', $data, true);
				
				 $this->load->library('m_pdf');
				$this->m_pdf->pdf->setFooter("Page {PAGENO} of {nb}");
				$this->m_pdf->pdf->WriteHTML($html);
				
				$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/building_summary/'; 
				
				$this->m_pdf->pdf->Output($path.$pdfFilePath, "F");
				
				$download_link = 'uploads/reports/building_summary/'.$pdfFilePath;
				echo $download_link;
		}
	
	
				
	}
	
	
	/*=====List confirmed and presumed report=========*/
	
	public function confirmed_presumed_summary( $cid=NULL )
	{
		$bidds = $this->building_model->get_building_list_clientt( $cid );
		$bids = $bidds->assigned_buildings;		
		$data['all_buildings'] = $this->building_model->get_building_lists( $bids );
		$data['bids'] = $bids;
		$data['client_id'] = $cid;
		$this->load->view('templates/header.php');
		$this->load->view('reports/confirmed_presumed_summary',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*===Get building summary====*/
	public function export_confirmed_presumed_summary_all()
	{
		
		$client_id 			= $this->input->post('client_id');
		$building_ids 		= $this->input->post('building_id');
		$bids 				= $this->input->post('bids');
		$report_type 		= $this->input->post('report_type');
		
		if( isset( $bids ) )
		{
			$building_ids = explode(',',$bids);
		}
		
		$client_info     	= $this->user_model->get_client_info( $client_id );
		$client_name 		= $client_info->client_name;
		
		/*===In Excel Format layout==*/
		if( $report_type == "excel" )
		{

			$this->load->library( 'excel' );	
			$objPHPExcel = new PHPExcel( );
			$objPHPExcel->getActiveSheet( )->setTitle( 'Confirmed_Presumed_Summary' );
				
			
			$sd=1;
			foreach( $building_ids as $building_id )
			{
				
				$system_material = $this->building_model->get_system_and_midentification( $building_id );
				$building_detail = $this->building_model->get_building_data( $building_id );
				
				$building_address 		= $building_detail->address;
				$building_developement 	= $building_detail->development;
				$building_district 		= $building_detail->district;
				
				if($system_material != "")
				{
					$material_identification='';
					$system='';
					
					foreach($system_material as $system_materials)
					{
						$material_identification  	.= $system_materials->m_id.',';
						$system 					.= $system_materials->system.',';
					}
					
					$material_identification_comma = rtrim($material_identification,',');
					$system_comma = rtrim($system,',');
					
					$rst = $this->building_model->get_final_b_report_rst( $material_identification_comma, $system_comma, $building_id );
					
					if(!empty($rst))
					{
					
						$heading1 = array('Client Name', 'Building Address');
						$heading2 = array('Development', 'District');
						$heading  = array( 'System','Material Name','Material Identification','Material Description','Locations','Friability','Accessibility','Total Quantity','Units','Results','Hazard','Priority','Estimated Cost' );
						
						/*==================== For Client and Building Info =========================*/
					
						$rowNumberH = $sd;
						$colH = 'A';
						
						foreach($heading1 as $h){
							$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
							$colH++;
						}
							$sd = $sd+1;
							$rownumber = $sd;
							$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$client_name );
							$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$building_address );
							
					/*==================== For Client and Building Info ==================*/		
					/*==================== For Building Sub Info =========================*/
					
						$sd = $sd+1;
						$rowNumberH = $sd;
						$colH = 'A';
						
						foreach($heading2 as $h){
							$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
							$colH++;
						}
						
							$sd = $sd+1;
							$rownumber = $sd;
							$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$building_developement );
							$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$building_district );		
							
					/*==================== For Building Sub Info =========================*/
										
						
						$sd = $sd+1;
						$rowNumberH = $sd;
						$colH = 'A';
						
						foreach($heading as $h){
							$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
							$colH++;
						}
						
						
						$cnt = count($rst);	
						if($rst != "")
						{
								
							$sd = $sd+1;
							$j=$sd;
							$i=0;
							foreach($rst as $rsts)
							{
								if($i=1){
									
									$location_ids = $this->building_model->get_location_ids($rsts->location_ids);
									$l='';
									foreach($location_ids as $location_idss){
										$l .= $location_idss->location_id.' ,';
									}
									$location_ids = rtrim($l,' ,');
									
								}
								
								$system 				= $rsts->system_name;
								$material_name 			= $rsts->material_name;							
								$m_identification 		= $rsts->m_identification;
								
								if($rsts->m_description == '')
								{
									$material_desc 			= $rsts->material_desc;
								}else{	
									$material_desc 			= $rsts->m_description;
								}
								
								$friability 			= ucfirst( $rsts->friability);
								$access 				= $rsts->access;
								$total 					= $rsts->grand;
								
								$unit 					= $rsts->unit;
								
								$result 				= $rsts->rst;
								$r_hazard 				= $rsts->r_hazard;
								$action 				= $rsts->action_number;
								$estimated_cost 		= "";
								
								
								/*================ For Room By Room Info =========================*/
									
								
									$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$j,$system );
									$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$j,$material_name );
									$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$j,$m_identification );
									$objPHPExcel->getActiveSheet()->setCellValue( 'D'.$j,$material_desc );
									$objPHPExcel->getActiveSheet()->setCellValue( 'E'.$j,$location_ids );
									$objPHPExcel->getActiveSheet()->setCellValue( 'F'.$j,$friability );
									$objPHPExcel->getActiveSheet()->setCellValue( 'G'.$j,$access );
									$objPHPExcel->getActiveSheet()->setCellValue( 'H'.$j,$total );
									$objPHPExcel->getActiveSheet()->setCellValue( 'I'.$j,$unit );
									$objPHPExcel->getActiveSheet()->setCellValue( 'J'.$j,$result );
									$objPHPExcel->getActiveSheet()->setCellValue( 'K'.$j,$r_hazard );
									$objPHPExcel->getActiveSheet()->setCellValue( 'L'.$j,$action );
									$objPHPExcel->getActiveSheet()->setCellValue( 'M'.$j,$estimated_cost );
								$j++;
								$i++;
							}
									
						} 
						/*================ For consultant Info =========================*/
						if(empty($rst)){
							$sd = $sd-1;
						}else{
							$sd = $sd+$cnt;
						}
					}
				}
				
				$sd++;
				
			}
						
				$objPHPExcel->getActiveSheet()->freezePane('A2');
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
				
				$fname =  'test.xls';
				$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/building_summary/';
				
				$download_link = 'uploads/reports/building_summary/'.$fname;				
				
				$objWriter->save($path.$fname);
				
				echo $download_link;	
				
		}else{
				/*==PDF layout===*/
			
				$data['client_info'] 		= $this->user_model->get_client_info( $client_id );
				$data['building_ids']		= $building_ids;
				
				$pdfFilePath = "confirmed_presumed_summary.pdf";
				$html = $this->load->view('reports/confirmed_presumed_summary_pdf_export', $data, true);
				
				 $this->load->library('m_pdf');
				$this->m_pdf->pdf->setFooter("Page {PAGENO} of {nb}");
				$this->m_pdf->pdf->WriteHTML($html);
				
				$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/building_summary/'; 
				
				$this->m_pdf->pdf->Output($path.$pdfFilePath, "F");
				
				$download_link = 'uploads/reports/building_summary/'.$pdfFilePath;
				echo $download_link;
		}
	
	
				
	}	
	
	/*=====List confirmed and presumed report=========*/
	
	
	
	/*==list building client==*/
	public function list_client_building_info( $bid=NULL, $cid=NULL )
	{
		
		$system_material = $this->building_model->get_system_and_midentification( $bid );
		if($system_material != "")
		{
			$material_identification='';
			$system='';
			
			foreach($system_material as $system_materials)
			{
				$material_identification  	.= $system_materials->m_id.',';
				$system 					.= $system_materials->system.',';
			}
			
			$material_identification_comma = rtrim($material_identification,',');
			$system_comma = rtrim($system,',');
			
			$rst = $this->building_model->get_final_b_report_rst( $material_identification_comma, $system_comma, $bid );
			
		}	
				$building_detail = $this->building_model->get_building_data( $bid );
				$client_name1 = $this->user_model->get_client_info( $cid );
						
				$client_name 			= $client_name1->client_name;
				$building_address 		= $building_detail->address;
				$building_developement 	= $building_detail->development;
				$building_district 		= $building_detail->district;
				
				echo '<tr>
						<td colspan="6" style="text-align:left !important;border:2px solid #ccc !important;"><b>Client Name:</b> '.$client_name.'</td>
						<td colspan="6" style="text-align:left !important;border:2px solid #ccc !important;"><b>Building Address:</b> '.$building_address.'</td>
					</tr>   
					<tr>    
						<td colspan="6" style="text-align:left !important;border:2px solid #ccc !important;"><b>Development:</b> '.$building_developement.'</td>
						<td colspan="6" style="text-align:left !important;border:2px solid #ccc !important;"><b>District:</b> '.$building_district.'</td>
					</tr>';
	}
	
	/*==list building summary for PDF view==*/	
	public function list_building_summry( $bid=NULL )
	{
		
		$system_material = $this->building_model->get_system_and_midentification( $bid );
		if($system_material != "")
		{
			$material_identification='';
			$system='';
			
			foreach($system_material as $system_materials)
			{
				$material_identification  	.= $system_materials->m_id.',';
				$system 					.= $system_materials->system.',';
			}
			
			$material_identification_comma = rtrim($material_identification,',');
			$system_comma = rtrim($system,',');
			
			$rst = $this->building_model->get_final_b_report_rst( $material_identification_comma, $system_comma, $bid );
			
			if(!empty($rst))
			{
				$x=0;	
				foreach($rst as $rsts)
				{
					
					if($x=1)
					{
									
						$location_ids = $this->building_model->get_location_ids($rsts->location_ids);
						$l='';
						foreach($location_ids as $location_idss){
							$l .= $location_idss->location_id.' ,';
						}
						$location_ids = rtrim($l,' ,');
						
					}
						$system 				= $rsts->system_name;
						$material_name 			= $rsts->material_name;							
						$m_identification 		= $rsts->m_identification;
						
						if($rsts->m_description == '')
						{
							$material_desc 			= $rsts->material_desc;
						}else{	
							$material_desc 			= $rsts->m_description;
						}
						
						$friability 			= ucfirst( $rsts->friability );
						$access 				= $rsts->access;
						$total 					= $rsts->grand;
						
						
						if( $rsts->units !="" )
						{
							$unit 					= $rsts->units;
						}else{	
							$unit 					= $rsts->unit;
						}	
						
						$result 				= $rsts->rst;
						$r_hazard 				= $rsts->r_hazard;
						$action 				= $rsts->action_number;
						$estimated_cost 		= "";
						?>
					
						<tr id="room_by-id-<?php echo $rsts->location_ids; ?>">
							<td>
								<?php echo $system;?>
							</td>
							<td>
								<?php echo $material_name;?>
							</td>
							<td>
								<?php echo $m_identification;?>
							</td>
							<td>
								<?php echo $material_desc; ?>
							</td>
							<td width="700" class="testt" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word;width:700px;float: left;display: inline-block;">
								<?php //echo $location_ids;?>
								<?php echo wordwrap($location_ids,100,"<br>\n");?>								
							</td>
							<td>
								<?php echo ucfirst($friability);?>
							</td>
							<td>
								<?php echo ucfirst($access);?>
							</td>
							<td>
								<?php echo $total;?>
							</td>
							<td>
								<?php if( $unit != "" ){ echo $this->get_units_code( $unit );}?>
							</td>
							<td>
								<?php echo $result;?>
							</td>
							<td>
								<?php echo $r_hazard; ?>
							</td>
							<td>
								<?php echo $action;?>
							</td>
							<td>
								<?php echo $estimated_cost;?>
							</td>
						</tr>	
					<?php 	
				
					$x++;			
				
				}
			}
			
		}
		
	}
	
	/*-----------------------------District Summary Report----------------------------------------*/
	
	
	public function district_summary( $cid=NULL )
	{
		$bidds = $this->building_model->get_building_list_clientt( $cid );
		$bids = $bidds->assigned_buildings;
		$data['all_buildings'] = $this->building_model->get_building_lists( $bids );
		$data['client_id'] = $cid;
		$this->load->view('templates/header.php');
		$this->load->view('reports/district_summary',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*===Export district summary report for Excel and PDF===*/
	public function export_district_summary_all(  )
	{
		
		$client_id 			= $this->input->post('client_id');
		$building_ids 		= $this->input->post('building_id');
		$report_type 		= $this->input->post('report_type');
		$district_id 		= $this->input->post('district_id');
		
		
		$client_info     	= $this->user_model->get_client_info( $client_id );
		$client_name 		= $client_info->client_name;
		
		
		if( $report_type == "excel" )
		{
				
			$this->load->library( 'excel' );	
			$objPHPExcel = new PHPExcel( );
			$objPHPExcel->getActiveSheet( )->setTitle( 'District_Summary' );
			
			$l='';
				foreach($building_ids as $building_idsss){
					$l .= $building_idsss.',';
				}
			$building_ids = rtrim($l,',');
				
			$building_ids = $this->building_model->filter_buildings( $district_id, $building_ids );
			
			
			$sd=1;
			foreach( $building_ids as $building_id )
			{
				$building_id = $building_id->id;
				$system_material = $this->building_model->get_system_and_midentification( $building_id );
				$building_detail = $this->building_model->get_building_data( $building_id );
				
				$building_address 		= $building_detail->address;
				$building_developement 	= $building_detail->development;
				$building_district 		= $building_detail->district;
				
				if($system_material != "")
				{
					$material_identification='';
					$system='';
					
					foreach($system_material as $system_materials)
					{
						$material_identification  	.= $system_materials->m_id.',';
						$system 					.= $system_materials->system.',';
					}
					
					$material_identification_comma = rtrim($material_identification,',');
					$system_comma = rtrim($system,',');
					
					$rst = $this->building_model->get_final_dist_report_rst( $material_identification_comma, $system_comma, $building_id );
					
					if(!empty($rst))
					{
					
						$heading1 = array('Client Name', 'Building Address');
						$heading2 = array('Development', 'District');
						$heading  = array( 'System','Material Name','Material Identification','Material Description','Development','Friability','Total Quantity','Units','Results','Hazard','Priority','Estimated Cost' );
						
						/*==================== For Client and Building Info =========================*/
					
						$rowNumberH = $sd;
						$colH = 'A';
						
						foreach($heading1 as $h){
							$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
							$colH++;
						}
							$sd = $sd+1;
							$rownumber = $sd;
							$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$client_name );
							$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$building_address );
							
					/*==================== For Client and Building Info ==================*/		
					/*==================== For Building Sub Info =========================*/
					
						$sd = $sd+1;
						$rowNumberH = $sd;
						$colH = 'A';
						
						foreach($heading2 as $h){
							$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
							$colH++;
						}
						
							$sd = $sd+1;
							$rownumber = $sd;
							$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$building_developement );
							$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$building_district );		
							
					/*==================== For Building Sub Info =========================*/
										
						
						$sd = $sd+1;
						$rowNumberH = $sd;
						$colH = 'A';
						
						foreach($heading as $h){
							$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
							$colH++;
						}
						
						
						$cnt = count($rst);	
						if($rst != "")
						{
								
							$sd = $sd+1;
							$j=$sd;
							$i=0;
							foreach($rst as $rsts)
							{
								$system 				= $rsts->system_name;
								$material_name 			= $rsts->material_name;							
								$m_identification 		= $rsts->m_identification;
								
								if($rsts->m_description == '')
								{
									$material_desc 			= $rsts->material_desc;
								}else{	
									$material_desc 			= $rsts->m_description;
								}
								
								$development 			= $rsts->development;
								$friability 			= ucfirst( $rsts->friability);
								$total 					= $rsts->grand;
								
								$unit 					= $rsts->unit;
								
								$result 				= $rsts->rst;
								$r_hazard 				= $rsts->r_hazard;
								$action 				= $rsts->action_number;
								$estimated_cost 		= "";
								
								
								/*================ For Room By Room Info =========================*/
									
								
									$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$j,$system );
									$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$j,$material_name );
									$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$j,$m_identification );
									$objPHPExcel->getActiveSheet()->setCellValue( 'D'.$j,$material_desc );
									$objPHPExcel->getActiveSheet()->setCellValue( 'E'.$j,$development );
									$objPHPExcel->getActiveSheet()->setCellValue( 'F'.$j,$friability );
									$objPHPExcel->getActiveSheet()->setCellValue( 'G'.$j,$total );
									$objPHPExcel->getActiveSheet()->setCellValue( 'H'.$j,$unit );
									$objPHPExcel->getActiveSheet()->setCellValue( 'I'.$j,$result );
									$objPHPExcel->getActiveSheet()->setCellValue( 'J'.$j,$r_hazard );
									$objPHPExcel->getActiveSheet()->setCellValue( 'K'.$j,$action );
									$objPHPExcel->getActiveSheet()->setCellValue( 'L'.$j,$estimated_cost );
								$j++;
								$i++;
							}
									
						} 
						/*================ For consultant Info =========================*/
						if(empty($rst)){
							$sd = $sd-1;
						}else{
							$sd = $sd+$cnt;
						}
					}
				}
				
				$sd++;
				
			}
						
				$objPHPExcel->getActiveSheet()->freezePane('A2');
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
				
				$fname =  'district_s.xls';
				$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/district_summary/';
				
				$download_link = 'uploads/reports/district_summary/'.$fname;				
				
				$objWriter->save($path.$fname);
				
				echo $download_link;	
				
		}else{
			
				$data['client_info'] 		= $this->user_model->get_client_info( $client_id );
				$data['building_ids']		= $building_ids;
				
				$pdfFilePath = "district_summary.pdf";
				$html = $this->load->view('reports/district_summary_pdf_export', $data, true);
				
				 $this->load->library('m_pdf');
				$this->m_pdf->pdf->setFooter("Page {PAGENO} of {nb}");
				$this->m_pdf->pdf->WriteHTML($html);
				
				$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/district_summary/'; 
				
				$this->m_pdf->pdf->Output($path.$pdfFilePath, "F");
				
				$download_link = 'uploads/reports/district_summary/'.$pdfFilePath;
				echo $download_link;
		}
	
	}
	
	public function get_development_name( $build )
	{
		$rst = $this->building_model->get_development_name_b( $build );
		echo $rst->development;
	}
	
	/*===District PDF View===*/
	public function list_district_summry( $bid=NULL )
	{
		
		$system_material = $this->building_model->get_system_and_midentification( $bid );
		if($system_material != "")
		{
			$material_identification='';
			$system='';
			
			foreach($system_material as $system_materials)
			{
				$material_identification  	.= $system_materials->m_id.',';
				$system 					.= $system_materials->system.',';
			}
			
			$material_identification_comma = rtrim($material_identification,',');
			$system_comma = rtrim($system,',');
			
			$rst = $this->building_model->get_final_dist_report_rst( $material_identification_comma, $system_comma, $bid );
			/* echo $this->db->last_query();die; */
			
			if(!empty($rst))
			{
				$x=0;	
				foreach($rst as $rsts)
				{
						$build 					= $rsts->building_ID;
						$system 				= $rsts->system_name;
						$material_name 			= $rsts->material_name;
						$m_identification 		= $rsts->m_identification;
						
						if($rsts->m_description == '')
						{
							$material_desc 			= $rsts->material_desc;
						}else{
							$material_desc 			= $rsts->m_description;
						}
						
						$friability 			= ucfirst( $rsts->friability);
						/* $development 			= $this->get_development_name($rsts->building_ID); */
						$total 					= $rsts->grand;
						
						if( $rsts->units !="" )
						{
							$unit 					= $rsts->units;
						}else{	
							$unit 					= $rsts->unit;
						}	
						
						$result 				= $rsts->rst;
						$r_hazard 				= $rsts->r_hazard;
						$action 				= $rsts->action_number;
						$estimated_cost 		= "";
						?>
					
						<tr id="room_by-id-<?php echo $rsts->location_ids; ?>">
							<td>
								<?php echo $system;?>
							</td>
							<td>
								<?php echo $material_name;?>
							</td>
							<td>
								<?php echo $m_identification;?>
							</td>
							<td>
								<?php echo $material_desc; ?>
							</td>
							<td>
								<?php echo $this->get_development_name( $build );?>
							</td>
							<td>
								<?php echo ucfirst($friability);?>
							</td>
							<td>
								<?php echo $total;?>
							</td>
							<td>
								<?php if( $unit != "" ){ echo $this->get_units_code( $unit );}?>
							</td>
							<td>
								<?php echo $result;?>
							</td>
							<td>
								<?php echo $r_hazard; ?>
							</td>
							<td>
								<?php echo $action;?>
							</td>
							<td>
								<?php echo $estimated_cost;?>
							</td>
						</tr>	
					<?php 	
				
					$x++;			
				
				}
			}
			
		}
		
	}
	
	/*--------------------------------Material Summary Report-------------------------------------------*/
	
	public function material_identi_summary( $cid=NULL )
	{
		$bidds = $this->building_model->get_building_list_clientt( $cid );
		$bids = $bidds->assigned_buildings;
		$data['all_buildings'] = $this->building_model->get_building_lists( $bids );
		$data['client_id'] = $cid;
		$this->load->view('templates/header.php');
		$this->load->view('reports/material_identi_summary',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*=====Export report in material summ======*/
	public function export_material_summary_all( )
	{
		
		$client_id 			= $this->input->post('client_id');
		$building_ids 		= $this->input->post('building_id');
		$report_type 		= $this->input->post('report_type');
		
		$client_info     	= $this->user_model->get_client_info( $client_id );
		$client_name 		= $client_info->client_name;
		
		if( $report_type == "excel" )
		{

			$this->load->library( 'excel' );	
			$objPHPExcel = new PHPExcel( );
			$objPHPExcel->getActiveSheet( )->setTitle( 'Material_Summary' );
		
			$sd=1;
			foreach( $building_ids as $building_id )
			{
				
				$building_detail = $this->building_model->get_building_data( $building_id );
				
				$building_address 		= $building_detail->address;
				$building_developement 	= $building_detail->development;
				$building_district 		= $building_detail->district;
				
				$rst = $this->building_model->get_final_material_report_rst( $building_id );
				
					if(!empty($rst))
					{
					
						$heading1 = array('Client Name', 'Building Address');
						$heading2 = array('Development', 'District');
						$heading  = array( 'Material','Material Identification','Material Description' );
						
						/*==================== For Client and Building Info =========================*/
					
						$rowNumberH = $sd;
						$colH = 'A';
						
						foreach($heading1 as $h){
							$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
							$colH++;
						}
							$sd = $sd+1;
							$rownumber = $sd;
							$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$client_name );
							$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$building_address );
							
					/*==================== For Client and Building Info ==================*/		
					/*==================== For Building Sub Info =========================*/
					
						$sd = $sd+1;
						$rowNumberH = $sd;
						$colH = 'A';
						
						foreach($heading2 as $h){
							$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
							$colH++;
						}
						
							$sd = $sd+1;
							$rownumber = $sd;
							$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$building_developement );
							$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$building_district );		
							
					/*==================== For Building Sub Info =========================*/
										
						
						$sd = $sd+1;
						$rowNumberH = $sd;
						$colH = 'A';
						
						foreach($heading as $h){
							$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
							$colH++;
						}
						
						
						$cnt = count($rst);	
						if($rst != "")
						{
								
							$sd = $sd+1;
							$j=$sd;
							$i=0;
							foreach($rst as $rsts)
							{
								$material_name 			= $rsts->material_name;							
								$m_identification 		= $rsts->m_identification;
								
								if($rsts->m_description == '')
								{
									$material_desc 			= $rsts->material_desc;
								}else{	
									$material_desc 			= $rsts->m_description;
								}								
								
								/*================ For Room By Room Info =========================*/
									
									$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$j,$material_name );
									$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$j,$m_identification );
									$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$j,$material_desc );
								$j++;
								$i++;
							}
									
						} 
						/*================ For consultant Info =========================*/
						if(empty($rst)){
							$sd = $sd-1;
						}else{
							$sd = $sd+$cnt;
						}
					}
				
				$sd++;
			}
				
				$objPHPExcel->getActiveSheet()->freezePane('A2');
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
				
				$fname =  'material_rst.xls';
				$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/material_summary/';
				
				$download_link = 'uploads/reports/material_summary/'.$fname;				
				
				$objWriter->save($path.$fname);
				
				echo $download_link;
			
			
		}else{
				
				$data['client_info'] 		= $this->user_model->get_client_info( $client_id );
				$data['building_ids']		= $building_ids;
				
				$pdfFilePath = "material_summary.pdf";
				$html = $this->load->view('reports/material_summary_pdf_export', $data,true);
				
				$this->load->library('m_pdf');
				$this->m_pdf->pdf->setFooter("Page {PAGENO} of {nb}");
				$this->m_pdf->pdf->WriteHTML($html);
				
				$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/material_summary/'; 
				
				$this->m_pdf->pdf->Output($path.$pdfFilePath, "F");
				
				$download_link = 'uploads/reports/material_summary/'.$pdfFilePath;
				echo $download_link;
		}	
		
	}

	/*===material summary PDF view==*/	
	public function list_material_summry( $bid=NULL )
	{	
		
		$rst = $this->building_model->get_final_material_report_rst( $bid );
		
		if(!empty($rst))
		{
			$x=0;	
			foreach($rst as $rsts)
			{
				
					$material_name 			= $rsts->material_name;							
					$m_identification 		= $rsts->m_identification;
					
					if($rsts->m_description == '')
					{
						$material_desc 			= $rsts->material_desc;
					}else{	
						$material_desc 			= $rsts->m_description;
					}
					?>
				
					<tr id="room_by-id-<?php echo $rsts->m_id; ?>">
						<td colspan="6">
							<?php echo $material_name;?>
						</td>
						<td colspan="6">
							<?php echo $m_identification;?>
						</td>
						<td colspan="6">
							<?php echo $material_desc; ?>
						</td>
					</tr>	
				<?php 	
			
				$x++;			
			
			}
		
		}
		
	}

	
	/*-------------------------------Development Summary-------------------------------------*/
	
	public function development_summary( $cid=NULL )
	{
		$bidds = $this->building_model->get_building_list_clientt( $cid );
		$bids = $bidds->assigned_buildings;
		$data['all_buildings'] = $this->building_model->get_building_lists( $bids );
		$data['bids'] = $bids;
		$data['client_id'] = $cid;
		$building_ids = explode( ',',$bids );
		foreach($building_ids as $building_id)
		{
			$develop[] = $this->building_model->get_all_develop( $building_id );
		}		
		$data['develop'] = $develop;
		
		$this->load->view('templates/header.php');
		$this->load->view('reports/development_summary',$data);
		$this->load->view('templates/footer.php');
	}

	/*==Dev Report=*/	
	public function export_dev_summary_all( )
	{
		$client_id 			= $this->input->post('client_id');
		$building_ids 		= $this->input->post('building_id');
		$bids 				= $this->input->post('bids');
		$report_type 		= $this->input->post('report_type');
		
		if( isset( $bids ) )
		{
			$building_ids = explode(',',$bids);
		}		
		
		$client_info     	= $this->user_model->get_client_info( $client_id );
		$client_name 		= $client_info->client_name;
		
		
		if( $report_type == "excel" )
		{

			$this->load->library( 'excel' );	
			$objPHPExcel = new PHPExcel( );
			$objPHPExcel->getActiveSheet( )->setTitle( 'Development_Summary' );	
			
			$sd=1;
			foreach( $building_ids as $building_id )
			{
				
				$system_material = $this->building_model->get_system_and_midentification( $building_id );
				$building_detail = $this->building_model->get_building_data( $building_id );
				
				$building_address 		= $building_detail->address;
				$building_developement 	= $building_detail->development;
				$building_district 		= $building_detail->district;
				
				if($system_material != "")
				{
					$material_identification='';
					$system='';
					
					foreach($system_material as $system_materials)
					{
						$material_identification  	.= $system_materials->m_id.',';
						$system 					.= $system_materials->system.',';
					}
					
					$material_identification_comma = rtrim($material_identification,',');
					$system_comma = rtrim($system,',');
					
					
					$rst = $this->building_model->get_final_dev_report_rst( $material_identification_comma, $system_comma, $building_id );
					
					if(!empty($rst))
					{
					
						$heading1 = array('Client Name', 'Building Address');
						$heading2 = array('Development', 'District');
						$heading  = array( 'System','Material Name','Material Identification','Material Description','Locations','Friability','Accessibility','Total Quantity','Units','Results','Hazard','Priority','Estimated Cost' );
						
						/*==================== For Client and Building Info =========================*/
					
						$rowNumberH = $sd;
						$colH = 'A';
						
						foreach($heading1 as $h){
							$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
							$colH++;
						}
							$sd = $sd+1;
							$rownumber = $sd;
							$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$client_name );
							$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$building_address );
							
					/*==================== For Client and Building Info ==================*/		
					/*==================== For Building Sub Info =========================*/
					
						$sd = $sd+1;
						$rowNumberH = $sd;
						$colH = 'A';
						
						foreach($heading2 as $h){
							$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
							$colH++;
						}
						
							$sd = $sd+1;
							$rownumber = $sd;
							$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$building_developement );
							$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$building_district );		
							
					/*==================== For Building Sub Info =========================*/
										
						
						$sd = $sd+1;
						$rowNumberH = $sd;
						$colH = 'A';
						
						foreach($heading as $h){
							$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
							$colH++;
						}
						
						
						$cnt = count($rst);	
						if($rst != "")
						{
								
							$sd = $sd+1;
							$j=$sd;
							$i=0;
							foreach($rst as $rsts)
							{
								if($i=1){
									
									$location_ids = $this->building_model->get_location_ids($rsts->location_ids);
									$l='';
									foreach($location_ids as $location_idss){
										$l .= $location_idss->location_id.',';
									}
									$location_ids = rtrim($l,',');
									
								}
								
								$system 				= $rsts->system_name;
								$material_name 			= $rsts->material_name;							
								$m_identification 		= $rsts->m_identification;
								
								if($rsts->m_description == '')
								{
									$material_desc 			= $rsts->material_desc;
								}else{	
									$material_desc 			= $rsts->m_description;
								}
								
								$friability 			= ucfirst( $rsts->friability);
								$access 				= $rsts->access;
								$total 					= $rsts->grand;
								
								$unit 					= $rsts->unit;
								
								$result 				= $rsts->rst;
								$r_hazard 				= $rsts->r_hazard;
								$action 				= $rsts->action_number;
								$estimated_cost 		= "";
								
								
								/*================ For Room By Room Info =========================*/
									
								
									$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$j,$system );
									$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$j,$material_name );
									$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$j,$m_identification );
									$objPHPExcel->getActiveSheet()->setCellValue( 'D'.$j,$material_desc );
									$objPHPExcel->getActiveSheet()->setCellValue( 'E'.$j,$location_ids );
									$objPHPExcel->getActiveSheet()->setCellValue( 'F'.$j,$friability );
									$objPHPExcel->getActiveSheet()->setCellValue( 'G'.$j,$access );
									$objPHPExcel->getActiveSheet()->setCellValue( 'H'.$j,$total );
									$objPHPExcel->getActiveSheet()->setCellValue( 'I'.$j,$unit );
									$objPHPExcel->getActiveSheet()->setCellValue( 'J'.$j,$result );
									$objPHPExcel->getActiveSheet()->setCellValue( 'K'.$j,$r_hazard );
									$objPHPExcel->getActiveSheet()->setCellValue( 'L'.$j,$action );
									$objPHPExcel->getActiveSheet()->setCellValue( 'M'.$j,$estimated_cost );
								$j++;
								$i++;
							}
									
						} 
						/*================ For consultant Info =========================*/
						if(empty($rst)){
							$sd = $sd-1;
						}else{
							$sd = $sd+$cnt;
						}
					}
				}
				
				$sd++;
				
			}
						
				$objPHPExcel->getActiveSheet()->freezePane('A2');
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
				
				$fname =  'test.xls';
				$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/development_summary/';
				
				$download_link = 'uploads/reports/development_summary/'.$fname;				
				
				$objWriter->save($path.$fname);
				
				echo $download_link;	
				
		}else{
			
				$data['client_info'] 		= $this->user_model->get_client_info( $client_id );
				$data['building_ids']		= $building_ids;
				/* $data['development']		= $development; */
				
				$pdfFilePath = "development_summary.pdf";
				$html = $this->load->view('reports/development_summary_pdf_export', $data, true);
				
				 $this->load->library('m_pdf');
				$this->m_pdf->pdf->setFooter("Page {PAGENO} of {nb}");
				$this->m_pdf->pdf->WriteHTML($html);
				
				$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/development_summary/'; 
				
				$this->m_pdf->pdf->Output($path.$pdfFilePath, "F");
				
				$download_link = 'uploads/reports/development_summary/'.$pdfFilePath;
				echo $download_link;
		}
	
		
	}
	
	/*==List dev repr in pDf view==*/
	
	public function list_development_summry( $bid=NULL )
	{
		$system_material = $this->building_model->get_system_and_midentification( $bid );
		if($system_material != "")
		{
			$material_identification='';
			$system='';
			
			foreach($system_material as $system_materials)
			{
				$material_identification  	.= $system_materials->m_id.',';
				$system 					.= $system_materials->system.',';
			}
			
			$material_identification_comma = rtrim($material_identification,',');
			$system_comma = rtrim($system,',');
			
		
			$rst = $this->building_model->get_final_dev_report_rst( $material_identification_comma, $system_comma, $bid );
			
			
			if( !empty( $rst ) )
			{
				$x=0;
				foreach( $rst as $rsts )
				{
					
					if( $x=1 )
					{
									
						$location_ids = $this->building_model->get_location_ids($rsts->location_ids);
						$l='';
						foreach($location_ids as $location_idss){
							$l .= $location_idss->location_id.' ,';
						}
						$location_ids = rtrim($l,' ,');
						
					}
						$system 				= $rsts->system_name;
						$material_name 			= $rsts->material_name;							
						$m_identification 		= $rsts->m_identification;
						
						if($rsts->m_description == '')
						{
							$material_desc 			= $rsts->material_desc;
						}else{	
							$material_desc 			= $rsts->m_description;
						}
						
						$friability 			= ucfirst( $rsts->friability);
						$access 				= $rsts->access;
						$total 					= $rsts->grand;
						
						if($rsts->units != "")
						{
							$unit 					= $rsts->units;
						}else{	
							$unit 					= $rsts->unit;
						}	
						
						$result 				= $rsts->rst;
						$r_hazard 				= $rsts->r_hazard;
						$action 				= $rsts->action_number;
						$estimated_cost 		= "";
						?>
					
						<tr id="room_by-id-<?php echo $rsts->location_ids; ?>">
							<td>
								<?php echo $system;?>
							</td>
							<td>
								<?php echo $material_name;?>
							</td>
							<td>
								<?php echo $m_identification;?>
							</td>
							<td>
								<?php echo $material_desc; ?>
							</td>
							<td width="700" class="testt" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word;width:700px;float: left;display: inline-block;">
								<?php //echo $location_ids;?>
								<?php echo wordwrap($location_ids,100,"<br>\n");?>								
							</td>
							<td>
								<?php echo ucfirst($friability);?>
							</td>
							<td>
								<?php echo ucfirst($access);?>
							</td>
							<td>
								<?php echo $total;?>
							</td>
							<td>
								<?php if( $unit != "" ){ echo $this->get_units_code( $unit );}?>
							</td>
							<td>
								<?php echo $result;?>
							</td>
							<td>
								<?php echo $r_hazard; ?>
							</td>
							<td>
								<?php echo $action;?>
							</td>
							<td>
								<?php echo $estimated_cost;?>
							</td>
						</tr>	
					<?php 	
				
					$x++;			
				
				}
			}
			
		}
		
	}
	
	/*------------------------------- Good, Poor, Fair and Debis Report ---------------------------------------*/
	
	public function good_poor_summary( $cid=NULL )
	{
		$bidds = $this->building_model->get_building_list_clientt( $cid );
		$bids = $bidds->assigned_buildings;
		$data['all_buildings'] = $this->building_model->get_building_lists( $bids );
		$data['bids'] = $bids;
		$data['client_id'] = $cid;
		$this->load->view('templates/header.php');
		$this->load->view('reports/good_poor_summary',$data);
		$this->load->view('templates/footer.php');
	}
	
	public function export_material_cond_summary_all()
	{
		$client_id 			= $this->input->post('client_id');
		$building_ids 		= $this->input->post('building_id');
		$bids 				= $this->input->post('bids');
		$report_type 		= $this->input->post('report_type');
		
		if( isset( $bids ) )
		{
			$building_ids = explode(',',$bids);
		}
		
		$client_info     	= $this->user_model->get_client_info( $client_id );
		$client_name 		= $client_info->client_name;
		
		
		if( $report_type == "excel" )
		{

			$this->load->library( 'excel' );
			$objPHPExcel = new PHPExcel( );
			$objPHPExcel->getActiveSheet( )->setTitle( 'Material_condition_Summary' );
			
			$sd=1;
			foreach( $building_ids as $building_id )
			{
				
				$system_material = $this->building_model->get_system_and_midentification( $building_id );
				$building_detail = $this->building_model->get_building_data( $building_id );
				
				$building_address 		= $building_detail->address;
				$building_developement 	= $building_detail->development;
				$building_district 		= $building_detail->district;
				
				if($system_material != "")
				{
					$material_identification='';
					$system='';
					
					foreach($system_material as $system_materials)
					{
						$material_identification  	.= $system_materials->m_id.',';
						$system 					.= $system_materials->system.',';
					}
					
					$material_identification_comma = rtrim($material_identification,',');
					$system_comma = rtrim($system,',');		
					
					$rst = $this->building_model->get_final_mat_cond_report_rst( $material_identification_comma, $system_comma, $building_id );
					//echo $this->db->last_query();
					
					
					if(!empty($rst))
					{
					
						$heading1 = array('Client Name', 'Building Address');
						$heading2 = array('Development', 'District');
						$heading  = array( 'System','Material Name','Material Identification','Material Description','Locations','Friability','Accessibility','Total Quantity','Units','Results','Hazard','Priority','Estimated Cost' );
						
						/*==================== For Client and Building Info =========================*/
					
						$rowNumberH = $sd;
						$colH = 'A';
						
						foreach($heading1 as $h){
							$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
							$colH++;
						}
							$sd = $sd+1;
							$rownumber = $sd;
							$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$client_name );
							$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$building_address );
							
					/*==================== For Client and Building Info ==================*/		
					/*==================== For Building Sub Info =========================*/
					
						$sd = $sd+1;
						$rowNumberH = $sd;
						$colH = 'A';
						
						foreach($heading2 as $h){
							$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
							$colH++;
						}
						
							$sd = $sd+1;
							$rownumber = $sd;
							$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$rownumber,$building_developement );
							$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$rownumber,$building_district );		
							
					/*==================== For Building Sub Info =========================*/
										
						
						$sd = $sd+1;
						$rowNumberH = $sd;
						$colH = 'A';
						
						foreach($heading as $h){
							$objPHPExcel->getActiveSheet()->setCellValue( $colH.$rowNumberH,$h );
							$colH++;
						}
						
						
						$cnt = count($rst);	
						if($rst != "")
						{
								
							$sd = $sd+1;
							$j=$sd;
							$i=0;
							foreach($rst as $rsts)
							{
								if($i=1){
									
									$location_ids = $this->building_model->get_location_ids($rsts->location_ids);
									//echo "<pre>";print_r($location_ids);
									$l='';
									foreach($location_ids as $location_idss){
										$l .= $location_idss->location_id.',';
									}
									$location_ids = rtrim($l,',');
									
								}
								
								$system 				= $rsts->system_name;
								$material_name 			= $rsts->material_name;							
								$m_identification 		= $rsts->m_identification;
								
								if($rsts->m_description == '')
								{
									$material_desc 			= $rsts->material_desc;
								}else{	
									$material_desc 			= $rsts->m_description;
								}
								
								//$location_ids 			= $rsts->location_ids;
								$friability 			= ucfirst( $rsts->friability);
								$access 				= $rsts->access;
								$total 					= $rsts->grand;
								
								$unit 					= $rsts->unit;
								
								$result 				= $rsts->rst;
								$r_hazard 				= $rsts->r_hazard;
								$action 				= $rsts->action_number;
								$estimated_cost 		= "";
								
								
								/*================ For Room By Room Info =========================*/
									
								
									$objPHPExcel->getActiveSheet()->setCellValue( 'A'.$j,$system );
									$objPHPExcel->getActiveSheet()->setCellValue( 'B'.$j,$material_name );
									$objPHPExcel->getActiveSheet()->setCellValue( 'C'.$j,$m_identification );
									$objPHPExcel->getActiveSheet()->setCellValue( 'D'.$j,$material_desc );
									$objPHPExcel->getActiveSheet()->setCellValue( 'E'.$j,$location_ids );
									$objPHPExcel->getActiveSheet()->setCellValue( 'F'.$j,$friability );
									$objPHPExcel->getActiveSheet()->setCellValue( 'G'.$j,$access );
									$objPHPExcel->getActiveSheet()->setCellValue( 'H'.$j,$total );
									$objPHPExcel->getActiveSheet()->setCellValue( 'I'.$j,$unit );
									$objPHPExcel->getActiveSheet()->setCellValue( 'J'.$j,$result );
									$objPHPExcel->getActiveSheet()->setCellValue( 'K'.$j,$r_hazard );
									$objPHPExcel->getActiveSheet()->setCellValue( 'L'.$j,$action );
									$objPHPExcel->getActiveSheet()->setCellValue( 'M'.$j,$estimated_cost );
								$j++;
								$i++;
							}
									
						} 
						/*================ For consultant Info =========================*/
						if(empty($rst)){
							$sd = $sd-1;
						}else{
							$sd = $sd+$cnt;
						}
					}
				}
				
				$sd++;
				
			}
						
				$objPHPExcel->getActiveSheet()->freezePane('A2');
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
				
				$fname =  'test.xls';
				$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/material_condition_summary/';
				
				$download_link = 'uploads/reports/material_condition_summary/'.$fname;				
				
				$objWriter->save($path.$fname);
				
				echo $download_link;	
				
		}else{
			
				$data['client_info'] 		= $this->user_model->get_client_info( $client_id );
				$data['building_ids']		= $building_ids;
				
				$pdfFilePath = "material_condition_summary.pdf";
				$html = $this->load->view('reports/material_condition_summary_pdf_export', $data, true);
				
				$this->load->library('m_pdf');
				$this->m_pdf->pdf->setFooter("Page {PAGENO} of {nb}");
				$this->m_pdf->pdf->WriteHTML($html);
				
				$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/material_condition_summary/'; 
				
				$this->m_pdf->pdf->Output($path.$pdfFilePath, "F");				
				$download_link = 'uploads/reports/material_condition_summary/'.$pdfFilePath;
				echo $download_link;
		}
	}
	
	public function list_material_condition_summry( $bid=NULL )
	{
		
		$system_material = $this->building_model->get_system_and_midentification( $bid );
		if($system_material != "")
		{
			$material_identification='';
			$system='';
			
			foreach($system_material as $system_materials)
			{
				$material_identification  	.= $system_materials->m_id.',';
				$system 					.= $system_materials->system.',';
			}
			
			$material_identification_comma = rtrim($material_identification,',');
			$system_comma = rtrim($system,',');
			
		
			$rstw = $this->building_model->get_final_mat_cond_report_rst( $material_identification_comma, $system_comma, $bid );
			
			
			if( !empty( $rstw ) )
			{
				$y=0;
				foreach( $rstw as $rsts )
				{
					/* echo "<pre>";print_r($rsts);exit; */
					if( $y=1 )
					{
						$location_idsss = rtrim($rsts->location_ids,' ,');
						
							$location_ids = $this->building_model->get_location_ids( $location_idsss );
							//echo $this->db->last_query();
							$l='';
							foreach($location_ids as $location_idss){
								$l .= $location_idss->location_id.' ,';
							}
							$location_ids = rtrim($l,' ,');
						
					}
						
						$systemID 				= $rsts->system_ID;
						$system 				= $rsts->system_name;
						$material_name 			= $rsts->material_name;							
						$m_identification 		= $rsts->m_identification;
						
						if($rsts->m_description == '')
						{
							$material_desc 			= $rsts->material_desc;
						}else{	
							$material_desc 			= $rsts->m_description;
						}
						
						$friability 			= ucfirst( $rsts->friability);
						$access 				= $rsts->access;
						$total 					= $rsts->grand;
						
						if($rsts->units != "")
						{
							$unit 					= $rsts->units;
						}else{	
							$unit 					= $rsts->unit;
						}	
						
						$result 				= $rsts->rst;
						$r_hazard 				= $rsts->r_hazard;
						$action 				= $rsts->action_number;
						$estimated_cost 		= "";
						   
						?>
					
						<tr id="room_by-id-<?php echo $rsts->location_ids; ?>">
							<td>
								<?php echo $system;?>
							</td>
							<td>
								<?php echo $material_name;?>
							</td>
							<td>
								<?php echo $m_identification;?>
							</td>
							<td>
								<?php echo $material_desc; ?>
							</td>
							<td width="700" class="testt" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word;width:700px;float: left;display: inline-block;">
								<?php //echo $location_ids;?>
								<?php echo wordwrap($location_ids,100,"<br>\n");?>								
							</td>
							<td>
								<?php echo ucfirst($friability);?>
							</td>
							<td>
								<?php echo ucfirst($access);?>
							</td>
							<td>
								<?php echo $this->get_grand_total( $location_ids, $systemID, $bid );?>
							</td>
							<td>
								<?php if( $unit != "" ){ echo $this->get_units_code( $unit );}?>
							</td>
							<td>
								<?php echo $result;?>
							</td>
							<td>
								<?php echo $r_hazard; ?>
							</td>
							<td>
								<?php echo $action;?>
							</td>
							<td>
								<?php echo $estimated_cost;?>
							</td>
						</tr>	
					<?php 	
				
					$y++;			
				
				}				
				
			}
			
		}
		
	}


/*------------------------------- Custom Report ---------------------------------------*/
	
	public function custom_report( $cid=NULL )
	{
		$bidds = $this->building_model->get_building_list_clientt( $cid );
		$bids = $bidds->assigned_buildings;
		$data['all_buildings'] = $this->building_model->get_building_lists( $bids );
		$data['bids'] = $bids;
		$data['system'] = $this->building_model->get_system_data( );
		$data['client_id'] = $cid;
		$this->load->view('templates/header.php');
		$this->load->view('reports/custom_report',$data);
		$this->load->view('templates/footer.php');
	}
	
	public function get_building_dist( )
	{
		
		$did = $this->input->post( 'district' );
		$bids = $this->input->post( 'bids' );
		$list_buildings = $this->building_model->get_building_dist( $did, $bids );
		
		$d = '<option>Please Select</option>';
		
		if( !empty( $list_buildings ) )
		{
			foreach( $list_buildings as $list_building )
			{
				$d .=  '<option value="'.$list_building->id.'">'.$list_building->building_name.'</option>';
			}
		}
		echo $d;
		
	}
	
	public function get_system( )
	{
		$building = $this->input->post( 'building' );
		
		$list_system = $this->building_model->get_system( $building );
		
		$d = '<option>Please Select</option>';
		
		if( !empty( $list_system ) )
		{
			foreach( $list_system as $list_systems )
			{
				$d .=  '<option value="'.$list_systems->id.'">'.$list_systems->system_name.'</option>';
			}
		}
		echo $d;
	}
	
	public function get_materials()
	{
		
		$bid = $this->input->post('building');
		$sid = $this->input->post('system');
		$list_materials = $this->building_model->get_materials( $bid, $sid );
		
		$d = '<option>Please Select</option>';
		
		if(!empty($list_materials))
		{
			foreach($list_materials as $list_material) 
			{
				$d .=  '<option value="'.$list_material->id.'">'.$list_material->material_name.'</option>';
			}
		}else{
				$d .=  '<option value="5">N/A</option>';
		}
		echo $d;
	}
	
	public function get_material_identi()
	{
		$bid = $this->input->post('building');
		$id = $this->input->post('material');
		$list_material_identi = $this->building_model->get_material_identi( $bid,$id );
		//print_r($list_material_identi);
		
		$d = '<option>Please Select</option>';
		
		if(!empty($list_material_identi))
		{
			foreach($list_material_identi as $list_material_identis) 
			{
				$d .=  '<option value="'.$list_material_identis->m_id.'">'.$list_material_identis->m_identification.'</option>';
			}	
		}else{
				$d .=  '<option value="5">N/A</option>';
		}
		echo $d;
	}
	
	
	public function get_friability( )
	{
		$bid 				= $this->input->post('building');
		$sid 				= $this->input->post('system');
		$mid 				= $this->input->post('material');
		$material_identi 	= $this->input->post('material_identi');
		
		$fribilty = $this->building_model->get_friability( $bid, $sid, $mid, $material_identi );
		
		$d = '<option>-Please Select-</option>';
		
		if(!empty($fribilty))
		{
			foreach( $fribilty as $fribiltys ) 
			{
				if( $fribiltys->friability != 'Please Select' )
				{
					$d .=  '<option value="'.$fribiltys->friability.'">'.ucfirst($fribiltys->friability).'</option>';
				}else{
					$d .=  '<option value="Please Select">N/A</option>';
				}	
			}	
		}else{
				$d .=  '<option value="Please Select">N/A</option>';
		}
		echo $d;
	}
	
	public function get_access( )
	{
		$bid 				= $this->input->post('building');
		$sid 				= $this->input->post('system');
		$mid 				= $this->input->post('material');
		$material_identi 	= $this->input->post('material_identi');
		$friability 		= $this->input->post('friability');
		
		$access = $this->building_model->get_access( $bid, $sid, $mid, $material_identi, $friability );
		
		$d = '<option>-Please Select-</option>';
		
		if(!empty($access))
		{
			foreach( $access as $accesss )
			{
				if($accesss->access != 'Please Select')
				{
					$d .=  '<option value="'.$accesss->access.'">'.ucfirst( $accesss->access ).'</option>';
				}else{
					$d .=  '<option value="Please Select">N/A</option>';
				}
			}	
		}else{
				$d .=  '<option value="Please Select">N/A</option>';
		}
		echo $d;
	}

	public function get_units()
	{
		$list_units = $this->building_model->get_units( );
		
		$d = '<option>Please Select</option>';
		
		if( !empty( $list_units ) )
		{		
			foreach( $list_units as $list_unit ) 
			{
				$d .=  '<option value="'.$list_unit->u_id.'">'.$list_unit->unit_code.'</option>';
			}	
		}
		echo $d;
	}
	
	public function get_hazard()
	{
		$bid 				= $this->input->post('building');
		$sid 				= $this->input->post('system');
		$mid 				= $this->input->post('material');
		$material_identi 	= $this->input->post('material_identi');
		$friability 		= $this->input->post('friability');
		$access 			= $this->input->post('access');
		
		$hazards = $this->building_model->get_hazard( $bid, $sid, $mid, $material_identi, $friability, $access );
		
		$d = '<option>-Please Select-</option>';
		
		if(!empty($hazards))
		{
			foreach( $hazards as $hazard )
			{
				if($hazard->r_hazard != 'Please Select')
				{
					$d .=  '<option value="'.$hazard->r_hazard.'">'.$hazard->r_hazard.'</option>';
				}else{
					$d .=  '<option value="Please Select">N/A</option>';
				}
			}	
		}else{
				$d .=  '<option value="Please Select">N/A</option>';
		}
		echo $d;
	}
	
	public function get_action()
	{
		$bid 				= $this->input->post('building');
		$sid 				= $this->input->post('system');
		$mid 				= $this->input->post('material');
		$material_identi 	= $this->input->post('material_identi');
		$friability 		= $this->input->post('friability');
		$access 			= $this->input->post('access');
		$hazard 			= $this->input->post('hazard');
		
		$actions = $this->building_model->get_action( $bid, $sid, $mid, $material_identi, $friability, $access, $hazard );
		
		$d = '<option>-Please Select-</option>';
		
		if(!empty($actions))
		{
			foreach( $actions as $action )
			{
				if($action->action != 'Please Select')
				{
					$d .=  '<option value="'.$action->action.'">'.$action->action_number.'</option>';
				}else{
					$d .=  '<option value="Please Select">N/A</option>';
				}
			}
		}else{
				$d .=  '<option value="Please Select">N/A</option>';
		}
		echo $d;
	}
	
	public function get_grand_total( $rst_location_ids=Null, $systemID=Null, $bid=Null )
	{
		
		$rst = $this->building_model->get_lc( $rst_location_ids, $systemID, $bid );
		$lc_ids='';
		foreach( $rst as $rsts )
		{
			$lc_ids .= $rsts->l_id.',';
		}
		
		$lc_id = rtrim($lc_ids,',');
					
		$rstss = $this->building_model->get_grand_total( $lc_id, $systemID, $bid );
		/* echo $this->db->last_query();exit; */
		echo $rstss->grand;
	}
		
	public function export_custom_summary_all()
	{
		
		$client_id = $this->input->post('client_id');
		$report_type = $this->input->post('report_type');
		
		if( $report_type == 'pdf' )
		{
			
			$action 		= $this->input->post('action');
			$hazard 		= $this->input->post('hazard');
			$access 		= $this->input->post('access');
			$friability 	= $this->input->post('friability');
			$district 		= $this->input->post('district');						
			$building 		= $this->input->post('building');
			
			$building 		= array($building);			
						
			$system 			= $this->input->post('system');			
			$material 			= $this->input->post('material');
			$material_identi 	= $this->input->post('material_identi');
			
			
			
			
			$data['client_info'] 		= $this->user_model->get_client_info( $client_id );
			$data['building_ids']		= $building;
			$data['friability']			= $friability;
			$data['system']				= $system;
			$data['material']			= $material;
			$data['material_identi']	= $material_identi;
			$data['access']				= $access;
			$data['hazard']				= $hazard;
			$data['action']				= $action;
			
			//echo "<pre>";print_r($data);
			$pdfFilePath = "custom_report.pdf";
			$html = $this->load->view( 'reports/custom_pdf_export', $data, true );
			
			
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->setFooter("Page {PAGENO} of {nb}");
			$this->m_pdf->pdf->WriteHTML($html);
			
			$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/custom/'; 
			
			$this->m_pdf->pdf->Output($path.$pdfFilePath, "F");
			
			$download_link = 'uploads/reports/custom/'.$pdfFilePath;
			echo $download_link;
				
		}
		
		
	}
	
	/*==list custom report in excel and PDF==*/
	public function list_custom_summry( $bid=NULL, $system=NULL, $material=NULL, $material_identi=NULL, $friability=NULL, $access=NULL, $hazard=NULL, $action=NULL )
	{
			$system_material = $this->building_model->get_system_and_midentification( $bid );
		
		if( $system_material != "" )
		{
			$material_identification='';
			$systems='';
			
			foreach( $system_material as $system_materials )
			{
				$material_identification  	.= $system_materials->m_id.',';
				$systems 					.= $system.',';
			}
			
			$material_identification_comma = rtrim( $material_identification,',' );
			$system_comma = rtrim( $systems,',' );
			
			
			$rst = $this->building_model->get_final_custom_report_rst( $system_comma, $bid, $material, $material_identi, $friability, $access, $hazard, $action );
			/* echo $this->db->last_query();exit; */
			
			if( !empty( $rst ) )
			{
				$x=0;
				foreach( $rst as $rsts )
				{
					
					if( $x=1 )
					{
						
						$my_string = $rsts->location_ids;
						$rst_location_ids = rtrim( $my_string, ',' );
						
						$location_ids = $this->building_model->get_location_ids( $rst_location_ids );
						$l='';
						foreach($location_ids as $location_idss){
							$l .= $location_idss->location_id.' ,';
						}
						$location_ids = rtrim($l,' ,');
						
					}
					
						$system 				= $rsts->system_name;
						$systemID 				= $rsts->system_ID;
						$material_name 			= $rsts->material_name;							
						$m_identification 		= $rsts->m_identification;
						
						if($rsts->m_description == '')
						{
							$material_desc 			= $rsts->material_desc;
						}else{
							$material_desc 			= $rsts->m_description;
						}
						
						$friability 			= ucfirst( $rsts->friability );
						$access 				= $rsts->access;
												
						if( $rsts->units !="" )
						{
							$unit 					= $rsts->units;
						}else{	
							$unit 					= $rsts->unit;
						}	
						
						$result 				= $rsts->rst;
						$r_hazard 				= $rsts->r_hazard;
						$action 				= $rsts->action_number;
						$estimated_cost 		= "";
						?>
					
						<tr id="room_by-id-<?php echo $rsts->location_ids; ?>">
							<td>
								<?php echo $system;?>
							</td>
							<td>
								<?php echo $material_name;?>
							</td>
							<td>
								<?php echo $m_identification;?>
							</td>
							<td>
								<?php echo $material_desc; ?>
							</td>
							<td width="700" class="testt" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word;width:700px;float: left;display: inline-block;">
								<?php //echo $location_ids;?>
								<?php echo wordwrap( $location_ids, 100, "<br>\n" );?>								
							</td>
							<td>
								<?php if($friability !="Please Select"){echo ucfirst($friability);}?>
							</td>
							<td>
								<?php if($access != "Please Select"){ echo ucfirst($access);}?>
							</td>
							<td>
								<?php echo $this->get_grand_total( $location_ids, $systemID, $bid );?>
							</td>
							<td>
								<?php if( $unit != "" ){ echo $this->get_units_code( $unit );}?>
							</td>
							<td>
								<?php echo $result;?>
							</td>
							<td>
								<?php echo $r_hazard; ?>
							</td>
							<td>
								<?php if($action !="0"){ echo $action;}?>
							</td>
							<td>
								<?php echo $estimated_cost;?>
							</td>
						</tr>	
					<?php 	
				
					$x++;			
				
				}
			}else{ ?>
				<tr>
					No Result Found !
				</tr>				
			<?php }
			
		}
		
	}
	
	
	/*-----------------------------Action Summary Report----------------------------------------*/
	
	
	public function action_summary( $cid=NULL )
	{
		$bidds = $this->building_model->get_building_list_clientt( $cid );
		$bids = $bidds->assigned_buildings;
		$data['all_buildings'] = $this->building_model->get_building_lists( $bids );
		$data['action'] = $this->building_model->get_priorty_lists( $bids );
		$data['client_id'] = $cid;
		$this->load->view('templates/header.php');
		$this->load->view('reports/action_summary',$data);
		$this->load->view('templates/footer.php');
	}
	
	public function export_actioni_summary_all( )
	{
		
			$client_id 			= $this->input->post('client_id');
			$building_ids 		= $this->input->post('building_id');
			$action 			= $this->input->post('action');
			$report_type 		= $this->input->post('report_type');
			$district_id 		= $this->input->post('district_id');
			
			$act = '';
			foreach( $action as $a ){
				$act .= $a.' ,';
			}
			$actions = rtrim($act, ',');
			
			
			$client_info     	= $this->user_model->get_client_info( $client_id );
			$client_name 		= $client_info->client_name;
		
		
			$data['client_info'] 		= $this->user_model->get_client_info( $client_id );
			$data['building_ids']		= $building_ids;
			$data['action']				= $actions;
			
			$pdfFilePath = "action_summary.pdf";
			$html = $this->load->view('reports/action_summary_pdf_export', $data, true);
			
			 $this->load->library('m_pdf');
			$this->m_pdf->pdf->setFooter("Page {PAGENO} of {nb}");
			$this->m_pdf->pdf->WriteHTML($html);
			
			$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/action_summary/'; 
			
			 /* $this->m_pdf->pdf->Output($pdfFilePath, "D"); */
			$this->m_pdf->pdf->Output($path.$pdfFilePath, "F");
			
			$download_link = 'uploads/reports/action_summary/'.$pdfFilePath;
			echo $download_link;
			
	}
	
	public function list_action_summry( $bid=NULL, $action=NULL )
	{
		
		$system_material = $this->building_model->get_system_and_midentification( $bid );
		if($system_material != "")
		{
			$material_identification='';
			$system='';
			
			foreach($system_material as $system_materials)
			{
				$material_identification  	.= $system_materials->m_id.',';
				$system 					.= $system_materials->system.',';
			}
			
			$material_identification_comma = rtrim($material_identification,',');
			$system_comma = rtrim($system,',');
			
			$rst = $this->building_model->get_final_action_report_rst( $material_identification_comma, $system_comma, $bid, $action );
			/* echo $this->db->last_query();die; */
			
			
			if(!empty($rst))
			{
				$x=0;	
				foreach($rst as $rsts)
				{
					
					if($x=1)
					{
									
						$location_ids = $this->building_model->get_location_ids($rsts->location_ids);
						$l='';
						foreach($location_ids as $location_idss){
							$l .= $location_idss->location_id.' ,';
						}
						$location_ids = rtrim($l,' ,');
						
					}
					
					
						$system 				= $rsts->system_name;
						$material_name 			= $rsts->material_name;							
						$m_identification 		= $rsts->m_identification;
						
						if($rsts->m_description == '')
						{
							$material_desc 			= $rsts->material_desc;
						}else{	
							$material_desc 			= $rsts->m_description;
						}
						
						$friability 			= ucfirst( $rsts->friability);
						/* $development 				= $rsts->development; */
						$total 					= $rsts->grand;
						
						if( $rsts->units !="" )
						{
							$unit 					= $rsts->units;
						}else{	
							$unit 					= $rsts->unit;
						}	
						
						$result 				= $rsts->rst;
						$r_hazard 				= $rsts->r_hazard;
						$action 				= $rsts->action_number;
						$estimated_cost 		= "";
						?>
					
						<tr id="room_by-id-<?php echo $rsts->location_ids; ?>">
							<td>
								<?php echo $system;?>
							</td>
							<td>
								<?php echo $material_name;?>
							</td>
							<td>
								<?php echo $m_identification;?>
							</td>
							<td>
								<?php echo $material_desc; ?>
							</td>
							<td width="700" class="testt" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word;width:700px;float: left;display: inline-block;">
								<?php //echo $location_ids;?>
								<?php echo wordwrap($location_ids,100,"<br>\n");?>								
							</td>
							<td>
								<?php echo ucfirst($friability);?>
							</td>
							<td>
								<?php echo $total;?>
							</td>
							<td>
								<?php if( $unit != "" ){ echo $this->get_units_code( $unit );}?>
							</td>
							<td>
								<?php echo $result;?>
							</td>
							<td>
								<?php echo $r_hazard; ?>
							</td>
							<td>
								<?php echo $action;?>
							</td>
							<td>
								<?php echo $estimated_cost;?>
							</td>
						</tr>	
					<?php 	
				
					$x++;			
				
				}
			}
			
		}
		
	}
	
	/*=========================================================================*/
	
	
	/*-====================--Custom report for multiple fields---=========================-*/
	
	public function custom_m_report( $cid=NULL )
	{
		$bidds = $this->building_model->get_building_list_clientt( $cid );
		$bids = $bidds->assigned_buildings;
		$data['all_buildings'] = $this->building_model->get_building_lists( $bids );
		$data['bids'] = $bids;
		$data['system'] = $this->building_model->get_system_data( );
		$data['client_id'] = $cid;
		$this->load->view('templates/header.php');
		$this->load->view('reports/custom_m_report',$data);
		$this->load->view('templates/footer.php');
	}
	
	public function get_building_dist_m( )
	{
		$did = $this->input->post( 'district' );
		$bids = $this->input->post( 'bids' );
		
		$didd = '';
		foreach( $did as $dids )
		{
			$didd .= $dids.' ,';
		}
		$diddd = rtrim( $didd, ',' );
		
		$list_buildings = $this->building_model->get_building_dist_m( $diddd, $bids );
		
		$d = '';
		if( !empty( $list_buildings ) )
		{
			foreach( $list_buildings as $list_building )
			{
				$d .=  '<option value="'.$list_building->id.'">'.$list_building->building_name.'</option>';
			}
		}
		echo $d;
		
	}
	
	public function get_materials_m()
	{
		
		$bid = $this->input->post('building');
		$sid = $this->input->post('system');
		
		$bd = '';
		foreach( $bid as $bids )
		{
			$bd .= $bids.' ,';
		}
		$bds = rtrim( $bd, ',' );
		
		$sys = '';
		foreach( $sid as $sids )
		{
			$sys .= $sids.' ,';
		}
		$system = rtrim( $sys, ',' );
		
		$list_materials = $this->building_model->get_materials_m( $bds, $system );
		
		$d = '';
		
		if(!empty($list_materials))
		{
			foreach($list_materials as $list_material) 
			{
				$d .=  '<option value="'.$list_material->id.'">'.$list_material->material_name.'</option>';
			}
		}else{
				$d .=  '<option value="5">N/A</option>';
		}
		echo $d;
	}
	
	public function get_material_identi_m()
	{
		$bid = $this->input->post('building');
		$id = $this->input->post('material');
		
		$bd = '';
		foreach( $bid as $bids )
		{
			$bd .= $bids.' ,';
		}
		$bds = rtrim( $bd, ',' );
		
		$sys = '';
		foreach( $id as $sids )
		{
			$sys .= $sids.' ,';
		}
		$mat = rtrim( $sys, ',' );
		
		$list_material_identi = $this->building_model->get_material_identi_m( $bds,$mat );
		/* echo $this->db->last_query();die; */
		//print_r($list_material_identi);
		
		$d = '';
		
		if(!empty($list_material_identi))
		{
			foreach($list_material_identi as $list_material_identis) 
			{
				$d .=  '<option value="'.$list_material_identis->m_id.'">'.$list_material_identis->m_identification.'</option>';
			}	
		}else{
				$d .=  '<option value="5">N/A</option>';
		}
		echo $d;
	}
	
	public function get_friability_m( )
	{
		$bid 				= $this->input->post('building');
		$sid 				= $this->input->post('system');
		$mid 				= $this->input->post('material');
		$material_identi 	= $this->input->post('material_identi');
		
		$bd = '';
		foreach( $bid as $bids )
		{
			$bd .= $bids.' ,';
		}
		$bds = rtrim( $bd, ',' );
		
		$sys = '';
		foreach( $sid as $sids )
		{
			$sys .= $sids.' ,';
		}
		$system = rtrim( $sys, ',' );
		
		$md = '';
		foreach( $mid as $mids )
		{
			$md .= $mids.' ,';
		}
		$mat = rtrim( $md, ',' );
		
		$md_ide = '';
		foreach( $material_identi as $m_identi )
		{
			$md_ide .= $m_identi.' ,';
		}
		$md_identi = rtrim( $md_ide, ',' );		
		
		$fribilty = $this->building_model->get_friability_m( $bds, $system, $mat, $md_identi );
		/* echo $this->db->last_query();die; */
		$d = '';
		
		if(!empty($fribilty))
		{
			foreach( $fribilty as $fribiltys ) 
			{
				if($fribiltys->friability != 'Please Select')
				{
					$d .=  '<option value="'.$fribiltys->friability.'">'.ucfirst($fribiltys->friability).'</option>';
				}else{
					$d .=  '<option value="Please Select">N/A</option>';
				}	
			}	
		}else{
				$d .=  '<option value="Please Select">N/A</option>';
		}
		echo $d;
	}
	
	public function get_access_m( )
	{
		$bid 				= $this->input->post('building');
		$sid 				= $this->input->post('system');
		$mid 				= $this->input->post('material');
		$material_identi 	= $this->input->post('material_identi');
		$friability 		= $this->input->post('friability');
		
		$bd = '';
		foreach( $bid as $bids )
		{
			$bd .= $bids.' ,';
		}
		$bds = rtrim( $bd, ',' );
		
		$sys = '';
		foreach( $sid as $sids )
		{
			$sys .= $sids.' ,';
		}
		$system = rtrim( $sys, ',' );
		
		$md = '';
		foreach( $mid as $mids )
		{
			$md .= $mids.' ,';
		}
		$mat = rtrim( $md, ',' );
		
		$md_ide = '';
		foreach( $material_identi as $m_identi )
		{
			$md_ide .= $m_identi.' ,';
		}
		$md_identi = rtrim( $md_ide, ',' );
		
		$frid = '';
		foreach( $friability as $fri )
		{
			$frid .= $fri.' ,';
		}
		$friabil = rtrim( $frid, ',' );
		
		$access = $this->building_model->get_access_m( $bds, $system, $mat, $md_identi, $friabil );
		
		$d = '';
		
		if(!empty($access))
		{
			foreach( $access as $accesss )
			{
				if($accesss->access != 'Please Select')
				{
					$d .=  '<option value="'.$accesss->access.'">'.ucfirst( $accesss->access ).'</option>';
				}else{
					$d .=  '<option value="Please Select">N/A</option>';
				}
			}	
		}else{
				$d .=  '<option value="Please Select">N/A</option>';
		}
		echo $d;
	}
	
	public function get_hazard_m()
	{
		$bid 				= $this->input->post('building');
		$sid 				= $this->input->post('system');
		$mid 				= $this->input->post('material');
		$material_identi 	= $this->input->post('material_identi');
		$friability 		= $this->input->post('friability');
		$access 			= $this->input->post('access');
		
		$bd = '';
		foreach( $bid as $bids )
		{
			$bd .= $bids.' ,';
		}
		$bds = rtrim( $bd, ',' );
		
		$sys = '';
		foreach( $sid as $sids )
		{
			$sys .= $sids.' ,';
		}
		$system = rtrim( $sys, ',' );
		
		$md = '';
		foreach( $mid as $mids )
		{
			$md .= $mids.' ,';
		}
		$mat = rtrim( $md, ',' );
		
		$md_ide = '';
		foreach( $material_identi as $m_identi )
		{
			$md_ide .= $m_identi.' ,';
		}
		$md_identi = rtrim( $md_ide, ',' );
		
		$frid = '';
		foreach( $friability as $fri )
		{
			$frid .= $fri.' ,';
		}
		$friabil = rtrim( $frid, ',' );
		
		$acce = '';
		foreach( $access as $acc )
		{
			$acce .= $acc.' ,';
		}
		$ac = rtrim( $acce, ',' );
		
		$hazards = $this->building_model->get_hazard_m( $bds, $system, $mat, $md_identi, $friabil, $ac );
		
		$d = '';
		
		if(!empty($hazards))
		{
			foreach( $hazards as $hazard )
			{
				if($hazard->r_hazard != 'Please Select')
				{
					$d .=  '<option value="'.$hazard->r_hazard.'">'.$hazard->r_hazard.'</option>';
				}else{
					$d .=  '<option value="Please Select">N/A</option>';
				}
			}	
		}else{
				$d .=  '<option value="Please Select">N/A</option>';
		}
		echo $d;
	}
	
	public function get_action_m()
	{
		$bid 				= $this->input->post('building');
		$sid 				= $this->input->post('system');
		$mid 				= $this->input->post('material');
		$material_identi 	= $this->input->post('material_identi');
		$friability 		= $this->input->post('friability');
		$access 			= $this->input->post('access');
		$hazard 			= $this->input->post('hazard');
		
		$bd = '';
		foreach( $bid as $bids )
		{
			$bd .= $bids.' ,';
		}
		$bds = rtrim( $bd, ',' );
		
		$sys = '';
		foreach( $sid as $sids )
		{
			$sys .= $sids.' ,';
		}
		$system = rtrim( $sys, ',' );
		
		$md = '';
		foreach( $mid as $mids )
		{
			$md .= $mids.' ,';
		}
		$mat = rtrim( $md, ',' );
		
		$md_ide = '';
		foreach( $material_identi as $m_identi )
		{
			$md_ide .= $m_identi.' ,';
		}
		$md_identi = rtrim( $md_ide, ',' );
		
		$frid = '';
		foreach( $friability as $fri )
		{
			$frid .= $fri.' ,';
		}
		$friabil = rtrim( $frid, ',' );
		
		$acce = '';
		foreach( $access as $acc )
		{
			$acce .= $acc.' ,';
		}
		$ac = rtrim( $acce, ',' );
		
		$hz = '';
		foreach( $hazard as $hazards )
		{
			$hz .= $hazards.' ,';
		}
		$hzd = rtrim( $hz, ',' );
		
		$action = $this->building_model->get_action_m( $bds, $system, $mat, $md_identi, $friabil, $ac, $hzd );
		
		$d = '';
		
		if( !empty( $action ) )
		{
			foreach( $action as $actions )
			{
				if($actions->r_hazard != 'Please Select')
				{
					$d .=  '<option value="'.$actions->a_id.'">'.$actions->action_number.'</option>';
				}else{
					$d .=  '<option value="Please Select">N/A</option>';
				}
			}	
		}else{
				$d .=  '<option value="Please Select">N/A</option>';
		}
		echo $d;
	}
	
	public function export_custom_m_summary_all()
	{
		
		$client_id = $this->input->post('client_id');
		$report_type = $this->input->post('report_type');
		
		if( $report_type == 'pdf' )
		{
			/* echo "<pre>";print_r($_POST); */
			
			$building 		= $this->input->post('building');
			$district 		= $this->input->post('district');
										
			$hazard 		= $this->input->post('hazard');
			$action 		= $this->input->post('action');
			$access 		= $this->input->post('access');
			$friability 	= $this->input->post('friability');
			$district 		= $this->input->post('district');
									
			$system 			= $this->input->post('system');
			$material 			= $this->input->post('material');
			$material_identi 	= $this->input->post('material_identi');
			
			if( $system !="" )
			{
				$sys = '';
				foreach( $system as $sids )
				{
					$sys .= $sids.' ,';
				}
				$systems = rtrim( $sys, ',' );
				$data['system']				= $systems;
			}else{
				$data['system']				= $system;
			}
			
			if( $material !="" )
			{
				$md = '';
				foreach( $material as $mids )
				{
					$md .= $mids.' ,';
				}
				$mat = rtrim( $md, ',' );
				$data['material']			= $mat;
			}else{
				$data['material']			= $material;
			}
			
			if( $material_identi !="" )
			{
				$md_ide = '';
				foreach( $material_identi as $m_identi )
				{
					$md_ide .= $m_identi.' ,';
				}
				$md_identi = rtrim( $md_ide, ',' );
				$data['material_identi']	= $md_identi;
			}else{
				$data['material_identi']	= $material_identi;
			}
			
			if( $friability !="" )
			{
				$frid = '';
				foreach( $friability as $fri )
				{
					$frid .= $fri.' ,';
				}
				$friabil = rtrim( $frid, ',' );
				$data['friability']			= $friabil;
			}else{
				$data['friability']			= $friability;
			}
			
			if( $access !="" )
			{
				$ac = '';
				foreach( $access as $acc )
				{
					$ac .= $acc.' ,';
				}
				$acces = rtrim( $ac, ',' );
				$data['access']			= $acces;
			}else{
				$data['access']			= $access;
			}		
			
			if( $hazard !="" )
			{
				$hazd = '';
				foreach( $hazard as $haz )
				{
					//$hazd .= $haz.' ,';
					$hazd .= "'".$haz."',";
				}
				$hazds = rtrim( $hazd, ',' );
				$data['hazard']			= $hazds;
			}else{
				$data['hazard']			= $hazard;
			}
			
			if( $action !="" )
			{
				$acti = '';
				foreach( $action as $act )
				{
					$acti .= $act.' ,';
				}
				$accest = rtrim( $acti, ',' );
				$data['action']			= $accest;
			}else{
				$data['action']			= $action;
			}
						
			$data['client_info'] 		= $this->user_model->get_client_info( $client_id );
			$data['building_ids']		= $building;		
			
			//echo "<pre>";print_r($data);
			$pdfFilePath = "custom_report.pdf";
			$html = $this->load->view( 'reports/custom_pdf_m_export', $data, true );
			
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->setFooter("Page {PAGENO} of {nb}");
			$this->m_pdf->pdf->WriteHTML($html);
			
			$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/custom/';
			
			$this->m_pdf->pdf->Output($path.$pdfFilePath, "F");
			
			$download_link = 'uploads/reports/custom/'.$pdfFilePath;
			echo $download_link;
				
		}
		
	}
	
	public function list_custom_m_summry( $bid=NULL, $system=NULL, $material=NULL, $material_identi=NULL, $friability=NULL, $access=NULL, $hazard=NULL )
	{
		/* echo "<pre>";print_r( $hazard );die; */
		
		
		$system_material = $this->building_model->get_system_and_midentification( $bid );
		
				
		if( $system_material != "" )
		{
			$material_identification='';
			$systems='';
			
			foreach( $system_material as $system_materials )
			{
				$material_identification  	.= $system_materials->m_id.',';
				$systems 					.= $system.',';
			}
			
			$material_identification_comma = rtrim( $material_identification,',' );
			$system_comma = rtrim( $systems,',' );
			
			$rst = $this->building_model->get_final_custom_m_report_rst( $system_comma, $bid, $material, $material_identi, $friability, $access, $hazard, $action );
			/* echo $this->db->last_query();die; */
			
			/* echo "<pre>";print_r($rst);die; */
			
			
			if( !empty( $rst ) )
			{
				$x=0;
				foreach( $rst as $rsts )
				{
					
					if( $x=1 )
					{
						
						$my_string = $rsts->location_ids;
						$rst_location_ids = rtrim( $my_string, ',' );
						
						$location_ids = $this->building_model->get_location_ids( $rst_location_ids );
						$l='';
						foreach($location_ids as $location_idss){
							$l .= $location_idss->location_id.' ,';
						}
						$location_ids = rtrim($l,' ,');
						
					}
						$system 				= $rsts->system_name;
						$systemID 				= $rsts->system_ID;
						$material_name 			= $rsts->material_name;							
						$m_identification 		= $rsts->m_identification;
						
						if($rsts->m_description == '')
						{
							$material_desc 			= $rsts->material_desc;
						}else{	
							$material_desc 			= $rsts->m_description;
						}
						
						//$location_ids 			= $rsts->location_ids;
						$friability 			= ucfirst( $rsts->friability );
						$access 				= $rsts->access;
						$total 					= array_sum(explode(',', $rsts->grand));
						
						if($rsts->units !="")
						{
							$unit 					= $rsts->units;
						}else{	
							$unit 					= $rsts->unit;
						}
						
						$result 				= $rsts->rst;
						$r_hazard 				= $rsts->r_hazard;
						$action 				= $rsts->action_number;
						$estimated_cost 		= "";
						?>
					
						<tr id="room_by-id-<?php echo $rsts->location_ids; ?>">
							<td>
								<?php echo $system;?>
							</td>
							<td>
								<?php echo $material_name;?>
							</td>
							<td>
								<?php echo $m_identification;?>
							</td>
							<td>
								<?php echo $material_desc; ?>
							</td>
							<td width="700" class="testt" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word;width:700px;float: left;display: inline-block;">
								<?php //echo $location_ids;?>
								<?php echo wordwrap($location_ids,100,"<br>\n");?>								
							</td>
							<td>
								<?php if($friability !="Please Select"){echo ucfirst($friability);}?>
							</td>
							<td>
								<?php if($access !="Please Select"){ echo ucfirst($access);}?>
							</td>
							<td>
								<?php /* if($total !="0"){ echo $total;} */?>
								<?php echo $this->get_grand_total( $location_ids, $systemID, $bid );?>
							</td>
							<td>
								<?php if( $unit != "" ){ echo $this->get_units_code( $unit );} ?>
							</td>
							<td>
								<?php echo $result;?>
							</td>
							<td>
								<?php echo $r_hazard; ?>
							</td>
							<td>
								<?php if($action !="0"){ echo $action;}?>
							</td>
							<td>
								<?php echo $estimated_cost;?>
							</td>
						</tr>	
					<?php 	
				
					$x++;			
				
				}
			}else{ ?>
				<tr>
					No Result Found !
				</tr>				
			<?php }
			
		}
		
	}
	
	
	/*====================== Locations Not Assessed Report =================================*/
	
	public function location_not_assessed( $cid=NULL )
	{
		$bidds = $this->building_model->get_building_list_clientt( $cid );
		$bids = $bidds->assigned_buildings;		
		$data['all_buildings'] = $this->building_model->get_building_lists( $bids );
		$data['bids'] = $bids;
		$data['client_id'] = $cid;
		$this->load->view('templates/header.php');
		$this->load->view('reports/location_not_assessed',$data);
		$this->load->view('templates/footer.php');
	}
	
	public function export_location_not_surveyed()
	{
		
		$client_id 			= $this->input->post('client_id');
		$building_ids 		= $this->input->post('building_id');
		$bids 				= $this->input->post('bids');
		$report_type 		= $this->input->post('report_type');
		
		if( isset( $bids ) )
		{
			$building_ids = explode(',',$bids);
		}
		
		$client_info     	= $this->user_model->get_client_info( $client_id );
		$client_name 		= $client_info->client_name;
		
		
			/*==PDF layout===*/
			
			$data['client_info'] 		= $this->user_model->get_client_info( $client_id );
			$data['building_ids']		= $building_ids;
			
			$pdfFilePath = "location_not_assessed.pdf";
			$html = $this->load->view('reports/location_not_assessed_pdf_export', $data, true);
			
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->setFooter("Page {PAGENO} of {nb}");
			$this->m_pdf->pdf->WriteHTML($html);
			
			$path = $_SERVER['DOCUMENT_ROOT'].'/ecohca/uploads/reports/location_not_assessed/'; 
			
			$this->m_pdf->pdf->Output($path.$pdfFilePath, "F");
			
			$download_link = 'uploads/reports/location_not_assessed/'.$pdfFilePath;
			echo $download_link;
		
	}
	
	public function list_location_not_surveyed( $bid=NULL )
	{
		$rst = $this->building_model->get_location_no_surveyed_report( $bid );
		//echo "<pre>";print_r($rst);die;
		$lc_id = "";
		$lc_ids = "";
		foreach( $rst as $rsts )
		{	
			$location_ids 	= $rsts->na;
			$location_id_type 	= $rsts->type;
			
			if( $location_id_type == 'no_access' )
			{
				$lc_id .= $location_ids.', ';
				
			}else{
				$lc_ids .= $location_ids.', ';
			}
			
		}	
			$lc_id_no_access = rtrim($lc_id,',');
			$lc_id_no_survey = rtrim($lc_ids,',');
			
			?>
			<tr id="room_by-id">
				<td style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word;width:700px;float: left;display: inline-block;">
					<?php echo wordwrap($lc_id_no_access,100,"<br>\n");?>								
				</td>
				<td style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word;width:700px;float: left;display: inline-block;">
					<?php echo wordwrap($lc_id_no_survey,100,"<br>\n");?>								
				</td>
			</tr>
			<?php 
			
	}
	
	
	
}	