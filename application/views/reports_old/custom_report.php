<script>
	var base_url="<?php echo base_url();?>";
	
	function export_custom_summary()
	{
		var client_id 			= jQuery('#client_id').val();
		
		var district 			= jQuery('#district').val();
		var building 			= jQuery('#building').val();
		var bids 				= jQuery('#bids').val();
		var system 				= jQuery('#system').val();
		var material 			= jQuery('#material').val();
		var material_identi 	= jQuery('#material_identi').val();
		var friability 			= jQuery('#friability').val();
		var access 				= jQuery('#access').val();
		var hazard 				= jQuery('#hazard').val();
		
		var report_type 		= jQuery('#report_type').val();
		
		var report = "";
		//alert(district);
		if( district != "Please Select"  && building !="Please Select" )
		{
			var report = { 'client_id' : client_id, 'building' : building, 'district' : district, 'bids' : bids, 'report_type' : report_type }			
		}
		if( building !="Please Select" && system !="Please Select" )
		{
			var report = { 'client_id' : client_id, 'building' : building, 'system' : system, 'report_type' : report_type }			
		}
		if( building !="Please Select" && system !="Please Select" && material !="Please Select" )
		{
			var report = { 'client_id' : client_id, 'building' : building, 'system' : system, 'material' : material, 'report_type' : report_type }
		}
		if( building !="Please Select" && system !="Please Select" && material !="Please Select" && material_identi !="Please Select" )
		{
			var report = { 'client_id' : client_id, 'building' : building, 'system' : system, 'material' : material, 'material_identi' : material_identi, 'report_type' : report_type }
		}
		if( building !="Please Select" && system !="Please Select" && material !="Please Select" && material_identi !="Please Select" && friability !="-Please Select-" )
		{
			var report = { 'client_id' : client_id, 'building' : building, 'system' : system, 'material' : material, 'material_identi' : material_identi,'friability' : friability, 'report_type' : report_type }
		}
		if( building !="Please Select" && system !="Please Select" && material !="Please Select" && material_identi !="Please Select" && friability !="-Please Select-" && access !="-Please Select-" )
		{
			var report = { 'client_id' : client_id, 'building' : building, 'system' : system, 'material' : material, 'material_identi' : material_identi,'friability' : friability, 'access' : access, 'report_type' : report_type }
		}
		if( building !="Please Select" && system !="Please Select" && material !="Please Select" && material_identi !="Please Select" && friability !="-Please Select-" && access !="-Please Select-" && hazard !="-Please Select-" )
		{
			var report = { 'client_id' : client_id, 'building' : building, 'system' : system, 'material' : material, 'material_identi' : material_identi,'friability' : friability, 'access' : access, 'hazard' : hazard, 'report_type' : report_type }
		}
		
		//console.log(report);
		
		if( report != '' )
		{
			jQuery('#loading_msg').show();
			
			jQuery.ajax({
				type: "POST",
				url: base_url+"reports/export_custom_summary_all",
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
		
		}else{
			alert('Fields cannot be empty!');
		}
		
	}
	
	jQuery(document).ready(function(){
		
		jQuery('#district').on('change',function(){
			var district 	= jQuery('#district').val();
			var bids 		= jQuery('#bids').val();
			
			var data = {'district' : district, 'bids' : bids }
			if(system != "Please Select"){
				jQuery.ajax({
					type: "POST",
					url: base_url+"reports/get_building_dist",
					data:data,
					success: function(data){
						jQuery("#building").html( data );
					}
				});
			}
		});
		
		jQuery('#building').on('change',function(){
			var building 	= jQuery('#building').val();
			var bids 		= jQuery('#bids').val();
			
			var data = {'building' : building }
			if(system != "Please Select"){
				jQuery.ajax({
					type: "POST",
					url: base_url+"reports/get_system",
					data:data,
					success: function(data){
						console.log(data);
						jQuery("#system").html( data );
					}
				});
			}
		});
		
		jQuery('#system').on('change',function(){
			var building = jQuery('#building').val();
			var system = jQuery('#system').val();
			var data = {'building' : building, 'system' : system }
			if(system != "Please Select"){
				jQuery.ajax({
					type: "POST",
					url: base_url+"reports/get_materials",
					data:data,
					success: function(data){
						jQuery("#material").html(data);
					}
				});
			}
		});	
		jQuery('#material').on('change',function(){
			var material = jQuery('#material').val();
			var building = jQuery('#building').val();
			var data = {'building' : building, 'material' : material }
			if(material != "Please Select"){
				jQuery.ajax({
					type: "POST",
					url: base_url+"reports/get_material_identi",
					data: data,
					success: function(data){
						jQuery("#material_identi").html(data);
					}
				});
			}
		});
		jQuery('#material_identi').on('change',function(){
			var building = jQuery('#building').val();
			var system = jQuery('#system').val();
			var material = jQuery('#material').val();
			var material_identi = jQuery('#material_identi').val();
			
			var data = {'building' : building, 'system' : system,'material_identi' : material_identi, 'material' : material }
			
			if(material_identi != "Please Select")
			{
				jQuery.ajax({
					type: "POST",
					url: base_url+"reports/get_friability",
					data: data,
					success: function(data){
						//console.log(data);	
						jQuery("#friability").html(data);
					}
				});
			}
		});
		jQuery('#friability').on('change',function(){
			var friability 		= jQuery('#friability').val();
			var building 		= jQuery('#building').val();
			var system 			= jQuery('#system').val();
			var material 		= jQuery('#material').val();
			var material_identi = jQuery('#material_identi').val();
			
			var data = {'building' : building, 'system' : system,'material_identi' : material_identi, 'material' : material, 'friability' : friability }
			
			if( friability != "-Please Select-" )
			{
				jQuery.ajax({
					type: "POST",
					url: base_url+"reports/get_access",
					data: data,
					success: function(data){
						console.log(data);	
						jQuery("#access").html(data);
					}
				});
			}
		});
		jQuery('#access').on('change',function(){
			var access = jQuery('#access').val();
			if(access != "-Please Select-"){
				jQuery('#hazard').html('<option>-Please Select-</option><option value="Presumed Asbestos">Presumed Asbestos</option><option value="Confirm Asbestos">Confirm Asbestos</option><option value="No Asbestos">No Asbestos</option><option value="None Detected">None Detected</option>');
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
						  <h3>Custom Report</h3>
						</div>
						
						<div class="widget-content">
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<?php //echo form_open('reports/export_custom_summary_all'); ?>
							
								<div id="loading_msg" style="display:none;"><img src="<?php echo base_url();?>assets/images/loading5.gif" /></div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">District</label>
									<div class="controls">
										<select name="district" id="district" class="span5">
											<option>Please Select</option>
											<?php for( $i=1;$i<=6;$i++ ){?>
												<option value="<?php echo $i;?>"><?php echo $i;?></option>
											<?php } ?>
										</select>
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Building/Development</label>
									<div class="controls">
										<select name="building" id="building" class="span5">
											<option>Please Select</option>
										</select>
									</div>								
								</div>
								
								<div class="control-group">
									<label class="control-label" for="siteTitle">System</label>
									<div class="controls">
										<select name="system" id="system" class="span5">
											<option>Please Select</option>
											<?php foreach($system as $systems){?>
												<option value="<?php echo $systems->id;?>"><?php echo $systems->system_name;?></option>
											<?php } ?>
										</select>
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Material</label>
									<div class="controls">
										<select name="material" id="material" class="span5">
										</select>
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Material Identification</label>
									<div class="controls">
										<select name="material_identi" id="material_identi" class="span5">
										</select>
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Friability</label>
									<div class="controls">
										<select name="friability" id="friability" class="span5">
										</select>
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Access</label>
									<div class="controls">
										<select name="access" id="access" class="span5">
										</select>
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Hazards</label>
									<div class="controls">
										<select name="hazard" id="hazard" class="span5">
										</select>
									</div>								
								</div>
							
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Report Type</label>
									<div class="controls">
										<select name="report_type" id="report_type" class="span5">
											<!--option value="excel">Excel</option-->
											<option value="pdf">Pdf</option>
										</select>
									</div>								
								</div>
								
							<hr>
							
							<input type="hidden" name="bids" id="bids" value="<?php echo $bids; ?>">
							<input type="hidden" name="client_id" id="client_id" value="<?php echo $client_id; ?>">
							<input name="submit" value="Export" onclick="export_custom_summary();" id="submit" class="btn btn-primary" type="button">
							<!--input name="submit" value="Export" id="submit" class="btn btn-primary" type="submit"-->
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