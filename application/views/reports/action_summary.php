<script>
var base_url="<?php echo base_url();?>";

	jQuery(document).ready(function(){
	
		jQuery('#district_id').on('change',function(){
			var district_id = jQuery('#district_id').val();
			var client_id = jQuery('#client_id').val();
			if(district_id != "Please Select"){
				var dta = { 'client_id' : client_id, 'district_id' : district_id }
				jQuery.ajax({
					type: "POST",
					url: base_url+"reports/get_buildings_district",
					data: dta,
					success: function(data){
						console.log(data);
						item=JSON.parse(data);
						jQuery("#building_id").html(item.d);
						jQuery("#buildind_ids_input").html(item.e);
					}
				});
			}
		
		});
	});	

	function export_action_summary()
	{
		
		var client_id 	= jQuery('#client_id').val();
		var building_id = jQuery('#building_id').val();
		var report_type = jQuery('#report_type').val();
		var district_id = jQuery('#district_id').val();
		var action 		= jQuery('#action').val();
		
		var building_ids = jQuery('#building_ids').val();
		
		 var intValArray=building_ids.split(',');
		//console.log(strings);
		for(var i=0;i<intValArray.length; i++ )
		{
			intValArray[i]=parseInt(intValArray[i]);
		}
		//console.log(intValArray);
		
		if( district_id != "Please Select" )
		{
			
			jQuery('#loading_msg').show();
			if( jQuery('#building_id :selected ').size() != '0')
			{
				var report = { 'client_id' : client_id, 'building_id' : building_id, 'action' : action, 'report_type' : report_type, 'district_id' : district_id }
			}else{
				var report = { 'client_id' : client_id, 'building_id' : intValArray, 'action' : [2,3,4], 'report_type' : report_type, 'district_id' : district_id }
			}
			
			/* console.log(report); */
			
			jQuery.ajax({
				type: "POST",
				url: base_url+"reports/export_actioni_summary_all",
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
		else
		{
			alert("Please select District or Building.");	
		}
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
						  <h3>Action Summary</h3>
						</div>
						
						<div class="widget-content">
						
							<div class="errors"><?php //echo validation_errors(); ?></div>
							<?php //echo form_open('reports/export_building_summary_all'); ?>
							
								<div id="loading_msg" style="display:none;"><img src="<?php echo base_url();?>assets/images/loading5.gif" /></div>
								
								<div class="control-group">
									<label class="control-label" for="siteTitle">District</label>
									<div class="controls">
										<select name="district_id" id="district_id" class="span5">
											<option>Please Select</option>
											<?php for($i=1;$i<=5;$i++){?>
												<option value="<?php echo $i;?>"><?php echo $i;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Buildings</label>
									<div class="controls">
										<select multiple="multiple" name="building_id" id="building_id" class="span5">
											<?php /* foreach($all_buildings as $all_building){?>
												<option value="<?php echo $all_building->id;?>"><?php echo $all_building->building_name;?></option>
											<?php } */ ?>
										</select>
									</div>
								</div>
								
								<div id="buildind_ids_input">
								
								</div>
								
								
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Actions</label>
									<div class="controls">
										<select multiple="multiple" name="action" id="action" class="span5">
											<?php foreach($action as $action_list){?>
												<option value="<?php echo $action_list->a_id;?>"><?php echo $action_list->action_number;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Report Type</label>
									<div class="controls">
										<select name="report_type" id="report_type" class="span5">
											<option value="pdf">Pdf</option>
										</select>
									</div>								
								</div>
							<hr>
							
							<input type="hidden" name="client_id" id="client_id" value="<?php echo $client_id; ?>">
							<input name="submit" value="Export" onclick="export_action_summary();" id="submit" class="btn btn-primary" type="button">
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