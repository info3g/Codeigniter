<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sample extends CI_Controller {

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
		$this->load->model('sample_model');
		$this->load->library('form_validation');
		
    }
	
	public function is_loggedIn()
    {
        if ( ! $this->session->userdata('logged_in') == TRUE )
		{
			redirect('login');
        }
    }
	
	/*====List sample ===*/
	public function index( $id=NULL )
	{
	
		$data['list_samples'] = $this->sample_model->list_samples( $id );
		$data['list_sample_data'] = $this->sample_model->list_sample_data( );
		$data['list_system'] = $this->sample_model->list_system( );
		$data['list_layers'] = $this->sample_model->list_layers( );
		$data['building_name'] = $this->sample_model->get_building_name( $id );
		$data['bid'] = $id;
		$data['building_name'] = $this->location_model->get_building_data( $id );
		$this->load->view('templates/header.php');
		$this->load->view('samples/list_samples',$data);
		$this->load->view('templates/footer.php');
	}
	
	/*== List location for onclick===*/
	public function list_location_fn( $id=NULL )
	{
		$keyword = $this->input->post('keyword');
		$result = $this->sample_model->get_location_like( $keyword, $id );
		if(!empty($result)) {
			echo '<ul id="location_id_l">';
			foreach($result as $location) {
				echo '<li onClick="selectlocation('.$location->location_id.')">'.$location->location_id.'</li>';
			}
			echo "</ul>";
		}
	}
	
	/*==jQuery location edit code===*/
	public function list_location_fn_edit( $id=NULL )
	{
		$keyword = $this->input->post('keyword');
		$result = $this->sample_model->get_location_like( $keyword, $id );
		if(!empty($result)) {
			echo '<ul id="location_id_l">';
			foreach($result as $location) {
				echo '<li onClick="selectlocation_edit('.$location->location_id.')">'.$location->location_id.'</li>';
			}
			echo "</ul>";
		}
	}
	
	/*==Remove sample child sample ==*/
	public function remove_sample_child( $id=NULL, $sid=NULL, $bid=NULL )
	{
		
		$this->sample_model->remove_sample_child( $id );
		$get_layer_percents = $this->sample_model->get_layer_percents( $sid );
		if($get_layer_percents != "" )
		{
			$hazard_conditions = $this->sample_model->get_all_hazard();						
			$r='';
			$r2='';		
			$rst = "L.O.D";
			foreach($get_layer_percents as $get_layer_percent)
			{										
					if($hazard_conditions->condition == ">=")
					{
					
						if($get_layer_percent->layer_one_percent == "N/A" || $get_layer_percent->layer_one_percent == "Not Analyzed" || $get_layer_percent->layer_one_percent == "L.O.D" || $get_layer_percent->layer_one_percent == "None Detected"){}
						else if($get_layer_percent->layer_one_percent >= $hazard_conditions->hazard){
							$l = "ca";
						}else if($get_layer_percent->layer_one_percent <= $hazard_conditions->hazard ){
							$ll = "lod";
						}
						
						if($get_layer_percent->layer_two_percent == "N/A" || $get_layer_percent->layer_two_percent == "Not Analyzed" || $get_layer_percent->layer_two_percent == "L.O.D" || $get_layer_percent->layer_two_percent == "None Detected"){}
						else if($get_layer_percent->layer_two_percent >= $hazard_conditions->hazard ){
							$lc = "ca";
						}else if($get_layer_percent->layer_two_percent <= $hazard_conditions->hazard ){
							$llc = "lod";
						}
						
						
					}
					
					if($hazard_conditions->condition == ">")
					{
						if( $get_layer_percent->layer_one_percent > $hazard_conditions->hazard || $get_layer_percent->layer_two_percent > $hazard_conditions->hazard )
						{
							$rst = $hazard_conditions->hazard_rst;
						}else{
							$rst = "L.O.D";
						}
					}
					if($hazard_conditions->condition == "<=")
					{
						if( $get_layer_percent->layer_one_percent > $hazard_conditions->hazard || $get_layer_percent->layer_two_percent > $hazard_conditions->hazard ){
							if( $hazard_conditions->hazard <= $get_layer_percent->layer_one_percent || $hazard_conditions->hazard <= $get_layer_percent->layer_two_percent )
							{	
								$rst = "L.O.D";
							}else{
								$rst = $hazard_conditions->hazard_rst;
							}
						}else{
							if( $get_layer_percent->layer_one_percent <= $hazard_conditions->hazard || $get_layer_percent->layer_two_percent <= $hazard_conditions->hazard )
							{
								$rst = $hazard_conditions->hazard_rst;
							}else{
								$rst = "L.O.D";
							}
						}
					}
					if($hazard_conditions->condition == "<")
					{
						if( $get_layer_percent->layer_one_percent < $hazard_conditions->hazard || $get_layer_percent->layer_two_percent < $hazard_conditions->hazard )
						{
							$rst = $hazard_conditions->hazard_rst;
						}else{
							$rst = "L.O.D";
						}
					}
					
			}
			
			if(isset($l)){
				$rst = "Confirmed Asbestos";
			}else if(isset($lc) && isset($ll)){
				$rst = "Confirmed Asbestos";
			}else if(isset($ll) && isset($llc)){
				$rst = "L.O.D";
			}else{
				$rst = "L.O.D";
			}
			
			$this->sample_model->update_db_sample_rst( $sid, $rst );
		}else{
			$this->sample_model->remove_sample( $sid );
		}	
		
		redirect( 'sample/index/'.$bid );
	}
	
	/*===Location check in DB======*/
	public function check_location( $bid=NULL )
	{
		$location_id  = $this->input->post( 'location_id' );
		$rst = $this->sample_model->check_location_id( $location_id, $bid );
		if(empty($rst))
		{
			echo "error";
		}
		
	}
	
	/*====jQuery material list====*/
	public function list_material_fn( $id=NULL )
	{
		$keyword = $this->input->post('keyword');
		$result = $this->sample_model->get_material_like( $keyword, $id );
		if(!empty($result)) {
			echo '<ul id="material_id_l">';
			foreach($result as $material) {
				echo '<li onClick="selectmaterial(\''.$material->material_name.'\', \''.$material->id.'\')">'.$material->material_name.'</li>';
			}
			echo "</ul>";
		}
	}
	
	/*====jQuery material Iden list====*/
	public function list_material_fn_edit( $id=NULL )
	{
		$keyword = $this->input->post('keyword');
		$result = $this->sample_model->get_material_like( $keyword, $id );
		if(!empty($result)) {
			echo '<ul id="material_id_l">';
			foreach($result as $material) {
				echo '<li onClick="selectmaterial_edit(\''.$material->material_name.'\', \''.$material->id.'\')">'.$material->material_name.'</li>';
			}
			echo "</ul>";
		}
	}
	
	/*====jQuery sytem material list====*/
	public function check_system_mat_identy( $id=NULL )
	{
		$system_id = $this->input->post('system_id');
		$result = $this->sample_model->get_mat_identy_info( $system_id, $id );
		$arr = array();
		$arr =  "<option>Please select</option>";
		if( !empty( $result ) )
		{			
			foreach($result as $results){
				$arr .=  "<option value=".$results->m_id.">".$results->m_identification."</option>";
			}
		}else{
			$arr .=  "<option value='5'>N/A</option>";
		}		
		echo json_encode($arr);
		
	}
	
	/*====jQuery material desc ====*/
	public function check_mat_desc( $id=NULL )
	{
		$material_id 		= $this->input->post('material_id');
		$material_identy 	= $this->input->post('material_identy');
		
		$arr = array();
		if($material_identy == '5')
		{
			$result = $this->sample_model->get_mat_desc( $material_id, $id );	
			$arr =  $result->material_desc;
		}else{
			$result = $this->sample_model->get_mat_identy_desc( $material_identy, $id );
			$arr =  $result->m_description;
		}
		echo json_encode($arr);
	}

	/*====Export Report for samples in Excel====*/
	public function export( )
	{
		
		$checked_s_ids = $this->input->post('check');
		
		
		$filename = "sample_data_csv.csv";
		$fp = fopen('php://output', 'w+');
		
		$heading = array( 'Buiding_name','DB_sample','Sample_number','LocationID','System','Material_identification','Material_description','Layer One Type','Layer One Percent','Layer Two Type','Layer Two Percent','Layer Three Type','Layer Three Percent','Comments' );
		
		header( 'Content-type: application/csv' );
		header( 'Content-Disposition: attachment; filename='.$filename );
		fputcsv($fp, $heading);
		
		if(!empty($checked_s_ids))
		{
			
			foreach($checked_s_ids as $checked_s_id)
			{
				$header = $this->sample_model->list_samples_export( $checked_s_id );
				
					foreach( $header as $row )
					{
						
						$rows = array($row->building_name, $row->db_sample, $row->sample_number, $row->locationID, $row->system, $row->m_identification, $row->m_description, '', '', '', '', '', '', $row->comments);
						
						fputcsv( $fp, $rows );
					}
			}
			
		}else{
			
			$bid = $this->input->post('bid');
			$header = $this->sample_model->list_samples_export_all( $bid );
			
			foreach( $header as $row )
			{
			
				$rows = array($row->building_name, $row->db_sample, $row->sample_number, $row->locationID, $row->system, $row->m_identification, $row->m_description, '', '', '', '', '', '', $row->comments);
						
				fputcsv($fp, $rows);
			}	
			
		}	
		fclose($fp);
    
	}
	
	/*====sample import in csv====*/
	public function import( )
	{
		
		$bid = $this->input->post('bid');
		
		$config['upload_path'] = $_FILES['filename']['tmp_name'];
			$this->load->library('upload', $config);
			$handle = fopen($config['upload_path'], "r+");
			$i=0;			
			while ( ( $data = fgetcsv( $handle, 1000, "," ) ) !== FALSE ) 
			{
				if( $i > 0 )
				{
					
					$layer_one_type = $data[7];
					$sys = $this->sample_model->get_layer_one_info( $layer_one_type );					
					$layer_type_one = $sys->layer_id;
					
					$layer_two_type = $data[9];
					$sys_data = $this->sample_model->get_layer_two_info( $layer_two_type );
					$layer_type_two = $sys_data->layer_id;
					
					$sample_number = $data[2];
					$data = array(
						'layer_one_type' => $layer_type_one,
						'layer_one_percent' => $data[8],
						'layer_two_type' => $layer_type_two,
						'layer_two_percent' => $data[10],
						'layer_three_type' => $data[11],
						'layer_three_percent' => $data[12]
					);
					
					
					$this->sample_model->update_sample_data( $sample_number, $data );
					
				}
				$i++;
			}
			fclose($handle);
			
			redirect( 'sample/index/'.$bid );
        
	}
	
	/*=====Table view of samples=====*/
	public function get_sample_data( $id=NULL )
	{
		
		$data = $this->sample_model->list_sample_data_sid( $id );
		$tempdata = $this->sample_model->list_sample_data_sid( $id );
		$list_layers = $this->sample_model->list_layers( );
		$hazard_conditions = $this->sample_model->get_all_hazard( );
		$db_sample_rst = $this->sample_model->db_sample_rst( $id );
		$j=1;
		foreach($data as $list_sample_datas)
		{ ?>
		<tr class="sample-data-row" id="sample-data-<?php echo $list_sample_datas->id;?>">
		
			<td><a data-type="sample_number" data-id="<?php echo $list_sample_datas->smID;?>" data-value="<?php echo $list_sample_datas->sample_number;?>" ondblclick="dblfunction(this);"><?php echo $list_sample_datas->sample_number;?></a></td>
			
			<td><a data-type="locationID" data-id="<?php echo $list_sample_datas->smID;?>" data-value="<?php echo $list_sample_datas->locationID;?>" ondblclick="dblfunction(this);"><?php echo $list_sample_datas->locationID;?></a></td>
			
			<td><a href="javascript:void(0);" data-type="system_id" data-id="<?php echo $list_sample_datas->smID;?>" data-value="<?php echo $list_sample_datas->system_name;?>" ondblclick="dbl_list_function(this);"><?php echo $list_sample_datas->system_name;?></a></td>
			
			<td><a data-type="mat_id" data-id="<?php echo $list_sample_datas->smID;?>" data-value="<?php echo $list_sample_datas->material_name;?>" ondblclick="dblfunction(this);"><?php echo $list_sample_datas->material_name;?></a></td>
			
			<td><a href="javascript:void(0);" data-type="material_identy" data-save="<?php echo $list_sample_datas->smID;?>" data-jugard="<?php echo $list_sample_datas->mat_id;?>" data-id="<?php echo $list_sample_datas->m_id;?>" id="<?php echo $list_sample_datas->system_id;?>" data-value="<?php echo $list_sample_datas->m_identification;?>" ondblclick="dbl_list_ide_function(this);"><?php echo $list_sample_datas->m_identification;?></a></td>
			
			<td><?php if($list_sample_datas->m_description == "" ){ echo $list_sample_datas->material_desc;}else{echo $list_sample_datas->m_description;}?></td>
			
			<td><a href="javascript:void(0);" data-type="layer_one_type" data-id="<?php echo $list_sample_datas->smID;?>" data-value="<?php if(isset($list_layers)){ foreach($list_layers as $list_layer){ if($list_sample_datas->layer_one_type == $list_layer->layer_id){echo $list_layer->layer_type;} } } ?>" ondblclick="dbl_list_function(this);"><?php if(isset($list_layers)){ foreach($list_layers as $list_layer){ if($list_sample_datas->layer_one_type == $list_layer->layer_id){echo $list_layer->layer_type;} } } ?></a></td>		
			
			<td><a data-type="layer_one_percent" data-sid="<?php echo $id;?>" data-id="<?php echo $list_sample_datas->smID;?>" data-value="<?php echo $list_sample_datas->layer_one_percent;?>" ondblclick="dblfunction_percent(this);"><?php echo $list_sample_datas->layer_one_percent;?></a></td>
			
			<td><a href="javascript:void(0);" data-type="layer_two_type" data-id="<?php echo $list_sample_datas->smID;?>" data-value="<?php if(isset($list_layers)){ foreach($list_layers as $list_layer){ if($list_sample_datas->layer_two_type == $list_layer->layer_id){echo $list_layer->layer_type;} } } ?>" ondblclick="dbl_list_function(this);"><?php if(isset($list_layers)){ foreach($list_layers as $list_layer){ if($list_sample_datas->layer_two_type == $list_layer->layer_id){echo $list_layer->layer_type;} } } ?></td>
			
			<td><a data-type="layer_two_percent" data-sid="<?php echo $id;?>" data-id="<?php echo $list_sample_datas->smID;?>" data-value="<?php echo $list_sample_datas->layer_two_percent;?>" ondblclick="dblfunction_percent(this);"><?php echo $list_sample_datas->layer_two_percent;?></a></td>
			
			 

			<?php if( $j==1 )
			{?>			
				<td rowspan="<?php echo $this->get_sample_data_count_last_row( $id);?>" class="td-actions">
					<a data-type="s_result" data-id="<?php echo $id;?>" data-value="<?php echo $db_sample_rst->s_result;?>" ondblclick="dblfunction(this);" title="<?php if($db_sample_rst->s_result=='L.O.D'){echo "Less than the Limit of Detection";}else{echo $db_sample_rst->s_result;}?>"><?php if($db_sample_rst->s_result=='L.O.D'){echo "&lt;L.O.D";}else{echo $db_sample_rst->s_result;}?></a>
				</td>
			<?php 
			} ?>
			
			<td><a data-type="comments" data-id="<?php echo $list_sample_datas->smID;?>" data-value="<?php echo $list_sample_datas->comments;?>" ondblclick="dblfunction(this);"><?php if( $list_sample_datas->comments != ""){echo $list_sample_datas->comments;}else{ echo "Add Comments";} ?></a></td>
			
			<td><a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="javascript:void(0)" onclick="delete_confirm_smid( <?php echo $list_sample_datas->smID;?>,<?php echo $id;?> )" title="Delete Row"><i class="btn-icon-only icon-remove"> </i></a></td>
			
			<?php if( $j==1 )
			{?>
				<td rowspan="<?php echo $this->get_sample_data_count_last_row( $id);?>" class="td-actions">				
					
					<a data-toggle="modal" role="button" class="btn btn-success btn-small add_field_button" href="javascript:void(0)"  title="Add Sample" onClick="addSubRow('#sample-id-<?php echo $id; ?>',<?php echo $id; ?>)"><i class="icon-plus-sign-alt"></i></a>
					
					<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="javascript:void(0)" onclick="delete_confirm( <?php echo $id; ?> )" title="Delete"><i class="btn-icon-only icon-remove"> </i></a>
					
				</td>
			<?php 
			} ?>
			
		</tr>
		<?php $j++; 
		}
		
	}
	
	/*=====Get First child sample=====*/
	public function get_sample_data_first_child(  )
	{
		$sid = $this->input->post('sid');
		$list_system = $this->sample_model->list_system( );
		$list_layers = $this->sample_model->list_layers( );
		$record = $this->sample_model->get_first_record_from_sample_data( $sid );
		
		$list='';
		$selected = '';
		foreach($list_system as $list_systems){
			$list .= '<option '.(($record->system_id==$list_systems->id)? 'selected' : '').' value="'.$list_systems->id.'">'.$list_systems->system_name.'</option>';
		}
		
		$layer_one='';
		$selected = '';
		foreach($list_layers as $list_layer){		
			$layer_one .= '<option  value="'.$list_layer->layer_id.'">'.$list_layer->layer_type.'</option>';
		}
		
		$layer_two='';
		$selected = '';
		foreach($list_layers as $list_layer){		
			$layer_two .= '<option  value="'.$list_layer->layer_id.'">'.$list_layer->layer_type.'</option>';
		}
		
		
		echo '<tr id="myTableRow">
			<td><input autocomplete="off" class="span1" type="text" name="sample_number" id="sample_number" value="'.$record->sample_number.'"></td>
			<td><input autocomplete="off" class="span1" type="text" id="location_id" name="location_id" onkeyup="return get_location(this);" value="'.$record->locationID.'"><div id="suggesstion-box"></div></td>
			<td><select onChange="return system_id()" name="system" id="system">
				<option>Please Select</option>
				'.$list.'
				</select></td>
			<td><input autocomplete="off" class="span1" type="text" onkeyup="return get_material(this);" name="mat_id" data-id="'.$record->mat_id.'" id="mat_id" value="'.$record->material_name.'"><div id="suggesstion-box1"></div></td>
			<td><select onChange="return mat_desc()" id="mat_identy" name="mat_identy"><option>Please select</option><option selected value="'.$record->m_id.'">'.$record->m_identification.'</option></select></td>
			<td><textarea name="mat_identy_desc" id="mat_identy_desc">'.(( $record->material_desc =='' )? $record->m_description : $record->material_desc ).'</textarea></td>
			<td><select class="span1" name="layer_one_type" onChange="get_drop_value_l();" id="layer_one_type"><option>Please Select</option>'.$layer_one.'</select></td>
			<td id="layer_one_percent_td"><input autocomplete="off" class="span1" type="text" name="layer_one_percent" id="layer_one_percent" value=""></td>
			<td><select class="span1" onChange="get_drop_value_l2();" name="layer_two_type" id="layer_two_type"><option>Please Select</option>'.$layer_two.'</select></td>
			<td id="layer_two_percent_td"><input autocomplete="off" class="span1" type="text" name="layer_two_percent" id="layer_two_percent" value="">
			</td>
			<td><input type="hidden" name="sid" id="sids" value="'.$sid.'"></td>
			<td><textarea id="comments" name="comments">'.$record->comments.'</textarea></td>
			<td><a href="javascript:void(0);" onclick="save_sample_data()" id="save_sample_number" class="btn btn-small btn-primary">Save</a>
			<a href="javascript:void(0);" onclick="remove_row('.$sid.')" class="remove_field btn btn-small btn-primary">Remove</a></td>
		</tr>';
		
	}
	
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
	
	/*==========================Save DB Sample Number=========================================*/
	
	public function add_dbsample_number( )
	{
		
			$building_id 			= $this->input->post('bid');
			$db_sample 				= $this->input->post('db_sample');
			$sample_number 			= $this->input->post('sample_number');
			$locationID 			= $this->input->post('location_id');
			$system 				= $this->input->post('system');
			$mat_id 				= $this->input->post('mat_id');
			$mat_identy 			= $this->input->post('mat_identy');
				
			$layer_one_type 		= $this->input->post('layer_one_type');
			$layer_one_percent 		= $this->input->post('layer_one_percent');
			$layer_two_type 		= $this->input->post('layer_two_type');
			$layer_two_percent 		= $this->input->post('layer_two_percent');
			
			$comments 				= $this->input->post('comments');
			
			if($layer_one_percent == ""){$layer_one_percent = "N/A";}
			if($layer_two_percent == ""){$layer_two_percent = "N/A";}
			
			if($layer_one_type == ""){$layer_one_type = "7";}
			if($layer_two_type == ""){$layer_two_type = "7";}
			
			$hazard_conditions = $this->sample_model->get_all_hazard( );
			
			$s_result = "L.O.D";
			if($hazard_conditions->condition == ">=")
			{
				if($layer_one_percent == "N/A" || $layer_one_percent == "Not Analyzed" || $layer_one_percent == "L.O.D" || $layer_one_percent == "None Detected"){}
						else if($layer_one_percent >= $hazard_conditions->hazard){
							$l = "ca";
						}else if($layer_one_percent <= $hazard_conditions->hazard ){
							$ll = "lod";
						}
						
						if($layer_two_percent == "N/A" || $layer_two_percent == "Not Analyzed" || $layer_two_percent == "L.O.D" || $layer_two_percent == "None Detected"){}
						else if($layer_two_percent >= $hazard_conditions->hazard ){
							$lc = "ca";
						}else if($layer_two_percent <= $hazard_conditions->hazard ){
							$llc = "lod";
						}
			}
			if($hazard_conditions->condition == ">")
			{
				if( $layer_one_percent > $hazard_conditions->hazard || $layer_two_percent > $hazard_conditions->hazard )
				{
					$s_result = $hazard_conditions->hazard_rst;
				}else{
					$s_result = "L.O.D";
				}
			}
			if($hazard_conditions->condition == "<=")
			{
				if( $layer_one_percent > $hazard_conditions->hazard || $layer_two_percent > $hazard_conditions->hazard ){
					if( $hazard_conditions->hazard <= $layer_one_percent || $hazard_conditions->hazard <= $layer_two_percent )
					{	
						$s_result = "L.O.D";
					}else{
						$s_result = $hazard_conditions->hazard_rst;
					}
				}else{
					if( $layer_one_percent <= $hazard_conditions->hazard || $layer_two_percent <= $hazard_conditions->hazard )
					{
						$s_result = $hazard_conditions->hazard_rst;
					}else{
						$s_result = "L.O.D";
					}
				}
			}
			if($hazard_conditions->condition == "<")
			{
				if( $layer_one_percent < $hazard_conditions->hazard || $layer_two_percent < $hazard_conditions->hazard )
				{
					$s_result = $hazard_conditions->hazard_rst;
				}else{
					$s_result = "L.O.D";
				}
			}	
				
			if(isset($l)){
				$s_result = "Confirmed Asbestos";
			}else if(isset($lc) && isset($ll)){
				$s_result = "Confirmed Asbestos";
			}else if(isset($ll) && isset($llc)){
				$s_result = "L.O.D";
			}else{
				$s_result = "L.O.D";
			}
			
			$inserted_data = array(
				'building_id' 		=> $building_id,
				'db_sample' 		=> $db_sample,
				's_result' 			=> $s_result,
				'added_date' 		=> date('y-m-d')
			);
			
			$last_inserted_id = $this->sample_model->insert_sample($inserted_data);
			
				$sample_data = array(
					'sampleID'				=> $last_inserted_id,
					'sample_number' 		=> $sample_number,
					'locationID' 			=> $locationID,
					'system_id' 			=> $system,
					'mat_id' 				=> $mat_id,
					'material_identy' 		=> $mat_identy,
					'layer_one_type' 		=> $layer_one_type,
					'layer_one_percent' 	=> $layer_one_percent,
					'layer_two_type' 		=> $layer_two_type,
					'layer_two_percent' 	=> $layer_two_percent,
					'comments' 				=> $comments
				);
				
				$this->sample_model->insert_sample_data($sample_data);
				
				echo "success";
				
	}
	
	/*=====add sampledata number to DB====*/
	public function add_sampledata_number( $bid=NULL )
	{
		
		$sample_number 	 = $this->input->post('sample_number');
		$location_id 	 = $this->input->post('location_id');
		$system 		 = $this->input->post('system');
		$mat_id 		 = $this->input->post('mat_id');
		$mat_identy 	 = $this->input->post('mat_identy');
		
		$layer_one_type 	 = $this->input->post('layer_one_type');
		$layer_one_percent 	 = $this->input->post('layer_one_percent');
		$layer_two_type 	 = $this->input->post('layer_two_type');
		$layer_two_percent 	 = $this->input->post('layer_two_percent');
		
		$comments 	     = $this->input->post('comments');
		$sid 		     = $this->input->post('sid');
		
		if($layer_one_percent == ""){$layer_one_percent = "N/A";}
		if($layer_two_percent == ""){$layer_two_percent = "N/A";}
		
		$arr = array(
			'sampleID' 				=> $sid,
			'sample_number' 		=> $sample_number,
			'locationId' 			=> $location_id,
			'system_id' 			=> $system,
			'mat_id' 				=> $mat_id,
			'material_identy' 		=> $mat_identy,
			'layer_one_type' 		=> $layer_one_type,
			'layer_one_percent' 	=> $layer_one_percent,
			'layer_two_type' 		=> $layer_two_type,
			'layer_two_percent' 	=> $layer_two_percent,
			'comments' 				=> $comments
		);
		
		$this->sample_model->insert_sample_data_extra( $arr );
		
		$get_layer_percents = $this->sample_model->get_layer_percents( $sid );
			$hazard_conditions = $this->sample_model->get_all_hazard();						
			$r='';
			$r2='';		
			$rst = "L.O.D";
			foreach($get_layer_percents as $get_layer_percent)
			{										
					if($hazard_conditions->condition == ">=")
					{
					
						if($get_layer_percent->layer_one_percent == "N/A" || $get_layer_percent->layer_one_percent == "Not Analyzed" || $get_layer_percent->layer_one_percent == "L.O.D" || $get_layer_percent->layer_one_percent == "None Detected"){}
						else if($get_layer_percent->layer_one_percent >= $hazard_conditions->hazard){
							$l = "ca";
						}else if($get_layer_percent->layer_one_percent <= $hazard_conditions->hazard ){
							$ll = "lod";
						}
						
						if($get_layer_percent->layer_two_percent == "N/A" || $get_layer_percent->layer_two_percent == "Not Analyzed" || $get_layer_percent->layer_two_percent == "L.O.D" || $get_layer_percent->layer_two_percent == "None Detected"){}
						else if($get_layer_percent->layer_two_percent >= $hazard_conditions->hazard ){
							$lc = "ca";
						}else if($get_layer_percent->layer_two_percent <= $hazard_conditions->hazard ){
							$llc = "lod";
						}
						
					
					}
					
					if($hazard_conditions->condition == ">")
					{
						if( $get_layer_percent->layer_one_percent > $hazard_conditions->hazard || $get_layer_percent->layer_two_percent > $hazard_conditions->hazard )
						{
							$rst = $hazard_conditions->hazard_rst;
						}else{
							$rst = "L.O.D";
						}
					}
					if($hazard_conditions->condition == "<=")
					{
						if( $get_layer_percent->layer_one_percent > $hazard_conditions->hazard || $get_layer_percent->layer_two_percent > $hazard_conditions->hazard ){
							if( $hazard_conditions->hazard <= $get_layer_percent->layer_one_percent || $hazard_conditions->hazard <= $get_layer_percent->layer_two_percent )
							{	
								$rst = "L.O.D";
							}else{
								$rst = $hazard_conditions->hazard_rst;
							}
						}else{
							if( $get_layer_percent->layer_one_percent <= $hazard_conditions->hazard || $get_layer_percent->layer_two_percent <= $hazard_conditions->hazard )
							{
								$rst = $hazard_conditions->hazard_rst;
							}else{
								$rst = "L.O.D";
							}
						}
					}
					if($hazard_conditions->condition == "<")
					{
						if( $get_layer_percent->layer_one_percent < $hazard_conditions->hazard || $get_layer_percent->layer_two_percent < $hazard_conditions->hazard )
						{
							$rst = $hazard_conditions->hazard_rst;
						}else{
							$rst = "L.O.D";
						}
					}
					
			}
			
			if(isset($l)){
				$rst = "Confirmed Asbestos";
			}else if(isset($lc) && isset($ll)){
				$rst = "Confirmed Asbestos";
			}else if(isset($ll) && isset($llc)){
				$rst = "L.O.D";
			}else{
				$rst = "L.O.D";
			}
			
			$this->sample_model->update_db_sample_rst( $sid, $rst );
		
		echo "success";		                 
		
	}
	
	/*=========================Save Sample Number=====================================*/
	
	/*====Remove sample to trash=====*/
	public function remove_sample_to_trash( $id=NULL )
	{
		$bid = $this->sample_model->get_building_id( $id );
		
		$this->sample_model->remove_sample_to_trash( $id );
		redirect( 'sample/index/'.$bid->building_id );
	}
	
	/*===list trash samles===*/
	public function list_trashed_samples( $id=NULL )
	{
		$data['list_samples'] = $this->sample_model->list_samples_trash( $id );
		$data['list_sample_data'] = $this->sample_model->list_sample_data( );
		$data['list_system'] = $this->sample_model->list_system( );
		$data['bid'] = $id;
		$this->load->view('templates/header.php');
		$this->load->view('samples/list_trash_samples',$data);
		$this->load->view('templates/footer.php');
	}
	
	public function remove_sample_permanent( $id=NULL )
	{
		$bid = $this->sample_model->get_building_id( $id );
		
		$this->sample_model->remove_sample_permanent( $id );
		redirect( 'sample/index/'.$bid->building_id );
	}
	
	/*==Get sample data trash==*/
	public function get_sample_data_trashed( $id=NULL )
	{
		
		$data = $this->sample_model->list_sample_data_sid( $id );
		$list_layers = $this->sample_model->list_layers( );
		$i=1;
		foreach($data as $list_sample_datas){ ?>
		<tr class="sample-data-row" id="sample-data-<?php echo $list_sample_datas->id;?>">
		
			<td><?php echo $list_sample_datas->sample_number;?></td>
			<td><?php echo $list_sample_datas->locationID;?></td>
			<td><?php echo $list_sample_datas->system_name;?></td>
			<td><?php echo $list_sample_datas->material_name;?></td>
			<td><?php echo $list_sample_datas->m_identification;?></td>
			<td><?php echo $list_sample_datas->m_description;?></td>
			
			<td><?php foreach($list_layers as $list_layer){ if($list_sample_datas->layer_one_type == $list_layer->layer_id){echo $list_layer->layer_type;} } ?></td>		
			
			<td><?php echo $list_sample_datas->layer_one_percent;?></td>
			
			<td><?php foreach($list_layers as $list_layer){ if($list_sample_datas->layer_two_type == $list_layer->layer_id){echo $list_layer->layer_type;} } ?></td>
			<td><?php echo $list_sample_datas->layer_two_percent;?></td>
			<td><?php echo $list_sample_datas->comments;?></td>

			
			<?php if($i==1){ ?>
			<td rowspan="<?php echo $this->get_sample_data_count_last_row( $id);?>" class="td-actions">Hazard</td>
			<td rowspan="<?php echo $this->get_sample_data_count_last_row( $id);?>" class="td-actions">
			
				<a href="<?php echo base_url();?>sample/restore_sample/<?php echo $id; ?>" class="btn btn-small btn-success" title="Restore"><i class="fa fa-undo"></i></a>
				
				<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="javascript:void(0)" onclick="delete_confirm( <?php echo $id; ?> )" title="Delete"><i class="btn-icon-only icon-remove"> </i></a>
				
			</td>
			<?php } ?>
			<td></td>
			
		</tr>
		<?php $i++; }
		
	}
	
	public function restore_sample( $id=NULL )
	{
		$bid = $this->sample_model->get_building_id( $id );
		$this->sample_model->restore_sample( $id );
		redirect( 'sample/index/'.$bid->building_id );
	}
	
	/*=======Update sample data fields========*/
	public function update_sampledata_field( )
	{
	
		$smid 			= $this->input->post('smid');
		$field_name 	= $this->input->post('field_name');
		$field_value 	= $this->input->post('field_value');
		$bid 			= $this->input->post('bid');
		
		if(!empty($field_value)){
			if( $field_name == 'results' ){
				$this->sample_model->update_sampledata_field_sample( $smid, $field_name, $field_value );
				echo "success";
			}else if( $field_name == 'layer_one_percent' ){
				$sid = $this->input->post('sid');
				$this->sample_model->update_sampledata_field( $smid, $field_name, $field_value );
				
				$get_layer_percents = $this->sample_model->get_layer_percents( $sid );
					$hazard_conditions = $this->sample_model->get_all_hazard();						
					$r='';
					$r2='';		
					$rst = "L.O.D";
					foreach($get_layer_percents as $get_layer_percent)
					{

							if($hazard_conditions->condition == ">=")
							{
								if($get_layer_percent->layer_one_percent == "N/A" || $get_layer_percent->layer_one_percent == "Not Analyzed" || $get_layer_percent->layer_one_percent == "L.O.D" || $get_layer_percent->layer_one_percent == "None Detected"){}
								else if($get_layer_percent->layer_one_percent >= $hazard_conditions->hazard){
									$l = "ca";
								}else if($get_layer_percent->layer_one_percent < $hazard_conditions->hazard ){
									$ll = "lod";
								}
								
								if($get_layer_percent->layer_two_percent == "N/A" || $get_layer_percent->layer_two_percent == "Not Analyzed" || $get_layer_percent->layer_two_percent == "L.O.D" || $get_layer_percent->layer_two_percent == "None Detected"){}
								else if($get_layer_percent->layer_two_percent >= $hazard_conditions->hazard ){
									$lc = "ca";
								}else if($get_layer_percent->layer_two_percent <= $hazard_conditions->hazard ){
									$llc = "lod";
								}
								
								
							}
							
							if($hazard_conditions->condition == ">")
							{
								if( $get_layer_percent->layer_one_percent > $hazard_conditions->hazard || $get_layer_percent->layer_two_percent > $hazard_conditions->hazard )
								{
									$rst = $hazard_conditions->hazard_rst;
								}else{
									$rst = "L.O.D";
								}
							}
							if($hazard_conditions->condition == "<=")
							{
								if( $get_layer_percent->layer_one_percent > $hazard_conditions->hazard || $get_layer_percent->layer_two_percent > $hazard_conditions->hazard ){
									if( $hazard_conditions->hazard <= $get_layer_percent->layer_one_percent || $hazard_conditions->hazard <= $get_layer_percent->layer_two_percent )
									{	
										$rst = "L.O.D";
									}else{
										$rst = $hazard_conditions->hazard_rst;
									}
								}else{
									if( $get_layer_percent->layer_one_percent <= $hazard_conditions->hazard || $get_layer_percent->layer_two_percent <= $hazard_conditions->hazard )
									{
										$rst = $hazard_conditions->hazard_rst;
									}else{
										$rst = "L.O.D";
									}
								}
							}
							if($hazard_conditions->condition == "<")
							{
								if( $get_layer_percent->layer_one_percent < $hazard_conditions->hazard || $get_layer_percent->layer_two_percent < $hazard_conditions->hazard )
								{
									$rst = $hazard_conditions->hazard_rst;
								}else{
									$rst = "L.O.D";
								}
							}
							
					}
					
					if(isset($l)){
						$rst = "Confirmed Asbestos";
					}else if(isset($lc) && isset($ll)){
						$rst = "Confirmed Asbestos";
					}else if(isset($ll) && isset($llc)){
						$rst = "L.O.D";
					}else{
						$rst = "L.O.D";
					}
					
					$this->sample_model->update_db_sample_rst( $sid, $rst );
				
				echo "success";
			}else if( $field_name == 'layer_two_percent' ){
				$sid = $this->input->post('sid');
				$this->sample_model->update_sampledata_field( $smid, $field_name, $field_value );
				
				$get_layer_percents = $this->sample_model->get_layer_percents( $sid );
					
					$hazard_conditions = $this->sample_model->get_all_hazard();						
					
					foreach($get_layer_percents as $get_layer_percent)
					{										
							if($hazard_conditions->condition == ">=")
							{
								if($get_layer_percent->layer_one_percent == "N/A" || $get_layer_percent->layer_one_percent == "Not Analyzed" || $get_layer_percent->layer_one_percent == "L.O.D" || $get_layer_percent->layer_one_percent == "None Detected"){}
								else if($get_layer_percent->layer_one_percent >= $hazard_conditions->hazard){
									$l = "ca";
								}else if($get_layer_percent->layer_one_percent <= $hazard_conditions->hazard ){
									$ll = "lod";
								}
								
								if($get_layer_percent->layer_two_percent == "N/A" || $get_layer_percent->layer_two_percent == "Not Analyzed" || $get_layer_percent->layer_two_percent == "L.O.D" || $get_layer_percent->layer_two_percent == "None Detected"){}
								else if($get_layer_percent->layer_two_percent >= $hazard_conditions->hazard ){
									$lc = "ca";
								}else if($get_layer_percent->layer_two_percent <= $hazard_conditions->hazard ){
									$llc = "lod";
								}
							}
							if($hazard_conditions->condition == ">")
							{
								if( $get_layer_percent->layer_one_percent > $hazard_conditions->hazard || $get_layer_percent->layer_two_percent > $hazard_conditions->hazard )
								{
									$rst = $hazard_conditions->hazard_rst;
								}else{
									$rst = "L.O.D";
								}
							}
							if($hazard_conditions->condition == "<=")
							{
								if( $get_layer_percent->layer_one_percent > $hazard_conditions->hazard || $get_layer_percent->layer_two_percent > $hazard_conditions->hazard ){
									if( $hazard_conditions->hazard <= $get_layer_percent->layer_one_percent || $hazard_conditions->hazard <= $get_layer_percent->layer_two_percent )
									{	
										$rst = "L.O.D";
									}else{
										$rst = $hazard_conditions->hazard_rst;
									}
								}else{
									if( $get_layer_percent->layer_one_percent <= $hazard_conditions->hazard || $get_layer_percent->layer_two_percent <= $hazard_conditions->hazard )
									{
										$rst = $hazard_conditions->hazard_rst;
									}else{
										$rst = "L.O.D";
									}
								}
							
								
							}
							if($hazard_conditions->condition == "<")
							{
								if( $get_layer_percent->layer_one_percent < $hazard_conditions->hazard || $get_layer_percent->layer_two_percent < $hazard_conditions->hazard )
								{
									$rst = $hazard_conditions->hazard_rst;
								}else{
									$rst = "L.O.D";
								}
							}							
					}
					
					if(isset($l)){
						$rst = "Confirmed Asbestos";
					}else if(isset($lc) && isset($ll)){
						$rst = "Confirmed Asbestos";
					}else if(isset($ll) && isset($llc)){
						$rst = "L.O.D";
					}else{
						$rst = "L.O.D";
					}
					
					$this->sample_model->update_db_sample_rst( $sid, $rst );
				
				echo "success";
			}else if( $field_name == 'db_sample' ){
				$this->sample_model->update_sample_field_dbsample( $smid, $field_name, $field_value );
				echo "success";
			}else if( $field_name == 'locationID' ){
				$rst = $this->sample_model->check_location_id( $field_value, $bid );
				if(empty($rst)){
					echo "error";
				}else{
					$this->sample_model->update_sampledata_field( $smid, $field_name, $field_value );
					echo "success";
				}	
			}else if( $field_name == 's_result' ){
				$this->sample_model->update_sample_rst_field_dbsample( $smid, $field_name, $field_value );
				echo "success";
			}else{
				$this->sample_model->update_sampledata_field( $smid, $field_name, $field_value );
				echo "success";
			}
		}
		
		
	}
	
	/*==update sampledata to mat=*/
	public function update_sampledata_field_mat( ) 
	{
		$smid 			= $this->input->post('smid');
		$field_name 	= $this->input->post('field_name');
		$field_value 	= $this->input->post('field_value');
		$mat_id 		= $this->input->post('mat_id');
		 
		
		if(!empty($field_value)){
			$this->sample_model->update_sampledata_field_sample_mat( $smid, $field_name, $field_value, $mat_id );
			echo "success";
		}
		
	}
	
	/*=mat identity list==*/
	public function get_identity_list_from_system( )
	{
		
		$system_id 		= $this->input->post('system_id');
		$smid 			= $this->input->post('smid');
		$field_name 	= $this->input->post('field_name');
		$field_value 	= $this->input->post('field_value');
		$sample_id 		= $this->input->post('sample_id');		
		$bid 			= $this->input->post('bid');
		
		$list_system = $this->sample_model->get_identity_list_from_system( $sample_id, $bid );
			
		$options = '<option value="">Please Select</option>';
		if(!empty($list_system))
		{
			foreach( $list_system as $list_systems )
			{
			
				$options .= '<option '.(($list_systems->m_id == $smid) ? 'selected' : '' ).' value="'.$list_systems->m_id.'">'.$list_systems->m_identification.'</option>';
			}
		}else{
			$options .= '<option value="5">N/A</option>';
		}	
		
		echo $options;
	}
	
	
	/*==hazzard setting===*/
	public function hazard_setting( $bid=NULL )
	{
		if(isset($_POST['submit']))
		{
			$hazard 		= $this->input->post('hazard');
			$condition 		= $this->input->post('condition');
			$hazard_rst 	= $this->input->post('hazard_condition_rst');
			
			$data = array(
				'hazard' 		=> $hazard,
				'condition' 	=> $condition,
				'hazard_rst' 	=> $hazard_rst
			);
			$rst = $this->sample_model->get_all_hazard( );
			
			if( $rst == "" )
			{
				$this->sample_model->data_get_inserted( $data );
			}else{
				$this->sample_model->data_get_updated( $data, $rst->id );
			}
			
		}
		$data['autofill_hazard'] = $this->sample_model->get_all_hazard( );
		$data['bid'] = $bid;
		$this->load->view('templates/header.php');
		$this->load->view('samples/hazard_setting',$data);
		$this->load->view('templates/footer.php');
	}
	
	public function check_layer_one_type()
	{
		$sid = $this->input->post('sid');
		$rst_layer_one = $this->sample_model->check_layer_one_type( $sid );
		if( !empty( $rst_layer_one ) ){
			echo $rst_layer_one->layer_one_type;
		}
		
	}
	
	public function check_layer_two_type()
	{
		$sid = $this->input->post('sid');
		$rst_layer_one = $this->sample_model->check_layer_two_type( $sid );
		if( !empty( $rst_layer_one ) ){
			echo $rst_layer_one->layer_two_type;
		}
		
	}
	
	
	
	 	
}	