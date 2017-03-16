 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


	<div class="main-inner">
		<div class="container">
			<div class="row">     
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>building/index/<?php echo $client_id->client_building_id;?>">Back</a>
					</div>
					<div class="widget">
						<div class="widget-header"> <i class="icon-cog"></i>
						  <h3>Building</h3>
						</div>
            
						<div class="widget-content">
						
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<?php 
							echo form_open( 'building/edit_building/'.$list_building->id ); 
							
							?>
							
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Building Name*</label>
									<div class="controls">
										<input type="text" name="building_name" value="<?php echo $list_building->building_name; ?>" id="building_name" class="span5" >
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Building Description</label>
									<div class="controls">
										<textarea name="building_desc" id="building_desc" class="span5"><?php echo $list_building->building_desc; ?></textarea>
									</div>								
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Address</label>
									<div class="controls">
										<input type="text" name="address" value="<?php echo $list_building->address; ?>" id="address" class="span5" >
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Postal Code</label>
									<div class="controls">
										<input type="text" name="postal_code" value="<?php echo $list_building->postal_code; ?>" id="postal_code" class="span5" >
									</div>
								</div>
								
								<!--------------New Fields---------------------->
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Portfolio</label>
									<div class="controls">
										<input type="text"  name="portfolio" value="<?php echo $list_building->portfolio; ?>" id="portfolio" class="span5" >
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">District</label>
									<div class="controls">
										<input type="text"  name="district" value="<?php echo $list_building->district; ?>" id="district" class="span5" >
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Development</label>
									<div class="controls">
										<input type="text"  name="development" value="<?php echo $list_building->development; ?>" id="development" class="span5" >
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Building Type</label>
									<div class="controls">
										<input type="text"  name="building_type" value="<?php echo $list_building->building_type; ?>" id="building_type" class="span5" >
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Orignal Year of Construction</label>
									<div class="controls">
										<input type="text"  name="construction_year" value="<?php echo $list_building->construction_year; ?>" id="construction_year" class="span5" >
									</div>								
								</div>
								<!--------------End New Fields---------------------->
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Sq Feet</label>
									<div class="controls">
										<input type="text" name="square_feet" value="<?php echo $list_building->square_feet; ?>" id="square_feet" class="span5" >
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Surveyor</label>
									<div class="controls">
										<input type="text" name="surveyor" value="<?php echo $list_building->surveyor; ?>" id="surveyor" class="span5" >
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Survey Date</label>
									<div class="controls">
										<input type="text" name="survey_date" value="<?php echo $list_building->survey_date; ?>" id="datepicker" class="span5" >
									</div>
								</div>
								
								<div class="control-group">			
									<label class="control-label" for="file_upload">Project Number</label>
									<div class="controls">
										<input type="text" name="project_number" value="<?php echo $list_building->project_number; ?>" class="span5" >
									</div> <!-- /controls -->				
								</div> <!-- /control-group -->
								
								<div class="control-group">
									<div class="controls">
										<input type="checkbox" name="location_as_building" value="1"> Manage Location as building
									</div>
								</div>
                
							<hr>
							
							<input type="hidden" name="post_id" value="<?php echo $list_building->id; ?>">
							<input type="hidden" name="client_id" value="<?php echo $client_id->client_building_id;?>">
							<input type="reset" value="Reset" class="btn btn-primary" >
							<input name="submit" value="Update" id="submit" class="btn btn-primary" type="submit">
							
							
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