
<div class="main-inner">
		<div class="container">
			<div class="row">     
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>location/units">Back</a>
					</div>
					<div class="widget">
						<div class="widget-header"> <i class="icon-cog"></i>
						  <h3>Add Units</h3>
						</div>
            
						<div class="widget-content">
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<?php 
							echo form_open( 'location/add_unit' ); ?>
							
							<div class="span12">
								
								<div class="control-group">
									<label class="control-label" for="siteTitle">Unit Code : </label>
									<div class="controls">
										<input type="text" name="unit_code" value="" id="unit_code" class="span5" >
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="siteTitle">Unit Name : </label>
									<div class="controls">
										<input type="text" name="unit_name" value="" id="unit_name" class="span5" >
									</div>
								</div>
								
							<hr>
						
								<input name="submit" value="Submit" id="submit" class="btn btn-primary" type="submit">
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