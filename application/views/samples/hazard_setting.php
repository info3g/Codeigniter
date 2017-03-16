<div class="main-inner">
		<div class="container">
			<div class="row">     
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>sample/index/<?php echo $bid;?>">Back</a>
					</div>
					<div class="widget">
						<div class="widget-header"> <i class="icon-cog"></i>
						  <h3>Hazard</h3>
						</div>
            
						<div class="widget-content">
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<?php echo form_open('sample/hazard_setting/'.$bid); ?>
							
								<div class="control-group">
									<label class="control-label" for="siteTitle">Hazard Condition</label>
									<div class="controls">
										<input name="hazard" id="hazard" class="span2" value="<?php if(isset($autofill_hazard)){echo $autofill_hazard->hazard;} ?>">
										<select class="span2" name="condition" id="condition">
											<option <?php if(isset($autofill_hazard)){ if($autofill_hazard->condition=='>='){echo "selected";} } ?> value=">=">Greater Than or equals to</option>
											<option  <?php if(isset($autofill_hazard)){ if($autofill_hazard->condition=='>'){echo "selected";} } ?> value=">">Greater Than</option>
											<option  <?php if(isset($autofill_hazard)){ if($autofill_hazard->condition=='<='){echo "selected";} } ?> value="<=">Less Than or equals to</option>
											<option  <?php if(isset($autofill_hazard)){ if($autofill_hazard->condition=='<'){echo "selected";} } ?> value="<">Less Than</option>
										</select>
										<input name="hazard_condition_rst" id="hazard_condition_rst" class="span2" value="<?php if(isset($autofill_hazard)){echo $autofill_hazard->hazard_rst;} ?>">
									</div>
								</div>
								
							<hr>
						
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