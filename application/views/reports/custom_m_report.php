<script>
	var base_url="<?php echo base_url();?>";
	
	function export_custom_m_summary()
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
		var action 				= jQuery('#action').val();
		var report_type 		= jQuery('#report_type').val();
		
		var report = "";
		//alert(district);
		if( district != "null"  && building !="null" )
		{
			var report = { 'client_id' : client_id, 'building' : building, 'district' : district, 'bids' : bids, 'hazard' : hazard, 'report_type' : report_type }
		}
		if( building !="null" && system !="null" )
		{
			var report = { 'client_id' : client_id, 'building' : building, 'system' : system, 'report_type' : report_type, 'hazard' : hazard }			
		}
		if( building !="null" && system !="null" && material !="null" )
		{
			var report = { 'client_id' : client_id, 'building' : building, 'system' : system, 'material' : material, 'report_type' : report_type, 'hazard' : hazard }
		}
		if( building !="null" && system !="null" && material !="null" && material_identi !="null" )
		{
			var report = { 'client_id' : client_id, 'building' : building, 'system' : system, 'material' : material, 'material_identi' : material_identi, 'report_type' : report_type, 'hazard' : hazard }
		}
		if( building !="null" && system !="null" && material !="null" && material_identi !="null" && friability !="null" )
		{
			var report = { 'client_id' : client_id, 'building' : building, 'system' : system, 'material' : material, 'material_identi' : material_identi,'friability' : friability, 'report_type' : report_type, 'hazard' : hazard }
		} 
		if( building !="null" && system !="null" && material !="null" && material_identi !="null" && friability !="null" && access !="null" )
		{
			var report = { 'client_id' : client_id, 'building' : building, 'system' : system, 'material' : material, 'material_identi' : material_identi,'friability' : friability, 'access' : access, 'report_type' : report_type, 'hazard' : hazard }
		}
		if( building !="null" && system !="null" && material !="null" && material_identi !="null" && friability !="null" && access !="null" && hazard !="null" )
		{
			var report = { 'client_id' : client_id, 'building' : building, 'system' : system, 'material' : material, 'material_identi' : material_identi,'friability' : friability, 'access' : access, 'hazard' : hazard, 'report_type' : report_type }
		}
		if( building !="null" && system !="null" && material !="null" && material_identi !="null" && friability !="null" && access !="null" && hazard !="null" && action !="null" )
		{
			var report = { 'client_id' : client_id, 'building' : building, 'system' : system, 'material' : material, 'material_identi' : material_identi,'friability' : friability, 'access' : access, 'hazard' : hazard, 'action' : action,  'report_type' : report_type }
		}
		
		//console.log(report);
		
		if( report != '' )
		{
			jQuery('#loading_msg').show();
			
			jQuery.ajax({
				type: "POST",
				url: base_url+"reports/export_custom_m_summary_all",
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
		
		jQuery('#get_building').on('click',function(){
			var district 	= jQuery('#district').val();
			var bids 		= jQuery('#bids').val();
			
			var data = {'district' : district, 'bids' : bids }
			if(system != "Please Select"){
				jQuery.ajax({
					type: "POST",
					url: base_url+"reports/get_building_dist_m",
					data:data,
					success: function(data){
						console.log(data);
						jQuery("#building").html( data );
					}
				});
			}
		});
		
		jQuery('#get_materials').on('click',function(){
			var building = jQuery('#building').val();
			var system = jQuery('#system').val();
			var data = {'building' : building, 'system' : system }
			if(system != "Please Select"){
				jQuery.ajax({
					type: "POST",
					url: base_url+"reports/get_materials_m",
					data:data,
					success: function(data){
						jQuery("#material").html(data);
					}
				});
			}
		});	
		jQuery('#get_material_identi').on('click',function(){
			var material = jQuery('#material').val();
			var building = jQuery('#building').val();
			var data = {'building' : building, 'material' : material }
			console.log(data);
			if(material != "Please Select"){
				jQuery.ajax({
					type: "POST",
					url: base_url+"reports/get_material_identi_m",
					data: data,
					success: function(data){
						console.log(data);
						jQuery("#material_identi").html(data);
					}
				});
			}
		});
		jQuery('#get_friability').on('click',function(){
			var building = jQuery('#building').val();
			var system = jQuery('#system').val();
			var material = jQuery('#material').val();
			var material_identi = jQuery('#material_identi').val();
			
			var data = {'building' : building, 'system' : system,'material_identi' : material_identi, 'material' : material }
			
			if(material_identi != "Please Select")
			{
				jQuery.ajax({
					type: "POST",
					url: base_url+"reports/get_friability_m",
					data: data,
					success: function(data){
						console.log(data);	
						jQuery("#friability").html(data);
					}
				});
			}
		});
		jQuery('#get_access').on('click',function(){
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
					url: base_url+"reports/get_access_m",
					data: data,
					success: function(data){
						console.log(data);	
						jQuery("#access").html(data);
					}
				});
			}
		});
		jQuery('#get_hazard').on('click',function(){
			
			var access 			= jQuery('#access').val();			
			var friability 		= jQuery('#friability').val();
			var building 		= jQuery('#building').val();
			var system 			= jQuery('#system').val();
			var material 		= jQuery('#material').val();
			var material_identi = jQuery('#material_identi').val();
			
			var data = {'building' : building, 'system' : system,'material_identi' : material_identi, 'material' : material, 'friability' : friability, 'access' : access }
			
			if( access != "-Please Select-" )
			{
				jQuery.ajax({
					type: "POST",
					url: base_url+"reports/get_hazard_m",
					data: data,
					success: function(data){
						console.log(data);	
						jQuery("#hazard").html(data);
					}
				});
			}
		});
		jQuery('#get_action').on('click',function(){
			
			var access 			= jQuery('#access').val();			
			var friability 		= jQuery('#friability').val();
			var building 		= jQuery('#building').val();
			var system 			= jQuery('#system').val();
			var material 		= jQuery('#material').val();
			var material_identi = jQuery('#material_identi').val();
			var hazard = jQuery('#hazard').val();
			
			var data = {'building' : building, 'system' : system,'material_identi' : material_identi, 'material' : material, 'friability' : friability, 'access' : access, 'hazard' :hazard}
			
			if( access != "-Please Select-" )
			{
				jQuery.ajax({
					type: "POST",
					url: base_url+"reports/get_action_m",
					data: data,
					success: function(data){
						console.log(data);	
						jQuery("#action").html(data);
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
						  <h3>Custom Multiple Report</h3>
						</div>
						
						<div class="widget-content">
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<?php //echo form_open('reports/export_custom_summary_all'); ?>
							
								<div id="loading_msg" style="display:none;"><img src="<?php echo base_url();?>assets/images/loading5.gif" /></div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">District</label>
									<div class="controls">
										<select multiple="multiple" name="district" id="district" class="span5">
											<?php for( $i=1;$i<=6;$i++ ){?>
												<option value="<?php echo $i;?>"><?php echo $i;?></option>
											<?php } ?>
										</select>
										<a href="javascript:void(0);" id="get_building">Get Building</a>
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Building/Development</label>
									<div class="controls">
										<select multiple="multiple" name="building" id="building" class="span5">
											
										</select>
									</div>								
								</div>
								
								<div class="control-group">
									<label class="control-label" for="siteTitle">System</label>
									<div class="controls">
										<select multiple="multiple" name="system" id="system" class="span5">
											<?php foreach($system as $systems){ ?>
												<option value="<?php echo $systems->id;?>"><?php echo $systems->system_name;?></option>
											<?php } ?>
										</select>
										<a href="javascript:void(0);" id="get_materials">Get Materials</a>
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Material</label>
									<div class="controls">
										<select multiple="multiple" name="material" id="material" class="span5">
										</select>
										<a href="javascript:void(0);" id="get_material_identi">Get Materials Identification</a>
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Material Identification</label>
									<div class="controls">
										<select multiple="multiple" name="material_identi" id="material_identi" class="span5">
										</select>
										<a href="javascript:void(0);" id="get_friability">Get Friability</a>
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Friability</label>
									<div class="controls">
										<select multiple="multiple" name="friability" id="friability" class="span5">
										</select>
										<a href="javascript:void(0);" id="get_access">Get Access</a>
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Access</label>
									<div class="controls">
										<select multiple="multiple" name="access" id="access" class="span5">
										</select>
										<a href="javascript:void(0);" id="get_hazard">Get Hazards</a>
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Hazards</label>
									<div class="controls">
										<select multiple="multiple" name="hazard" id="hazard" class="span5">
											<option value="Confirmed Asbestos">Confirmed Asbestos</option>
											<option value="Presumed Asbestos">Presumed Asbestos</option>
											<option value="No Asbestos">No Asbestos</option>
											<option value="L.O.D">&lt;L.O.D</option>
										</select>
										<a href="javascript:void(0);" id="get_action">Get Action</a>
									</div>								
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Action</label>
									<div class="controls">
										<select multiple="multiple" name="action" id="action" class="span5">
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
							<input name="submit" value="Export" onclick="export_custom_m_summary();" id="submit" class="btn btn-primary" type="button">
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