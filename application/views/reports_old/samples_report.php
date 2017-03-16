<script>
	var base_url="<?php echo base_url();?>";
	
	jQuery(document).ready(function(){
	
		jQuery('#client_id').on('change',function(){
			var client_id = jQuery('#client_id').val();
			if(client_id != "Please Select"){
				jQuery.ajax({
					type: "POST",
					url: base_url+"reports/get_buildings",
					data:'client_id='+client_id,
					success: function(data){
						jQuery("#building_id").html(data);
					}
				});
			}
			
		});
	});
</script>
<?php 
	$session_data_enter = $this->session->userdata('enter_in');
			$client_id_enter = $session_data_enter['client_id'];
	?>
<div class="main-inner">
		<div class="container">
			<div class="row">     
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="javascript:void(0);" onclick="goBack();">Back</a>
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>/building/index/<?php echo $client_id_enter;?>">Building List</a>
					</div>
					<div class="widget">
						<div class="widget-header"> <i class="icon-cog"></i>
						  <h3>Samples Report</h3>
						</div>
            
						<div class="widget-content">
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<?php echo form_open('reports/export_samples_report'); ?>
							
								<!--div class="control-group">	
									<label class="control-label" for="siteFooter">Client</label>
									<div class="controls">
										<select name="client_id" id="client_id" class="span5">
												<option value="">Please Select</option>
											<?php foreach( $all_clients as $all_client ){?>
												<option value="<?php echo $all_client->id;?>"><?php echo $all_client->client_name;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Buildings</label>
									<div class="controls">
										<select name="building_id" id="building_id" class="span5">
										</select>
									</div>								
								</div-->
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Report Type</label>
									<div class="controls">
										<select name="report_type" id="report_type" class="span5">
											<option value="excel">Excel</option>
											<option value="pdf">Pdf</option>
										</select>
									</div>								
								</div>
							<hr>
							
							<input type="hidden" name="client_id" id="client_id" value="<?php echo $client_id->client_building_id; ?>">
							<input type="hidden" name="building_id" id="building_id" value="<?php echo $bid; ?>">
							<input name="submit" value="Export" id="submit" class="btn btn-primary" type="submit">
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