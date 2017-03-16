 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


	<div class="main-inner">
		<div class="container">
			<div class="row">     
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>client">Back</a>
					</div>
					<div class="widget">
						<div class="widget-header"> <i class="icon-cog"></i>
						  <h3>Add Clients</h3>
						</div>
            
						<div class="widget-content">
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<div class="errors"><?php if(isset($error['error'])) {echo $error['error'];} ?></div>
							<?php 
							
							echo form_open_multipart('client/add_client'); ?>
							
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Client Name*</label>
									<div class="controls">
										<input type="text" name="client_name" value="<?php echo set_value('client_name'); ?>" id="client_name" class="span5" >
									</div>								
								</div>
                
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Client Address</label>
									<div class="controls">
										<input type="text" name="client_address" value="<?php echo set_value('client_address'); ?>" id="client_address" class="span5" >
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">City</label>
									<div class="controls">
										<input type="text" name="city" value="<?php echo set_value('city'); ?>" id="city" class="span5" >
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Province</label>
									<div class="controls">
										<input type="text" name="province" value="<?php echo set_value('province'); ?>" id="province" class="span5" >
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Postal Code</label>
									<div class="controls">
										<input type="text" name="postal_code" value="<?php echo set_value('postal_code'); ?>" id="postal_code" class="span5" >
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Select Buildings</label>
									<div class="controls">
										<select name="all_building[]" multiple="multiple" class="span5" >
											<?php foreach( $all_building as $all_buildings ){ ?>
												<option value="<?php echo $all_buildings->id;?>"><?php echo $all_buildings->building_name;?></option>
											<?php } ?>
										</select>
										( ctrl+click ) to select multiple buildings.
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Client Project Number</label>
									<div class="controls">
										<input type="text" name="c_project_number" value="<?php echo set_value('c_project_number'); ?>" id="c_project_number" class="span5" >
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Username*</label>
									<div class="controls">
										<input type="text" name="username" value="<?php echo set_value('username'); ?>" id="username" class="span5" >
									</div>
								</div>
            
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Email Address*</label>
									<div class="controls">
										<input type="text" name="email" value="<?php echo set_value('email'); ?>" id="email" class="span5" >
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Password</label>
									<div class="controls">
										<input type="password" name="password" value="" id="password" class="span5" >
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Confirm Password</label>
									<div class="controls">
										<input type="password" name="cpassword" value="" id="cpassword" class="span5" >
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Client Logo*</label>
									<div class="controls">
										<input type="file" name="userfile" size="20" />
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Permissions</label>
									<div class="controls">
										<input type="radio" name="permission" value="0" checked >Read
										<input type="radio" name="permission" value="1" >Read/Write
									</div>
								</div>
                
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