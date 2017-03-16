<?php
Class Dashboard_model extends CI_Model
{
	
	public function get_total_building()
	{
		$this -> db -> select('*');
		$query = $this -> db -> get('building');
		$result = $query -> num_rows();
		if($result){
			return $result;
		}
	}
	
	public function get_total_locations()
	{
		$this -> db -> select('*');
		$query = $this -> db -> get('location');
		$result = $query -> num_rows();
		if($result){
			return $result;
		}
	}
	
	public function get_total_clients()
	{
		$this -> db -> select('*');
		$this -> db -> where('user_type', 'client');
		$this -> db -> where('trash', '0');
		$query = $this -> db -> get('users');
		$result = $query -> num_rows();
		if($result){
			return $result;
		}
	}

	public function list_materials( $num, $offset=0, $id )
	{
		$this -> db -> select('*');
		/* $this -> db -> where( 'm_building_id', $id ); */
		$this -> db -> where( 'status', '0' );
		$this -> db -> order_by( "material_name","asc" );
		$this -> db -> limit($num, $offset);
		$query = $this -> db -> get('material');
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function filter_materials( $keyword )
	{
		$this->db->like( 'material_name',$keyword );
        $query  =   $this->db->get( 'material' );
        $result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function list_materials_in_identification( )
	{
		$this -> db -> select('*');
		$this -> db -> where( 'status', '0' );
		$query = $this -> db -> get('material');
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function add_material( $material_data )
	{
		$this -> db -> insert( 'material',$material_data );
	}
	
	public function remove_material( $id )
	{
		$this -> db -> delete( 'material', array( 'id' => $id ) );
	}
	
	
	public function get_total_materials( $id )
	{
		$this -> db -> select( '*' );
		/* $this -> db -> where( 'm_building_id', $id ); */
		$this -> db -> where( 'status', '0' );
		$query = $this -> db -> get( 'material' );
		$result = $query -> num_rows( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_total_materials_dash()
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'status', '0' );
		$query = $this -> db -> get( 'material' );
		$result = $query -> num_rows( );
		if( $result ){
			return $result;
		}
	}
	
	public function list_materials_trashed( $num, $offset=0, $id )
	{
		$this -> db -> select('*');
		$this -> db -> where( 'm_building_id', $id );
		$this -> db -> where( 'status', '1' );
		$this -> db -> order_by( "id","desc" );
		$this -> db -> limit($num, $offset);
		$query = $this -> db -> get('material');
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function get_total_materials_trashed( $id )
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'm_building_id', $id );
		$this -> db -> where( 'status', '1' );
		$query = $this -> db -> get( 'material' );
		$result = $query -> num_rows( );
		if( $result ){
			return $result;
		}
	}
	
	public function material_code_check( $material_code )
	{
		$this->db->select('*');			
		$this->db->where('material_code',$material_code);
		$query = $this->db->get('material');
		$result = $query->result();
		if($result){
			return true;
		}else{
			return false;
		}		
	}
	
	public function remove_material_trashed( $id )
	{
		$this -> db -> set( 'status', '1' );
		$this -> db -> where( 'id', $id );
		$this -> db -> update( 'material' );
	}
	
	public function restore_material( $id )
	{
		$this -> db -> set( 'status', '0' );
		$this -> db -> where( 'id', $id );
		$this -> db -> update( 'material' );
	}
	
	public function update_material( $material_data, $id )
	{
		$this -> db -> where( 'id', $id );
		$this -> db -> update( 'material', $material_data );
	}
	
	public function get_material_value( $id )
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'id', $id );
		$query = $this -> db -> get( 'material' );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function list_building()
	{
		$this -> db -> select( '*' );
		$query = $this -> db -> get( 'building' );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function list_system()
	{
		$this -> db -> select( '*' );
		$query = $this -> db -> get( 'system_data' );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	/*====================== Material Identification ==========================*/
	
	
	public function insert_material_identification( $inserted_data )
	{
		$this -> db -> insert( 'material_identification', $inserted_data );
	}
	
	public function list_mat_identy( $id )
	{
		$this->db->select('material_identification.*, building.building_name, material.material_name, system_data.*' );
		$this->db->from('material_identification', 'building', 'material', 'system_data');
		$this->db->where('material_identification.building_id', $id );
		$this->db->join('building', 'material_identification.building_id = building.id');
		$this->db->join('system_data', 'material_identification.system = system_data.id');
		$this->db->join('material', 'material_identification.material_id = material.id and material_identification.status=0');
		$query = $this->db->get();
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_mat_identy_info( $id )
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'm_id', $id );
		$query = $this -> db -> get( 'material_identification' );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function update_material_identification( $updated_data, $id )
	{
		$this -> db -> where( 'm_id', $id );
		$this -> db -> update( 'material_identification', $updated_data );
	}
	
	public function trashed_mat_identy( $id )
	{
		$this -> db -> set( 'status', '1' );
		$this -> db -> where( 'm_id', $id );
		$this -> db -> update( 'material_identification' );
	}
	
	public function list_mat_identy_trash( $id )
	{
		$this->db->select('material_identification.*, building.building_name, material.material_name, system_data.*' );
		$this->db->from('material_identification', 'building', 'material', 'system_data');
		$this->db->where('material_identification.building_id', $id );
		$this->db->join('building', 'material_identification.building_id = building.id');
		$this->db->join('system_data', 'material_identification.system = system_data.id');
		$this->db->join('material', 'material_identification.material_id = material.id and material_identification.status=1');		
		$query = $this->db->get();
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function mat_identy( $id )
	{
		$this -> db -> delete( 'material_identification', array( 'm_id' => $id ) );
	}
	
	public function restore_mat_identy( $id )
	{
		$this -> db -> set( 'status', '0' );
		$this -> db -> where( 'm_id', $id );
		$this -> db -> update( 'material_identification' );
	}
	

	/*==========================User Area===============================*/
	
	public function get_total_building_c( $user_id )
	{
		$this -> db -> select('*');
		$this -> db -> where( 'client_building_id', $user_id );
		$this -> db -> where( 'trash', 0 );
		$query = $this -> db -> get('building');
		$result = $query -> num_rows();
		if($result){
			return $result;
		}
	}
	
	public function get_client_info( $user_id )
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'id', $user_id );
		$query = $this -> db -> get( 'users' );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
	public function get_buildings_info( $building_idss )
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'id', $building_idss );
		$query = $this -> db -> get( 'building' );
		$result = $query -> result( );
		if( $result ){
			return $result[0];
		}
	}
	
}
