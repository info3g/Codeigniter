 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<div class="main-inner">
		<div class="container">
			<div class="row">     
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>dashboard/materials/<?php echo $bid;?>">Back</a>
					</div>
					<div class="widget">
						<div class="widget-header"> <i class="icon-cog"></i>
						  <h3>Add Material</h3>
						</div>
            
						<div class="widget-content">
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<?php 
							echo form_open('dashboard/add_material/'.$bid); ?>
							
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Material Name*</label>
									<div class="controls">
										<input type="text" name="material_name" value="" id="material_name" class="span5" >
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Material Description*</label>
									<div class="controls">
										<textarea name="material_desc" id="material_desc" class="span5" ></textarea>
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