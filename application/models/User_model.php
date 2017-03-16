<?php
Class User_model extends CI_Model
{

	function login($username, $password)
	{
		$this -> db -> select('id, username, password, user_type');
		$this -> db -> from('users');
		$this -> db -> where('username', $username);
		$this -> db -> where('password', MD5($password));
		/* $this -> db -> where('user_type', 'admin'); */
		$this -> db -> limit(1);
	 
		$query = $this -> db -> get();
	 
		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	
	public function email_check($email)
	{
		$this -> db -> select('*');			
		$this -> db -> where('email',$email);
		$query = $this -> db -> get('users');
		$result = $query -> result();
		if($result != ''){
			return true;
		}else{
			return false;
		}			
	}
	
	public function username_check($username)
	{
		$this -> db -> select('*');			
		$this -> db -> where('username',$username);
		$query = $this -> db -> get('users');
		$result = $query -> result();
		if($result != ''){
			return true;
		}else{
			return false;
		}			
	}
	
	public function add_client( $user )
	{
		$this -> db -> insert('users',$user);
	}
	
	public function list_clients( $num, $offset=0 )
	{
		$this -> db -> select('*');
		$this -> db -> where('user_type','client');
		$this -> db -> where('trash','0');
		$this -> db -> limit($num, $offset);
		$query = $this -> db -> get('users');
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function get_total_cnt_building($id)
	{
		$this -> db -> select( 'building.id as cnt' );
		$this -> db -> where( 'client_building_id', $id );
		$this -> db -> where( 'trash', 0 );
		$query = $this -> db -> get( 'building' );
		return $result = $query -> num_rows( );
	}
	
	public function get_client_info( $id )
	{
		$this -> db -> select('*');
		$this -> db -> where('id',$id);
		$query = $this -> db -> get('users');
		$result = $query -> result();
		if($result){
			return $result[0];
		}
	}
	
	public function update_client( $user_update, $id )
	{
		$this -> db -> where( 'id', $id );
		$this -> db -> update( 'users', $user_update );
	}
	
	public function remove_client_trash( $id )
	{
		$this -> db -> set( 'trash', '1' );
		$this -> db -> where( 'id', $id );
		$this -> db -> update( 'users' );
	}
	
	public function restore_client( $id )
	{
		$this -> db -> set( 'trash', '0' );
		$this -> db -> where( 'id', $id );
		$this -> db -> update( 'users' );
	}
	
	public function list_clients_trashed( )
	{
		$this -> db -> select('*');
		$this -> db -> where('user_type','client');
		$this -> db -> where('trash','1');
		$query = $this -> db -> get('users');
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function remove_client( $id )
	{
		$this -> db -> delete( 'users', array( 'id' => $id ) );
	}
	
	public function get_total_clients( )
	{
		$this -> db -> select( '*' );
		$this -> db -> where('user_type','client');
		$this -> db -> where( 'trash', '0' );
		$query = $this -> db -> get( 'users' );
		$result = $query -> num_rows( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_search_result( $search_keyword )
	{
		$sql = "SELECT * FROM users WHERE ( client_name LIKE '%{$search_keyword}%' OR c_project_number LIKE '%{$search_keyword}%') AND trash =0 ";
		$query = $this->db->query($sql);
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	
}