 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script>
jQuery(document).ready(function(){
	jQuery(".map").click(function(){
		var address = jQuery('#address').val();
		var geocoder =  new google.maps.Geocoder();
		geocoder.geocode( { 'address': address}, function(results, status) {
		
			if (status == google.maps.GeocoderStatus.OK) {
				jQuery('#latitude').val(results[0].geometry.location.lat());
				jQuery('#longitude').val(results[0].geometry.location.lng());
				
				jQuery('#lat').text('Latitude: '+results[0].geometry.location.lat());
				jQuery('#long').text('Longitude: '+results[0].geometry.location.lng());
				
					var lat = parseFloat(results[0].geometry.location.lat());
					var lng = parseFloat(results[0].geometry.location.lng());
					
					var latlng = new google.maps.LatLng(lat, lng);
					var geocoder = geocoder = new google.maps.Geocoder();
					geocoder.geocode({ 'latLng': latlng }, function (results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							if (results[1]) {
								jQuery('#city').val(results[1].address_components[3].long_name);
								jQuery('#postal_code').val(results[1].address_components[6].long_name);
							}
						}
					});
					
			}
		});
	});
	
});
</script>


	<div class="main-inner">
		<div class="container">
			<div class="row">     
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>building/index/<?php echo $client_id;?>">Back</a>
					</div>
					<div class="widget">
						<div class="widget-header"> <i class="icon-cog"></i>
						  <h3>Building</h3>
						</div>
            
						<div class="widget-content">
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<?php 
							$attributes = array('id' => 'add_building');
							echo form_open('building/add_building/'.$client_id,$attributes); ?>
							
								<div class="control-group">	
									<!--label class="control-label" for="siteFooter">Client</label>
									<div class="controls">
										<select name="building_id" id="building_id" class="span5">
											<?php foreach( $all_clients as $all_client ){?>
												<option value="<?php echo $all_client->id;?>"><?php echo $all_client->client_name;?></option>
											<?php } ?>
										</select>
									</div-->
									<input type="hidden" name="building_id" value="<?php echo $all_clients;?>">
								</div>
							
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Building Name*</label>
									<div class="controls">
										<input type="text" name="building_name" value="" id="building_name" class="span5" >
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Building Description</label>
									<div class="controls">
										<textarea name="building_desc" id="building_desc" class="span5"></textarea>
									</div>								
								</div>
                
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Address</label>
									<div class="controls">
										<input type="text" name="address" value="" id="address" class="span5" ><span><a href="javascript:void(0);" class="map">Get map info</a></span>
									</div>
									<span id="lat"></span>   <span id="long"></span>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">City</label>
									<div class="controls">
										<input type="text" name="city" value="" id="city" class="span5" >
									</div>
								</div>
            
								<div class="control-group">
									<label class="control-label" for="themes">Province/Region</label>
									<div class="controls">
										<select name="region" id="region" class="span5">
											<?php foreach($all_province as $all_provinces){?>
												<option value="<?php echo $all_provinces->code;?>"><?php echo $all_provinces->code;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Postal Code</label>
									<div class="controls">
										<input type="text" name="postal_code" value="" id="postal_code" class="span5" >
									</div>
								</div>
								
								<div class="control-group">	
									<!--label class="control-label" for="siteFooter">Latitude</label-->
									<div class="controls">
										<input type="hidden" name="latitude" value="" id="latitude" class="span5" >
									</div>
								</div>
								
								<div class="control-group">	
									<!--label class="control-label" for="siteFooter">Longitude</label-->
									<div class="controls">
										<input type="hidden" name="longitude" value="" id="longitude" class="span5" >
									</div>
								</div>
								
								<!--------------New Fields---------------------->
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Portfolio</label>
									<div class="controls">
										<input type="text"  name="portfolio" value="" id="portfolio" class="span5" >
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">District</label>
									<div class="controls">
										<input type="text"  name="district" value="" id="district" class="span5" >
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Development</label>
									<div class="controls">
										<input type="text"  name="development" value="" id="development" class="span5" >
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Building Type</label>
									<div class="controls">
										<input type="text"  name="building_type" value="" id="building_type" class="span5" >
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Orignal Year of Construction</label>
									<div class="controls">
										<input type="text"  name="construction_year" value="" id="construction_year" class="span5" >
									</div>								
								</div>
								<!--------------End New Fields---------------------->
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Sq Feet</label>
									<div class="controls">
										<input type="text" name="square_feet" value="" id="square_feet" class="span5" >
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Surveyor</label>
									<div class="controls">
										<input type="text" name="surveyor" value="" id="surveyor" class="span5" >
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="siteFooter">Survey Date</label>
									<div class="controls">
										<input type="text" name="survey_date" value="" id="datepicker" class="span5" >
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="themes">Validated</label>
									<div class="controls">
										<input type="radio" name="validated" checked value="y">Yes
										<input type="radio" name="validated" value="n">No
									</div>
								</div>
								
								<div class="control-group">
									<div class="controls">
										<input type="checkbox" name="location_as_building" value="1"> Manage Location as building
									</div>
								</div>
								
							<hr>
            
								<div class="control-group">			
									<label class="control-label" for="file_upload">Project Number</label>
									<div class="controls">
										<input type="text" name="project_number" value="" class="span5" >
									</div> <!-- /controls -->				
								</div> <!-- /control-group -->
                
							<hr>
						
							<input type="reset" value="Reset" class="btn btn-primary" >
							<input name="submit" value="Save" id="submit" class="btn btn-primary" type="submit">
							
							
							<?php echo form_close(); ?>
						
						</div> 
					</div>
					<!-- /widget -->
 
         
				</div>
			</div>
			<!-- /row --> 
		</div>
		<!-- /container --> 
  </div>