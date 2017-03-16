<script>
var base_url="<?php echo base_url();?>";

	function export_report_sample()
	{
		var client_id = jQuery('#client_id').val();
		var building_id = jQuery('#building_id').val();
		var report_type = jQuery('#report_type').val();
		
		jQuery('#loading_msg').show();
		
		var report = { 'client_id' : client_id, 'building_id' : building_id, 'report_type' : report_type }
		jQuery.ajax({
			type: "POST",
			url: base_url+"reports/export_samples_report",
			data: report,
			success: function(data){
				jQuery('#loading_msg').hide();
				console.log(data);
				var r=confirm( "Do you want to download ?" )
				if (r==true){
						var url = base_url+data;
						var ext = url.split('.');
						var extension = ext[2];
						if(extension == 'pdf')
						{
							var f_name = url.split('/');
							var fname = f_name[7];
							var $a = $('<a />', {
							  'href': url,
							  'download': fname,
							  'text': "click"
							}).hide().appendTo("body")[0].click();
						}else{
							window.open(base_url+data); 
						}
        		}else{
				    return false;
				} 
			}
		});
		
	}
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
							<?php //echo form_open('reports/export_samples_report'); ?>
							
								<div id="loading_msg" style="display:none;"><img src="<?php echo base_url();?>assets/images/loading5.gif" /></div>
							
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Buildings</label>
									<div class="controls">
										<select name="building_id" id="building_id" class="span5">
											<option value="">Please Select</option>
											<?php foreach($all_buildings as $all_building){?>
												<option value="<?php echo $all_building->id;?>"><?php echo $all_building->building_name;?></option>
											<?php } ?>	
										</select>
									</div>								
								</div>
								
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
							
							<input type="hidden" name="client_id" id="client_id" value="<?php echo $client_id; ?>">
							<input name="submit" value="Export" onclick="export_report_sample();" id="submit" class="btn btn-primary" type="submit">
							<?php //echo form_close(); ?>
						
						</div> 
					</div>
					<!-- /widget -->
 
         
				</div>
			</div>
			<!-- /row --> 
		</div>
		<!-- /container --> 
  </div>