 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<div class="main-inner">
		<div class="container">
			<div class="row">     
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>dashboard/material_identification/<?php echo $bid;?>">Back</a>
					</div>
					<div class="widget">
						<div class="widget-header"> <i class="icon-cog"></i>
						  <h3>Add Material</h3>
						</div>
            
						<div class="widget-content">
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<?php 
							echo form_open('dashboard/add_material_identification/'.$bid); ?>
							
								<input type="hidden" name="building_id" value="<?php echo $bid; ?>">
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Select System</label>
									<div class="controls">
										<select name="system_id" class="span5" >
											<?php foreach($system_list as $system_lists){ ?>
												<option value="<?php echo $system_lists->id;?>" ><?php echo $system_lists->system_name;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Select Material</label>
									<div class="controls">
										<select name="material_id" class="span5" >
											<?php foreach($material_list as $material_lists){ ?>
												<option value="<?php echo $material_lists->id;?>" ><?php echo $material_lists->material_name;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Material Identification*</label>
									<div class="controls">
										<input name="material_identification" id="material_identification" class="span5" value="">
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Material Identification Description*</label>
									<div class="controls">
										<textarea name="material_identification_desc" id="material_identification_desc" class="span5" ></textarea>
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