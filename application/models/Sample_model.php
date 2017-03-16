<?php
Class Sample_model extends CI_Model
{
	
	public function list_location( )
	{
		$this -> db -> select( '*' );
		$query = $this -> db -> get( 'location' );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_identy_number( )
	{
		$this -> db -> select( '*' );
		$query = $this -> db -> get( 'material_identification' );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function insert_sample( $inserted_data )
	{
		$this -> db -> insert( 'samples', $inserted_data );
		return $this -> db -> insert_id();
	}
	
	public function insert_sample_data( $sample_data )
	{
		$this -> db -> insert( 'sample_data', $sample_data );
	}
	
	public function list_samples_export( $checked_s_id )
	{
		$this -> db -> select( 'samples.*, sample_data.*, material_identification.*, material.*, building.building_name' );
		$this -> db -> from( 'samples', 'sample_data', 'material_identification', 'material', 'building' );		
		$this -> db -> where( 'samples.s_id', $checked_s_id );
		$this -> db -> join( 'sample_data', 'samples.s_id = sample_data.sampleID ' );
		$this -> db -> join( 'material_identification', 'sample_data.material_identy = material_identification.m_id' );
		$this -> db -> join( 'material', 'sample_data.system_id = material.id' );
		$this -> db -> join( 'building', 'samples.building_id = building.id and samples.status=0' );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function list_samples_export_all( $bid )
	{
		$this -> db -> select( 'samples.*, sample_data.*, material_identification.*, material.*, building.building_name' );
		$this -> db -> from( 'samples', 'sample_data', 'material_identification', 'material', 'building' );
		$this -> db -> where( 'samples.building_id', $bid );
		$this -> db -> join( 'sample_data', 'samples.s_id = sample_data.sampleID ' );
		$this -> db -> join( 'material_identification', 'sample_data.material_identy = material_identification.m_id' );
		$this -> db -> join( 'material', 'sample_data.system_id = material.id' );
		$this -> db -> join( 'building', 'samples.building_id = building.id and samples.status=0' );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function list_samples_export_all_new( $bid )
	{
		$this -> db -> select( 'samples.*, sample_data.*, material_identification.*, material.*, building.building_name,system_data.*,layers.layer_type' );
		$this -> db -> from( 'samples', 'sample_data', 'material_identification', 'material', 'building', 'system_data', 'layers' );
		$this -> db -> where( 'samples.building_id', $bid );
		$this -> db -> join( 'sample_data', 'samples.s_id = sample_data.sampleID ' );
		$this -> db -> join( 'material_identification', 'sample_data.material_identy = material_identification.m_id' );
		$this -> db -> join( 'material', 'sample_data.mat_id = material.id' );
		$this -> db -> join( 'system_data', 'sample_data.system_id = system_data.id' );
		$this -> db -> join( 'layers', 'sample_data.layer_one_type = layers.layer_id' );
		$this -> db -> join( 'building', 'samples.building_id = building.id and samples.status=0' );
		$this -> db -> order_by( 'samples.s_id', 'asc' );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_layer_two_name( $l2 )
	{
		$this -> db -> select( '*' );
		$this -> db -> select( 'layer_id', $l2 );
		$query = $this -> db -> get( 'layers' );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}		
	}
	
	public function list_system( )
	{
		$this -> db -> select( '*' );
		$query = $this -> db -> get( 'system_data' );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function list_layers( )
	{
		$this -> db -> select( '*' );
		$query = $this -> db -> get( 'layers' );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function list_samples( $id )
	{
		$this -> db -> select( 'samples.*, building.building_name' );
		$this -> db -> from( 'samples', 'building' );
		$this -> db -> where( 'samples.building_id', $id );
		$this -> db -> join( 'building', 'samples.building_id = building.id and samples.status=0' );
		$this -> db -> order_by( "samples.s_id","asc" );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function list_samples_trash( $id )
	{
		$this -> db -> select( 'samples.*, building.building_name' );
		$this -> db -> from( 'samples', 'building' );
		$this -> db -> where( 'samples.building_id', $id );
		$this -> db -> join( 'building', 'samples.building_id = building.id and samples.status=1' );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function list_sample_data( )
	{
		$this -> db -> select( 'samples.*, sample_data.*, material_identification.*, material.*' );
		$this -> db -> from( 'samples', 'sample_data', 'material_identification', 'material' );		
		$this -> db -> join( 'sample_data', 'samples.s_id = sample_data.sampleID ' );
		$this -> db -> join( 'material_identification', 'sample_data.material_identy = material_identification.m_id' );
		$this -> db -> join( 'material', 'sample_data.system_id = material.id and samples.status=0' );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function list_sample_data_sid( $id )
	{
		$this -> db -> select( 'sample_data.id as smID, sample_data.sampleID, sample_data.sample_number, sample_data.locationID, sample_data.system_id, sample_data.mat_id, sample_data.material_identy, sample_data.layer_one_type, sample_data.layer_one_percent, sample_data.layer_two_type, sample_data.layer_two_percent, sample_data.results, sample_data.comments, material_identification.*, material.*, system_data.*' );
		$this -> db -> from( 'sample_data', 'material_identification', 'material', 'system_data' );		
		$this -> db -> where( 'sample_data.sampleID', $id  );
		$this -> db -> join( 'material_identification', 'sample_data.material_identy = material_identification.m_id' );
		$this -> db -> join( 'material', 'sample_data.mat_id = material.id' );
		$this -> db -> join( 'system_data', 'sample_data.system_id = system_data.id' );
		$this -> db -> order_by( "smID","asc" );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_sample_data_count( $id )
	{
		$this -> db -> select( 'count(sampleID) as cnt' );
		$this -> db -> from(  'sample_data' );		
		$this -> db -> where( 'sampleID', $id  );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function update_sample_data( $sample_number, $data )
	{
		$this-> db -> where( 'sample_number', $sample_number );
		$this-> db -> update( 'sample_data', $data );
	}
	
	public function selected_data( $id )
	{
		$this -> db -> select( 'samples.*, building.building_name' );
		$this -> db -> from( 'samples', 'building' );		
		$this -> db -> where( 'samples.s_id', $id );		
		$this -> db -> join( 'building', 'samples.building_id = building.id and samples.status=0' );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function check_sample_number( $sample_number )
	{
		$this -> db -> select( 'sample_number' );
		$this -> db -> from(  'sample_data' );		
		$this -> db -> where( 'sample_number', $sample_number  );
		$query = $this ->db -> get( );
		return $result = $query -> num_rows( );
	}
	
	public function update_sample_data_s( $sample_data, $sample_number )
	{
		$this-> db -> where( 'sample_number', $sample_number );
		$this-> db -> update( 'sample_data', $sample_data );
	}
	
	public function get_location_like( $keyword, $id )
	{
		$sql = "SELECT * FROM location WHERE ( location_name LIKE '%{$keyword}%' OR location_id LIKE '%{$keyword}%') AND building_id = '{$id}' AND trash =0 ";			
		$query = $this->db->query($sql);
		$result = $query -> result( );
		if($result){
			return $result;
		}
		
	}
	
	public function check_location_id( $location_id, $bid )
	{
		$this -> db -> select( 'l_id' );
		$this -> db -> where( 'location_id', $location_id );
		$this -> db -> where( 'building_id', $bid );
		$this -> db -> from( 'location' );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function get_material_like( $keyword, $id )
	{
		$this -> db -> select( '*' );
		$this -> db -> from(  'material' );		
		/* $this -> db -> where( 'm_building_id', $id  ); */
		$this -> db -> like( 'material_name', $keyword, 'after'  );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_mat_identy_info( $system_id, $id )
	{
		$this -> db -> select( '*' );
		$this -> db -> from(  'material_identification' );		
		$this -> db -> where( 'building_id', $id  );
		$this -> db -> where( 'material_id', $system_id );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_mat_identy_desc( $material_identy, $id )
	{
		$this -> db -> select( '*' );
		$this -> db -> from(  'material_identification' );		
		$this -> db -> where( 'building_id', $id  );
		$this -> db -> where( 'm_id', $material_identy  );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function get_mat_desc( $material_id, $id )
	{
		$this -> db -> select( '*' );
		$this -> db -> from(  'material' );		
		/* $this -> db -> where( 'm_building_id', $id  ); */
		$this -> db -> where( 'id', $material_id  );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function insert_sample_data_extra( $arr )
	{
		$this -> db -> insert( 'sample_data', $arr );
	}
	
	public function remove_sample_to_trash( $id )
	{
		$this -> db -> set( 'status', '1' );
		$this -> db -> where( 's_id', $id );
		$this -> db -> update( 'samples' );
	}
	
	public function get_building_id( $id )
	{
		$this -> db -> select( 'building_id' );
		$this -> db -> from(  'samples' );		
		$this -> db -> where( 's_id', $id  );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function restore_sample( $id )
	{
		$this -> db -> set( 'status', '0' );
		$this -> db -> where( 's_id', $id );
		$this -> db -> update( 'samples' );
	}
	
	public function remove_sample_permanent( $id )
	{
		$this -> db -> delete( 'sample_data', array( 'sampleID' => $id ) );
		$this -> db -> delete( 'samples', array( 's_id' => $id ) );
	}
	
	public function remove_sample_child( $id )
	{
		$this -> db -> delete( 'sample_data', array( 'id' => $id ) );
	}
	
	public function remove_sample( $sid )
	{
		$this -> db -> delete( 'samples', array( 's_id' => $sid ) );
	}
	
	public function get_first_record_from_sample_data( $sid )
	{
		$this -> db -> select( 'sample_data.*, material.*, material_identification.*' );
		$this -> db -> from( 'sample_data', 'material' );
		$this -> db -> where( 'sampleID', $sid  );
		$this -> db -> join( 'material', 'sample_data.mat_id = material.id' );
		$this -> db -> join( 'material_identification', 'sample_data.material_identy = material_identification.m_id' );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function update_sampledata_field( $smid, $field_name, $field_value )
	{
		$this -> db -> set( $field_name, $field_value );
		$this -> db -> where( 'id', $smid );
		$this -> db -> update( 'sample_data' );
	}
	
	public function update_sampledata_field_sample( $smid, $field_name, $field_value )
	{
		$this -> db -> set( $field_name, $field_value );
		$this -> db -> where( 'sampleID', $smid );
		$this -> db -> update( 'sample_data' );
	}
	
	public function get_building_name( $id )
	{
		$this -> db -> select( '*' );
		$this -> db -> from( 'building' );
		$this -> db -> where( 'id', $id  );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function get_layer_one_info( $layer_one_type )
	{
		$this -> db -> select( '*' );
		$this -> db -> from( 'layers' );
		$this -> db -> where( 'layer_type', $layer_one_type );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function get_layer_two_info( $layer_two_type )
	{
		$this -> db -> select( '*' );
		$this -> db -> from( 'layers' );
		$this -> db -> where( 'layer_type', $layer_two_type );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function get_identity_list_from_system( $sample_id, $bid )
	{
		$this -> db -> select( '*' );
		$this -> db -> from( 'material_identification' );
		$this -> db -> where( 'material_id', $sample_id );
		$this -> db -> where( 'building_id', $bid );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_identy_desc( $field_value )
	{
		$this -> db -> select( 'm_description' );
		$this -> db -> from( 'material_identification' );
		$this -> db -> where( 'm_id', $field_value );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function update_sampledata_field_sample_mat( $smid, $field_name, $field_value, $mat_id )
	{
		$this -> db -> set( $field_name, $mat_id );
		$this -> db -> where( 'id', $smid );
		$this -> db -> update( 'sample_data' );
	}
	
	public function update_sample_field_dbsample( $smid, $field_name, $field_value )
	{
		$this -> db -> set( $field_name, $field_value );
		$this -> db -> where( 's_id', $smid );
		$this -> db -> update( 'samples' );
	}
	
	public function get_layer_percents( $sid )
	{
		$this -> db -> select( '*' );
		$this -> db -> from( 'sample_data' );
		$this -> db -> where( 'sampleID', $sid );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function update_db_sample_rst( $sid, $rst )
	{
		$this -> db -> set( 's_result', $rst );
		$this -> db -> where( 's_id', $sid );
		$this -> db -> update( 'samples' );
	}
	
	public function data_get_inserted( $data )
	{
		$this -> db -> insert( 'hazard', $data );
	}
	
	public function get_all_hazard( )
	{
		$this -> db -> select( '*' );
		$this -> db -> from( 'hazard' );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function data_get_updated( $data, $id )
	{
		$this -> db -> where( 'id', $id );
		$this -> db -> update( 'hazard', $data );
	}
	
	public function update_sample_rst_field_dbsample( $smid, $field_name, $field_value )
	{
		$this -> db -> set( 's_result', $field_value );
		$this -> db -> where( 's_id', $smid );
		$this -> db -> update( 'samples' );
	}
	
	public function db_sample_rst( $id )
	{
		$this -> db -> select( 's_result' );
		$this -> db -> from( 'samples' );
		$this -> db -> where( 's_id', $id );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function check_layer_one_type( $sid )
	{
		$this -> db -> select( '*' );
		$this -> db -> from( 'sample_data' );
		$this -> db -> where( 'id', $sid  );
		$this -> db -> where( 'layer_one_type', '7' );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function check_layer_two_type( $sid )
	{
		$this -> db -> select( '*' );
		$this -> db -> from( 'sample_data' );
		$this -> db -> where( 'id', $sid  );
		$this -> db -> where( 'layer_two_type', '7' );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	
}