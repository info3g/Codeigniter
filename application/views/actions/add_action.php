
<div class="main-inner">
		<div class="container">
			<div class="row">     
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>location/location_action">Back</a>
					</div>
					<div class="widget">
						<div class="widget-header"> <i class="icon-cog"></i>
						  <h3>Add Actions</h3>
						</div>
            
						<div class="widget-content">
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<?php 
							echo form_open( 'location/add_action' ); ?>
							
							<div class="span12">
								
								<div class="control-group">
									<label class="control-label" for="siteTitle">Action Number : </label>
									<div class="controls">
										<input type="text" name="action_number" value="" id="action_number" class="span5" >
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="siteTitle">Action Name : </label>
									<div class="controls">
										<input type="text" name="action_name" value="" id="action_name" class="span5" >
									</div>
								</div>
								
							<hr>
							<?php 
								$uids = $_SERVER['REQUEST_URI'];
								$e = explode('/',$uids);
								$uid = $e[4];
							?>
								<input type="hidden" name="uid" value="<?php echo $uid; ?>">
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