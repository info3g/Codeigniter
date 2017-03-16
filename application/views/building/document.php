 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<div class="main-inner">
		<div class="container">
			<div class="row">     
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>building">Back</a>
					</div>
					<div class="widget">
						<div class="widget-header"> <i class="icon-cog"></i>
						  <h3>Add Documents</h3>
						</div>
            
						<div class="widget-content">
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<?php 
							echo form_open_multipart('building/add_document/'.$building_id); ?>
							
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Document Title*</label>
									<div class="controls">
										<input type="text"  name="document_title" value="" id="document_title" class="span5" >
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Document Description*</label>
									<div class="controls">
										<textarea name="document_desc" id="document_desc" class="span5" ></textarea>
									</div>								
								</div>
                
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Upload </label>
									<div class="controls">
										<input type="file" name="document_upload" id="file" class="span5" >
										<?php  if(isset($error)){ echo $error['error']; }?>
									</div>
								</div>
                
							<hr>
						
							<input type="reset" value="Reset" class="btn btn-primary" >
							<input name="submit" value="Upload" id="submit" class="btn btn-primary" type="submit">
							
							
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