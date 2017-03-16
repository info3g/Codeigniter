 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
	jQuery(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = jQuery(".input_fields_wrap"); //Fields wrapper
    var add_button      = jQuery(".add_field_button"); //Add button ID
	
	var assignedRoleId = new Array();
	var assignedRolevalue = new Array();
	
	var mat_identy_id = new Array();
	var mat_identy_value = new Array();
	
	
	jQuery('#mat_id option').each(function(){
			assignedRoleId.push(this.value);
			assignedRolevalue.push(this.text);
	});	
	
	jQuery('#mat_identy option').each(function(){
			mat_identy_id.push(this.value);
			mat_identy_value.push(this.text);
	});	
		
    var x = 1; //initlal text box count
    jQuery(add_button).click(function(e){ //on add input button click
        e.preventDefault();
		
		var numbers = assignedRoleId;
		var numbersd = assignedRolevalue;
		var option = '';
		for (var i=0;i<numbers.length;i++){
		   option += '<option value="'+ numbers[i] + '">' + numbersd[i] + '</option>';
		}
		
		var matidentyid = mat_identy_id;
		var matidentyvalue = mat_identy_value;
		var option_mat = '';
		for (var i=0;i<matidentyid.length;i++){
		   option_mat += '<option value="'+matidentyid[i] + '">' +matidentyvalue[i] + '</option>';
		}
		
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            jQuery(wrapper).append('<div><div class="widget-content bg"><div class="control-group"><label class="control-label" for="siteFooter">Sample Number*</label><div class="controls"><input name="sample_number[]" id="sample_number" class="span5" value=""></div></div><div class="control-group"><label class="control-label" for="siteFooter">Location Number</label><div class="controls"><input name="location_id[]" id="location_id" class="span5" value=""></div></div><div class="control-group"><label class="control-label" for="siteFooter">System</label><div class="controls"><select id="mat_id" name="material_id[]" class="span5" >'+option+'</select></div></div><div class="control-group"><label class="control-label" for="siteFooter">Material Identification</label><div class="controls"><select id="mat_identy" name="material_identy[]" class="span5" >'+option_mat+'</select></div></div><div class="control-group"><label class="control-label" for="siteFooter">Layer One Type</label><div class="controls"><input name="layer_one_type[]" id="layer_one_type" class="span5" value=""></div></div><div class="control-group"><label class="control-label" for="siteFooter">Layer One %</label><div class="controls"><input name="layer_one_percent[]" id="layer_one_percent" class="span5" value=""></div></div><div class="control-group"><label class="control-label" for="siteFooter">Layer Two Type</label><div class="controls"><input name="layer_two_type[]" id="layer_two_type" class="span5" value=""></div></div><div class="control-group"><label class="control-label" for="siteFooter">Layer Two %</label><div class="controls"><input name="layer_two_percent[]" id="layer_two_percent" class="span5" value=""></div></div><div class="control-group"><label class="control-label" for="siteFooter">Layer Three Type</label><div class="controls"><input name="layer_three_type[]" id="layer_three_type" class="span5" value=""></div></div><div class="control-group"><label class="control-label" for="siteFooter">Layer Three %</label><div class="controls"><input name="layer_three_percent[]" id="layer_three_percent" class="span5" value=""></div></div><div class="control-group"><label class="control-label" for="siteFooter">Comments</label><div class="controls"><textarea name="comments[]" class="span5" ></textarea></div></div></div><a href="#" class="remove_field">Remove</a></div>'); //add input boxes
        }
    });
   
    jQuery(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault();
		jQuery(this).parent('div').remove(); x--;
    });
	jQuery(".test").on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault();
		jQuery(this).parent('div').remove(); x--;
    });
});
</script>
<style>
.auto_multi_select:first-child {
  float: left;
  width: 30%;
}
.auto_multi_select select {
  height: 30px;
  width: 100%;
}
.auto_multi_select {
  display: inline-block;
  margin-bottom: 10px;
  margin-right: 10px;
  width: 10%;
}
.auto_multi_select .innw {
  width: 100%;
}
.auto_multi_select .innw input {
  height: 30px;
  width: 100%;
}
.auto_multi_select a.remove_field {
  margin: 0;
}
</style>
	<div class="main-inner">
		<div class="container">
			<div class="row">     
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>sample">Back</a>
					</div>
					<div class="widget">
						<div class="widget-header"> <i class="icon-cog"></i>
						  <h3>Update Sample</h3>
						</div>
						<?php 
							//echo "<pre>";print_r($selected_data);
						?>
						<div class="widget-content">
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<?php 
							echo form_open('sample/edit_sample/'.$selected_sample->s_id); ?>
							
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Building Name : <?php $selected_sample->building_name;?></label>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">DB Sample Number : <?php echo $selected_sample->db_sample;?></label>
								</div>
								
								
							<?php //echo "<pre>";print_r($selected_sample_data);?>
				<!--==========================Reapeated Part=============================================-->
				
				<?php  foreach($selected_sample_data as $selected_sample_datas){?>
				
							<div class="widget-content bg">	
							
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Sample Number : <?php echo $selected_sample_datas->sample_number;?></label>
									<input type="hidden" name="sample_number[]" value="<?php echo $selected_sample_datas->sample_number;?>">
								</div>
								
								<div class="control-group">
									<label class="control-label" for="siteFooter">Location Number: <?php echo $selected_sample_datas->locationID;?></label>
									<input type="hidden" name="location_id[]" value="<?php echo $selected_sample_datas->locationID;?>">
								</div>
                
								<div class="control-group">	
									<label class="control-label" for="siteFooter">System</label>
									<div class="controls">
										<select  id="mat_id" name="material_id[]" class="span5" >
											<?php foreach($system_list as $system_lists){?>
												<option <?php if($selected_sample_datas->system_id == $system_lists->id){ echo "selected";}?> value="<?php echo $system_lists->id;?>" ><?php echo $system_lists->material_name;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Material Identification</label>
									<div class="controls">
										<select id="mat_identy" name="material_identy[]" class="span5" >
											<?php foreach( $material_identy_number as $material_identy_numbers ){?>
												<option <?php if($selected_sample_datas->material_identy == $material_identy_numbers->m_id){echo "selected";} ?> value="<?php echo $material_identy_numbers->m_id;?>" ><?php echo $material_identy_numbers->m_identification;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="siteFooter">Layer One Type</label>
									<div class="controls">
										<input name="layer_one_type[]" id="layer_one_type" class="span5" value="<?php echo $selected_sample_datas->layer_one_type;?>">
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="siteFooter">Layer One %</label>
									<div class="controls">
										<input name="layer_one_percent[]" id="layer_one_percent" class="span5" value="<?php echo $selected_sample_datas->layer_one_percent;?>">
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="siteFooter">Layer Two Type</label>
									<div class="controls">
										<input name="layer_two_type[]" id="layer_two_type" class="span5" value="<?php echo $selected_sample_datas->layer_two_type;?>">
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="siteFooter">Layer Two %</label>
									<div class="controls">
										<input name="layer_two_percent[]" id="layer_two_percent" class="span5" value="<?php echo $selected_sample_datas->layer_two_percent;?>">
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="siteFooter">Layer Three Type</label>
									<div class="controls">
										<input name="layer_three_type[]" id="layer_three_type" class="span5" value="<?php echo $selected_sample_datas->layer_three_type;?>">
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="siteFooter">Layer Three %</label>
									<div class="controls">
										<input name="layer_three_percent[]" id="layer_three_percent" class="span5" value="<?php echo $selected_sample_datas->layer_three_percent;?>">
									</div>
								</div>
								
								<div class="control-group">	
									<label class="control-label" for="siteFooter">Comments</label>
									<div class="controls">
										<textarea name="comments[]" class="span5" ><?php echo $selected_sample_datas->comments;?></textarea>
									</div>
								</div>
								
								
							</div>
							
					<?php } ?>		
							<div class="input_fields_wrap">
							</div>
				<!--==========================Reapeated Part End=============================================-->			
								
								<div class="control-group">	
									<div class="controls"><a href="javascript:void(0)" id="add_new_sample" class="add_field_button">Add More sample +</a></div>
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