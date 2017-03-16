<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="main-inner">
    <div class="container">
		
			<div class="row">
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
				
				<div class="inner-detail">
					<div class="right-sec">
						<h2>Total Number of building showing on Map</h2>
					</div>
                </div>
				
				 <div class="inner-dis">
                	<ul>
                    	<li><?php echo $grand_total_buildings;?></li>
                    </ul>
                </div>
                
                <div class="map">
                	<?php echo $map['js']; ?>
					<?php echo $map['html']; ?>
                </div>
            </div>
        </div>
        </div>
		
		
	</div>
</div>