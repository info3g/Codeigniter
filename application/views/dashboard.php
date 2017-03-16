<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="main-inner">
    <div class="container">
		<div class="row">
		
		<?php 	
			$session_data = $this->session->userdata('logged_in');
			$user_type = $session_data['user_type'];
			if($user_type == 'admin'){
		?>
			<div class="span6">
			
				<div class="widget">
					<div class="widget-header"> <i class="icon-dashboard"></i>
						<h3>Welcome to Ecoh</h3>
					</div>
					<!-- /widget-header -->
					<div class="widget-content">
						<div class="text">
							<p>This is your Ecoh dashboard, Using the navigation above you can add or edit the users, pages or navigation menus on your website. Ecoh is built around the bootstrap framework, this should make your website fully responsive with ease.</p>
						</div>
						<!-- /widget-content --> 
					</div>
				</div>
				  <!-- /widget -->
			 
			</div>
        <!-- /span6 -->
		
        <div class="span6">
			<div class="widget widget-nopad">
				<div class="widget-header"> <i class="icon-file"></i>
				  <h3>Latest</h3>
				</div>
				<!-- /widget-header -->
				
				<div class="widget-content">
					<ul class="news-items">
						<li>
							<div class="news-item-date">
								<span class="news-item-day"><?php echo $total_building;?></span>
							</div>
							<div class="news-item-detail"> 
								<?php if($total_building > 1){echo "Buildings";}else{echo "Building";}?>
							</div>
						</li>
						
						<li>
							<div class="news-item-date">
								<span class="news-item-day"><?php echo $total_locations;?></span>
							</div>
							<div class="news-item-detail"> 
								<?php if($total_locations > 1){echo "Locations";}else{echo "Location";}?>
							</div>
						</li>
						
						<li>
							<div class="news-item-date">
								<span class="news-item-day"><?php echo $total_clients;?></span>
							</div>
							<div class="news-item-detail"> 
								<?php if($total_clients > 1){echo "Clients";}else{echo "Client";}?>
							</div>
						</li>
						
						<li>
							<div class="news-item-date">
								<span class="news-item-day"><?php echo $total_materials;?></span>
							</div>
							<div class="news-item-detail"> 
								<?php if($total_materials > 1){echo "Materials";}else{echo "Material";}?>
							</div>
						</li>
						
					</ul>
				</div>
            <!-- /widget-content --> 
			</div>
          <!-- /widget -->


        </div>
		<?php }else{ ?>
			
        	<div class="col-md-3 col-sm-3">
            	<div class="left-sec">
                	<div class="see-option">
                    	<ul>
                        	<li><a href="<?php echo base_url();?>building/index/<?php echo $client_info->id; ?>">Back</a></li>
                            <li><a href="<?php echo base_url();?>building/index/<?php echo $client_info->id; ?>"><i class="fa fa-list"></i>List</a></li>
                        </ul>
                    </div>
                    
                    <div class="search">
						<?php echo form_open('building/map_search/'.$client_info->id); ?>
                    	<input type="text" name="search" value="" placeholder="Search" class="span2 search" >
                        <div class="find">
							<input type="submit" name="submit" class="btn btn-primary" value="search" >
                        </div>
						<?php echo form_close(); ?>
                    </div>
                    <?php echo form_open('building/filter_result_map/'.$client_info->id);?>
                    <div class="portfolio">
                    	<h2>Portfoliio</h2>
                        <ul>
                            <li><input type="checkbox" name="portfolio[]" value="PH">PH</li>
                            <li><input type="checkbox" name="portfolio[]" value="NPS">NPS</li>
                            <li><input type="checkbox" name="portfolio[]" value="NPF">NPF</li>
                        </ul>
                    </div>
                    
                    <div class="portfolio">
                    	<h2>District</h2>
                        <ul>
							<?php for($i=1;$i<=6;$i++){?>
								<li><input type="checkbox" name="district[]" value="<?php echo $i;?>"><?php echo $i; ?></li>
							<?php } ?>
                        </ul>
                    </div>
                    
                    <div class="portfolio">
                    	<h2>Development</h2>
						<?php print_r($develop);?>
                        <ul>
							<?php 
							$de = array_unique($develop, SORT_REGULAR);
							foreach($de as $dev){
								$develops = $dev[0];
								if($develops->development != ""){?>
                            <li><input type="checkbox" name="development[]" value="<?php echo $develops->development;?>"><?php echo $develops->development;?></li>
							<?php }
							} ?>
                        </ul>
                    </div>
                    
                    <div class="portfolio">
                    	<h2>Address</h2>
                        <ul>
                        	<?php 
							$addr = array_unique($address, SORT_REGULAR);
							foreach($addr as $add){
								$addresss = $add[0];
								if($addresss->address != ""){
							?>
                            <li><input type="checkbox" name="address[]" value="<?php echo $addresss->address;?>"><?php echo $addresss->address;?></li>
							<?php }
							} ?>
                        </ul>
                    </div>
                    
                    <div class="portfolio">
                    	<h2>City/Town</h2>
                        <ul>
                        	<?php 
							$cit = array_unique($city, SORT_REGULAR);
							foreach($cit as $cityss){
								$citys = $cityss[0];
								if($citys->city != ""){
							?>
                            <li><input type="checkbox" name="city[]" value="<?php echo $citys->city;?>"><?php echo $citys->city;?></li>
							<?php }
							} ?>
                        </ul>
                    </div>
                    
                    <div class="portfolio">
                    	<h2>Building Type</h2>
                        <ul>
							<?php 
							$btype = array_unique($building_type, SORT_REGULAR);
							foreach($btype as $building_typess){
								$building_types = $building_typess[0];
								if($building_types->building_type != ""){
							?>
                        	<li><input type="checkbox" name="building_type[]" value="<?php echo $building_types->building_type;?>"><?php echo $building_types->building_type;?></li>
							<?php }
							} ?>
                        </ul>
                    </div>
					<input type="submit" name="submit" value="Filter" class="btn btn-small btn-primary" />
                    <?php echo form_close();?>                                                
                </div>
            </div>
            
            <div class="col-md-9 col-sm-9">
            	<div class="right-sec">
                	<h2>Client Information</h2>
                </div>
            
            <div class="client-details">
            	<div class="inner-detail">
                	<ul>
                    	<li>Client logo</li>
                        <li>Client Name</li>
                        <li>Client Address</li>
                        <li>Total Buildings</li>
                    </ul>
                </div>
                
                <div class="inner-dis">
                	<ul>
                    	<li>Client logo</li>
                        <li><?php echo $client_info->client_name;?></li>
                        <li><?php echo $client_info->client_address;?></li>
                        <li><?php echo $total_buildings;?></li>
                    </ul>
                </div>
                
                <div class="map">
                	<?php echo $map['js']; ?>
					<?php echo $map['html']; ?>
                </div>
            </div>
        </div>
        	
		<?php } ?>	
        <!-- /span6 --> 
      <!-- /row --> 
    </div>
    </div>
    <!-- /container --> 
  </div>