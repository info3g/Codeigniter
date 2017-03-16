<div class="main-inner">
		<div class="container">
			<div class="row">     
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>location/location_action">Back</a>
					</div>
					<div class="widget">
						<div class="widget-header"> <i class="icon-cog"></i>
						  <h3>Edit Units</h3>
						</div>
            
						<div class="widget-content">
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<?php 
							echo form_open( 'location/edit_action/'.$get_action_values->a_id ); ?>
							
							<div class="span12">							
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Action Number : </label>
									<div class="controls">
										<input type="text" name="action_number" value="<?php echo $get_action_values->action_number; ?>" id="action_number" class="span5" >
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Action Name : </label>
									<div class="controls">
										<input type="text" name="action_name" value="<?php echo $get_action_values->action_name; ?>" id="action_name" class="span5" >
									</div>
								</div>
								
							<hr>
						
								<input name="submit" value="Update" id="submit" class="btn btn-primary" type="submit">
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