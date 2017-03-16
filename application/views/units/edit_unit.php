<div class="main-inner">
		<div class="container">
			<div class="row">     
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>location/units">Back</a>
					</div>
					<div class="widget">
						<div class="widget-header"> <i class="icon-cog"></i>
						  <h3>Edit Units</h3>
						</div>
            
						<div class="widget-content">
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<?php 
							echo form_open( 'location/edit_unit/'.$get_unit_values->u_id ); ?>
							
							<div class="span12">							
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Unit Code : </label>
									<div class="controls">
										<input type="text" name="unit_code" value="<?php echo $get_unit_values->unit_code; ?>" id="unit_code" class="span5" >
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Unit Name : </label>
									<div class="controls">
										<input type="text" name="unit_name" value="<?php echo $get_unit_values->unit_name; ?>" id="unit_name" class="span5" >
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