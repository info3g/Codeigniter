<?php
Class Location_model extends CI_Model
{

	public function get_building_data( $id )
	{
		$this -> db -> select('*');
		$this -> db -> where( array('id' => $id) );
		$query = $this -> db -> get('building');
		$result = $query -> result();
		if($result){
			return $result[0];
		}
	}
		
	public function add_location( $location_data )
	{
		$this -> db -> insert( 'location',$location_data );
	}
	
	public function list_location( $id )
	{
		$this -> db -> select('*');
		$this -> db -> where('trash',0);
		$this -> db -> where('building_id', $id );
		$query = $this -> db -> get('location');
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function get_filter_result( $id, $condition, $field_name)
	{
		$this -> db -> select('*');
		$this -> db -> where('trash',0);
		$this -> db -> where('building_id', $id );
		$this -> db -> order_by( $field_name, $condition );
		$query = $this -> db -> get('location');
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function list_location_p( $num, $offset=0,$id )
	{
		$this -> db -> select('*');
		$this -> db -> where('trash',0);
		$this -> db -> where('building_id', $id );
		$this -> db -> limit($num, $offset);
		$query = $this -> db -> get('location');
		$result = $query -> result();
		if($result){
			return $result;
		} 
	}
	
	public function list_location_psa( $id )
	{
		$this -> db -> select('*');
		$this -> db -> where('trash',0);
		$this -> db -> where('building_id', $id );
		/* $this -> db -> limit($num, $offset); */
		$query = $this -> db -> get('location');
		$result = $query -> result();
		if($result){
			return $result;
		} 
	}
	
	public function remove_location( $id )
	{
		$this -> db -> delete( 'location', array( 'l_id' => $id ) ); 
	}
	
	public function get_location_data( $id )
	{
		$this -> db -> select('*');
		$this -> db -> where( array('l_id' => $id) );
		$query = $this -> db -> get('location');
		$result = $query -> result();
		if($result){
			return $result[0];
		}
	}
	
	public function get_all_location_data( $building_id )
	{
		$this -> db -> select('*');
		$this -> db -> where('building_id', $building_id );
		$this -> db -> where('trash', 0 );
		$query = $this -> db -> get('location');
		$result = $query -> result();
		if($result){
			return $result;
		}		
	}
	
	public function update_location( $update_location_data, $id )
	{
		$this -> db -> where( 'l_id', $id );
		$this -> db -> update( 'location', $update_location_data );
	}
	
	public function get_building_list( $id )
	{
		$this -> db -> select( 'location.*, building.*' );
		$this -> db -> from( 'location', 'building' );
		$this -> db -> where( 'l_id', $id  );
		$this -> db -> join( 'building', 'location.building_id = building.id' );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function get_material_list( )
	{
		$this -> db -> select('*');
		$query = $this -> db -> get('material');
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function remove_location_trash( $id )
	{
		$this -> db -> set( 'trash', '1' );
		$this -> db -> where( 'l_id', $id );
		$this -> db -> update( 'location' );
	}
	
	public function list_location_trash( $num, $offset=0,$id ) 
	{
		$this -> db -> select('*');
		$this -> db -> where('trash',1);
		$this -> db -> where('building_id', $id );
		$this -> db -> limit($num, $offset);
		$query = $this -> db -> get('location');
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function restore_location( $id )
	{
		$this -> db -> set( 'trash', '0' );
		$this -> db -> where( 'l_id', $id );
		$this -> db -> update( 'location' );
	}
	
	/*==============Edit location Observation===============*/
	
	public function get_system_data( )
	{
		$this -> db -> select('*');
		$query = $this -> db -> get( 'system_data' );
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function units_added( $data )
	{
		$this -> db -> insert( 'units', $data );
	}
	
	public function get_list_unit()
	{
		$this -> db -> select('*');
		$query = $this -> db -> get( 'units' );
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function get_unit_values( $id )
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'u_id', $id );
		$query = $this -> db -> get( 'units' );
		$result = $query -> result();
		if($result){
			return $result[0];
		}
	}
	
	public function units_updated( $data, $id )
	{
		$this -> db -> where( 'u_id', $id );
		$this -> db -> update( 'units', $data );
	}
	
	public function units_remove( $id )
	{
		$this -> db -> delete( 'units', array( 'u_id' => $id ) );
	}
	
	/*=========================Actions=================================*/
	
	public function action_added( $data )
	{
		$this -> db -> insert( 'actions', $data );
	}
	public function action_addeds( $data )
	{
		$this -> db -> insert( 'actions', $data );
	}
	
	public function get_list_action( $id )
	{
		$this -> db -> select('*');
		$this -> db -> where('a_id !=', '1');
		$this -> db -> where("(u_id='0' OR u_id=$id )", NULL, FALSE);
		$query = $this -> db -> get( 'actions' );
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function get_list_actions( )
	{
		$this -> db -> select('*');
		$this -> db -> where('a_id !=', '1');
		$this -> db -> where('u_id', '0');
		$query = $this -> db -> get( 'actions' );
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function get_action_values( $id )
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'a_id', $id );
		$query = $this -> db -> get( 'actions' );
		$result = $query -> result();
		if($result){
			return $result[0];
		}
	}
	
	public function actions_updated( $data, $id )
	{
		$this -> db -> where( 'a_id', $id );
		$this -> db -> update( 'actions', $data );
	}
	
	public function actions_remove( $id )
	{
		$this -> db -> delete( 'actions', array( 'a_id' => $id ) );
	}
	
	/*==========================================*/
	
	public function get_material_identy_list( $id )
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'system', $id );
		$query = $this -> db -> get( 'material_identification' );
		$result = $query -> result();
		if($result){
			return $result;
		}
	}

	public function action_list( $client_id_enter )
	{
		$this -> db -> select( '*' );
		$this -> db -> where('a_id !=', '1');
		$this -> db -> where("(u_id='0' OR u_id=$client_id_enter )", NULL, FALSE);
		$query = $this -> db -> get( 'actions' );
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function sample_list( $bid )
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'building_id', $bid );
		$this -> db -> where( 'status', 0 );
		$this -> db -> order_by( 'added_date', 'asc' );
		$query = $this -> db -> get( 'samples' );
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function access_list( )
	{
		$this -> db -> select( '*' );
		$query = $this -> db -> get( 'accessibility' );
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function get_s_rst( $dbsample_id )
	{
		$this -> db -> select( 's_id,s_result' );
		$this -> db -> where( 's_id', $dbsample_id );
		$query = $this -> db -> get( 'samples' );
		$result = $query -> result();
		if($result){
			return $result[0];
		}
	}
	
	public function get_layer_name( $layer_type )
	{
		$this -> db -> select( 'layer_type' );
		$this -> db -> where( 'layer_id', $layer_type );
		$query = $this -> db -> get( 'layers' );
		$result = $query -> result();
		if($result){
			return $result[0];
		}
	}
		
	public function get_max_rst( $id )
	{
		$this -> db -> select( 'layer_one_type, layer_one_percent, layer_two_type, layer_two_percent' );
		$this -> db -> where( 'sampleID', $id );
		$query = $this -> db -> get( 'sample_data' );
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	/*=======This function is for search locations=======*/
	
	public function get_search_result( $search_keyword, $id )
	{
		$sql = "SELECT * FROM location WHERE ( floor LIKE '%{$search_keyword}%' OR location_id LIKE '%{$search_keyword}%' OR location_name LIKE '%{$search_keyword}%' OR square_feet LIKE '%{$search_keyword}%') AND building_id = '{$id}' AND trash =0 ";
		$query = $this->db->query($sql);
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	
	public function units_list( )
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'status', 0 );
		$query = $this -> db -> get( 'units' );
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	/*==================== Add Room By Room Data Samples ========================*/
	
	public function add_room_by_room_data_samples( $room_by_room_data )
	{
		$this -> db -> insert( 'room_by_room', $room_by_room_data );
	}
	
	public function list_room_by_room_data( $id )
	{
		$this -> db -> select( 'room_by_room.*, system_data.system_name,material.*,material_identification.*,samples.db_sample,actions.*' );
		$this -> db -> from( 'room_by_room', 'system_data', 'material', 'material_identification', 'samples', 'actions' );
		$this -> db -> where( 'room_by_room.location_ID', $id );
		$this -> db -> join( 'system_data', 'room_by_room.system_ID = system_data.id');
		$this -> db -> join( 'material', 'room_by_room.material_ID = material.id');
		$this -> db -> join( 'material_identification', 'room_by_room.material_identi = material_identification.m_id');
		$this -> db -> join( 'samples', 'room_by_room.s_number = samples.s_id');
		//$this -> db -> join( 'accessibility', 'room_by_room.access = accessibility.access');
		$this -> db -> join( 'actions', 'room_by_room.action = actions.a_id and room_by_room.parent="0"');
		$this -> db -> order_by( "room_by_room.r_id","asc" );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function list_room_by_room_data_child( $id )
	{
		$this -> db -> select( 'room_by_room.*, system_data.system_name,material.*,material_identification.*,samples.db_sample,actions.*' );
		$this -> db -> from( 'room_by_room', 'system_data', 'material', 'material_identification', 'samples', 'actions' );
		$this -> db -> where( 'room_by_room.parent', $id );
		$this -> db -> join( 'system_data', 'room_by_room.system_ID = system_data.id');
		$this -> db -> join( 'material', 'room_by_room.material_ID = material.id');
		$this -> db -> join( 'material_identification', 'room_by_room.material_identi = material_identification.m_id');
		$this -> db -> join( 'samples', 'room_by_room.s_number = samples.s_id');
		//$this -> db -> join( 'accessibility', 'room_by_room.access = accessibility.access');
		$this -> db -> join( 'actions', 'room_by_room.action = actions.a_id and room_by_room.parent != "0"');
		$this -> db -> order_by( "room_by_room.r_id","asc" );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_units_code( $units )
	{
		$this -> db -> select( 'unit_code' );
		$this -> db -> where( 'u_id', $units );
		$query = $this -> db -> get( 'units' );
		$result = $query -> result();
		if($result){
			return $result[0];
		}
	}
	
	public function update_system_id( $roomID, $field_name, $field_value )
	{
		$this -> db -> set( $field_name, $field_value );
		$this -> db -> where( 'r_id', $roomID );
		$this -> db -> update( 'room_by_room' );
	}
	
	public function update_material_id( $roomID, $field_name, $mat_id )
	{
		$this -> db -> set( $field_name, $mat_id );
		$this -> db -> where( 'r_id', $roomID );
		$this -> db -> update( 'room_by_room' );
	}
	
	public function get_identity_list_from_mat( $material_id, $bid )
	{
		$this -> db -> select( '*' );
		$this -> db -> from( 'material_identification' );
		$this -> db -> where( 'building_id', $bid );
		$this -> db -> where( 'material_id', $material_id );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_fair_poor_values( $roomID )
	{
		$this -> db -> select( 'good,fair,poor' );
		$this -> db -> from( 'room_by_room' );
		$this -> db -> where( 'r_id', $roomID );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function update_total( $total, $roomID, $field_value,$field_name )
	{
		$this -> db -> set( $field_name, $field_value );
		$this -> db -> set( 'total', $total );
		$this -> db -> where( 'r_id', $roomID );
		$this -> db -> update( 'room_by_room' );
	}
	
	public function update_sample_and_rst( $roomID, $field_name, $field_value, $rst, $hzd )
	{
		$this -> db -> set( $field_name, $field_value );
		$this -> db -> set( 'r_hazard', $hzd );
		$this -> db -> set( 'rst', $rst );
		$this -> db -> where( 'r_id', $roomID );
		$this -> db -> update( 'room_by_room' );
	}
	
	public function locationid_check( $location_id, $bid )
	{
		$this -> db -> select('*');			
		$this -> db -> where('location_id',$location_id);
		$this -> db -> where('building_id',$bid);
		$query = $this -> db -> get( 'location' );
		$result = $query -> result();
		if( !empty( $result ) ){
			return false;
		}else{
			return true;
		}
	}
	
	public function locationid_check_edit( $location_id, $id, $bid )
	{
		$this -> db -> select('*');			
		$this -> db -> where('location_id',$location_id);
		$this -> db -> where( 'l_id',$id );
		$this -> db -> where( 'building_id',$bid );
		$query = $this -> db -> get( 'location' );
		$result = $query -> result();
		if( !empty( $result ) ){
			return true;
		}else{
			return false;
		}
	}
	public function get_total_locations( $id )
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'building_id', $id );
		$this -> db -> where( 'trash', '0' );
		$query = $this -> db -> get( 'location' );
		$result = $query -> num_rows( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_total_locations_t( $id )
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'building_id', $id );
		$this -> db -> where( 'trash', '1' );
		$query = $this -> db -> get( 'location' );
		$result = $query -> num_rows( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_client_id( $id )
	{
		$this -> db -> select( 'client_building_id' );
		$this -> db -> where( 'id', $id );
		$this -> db -> where( 'trash', '0' );
		$query = $this -> db -> get( 'building' );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function get_all_locations_bid( $bid, $id )
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'building_id', $bid );
		$this -> db -> where( 'l_id !=', $id );
		$this -> db -> where( 'trash', '0' );
		$query = $this -> db -> get( 'location' );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_location_notes( $location_id )
	{
		$this -> db -> select( 'note' );
		$this -> db -> where( 'l_id', $location_id );
		$this -> db -> where( 'trash', '0' );
		$query = $this -> db -> get( 'location' );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function get_room_by_room_data( $location_id )
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'location_ID', $location_id );
		$this -> db -> where( 'parent', 0 );
		$query = $this -> db -> get( 'room_by_room' );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_child_room_data( $r_id,$l_id )
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'location_ID', $l_id );
		$this -> db -> where( 'parent', $r_id );
		$query = $this -> db -> get( 'room_by_room' );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function update_room_by_room_data( $room_by_room_data_copy )
	{
		$this -> db -> insert( 'room_by_room',$room_by_room_data_copy );
	}
	
	public function insert_child_room_data( $room_by_room_data_copy_child )
	{
		$this -> db -> insert( 'room_by_room',$room_by_room_data_copy_child );
	}
	
	public function remove_room_by_room_data( $id )
	{
		$this -> db -> delete( 'room_by_room', array( 'r_id' => $id ) );
	}
	
	public function get_all_data_count( $location_id )
	{
		$this -> db -> select( 'room_by_room.*, system_data.system_name,material.*,material_identification.*,samples.db_sample,actions.*' );
		$this -> db -> from( 'room_by_room', 'system_data', 'material', 'material_identification', 'samples', 'actions' );
		$this -> db -> where( 'room_by_room.location_ID', $location_id );
		$this -> db -> join( 'system_data', 'room_by_room.system_ID = system_data.id');
		$this -> db -> join( 'material', 'room_by_room.material_ID = material.id');
		$this -> db -> join( 'material_identification', 'room_by_room.material_identi = material_identification.m_id');
		$this -> db -> join( 'samples', 'room_by_room.s_number = samples.s_id');
		$this -> db -> join( 'actions', 'room_by_room.action = actions.a_id');
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_room_by_room( $location_id )
	{
		$this -> db -> select( 'room_by_room.*, system_data.system_name,material.*,material_identification.*,samples.db_sample,actions.*' );
		$this -> db -> from( 'room_by_room', 'system_data', 'material', 'material_identification', 'samples', 'actions' );
		$this -> db -> where( 'room_by_room.location_ID', $location_id );
		$this -> db -> join( 'system_data', 'room_by_room.system_ID = system_data.id');
		$this -> db -> join( 'material', 'room_by_room.material_ID = material.id');
		$this -> db -> join( 'material_identification', 'room_by_room.material_identi = material_identification.m_id');
		$this -> db -> join( 'samples', 'room_by_room.s_number = samples.s_id');
		$this -> db -> join( 'actions', 'room_by_room.action = actions.a_id and room_by_room.parent="0"');
		$this -> db -> order_by( "room_by_room.r_id","asc" );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}	
	}
	
	/*============For Reports All location room by room===============*/
	
	public function list_room_by_room_data_report( $location_id )
	{
		$this -> db -> select( 'room_by_room.*, system_data.system_name,material.*,material_identification.*,samples.db_sample,actions.*' );
		$this -> db -> from( 'room_by_room', 'system_data', 'material', 'material_identification', 'samples', 'actions' );
		$this -> db -> where( 'room_by_room.location_ID', $location_id );
		$this -> db -> join( 'system_data', 'room_by_room.system_ID = system_data.id');
		$this -> db -> join( 'material', 'room_by_room.material_ID = material.id');
		$this -> db -> join( 'material_identification', 'room_by_room.material_identi = material_identification.m_id');
		$this -> db -> join( 'samples', 'room_by_room.s_number = samples.s_id');
		$this -> db -> join( 'actions', 'room_by_room.action = actions.a_id and room_by_room.parent="0"');
		$this -> db -> order_by( "room_by_room.r_id","asc" );
		$query = $this ->db -> get( );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_notes( $location_id )
	{
		$this -> db -> select( 'note' );
		$this -> db -> where( 'l_id', $location_id );
		$query = $this -> db -> get( 'location' );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	
	
	
	
}	
	