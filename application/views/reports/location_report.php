<script>
var base_url="<?php echo base_url();?>";
	function export_location()
	{
		var client_id = jQuery('#client_id').val();
		var building_id = jQuery('#building_id').val();
		var report_type = jQuery('#report_type').val();
		
		jQuery('#loading_msg').show();
		
		var report = { 'client_id' : client_id, 'building_id' : building_id, 'report_type' : report_type }
		jQuery.ajax({
			type: "POST",
			url: base_url+"reports/export_all_location_report",
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
						  <h3>All Locations Report</h3>
						</div>
						
						<div class="widget-content">
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<?php //echo form_open('reports/export_all_location_report'); ?>
							
								<div id="loading_msg" style="display:none;"><img src="<?php echo base_url();?>assets/images/loading5.gif" /></div>
							
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
							<input name="submit" value="Export" onclick="export_location();" id="submit" class="btn btn-primary" type="button">
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