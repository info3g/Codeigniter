<?php
Class Building_model extends CI_Model
{
	
	public function get_all_clients( )
	{
		$this -> db -> select('*');
		$this -> db -> where('user_type', 'client');
		$this -> db -> where('trash', '0');
		$query = $this -> db -> get('users');
		$result = $query -> result();
		if( $result ){
			return $result;
		}
	}
	
	public function add_building( $add_building )
	{
		$this -> db -> insert( 'building',$add_building );
	}
	
	public function get_building_list( )
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'trash', '0' );
		$query = $this -> db -> get( 'building' );
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_location_building( $building_idss )
	{
		$sql = "SELECT * FROM `location` WHERE `building_id` IN ( {$building_idss} ) AND `l_address` != '' AND `trash` !=1";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_building_list_client( $num, $offset=0,$id )
	{
		$this -> db -> select('*');
		$this -> db -> where( 'client_building_id', $id );
		$this -> db -> where( 'trash', '0' );
		$this -> db -> limit( $num, $offset );
		$query = $this -> db -> get( 'building' );
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function get_building_list_client_new($id,$limit,$start)
	{
		$sql = "SELECT t1.id, t1.portfolio, t1.district, t1.development, t1.address, t1.postal_code, t1.city, t1.building_type, t2.id as uid FROM building as t1 LEFT JOIN users as t2 ON find_in_set(t1.id, t2.assigned_buildings) where t2.id ='{$id}' limit {$start},{$limit}";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	/*===============clients have buildings================*/
	
	public function get_all_building_for_client( $id )
	{
		$this -> db -> select( 'assigned_buildings' );
		$this -> db -> where( 'id', $id );
		$this -> db -> where( 'trash', '0' );
		$query = $this -> db -> get('users');
		$result = $query -> result();
		if($result){
			return $result[0];
		}
	}
	
	public function update_client_buildings( $id, $client_building_update )
	{
		$this -> db -> set( 'assigned_buildings', $client_building_update );
		$this -> db -> where( 'id', $id );
		$this -> db -> update( 'users' );
	}
	
	public function get_building_list_clients( $id )
	{
		$this -> db -> select('*');
		$this -> db -> where( 'client_building_id', $id );
		$this -> db -> where( 'trash', '0' );
		$query = $this -> db -> get( 'building' );
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function get_building_list_clientt( $cid )
	{
		$this -> db -> select('assigned_buildings');
		$this -> db -> where( 'id', $cid );
		$this -> db -> where( 'trash', '0' );
		$query = $this -> db -> get('users');
		$result = $query -> result();
		if($result){
			return $result[0];
		}
	}
	
	public function get_building_list_clientt_dis( $dist, $bids )
	{
		/* $this->db->distinct();
		$this -> db -> select('id,building_name');
		$this -> db -> where( 'district', $dist );
		$this -> db -> where( 'trash', '0' );
		$query = $this -> db -> get('building');
		$result = $query -> result();
		if($result){
			return $result;
		} */
		$sql = "SELECT DISTINCT * FROM building WHERE id IN ( {$bids} ) AND district={$dist} and trash =0 ";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_building_lists( $bids )
	{
		$sql = "SELECT DISTINCT * FROM building WHERE id IN ( {$bids} ) AND trash =0 ";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
		
	}
	
	public function get_building_list_trash()
	{
		$this -> db -> select('*');
		$this -> db -> where( 'trash', '1' );
		$query = $this -> db -> get('building');
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function remove_building( $id )
	{
		$this -> db -> delete( 'building', array( 'id' => $id ) ); 
	}
	
	public function get_building_data( $id )
	{
		$this -> db -> select('*');
		$this -> db -> where( array( 'id' => $id ) );
		$query = $this -> db -> get('building');
		$result = $query -> result();
		if($result){	
			return $result[0];
		}
	}
	
	public function update_building( $id, $data )
	{
		$this -> db -> where( 'id', $id );
		$this -> db -> update( 'building', $data );
	}
	
	public function get_total_location( $id )
	{
		$this -> db -> select('*');
		$this -> db -> where( array( 'trash' => 0 ) );
		$this -> db -> where( array( 'building_id' => $id ) );
		$query = $this -> db -> get('location');
		$result = $query -> num_rows();
		if($result >= 1){
			return $result;
		}else{
			return 0;
		}
	}
	
	public function document_upload( $data_doc )
	{
		$this -> db -> insert('document',$data_doc);		
	}
	
	public function get_total_documents( $id )
	{
		$this -> db -> select('*');
		$this -> db -> where( array( 'buildingID' => $id ) );
		$this -> db -> where( array( 'locationID' => 0 ) );
		$query = $this -> db -> get('document');
		$result = $query -> result();
		if($result){
			return $result;
		}	
	}
	
	public function get_document_path( $id )
	{
		$this -> db -> select('*');
		$this -> db -> where( array( 'd_id' => $id ) );
		$query = $this -> db -> get('document');
		$result = $query -> result();
		if($result){
			return $result[0];
		}
	}
	
	public function remove_document( $id )
	{
		$this -> db -> delete( 'document', array( 'd_id' => $id ) ); 
	}
	
	public function get_search_result( $building_idss,$search_keyword, $id )
	{
		/* $sql = "SELECT * FROM building WHERE ( portfolio LIKE '%{$search_keyword}%' OR district LIKE '%{$search_keyword}%' OR development LIKE '%{$search_keyword}%' OR address LIKE '%{$search_keyword}%' OR city LIKE '%{$search_keyword}%' OR building_type LIKE '%{$search_keyword}%' ) AND client_building_id = '{$id}' AND trash =0 "; */
		
		$sql = "SELECT DISTINCT * FROM building WHERE id IN ( {$building_idss} ) AND portfolio LIKE '{$search_keyword}' OR district LIKE '{$search_keyword}' OR development LIKE '{$search_keyword}' OR address LIKE '{$search_keyword}' OR city LIKE '{$search_keyword}' OR building_type LIKE '{$search_keyword}' AND trash =0 ";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_search_building_locations( $building_idss,$search_keyword )
	{
		$sql = "SELECT DISTINCT * FROM building WHERE id IN ( {$building_idss} ) AND portfolio LIKE '%{$search_keyword}%' OR district LIKE '%{$search_keyword}%' OR development LIKE '%{$search_keyword}%' OR address LIKE '%{$search_keyword}%' OR city LIKE '%{$search_keyword}%' OR building_type LIKE '%{$search_keyword}%' AND trash =0 ";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function remove_building_trash( $id )
	{
		$this -> db -> set( 'trash', '1' );
		$this -> db -> where( 'id', $id );
		$this -> db -> update( 'building' );
	}
	
	public function update_user_buildings( $id, $cid )
	{
		$sql = "UPDATE users SET assigned_buildings = replace(replace(assigned_buildings, ',{$id}', ''), ',,', '') where id={$cid}";
		$query = $this->db->query( $sql );
	}
	
	public function restore_building_users( $cid, $assigned_buildings )
	{
		$this -> db -> set( 'assigned_buildings', $assigned_buildings );
		$this -> db -> where( 'id', $cid );
		$this -> db -> update( 'users' );
	}
	
	public function restore_building( $id )
	{
		$this -> db -> set( 'trash', '0' );
		$this -> db -> where( 'id', $id );
		$this -> db -> update( 'building' );
	}
	
	public function get_all_province()
	{
		$this -> db -> select('*');
		$query = $this -> db -> get('Province');
		$result = $query -> result();
		if($result){
			return $result;
		}
	}
	
	public function get_total_buildings( $id )
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'client_building_id', $id );
		$this -> db -> where( 'trash', '0' );
		$query = $this -> db -> get( 'building' );
		$result = $query -> num_rows( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_client_id( $bid )
	{
		$this -> db -> select( 'client_building_id' );
		$this -> db -> where( 'id', $bid );
		$query = $this -> db -> get( 'building' );
		$result = $query -> result( );
		if($result){
			return $result[0];
		}	
	}
	
	public function get_all_locations( $bid )
	{
		$this -> db -> select( '*' );
		$this -> db -> where( 'building_id', $bid );
		$query = $this -> db -> get( 'location' );
		$result = $query -> result( );
		if($result){
			return $result;
		}	
	}
	
	public function get_all_develop( $building_id )
	{
		$this->db->distinct();
		$this -> db -> select( 'development' );
		$this -> db -> where( 'id', $building_id );
		$query = $this -> db -> get( 'building' );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_all_address( $building_id )
	{
		$this->db->distinct();
		$this -> db -> select( 'address' );
		$this -> db -> where( 'id', $building_id );
		$query = $this -> db -> get( 'building' );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_all_city( $building_id )
	{
		$this->db->distinct();
		$this -> db -> select( 'city' );
		$this -> db -> where( 'id', $building_id );
		$query = $this -> db -> get( 'building' );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_all_building_type( $building_id )
	{
		$this->db->distinct();
		$this -> db -> select( 'building_type' );
		$this -> db -> where( 'id', $building_id );
		$query = $this -> db -> get( 'building' );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_filter_result( $port,$building_idss,$id )
	{
			$sql = "SELECT DISTINCT * FROM building WHERE id IN ( {$building_idss} ) ";		
		
			if( isset( $port['portfolio'] ) == 'portfolio' )
			{
				$i=1;
				foreach( $port['portfolio'] as $ports )
				{
					if($i>1){
						$sql .=	"OR portfolio LIKE '%{$ports}%'";
					}else{
						$sql .=	"AND portfolio LIKE '%{$ports}%'";
					}
				$i++;
				}
			}
			if( isset( $port['district'] ) == 'district' )
			{	
				$i=1;
				foreach( $port['district'] as $ports )
				{
					if($i>1){
						$sql .=	"OR district LIKE '%{$ports}%'";
					}else{
						$sql .=	" AND district LIKE '%{$ports}%'";
					}
				$i++;
				}	
			}
			if( isset( $port['development'] ) == 'development' )
			{	
				$i=1;
				foreach( $port['development'] as $ports )
				{
					if($i>1){
						$sql .=	"OR development LIKE '%{$ports}%'";
					}else{
						$sql .=	" AND development LIKE '%{$ports}%'";
					}
				$i++;
				}	
			}
			if( isset( $port['address'] ) == 'address' )
			{	
				$i=1;
				foreach( $port['address'] as $ports )
				{
					if($i>1){
						$sql .=	"OR address LIKE '%{$ports}%'";
					}else{
						$sql .=	" AND address LIKE '%{$ports}%'";
					}
				$i++;
				}	
			}
			if( isset( $port['city'] ) == 'city' )
			{	
				$i=1;
				foreach( $port['city'] as $ports )
				{
					if($i>1){
						$sql .=	"OR city LIKE '%{$ports}%'";
					}else{
						$sql .=	" AND city LIKE '%{$ports}%'";
					}
				$i++;
				}	
			}
			if( isset( $port['building_type'] ) == 'building_type' )
			{
				$i=1;
				foreach( $port['building_type'] as $ports )
				{
					if($i>1){
						$sql .=	"OR building_type LIKE '%{$ports}%'";
					}else{
						$sql .=	" AND building_type LIKE '%{$ports}%'";
					}
				$i++;
				}	
			}
			
				
		$sql .=	"AND trash =0 ";
		$query = $this->db->query($sql);
		$result = $query -> result( );
		if($result){
			return $result;
		}
		
	}
	
	public function get_assigned_b( $cid )
	{
		$this->db->distinct();
		$this -> db -> select( 'building_type' );
		$this -> db -> where( 'id', $cid );
		$query = $this -> db -> get( 'building' );
		$result = $query -> result( );
		if($result){
			return $result[0];
		}
	}
	
	public function get_building_as_location( $port,$building_idss )
	{
		
		$sql = "SELECT * FROM building WHERE id IN ( {$building_idss} )";
			if( isset( $port['portfolio'] ) == 'portfolio' )
			{
				$i=1;
				foreach( $port['portfolio'] as $ports )
				{
					if($i>1){
						$sql .=	"OR portfolio LIKE '%{$ports}%'";
					}else{
						$sql .=	"AND portfolio LIKE '%{$ports}%'";
					}
				$i++;
				}	
			}
			if( isset( $port['district'] ) == 'district' )
			{	
				$i=1;
				foreach( $port['district'] as $ports )
				{
					if($i>1){
						$sql .=	"OR district LIKE '%{$ports}%'";
					}else{
						$sql .=	" AND district LIKE '%{$ports}%'";
					}
				$i++;
				}	
			}
			if( isset( $port['development'] ) == 'development' )
			{	
				$i=1;
				foreach( $port['development'] as $ports )
				{
					if($i>1){
						$sql .=	"OR development LIKE '%{$ports}%'";
					}else{
						$sql .=	" AND development LIKE '%{$ports}%'";
					}
				$i++;
				}	
			}
			if( isset( $port['address'] ) == 'address' )
			{	
				$i=1;
				foreach( $port['address'] as $ports )
				{
					if($i>1){
						$sql .=	"OR address LIKE '%{$ports}%'";
					}else{
						$sql .=	" AND address LIKE '%{$ports}%'";
					}
				$i++;
				}	
			}
			if( isset( $port['city'] ) == 'city' )
			{	
				$i=1;
				foreach( $port['city'] as $ports )
				{
					if($i>1){
						$sql .=	"OR city LIKE '%{$ports}%'";
					}else{
						$sql .=	" AND city LIKE '%{$ports}%'";
					}
				$i++;
				}	
			}
			if( isset( $port['building_type'] ) == 'building_type' )
			{
				$i=1;
				foreach( $port['building_type'] as $ports )
				{
					if($i>1){
						$sql .=	"OR building_type LIKE '%{$ports}%'";
					}else{
						$sql .=	" AND building_type LIKE '%{$ports}%'";
					}
				$i++;
				}
			}
			
				
		$sql .=	"AND location_as_building = 1 ";
		$sql .=	"AND trash =0 ";
		$query = $this->db->query($sql);
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	/*====================  Building Report ==============================*/
	
	public function get_system_and_midentification( $building_id )
	{
		$sql = "SELECT DISTINCT m_id,system FROM `material_identification` WHERE `building_id` = {$building_id}";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_system_and_midentification_sys( $building_id, $system )
	{
		$sql = "SELECT DISTINCT m_id FROM `material_identification` WHERE `building_id` =  {$building_id} and `system` IN ({$system} ) ";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	
	public function get_final_b_report_rst( $material_identification_comma, $system_comma, $building_id )
	{
		/* $sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( r.`location_ID` SEPARATOR ', ' ) AS location_ids, sum( r.`total` ) AS grand FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`material_identi` IN ({$material_identification_comma}) AND r. r_hazard IN ( 'Confirmed Asbestos', 'Presumed Asbestos') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`"; */
		$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( r.`location_ID` SEPARATOR ', ' ) AS location_ids, sum( r.`total` ) AS grand FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a WHERE r.`building_ID` ={$building_id} AND r. r_hazard IN ( 'Confirmed Asbestos', 'Presumed Asbestos') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.`system_ID`, r.`access`";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_location_ids( $lids )
	{
		$sql = "SELECT `location_id` FROM `location` WHERE `l_id` IN ( {$lids} ) AND `trash` =0";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function filter_buildings( $district_id, $building_ids )
	{
		$sql = "SELECT id FROM `building` WHERE `id` IN ( {$building_ids} ) AND `district` = '{$district_id}'";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_final_dist_report_rst( $material_identification_comma, $system_comma, $building_id )
	{
		/* $sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc, mi.m_identification, mi.m_description, a.action_number, sum( r.`total` ) AS grand, b.district, b.development FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m` , `material_identification` AS mi, actions AS a, building AS b WHERE r.`building_ID` ={$building_id}  AND r. r_hazard IN ( 'Confirmed Asbestos', 'Presumed Asbestos') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id AND b.id ={$building_id} GROUP BY  r.`system_ID`, r.`material_ID`, r.`material_identi`, r.`friability`, r.`r_hazard`, r.`action`"; */
		$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( r.`location_ID` SEPARATOR ', ' ) AS location_ids, sum( r.`total` ) AS grand FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a WHERE r.`building_ID` ={$building_id} AND r. r_hazard IN ( 'Confirmed Asbestos', 'Presumed Asbestos') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.`system_ID`, r.`access`, r.`action`";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_development_name_b( $build )
	{
		$sql = "SELECT development FROM `building` where `id` = {$build}";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result[0];
		}
	}
	
	public function get_totals_dis( $location_ids )
	{
		$sql = "SELECT sum( `total` ) as grand FROM `room_by_room`  WHERE `location_ID` IN ( {$location_ids} )";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result[0];
		}
	}
	
	public function get_final_material_report_rst( $building_id )
	{
		/* $sql = "SELECT mid. m_identification , mat. * FROM `material_identification` AS mid, `material` AS mat WHERE  mat.m_building_id ={$building_id} AND mat.`status` =0 and mat.id=mid.m_id";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		} */
		$this->db->select('material_identification.*, material.material_name ' );
		$this->db->from('material_identification', 'material');
		$this->db->where('material_identification.building_id', $building_id );
		$this->db->join('material', 'material_identification.material_id = material.id and material_identification.status=0');
		$query = $this->db->get();
		$result = $query -> result( );
		if( $result ){
			return $result;
		}
	}
	
	public function get_final_dev_report_rst( $material_identification_comma, $system_comma, $building_id )
	{
		/* $sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( r.`location_ID` SEPARATOR ', ' ) AS location_ids, sum( r.`total` ) AS grand FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`material_identi` IN ({$material_identification_comma}) AND r. r_hazard IN ( 'Confirmed Asbestos', 'Presumed Asbestos') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_ID`, r.`material_identi`, r.friability, r.r_hazard, r.action"; */
		$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( r.`location_ID` SEPARATOR ', ' ) AS location_ids, sum( r.`total` ) AS grand FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a WHERE r.`building_ID` IN ('{$building_id}') AND r. r_hazard IN ( 'Confirmed Asbestos', 'Presumed Asbestos') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.`system_ID`, r.`access`";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}    
	
	public function get_final_mat_cond_report_rst( $material_identification_comma, $system_comma, $building_id )
	{
		$sql = "SELECT r.* , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( r.`location_ID` SEPARATOR ', ' ) AS location_ids, sum( r.`total` ) AS grand FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` = '{$building_id}' AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id AND r.`good`!='' GROUP BY r.`material_identi`";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	
	public function get_final_custom_report_rst( $system_comma, $building_id, $material, $material_identi, $friability, $access, $hazard, $action )
	{
		
		if( $action != ""  )
		{
			$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` = {$building_id} AND r.`system_ID` IN ({$system_comma}) AND r.`material_ID` IN ({$material}) AND r.`material_identi` IN ({$material_identi}) AND r.`friability` IN ('{$friability}') AND r.`access` IN ('{$access}') AND r.`r_hazard` IN ('{$hazard}') AND r.`action` IN ('{$action}') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.access, r.friability, r.`action`";
		}else
		if( $access != "" && $hazard != "" )
		{
			$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` = {$building_id} AND r.`system_ID` IN ({$system_comma}) AND r.`material_ID` IN ({$material}) AND r.`material_identi` IN ({$material_identi}) AND r.`friability` IN ('{$friability}') AND r.`access` IN ('{$access}') AND r.`r_hazard` IN ('{$hazard}') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.access, r.friability, r.`action`";
		}else
		if( $access != "" )
		{
			$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand  FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`material_ID` IN ({$material}) AND r.`material_identi` IN ({$material_identi}) AND r.`friability` IN ('{$friability}') AND r.`access` IN ('{$access}') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY  r.`material_identi`, r.access, r.friability, r.`action`";
		}else
		if( $friability != "" )
		{
			if( $hazard != "" )
			{
				$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand  FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`material_ID` IN ({$material}) AND r.`material_identi` IN ({$material_identi}) AND r.`friability` IN ('{$friability}') AND r.`r_hazard` IN ('{$hazard}') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.access, r.friability, r.`action`";
			}else{
				$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand  FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`material_ID` IN ({$material}) AND r.`material_identi` IN ({$material_identi}) AND r.`friability` IN ('{$friability}') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.access, r.friability, r.`action`";
			}
		}else
		if( $material_identi != "" )
		{
			if( $hazard != "" )
			{
				$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand  FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`material_ID` IN ({$material}) AND r.`material_identi` IN ({$material_identi}) AND r.`r_hazard` IN ('{$hazard}') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY  r.`material_identi`, r.access, r.friability, r.`action`";
			}else{	
				$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand  FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`material_ID` IN ({$material}) AND r.`material_identi` IN ({$material_identi}) AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.access, r.friability, r.`action`";
			}	
		}else
		if( $material != "" )
		{
			if( $hazard != "" )
			{
				$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand  FROM ` ` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`material_ID` IN ({$material}) AND r.`r_hazard` IN ('{$hazard}') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.access, r.friability, r.`action`";
			}else{
				$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand  FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`material_ID` IN ({$material}) AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY  r.`material_identi`, r.access, r.friability, r.`action`";
			}
		}else
		if( $system_comma != "" )
		{
			if( $hazard != "" )
			{
				$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT(  r.`total` SEPARATOR ', ' ) AS grand  FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`r_hazard` IN ('{$hazard}') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.access, r.friability, r.`action`";
			}else{
				$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand  FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.access, r.friability, r.`action`";
			}	
		}else{
			$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc, mi.m_identification, mi.m_description, a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand , b.district, b.development FROM `room_by_room` AS r, system_data AS `s` , material AS `m` , material_identification AS mi, actions AS a, building AS b WHERE r.building_ID ={$building_id}  AND r. r_hazard IN ( 'Confirmed Asbestos', 'Presumed Asbestos') AND r.system_ID = s.id AND r.material_ID = m.id AND r.material_identi = mi.m_id AND r.action = a.a_id AND b.id ={$building_id} GROUP BY r.`material_identi`, r.access, r.friability, r.`action`";
		}
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	
	
	
	public function get_building_dist( $did, $bids )
	{
		$sql = "SELECT id,building_name FROM `building` WHERE `id` IN ( {$bids} ) AND `district` = {$did} ";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_system_and_midentification_dist( $dist )
	{
		$sql = "SELECT DISTINCT m_id,system FROM `material_identification` WHERE `building_id` IN ({$dist})";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_system( $building )
	{
		$sql = "SELECT * FROM `room_by_room` as r, system_data as s where r.`building_ID` = {$building} and r.system_ID = s.id group by r.system_ID";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_system_data( )
	{
		$sql = "SELECT * from system_data where status=0";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_materials( $bid, $sid )
	{
		$sql = "SELECT * FROM `room_by_room` as r,`material` as m WHERE r.`building_ID` = {$bid} AND r.`system_ID` = {$sid} and r.material_ID=m.id  group by r.`material_ID`";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_material_identi( $bid,$id )
	{
		$sql = "SELECT * from material_identification where material_id={$id} and building_id={$bid}";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_friability( $bid, $sid, $mid, $material_identi )
	{
		$sql = "SELECT * FROM `room_by_room` as r,`material` as m WHERE r.`building_ID` = {$bid} AND r.`system_ID` = {$sid} AND r.`material_ID` = {$mid} AND r.`material_identi` = {$material_identi} and r.material_ID = m.id  group by r.`friability`";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_units()
	{
		$sql = "SELECT * from units";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_access( $bid, $sid, $mid, $material_identi, $friability )
	{
		$sql = "SELECT * FROM `room_by_room` as r,`material` as m WHERE r.`building_ID` = {$bid} AND r.`system_ID` = {$sid} AND r.`material_ID` = {$mid} AND r.`material_identi` = {$material_identi} AND r.`friability` = '{$friability}' and r.material_ID = m.id  group by r.`friability`, r.`access`";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_hazard( $bid, $sid, $mid, $material_identi, $friability, $access )
	{
		$sql = "SELECT * FROM `room_by_room` as r,`material` as m WHERE r.`building_ID` = {$bid} AND r.`system_ID` = {$sid} AND r.`material_ID` = {$mid} AND r.`material_identi` = {$material_identi} AND r.`friability` = '{$friability}' and r.`access` = '{$access}' and r.material_ID = m.id  group by r.`friability`";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_action( $bid, $sid, $mid, $material_identi, $friability, $access, $hazard )
	{
		$sql = "SELECT * FROM `room_by_room` as r,`material` as m, `actions` as a WHERE r.`building_ID` = {$bid} AND r.`system_ID` = {$sid} AND r.`material_ID` = {$mid} AND r.`material_identi` = {$material_identi} AND r.`friability` = '{$friability}' and r.`access` = '{$access}' and r.`r_hazard` = '{$hazard}' and r.material_ID = m.id   AND r.action = a.a_id group by r.`friability`";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_grand_total( $lc_id, $systemID, $bid )
	{
		$sql = "SELECT sum(total) as grand FROM `room_by_room` WHERE `building_ID` ={$bid} AND `location_ID` IN ( {$lc_id} ) AND `system_ID` ={$systemID}";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result[0];
		}
	}
	
	public function get_lc( $rst_location_ids, $systemID, $bid )
	{
		$sql = "SELECT l_id FROM `location` WHERE `building_id` ={$bid} AND `location_id`IN ( {$rst_location_ids} )";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}		
	}
	
	public function get_priorty_lists( $bids )
	{
		/* $sql = "SELECT Distinct( action ) FROM `room_by_room` as r, `actions` as a WHERE r.`building_ID` IN ({$bids}) and a.a_id=r.action"; */
		$sql = "SELECT * from `actions` as a WHERE `a_id` != '1'";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	
	public function get_final_action_report_rst( $material_identification_comma, $system_comma, $building_id, $action )
	{
		
		/* $sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc, mi.m_identification, mi.m_description, a.action_number, sum( r.`total` ) AS grand, b.district, b.development FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m` , `material_identification` AS mi, actions AS a, building AS b WHERE r.`building_ID` ={$building_id} AND r.`action` IN({$action}) AND r. r_hazard IN ( 'Confirmed Asbestos', 'Presumed Asbestos') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id AND b.id ={$building_id} GROUP BY r.`material_identi`, r.`system_ID`, r.`action`"; */
		$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc, mi.m_identification, mi.m_description, a.action_number, GROUP_CONCAT( r.`location_ID` SEPARATOR ', ' ) AS location_ids, sum( r.`total` ) AS grand FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m` , `material_identification` AS mi, actions AS a WHERE r.`building_ID` ={$building_id} AND r.`action` IN({$action}) AND r. r_hazard IN ( 'Confirmed Asbestos', 'Presumed Asbestos') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id  GROUP BY r.`material_identi`, r.`system_ID`, r.`action`";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
		
	}
	
	
		/*------------------------For Custom Multiple Report -----------------------------------------*/
	
	public function get_building_dist_m( $diddd, $bids )
	{
		$sql = "SELECT id,building_name FROM `building` WHERE `id` IN ( {$bids} ) AND `district` IN ( {$diddd} ) ";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_materials_m( $bds, $system )
	{
		$sql = "SELECT * FROM `room_by_room` as r,`material` as m WHERE r.`building_ID` IN ( {$bds} ) AND r.`system_ID` IN ( {$system} ) and r.material_ID=m.id  group by r.`material_ID`";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_material_identi_m( $bds,$mat )
	{
		$sql = "SELECT DISTINCT(m_id),m_identification from material_identification where material_id IN ( {$mat} ) and building_id IN ( {$bds} )";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_friability_m( $bid, $sid, $mid, $material_identi )
	{
		$sql = "SELECT * FROM `room_by_room` as r,`material` as m WHERE r.`building_ID` IN ({$bid}) AND r.`system_ID` IN ({$sid}) AND r.`material_ID` IN ({$mid}) AND r.`material_identi` IN ({$material_identi}) and r.material_ID = m.id  group by r.`friability`";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_access_m( $bid, $sid, $mid, $material_identi, $friability )
	{
		$sql = "SELECT * FROM `room_by_room` as r,`material` as m WHERE r.`building_ID` IN ({$bid}) AND r.`system_ID` IN ({$sid}) AND r.`material_ID` IN ({$mid}) AND r.`material_identi` IN ({$material_identi}) AND r.`friability` IN ('{$friability}') and r.material_ID = m.id  group by r.`friability`";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_hazard_m( $bid, $sid, $mid, $material_identi, $friability, $access )
	{
		$sql = "SELECT * FROM `room_by_room` as r,`material` as m WHERE r.`building_ID` IN ({$bid}) AND r.`system_ID` IN ({$sid}) AND r.`material_ID` IN ({$mid}) AND r.`material_identi` IN ({$material_identi}) AND r.`friability` IN ('{$friability}') and r.`access` IN ('{$access}') and r.material_ID = m.id  group by r.`friability`";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	
	public function get_action_m( $bid, $sid, $mid, $material_identi, $friability, $access, $hzd )
	{
		$sql = "SELECT * FROM `room_by_room` as r,`material` as m, `actions` as a WHERE r.`building_ID` IN ({$bid}) AND r.`system_ID` IN ({$sid}) AND r.`material_ID` IN ({$mid}) AND r.`material_identi` IN ({$material_identi}) AND r.`friability` IN ('{$friability}') and r.`access` IN ('{$access}') and r.`r_hazard` IN ('{$hzd}') and r.material_ID = m.id and r.action = a.a_id  group by r.`friability`";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	public function get_final_custom_m_report_rst( $system_comma, $building_id, $material, $material_identi, $friability, $access, $hazard, $action )
	{
		
		if( $action != ""  )
		{
			$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` = {$building_id} AND r.`system_ID` IN ({$system_comma}) AND r.`material_ID` IN ({$material}) AND r.`material_identi` IN ({$material_identi}) AND r.`friability` IN ('{$friability}') AND r.`access` IN ('{$access}') AND r.`r_hazard` IN ({$hazard}) AND r.`action` IN ('{$action}') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.access, r.friability, r.`action`";
		}else
		if( $access != "" && $hazard != "" )
		{
			$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` = {$building_id} AND r.`system_ID` IN ({$system_comma}) AND r.`material_ID` IN ({$material}) AND r.`material_identi` IN ({$material_identi}) AND r.`friability` IN ('{$friability}') AND r.`access` IN ('{$access}') AND r.`r_hazard` IN ({$hazard}) AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.access, r.friability, r.`action`";
		}else
		if( $access != "" )
		{
			$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand  FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`material_ID` IN ({$material}) AND r.`material_identi` IN ({$material_identi}) AND r.`friability` IN ('{$friability}') AND r.`access` IN ('{$access}') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.access, r.friability, r.`action`";
		}else
		if( $friability != "" )
		{
			if( $hazard != "" )
			{
				$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand  FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`material_ID` IN ({$material}) AND r.`material_identi` IN ({$material_identi}) AND r.`friability` IN ('{$friability}') AND r.`r_hazard` IN ({$hazard}) AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.access, r.friability, r.`action`";
			}else{
				$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand  FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`material_ID` IN ({$material}) AND r.`material_identi` IN ({$material_identi}) AND r.`friability` IN ('{$friability}') AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.access, r.friability, r.`action`";
			}
		}else
		if( $material_identi != "" )
		{
			if( $hazard != "" )
			{
				$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand  FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`material_ID` IN ({$material}) AND r.`material_identi` IN ({$material_identi}) AND r.`r_hazard` IN ({$hazard}) AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.access, r.friability, r.`action`";
			}else{	
				$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand  FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`material_ID` IN ({$material}) AND r.`material_identi` IN ({$material_identi}) AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.access, r.friability, r.`action`";
			}	
		}else
		if( $material != "" )
		{
			if( $hazard != "" )
			{
				$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand  FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`material_ID` IN ({$material}) AND r.`r_hazard` IN ({$hazard}) AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.access, r.friability, r.`action`";
			}else{
				$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand  FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`material_ID` IN ({$material}) AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_identi`, r.access, r.friability, r.`action`";
			}
		}else
		if( $system_comma != "" )
		{
			if( $hazard != "" )
			{
				$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT(  r.`total` SEPARATOR ', ' ) AS grand  FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`r_hazard` IN ({$hazard}) AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_ID`, r.access, r.action,r.material_identi";
			}else{
				$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc,mi.m_identification,mi.m_description,a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand  FROM `room_by_room` AS r, `system_data` AS `s` , `material` AS `m`, `material_identification` as mi, actions as a, building as b WHERE r.`building_ID` ={$building_id} AND r.`system_ID` IN ( {$system_comma} ) AND r.`system_ID` = s.id AND r.`material_ID` = m.id AND r.`material_identi` = mi.m_id AND r.`action` = a.a_id GROUP BY r.`material_ID`, r.access, r.friability, r.`action`";
			}	
		}else{
			if( $hazard != "" )
			{
				$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc, mi.m_identification, mi.m_description, a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand , b.district, b.development FROM `room_by_room` AS r, system_data AS `s` , material AS `m` , material_identification AS mi, actions AS a, building AS b WHERE r.building_ID ={$building_id}  AND r.`r_hazard` IN ({$hazard})  AND r.system_ID = s.id AND r.material_ID = m.id AND r.material_identi = mi.m_id AND r.action = a.a_id AND b.id ={$building_id} GROUP BY r.material_identi, r.system_ID, r.access, r.friability, r.`action`";	
			}else{
				$sql = "SELECT r. * , s.system_name, m.material_name, m.material_desc, mi.m_identification, mi.m_description, a.action_number, GROUP_CONCAT( DISTINCT r.`location_ID` SEPARATOR ', ' ) AS location_ids, GROUP_CONCAT( DISTINCT r.`total` SEPARATOR ', ' ) AS grand , b.district, b.development FROM `room_by_room` AS r, system_data AS `s` , material AS `m` , material_identification AS mi, actions AS a, building AS b WHERE r.building_ID ={$building_id}  AND r. r_hazard IN ( 'Confirmed Asbestos', 'Presumed Asbestos') AND r.system_ID = s.id AND r.material_ID = m.id AND r.material_identi = mi.m_id AND r.action = a.a_id AND b.id ={$building_id} GROUP BY r.material_identi, r.system_ID, r.access, r.friability, r.`action`";
			}
			
		}
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	/*================== Location No Surveyed Report ===========================*/
	
	public function get_location_no_surveyed_report( $bid )
	{
		$sql = "SELECT location_id as na, no_access as type FROM location WHERE `building_id` ={$bid} AND `no_access` !=  '0' AND `trash`=0 UNION ALL SELECT location_id as ns, no_survey as type FROM location WHERE `building_id` ={$bid} AND  `no_survey`!= '0' AND `trash` =0";
		$query = $this->db->query( $sql );
		$result = $query -> result( );
		if($result){
			return $result;
		}
	}
	
	
	
}