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
						  <h3>Update Material Identification</h3>
						</div>
            
						<div class="widget-content">
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<?php 
							echo form_open('dashboard/edit_material_identy/'.$bid.'/'.$get_mat_identy_info->m_id); ?>
							
								
								<input type="hidden" name="building_id" value="<?php echo $bid;?>">
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Select System</label>
									<div class="controls">
										<select name="system_id" class="span5" >
											<?php foreach($system_list as $system_lists){ ?>
												<option <?php if($system_lists->id == $get_mat_identy_info->system){echo "selected";}?> value="<?php echo $system_lists->id;?>" ><?php echo $system_lists->system_name;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Select Material</label>
									<div class="controls">
										<select name="material_id" class="span5" >
											<?php foreach($material_list as $material_lists){ ?>
												<option <?php if($material_lists->id == $get_mat_identy_info->material_id){echo "selected";}?> value="<?php echo $material_lists->id;?>" ><?php echo $material_lists->material_name;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Material Identification*</label>
									<div class="controls">
										<input name="material_identification" id="material_identification" class="span5" value="<?php echo $get_mat_identy_info->m_identification; ?>">
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Material Identification Description*</label>
									<div class="controls">
										<textarea name="material_identification_desc" id="material_identification_desc" class="span5" ><?php echo $get_mat_identy_info->m_description; ?></textarea>
									</div>
								</div>
							<hr>
						
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