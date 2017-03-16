<script>
	function show_address_field()
	{
		jQuery('#l_address').toggle();
	}
	
	function no_access_click(){
		if (jQuery("#no_access").is(':checked')) {
			jQuery("#note").val("Location was not accessable.");
		}else{
			jQuery("#note").val("");
		}
	}
	function no_survey_click(){	
		if (jQuery("#no_survey").is(':checked')) {
			jQuery("#note").val("Location was not surveyed.");
		}else{
			jQuery("#note").val("");
		}		
	}
</script>
<div class="main-inner">
		<div class="container">
			<div class="row">     
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>location/index/<?php echo $building_data->id; ?>">Back</a>
					</div>
					<div class="widget">
						<div class="widget-header"> <i class="icon-cog"></i>
						  <h3>Location</h3>
						</div>
            
						<div class="widget-content">
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<?php 
							echo form_open( 'location/add_location/'.$building_data->id ); ?>
							
							<div class="span4">
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Building Name : <b><?php echo $building_data->building_name; ?><b></label>
								</div>
								
								<div class="control-group">														
									<!--label class="control-label" for="siteTitle">Client Building # : <b><?php //echo $building_data->client_building_id; ?><b></label-->
								</div>
							</div>

							<div class="span4">
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Surveyor : <b><?php echo $building_data->surveyor; ?><b></label>
								</div>
							</div>	
							
							<div class="span12">
							
								<div class="span12">	
									<div class="span4">
										<div class="control-group">														
											<label class="control-label" for="siteTitle">Consultant Name : </label>
											<div class="controls">
												<input type="text" name="consultant_name" value="<?php echo "ECOH";?>" id="consultant_name" class="span4" >
											</div>
										</div>
									</div>
									<div class="span4">
										<div class="control-group">														
											<label class="control-label" for="siteTitle">Last Survey Date : </label>
											<div class="controls">
												<input type="text" name="survey_date" value="<?php echo $building_data->survey_date; ?>" id="datepicker" class="span4" >
											</div>
										</div>
									</div>
									<div class="span4">
										<div class="control-group">														
											<label class="control-label" for="siteTitle">Last Reassessment Date : </label>
											<div class="controls">
												<input type="text" name="reassessment_date" value="<?php echo $building_data->survey_date; ?>" id="datepicker" class="span4" >
											</div>
										</div>
									</div>
									
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Floor : </label>
									<div class="controls">
										<input type="text" name="floor" value="<?php echo set_value('floor'); ?>" id="floor" class="span5" >
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Square Feet : </label>
									<div class="controls">
										<input type="text" name="square_feet" value="<?php echo set_value('square_feet'); ?>" id="square_feet" class="span5" >
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Room Prefix : </label>
									<div class="controls">
										<input type="text" name="room_prefix" value="<?php echo set_value('room_prefix'); ?>" id="room_prefix" class="span5" >
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Room # : </label>
									<div class="controls">
										<input type="text" name="room_no" value="<?php echo set_value('room_no'); ?>" id="room_no" class="span5" >
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Location Name : </label>
									<div class="controls">
										<input type="text" name="location_name" value="<?php echo set_value('location_name'); ?>" id="location_name" class="span5" >
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Location # : </label>
									<div class="controls">
										<input type="text" name="location_id" value="<?php echo set_value('location_id'); ?>" id="location_id" class="span5" >
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Note : </label>
									<div class="controls">
										<textarea name="note" id="note" class="span5" ><?php echo "Location was not surveyed."; ?></textarea>
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Validated? : </label>
									<div class="controls">
										<input type="checkbox" name="validated" value="y" checked /> YES
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">No Access to room? : </label>
									<div class="controls">
										<input type="checkbox" onclick="no_access_click();" id="no_access" name="no_access" value="no_access" checked /> NAR
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Location Not Surveyed? : </label>
									<div class="controls">
										<input type="checkbox" onclick="no_survey_click();" id="no_survey" name="no_survey" value="no_survey" checked /> NS
									</div>
								</div>
								
								<div class="control-group">
									<div class="controls">
										<input type="checkbox" onclick="show_address_field();" name="show_map" value="1"> Show On Map As Building
									</div>
								</div>
								<div class="control-group" id="l_address" style="display:none;">														
									<label class="control-label" for="siteTitle">Address : </label>
									<div class="controls">
										<input type="text" name="l_address" value="<?php echo set_value('l_address '); ?>" id="room_no" class="span5" >
									</div>
								</div>
								
							<hr>
						
								<input type="hidden" name="bid" value="<?php echo $building_data->id; ?>" >
								<input type="reset" value="Reset" class="btn btn-primary" >
								<input name="submit" value="Save" id="submit" class="btn btn-primary" type="submit">
							</div>
							
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