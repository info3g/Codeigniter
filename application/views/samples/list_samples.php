<script type="text/javascript">
	var base_url="<?php echo base_url();?>";
	var loaderimg = "<img src='<?php echo base_url();?>assets/images/loading5.gif'>";
    function delete_confirm( id )
	{
       var r=confirm( "Are you sure, you want to delete this?" )
        if (r==true)
          window.location = base_url+"sample/remove_sample_to_trash/"+id;
        else
          return false;
    }
	
	function delete_confirm_smid( id, sid )
	{
       var r=confirm( "Are you sure, you want to delete this?" )
        if (r==true)
          window.location = base_url+"sample/remove_sample_child/"+id+"/"+sid+"/<?php echo $bid;?>";
        else
          return false;
    }
	jQuery(document).ready(function() {
	
	
		jQuery('#selecctall').click(function(event) {
			if(this.checked) {
				jQuery('.check').each(function() {
					this.checked = true;
				});
			}else{
				jQuery('.check').each(function() {
					this.checked = false;
				});
			}
		});
		
		jQuery('#suggesstion-box1').on('click',function(e){
			e.preventDefault();
		});	
		
		jQuery(document).on('click',function(){
			jQuery(document).find('#suggesstion-box1').html('');
		});	
		
		jQuery('#suggesstion-box').on('click',function(e){
			e.preventDefault();
		});	
		
		jQuery(document).on('click',function(){
			jQuery(document).find('#suggesstion-box').html('');
		});
		
	});
	
	
	
	/*==============location autocomplete==================*/
	
	function get_drop_value_l()
	{
		var layer_one_type = jQuery('#layer_one_type').val();
		if(layer_one_type == 7)
		{
			var html = '<select id="layer_one_percent" name="layer_one_percent"><option value="N/A">N/A</option><option value="L.O.D">&lt;L.O.D</option><option value="Not Analyzed">Not Analyzed</option><option value="None Detected">None Detected</option></select>';
			jQuery('#layer_one_percent_td').html(html);
		}else{
			var html = '<input autocomplete="off" class="span1" type="text" name="layer_one_percent" id="layer_one_percent" value="">';
			jQuery('#layer_one_percent_td').html(html);
		}
	}
	
	function get_drop_value_l2()
	{
		var layer_two_type = jQuery('#layer_two_type').val();
		if(layer_two_type == 7)
		{
			var html = '<select id="layer_two_percent" name="layer_two_percent"><option value="N/A">N/A</option><option value="L.O.D">&lt;L.O.D</option><option value="Not Analyzed">Not Analyzed</option><option value="None Detected">None Detected</option></select>';
			jQuery('#layer_two_percent_td').html(html);
		}else{
			var html = '<input autocomplete="off" class="span1" type="text" name="layer_two_percent" id="layer_two_percent" value="">';
			jQuery('#layer_two_percent_td').html(html);
		}
	}
	
	function get_location(object){
		jQuery.ajax({
		type: "POST",
		url: base_url+"sample/list_location_fn/<?php echo $bid;?>",
		data:'keyword='+jQuery(object).val(),
		beforeSend: function(){
			jQuery("#location_id").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			jQuery("#suggesstion-box").show();
			jQuery("#suggesstion-box").html(data);
			jQuery("#location_id").css("background","#FFF");
		}
		});
	}
	
	function selectlocation(val) {
		jQuery("#location_id").val(val);
		jQuery("#suggesstion-box").hide();
	}
	
	/*======EDit====*/
	function get_location_edit(object){
		jQuery.ajax({
		type: "POST",
		url: base_url+"sample/list_location_fn_edit/<?php echo $bid;?>",
		data:'keyword='+jQuery(object).val(),
		beforeSend: function(){
			jQuery("#save_field").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			jQuery("#suggesstion-box").show();
			jQuery("#suggesstion-box").html(data);
			jQuery("#save_field").css("background","#FFF");
		}
		});
	}
	
	function selectlocation_edit(val) {
		jQuery("#save_field").val(val);
		jQuery("#suggesstion-box").hide();
	}
	/*================= / This is auto complete for Locations=====================*/
	
	/*=================This is auto complete for materials=====================*/
	
	function get_material(object){
		jQuery.ajax({
		type: "POST",
		url: base_url+"sample/list_material_fn/<?php echo $bid;?>",
		data:'keyword='+jQuery(object).val(),
		beforeSend: function(){
			jQuery("#mat_id").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			jQuery("#suggesstion-box1").show();
			jQuery('.action-table').addClass('drop');
			jQuery("#suggesstion-box1").html(data);
			jQuery("#mat_id").css("background","#FFF");
		}
		});
	}
	
	function selectmaterial( val, id ) {
		jQuery("#mat_id").val(val);
		jQuery("#mat_id").attr('data-id',id);
		jQuery('.action-table').removeClass('drop');
		jQuery("#suggesstion-box1").hide();
		
		jQuery.ajax({
			type: "POST",
			url: base_url+"sample/check_system_mat_identy/<?php echo $bid;?>",
			data:'system_id='+id,
				success: function(data){
					data = jQuery.parseJSON(data);
					jQuery('#mat_identy').html(data);
				}
			});
	}
	
	
	function get_material_edit(object){
		jQuery.ajax({
		type: "POST",
		url: base_url+"sample/list_material_fn_edit/<?php echo $bid;?>",
		data:'keyword='+jQuery(object).val(),
		beforeSend: function(){
			jQuery("#save_field").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			jQuery("#suggesstion-box1").show();
			jQuery("#suggesstion-box1").html(data);
			jQuery("#save_field").css("background","#FFF");
		}
		});
	}
	
	function selectmaterial_edit( val, id ) {
		jQuery("#save_field").val(val);
		jQuery("#save_field").attr('data-id',id);
		jQuery("#suggesstion-box1").hide();
	}
	/*================= / This is auto complete for materials=====================*/
	
	/*=================system select=============================*/
		
		function system_id()
		{
			var vals = jQuery("#system").val();
		}
		
		function mat_desc()
		{
			
			var material_id = jQuery("#mat_id").attr('data-id');
			var vals = jQuery("#mat_identy").val();
			
			var material_data = { 'material_id' : material_id, 'material_identy' : vals }
			
			jQuery.ajax({
			type: "POST",
			url: base_url+"sample/check_mat_desc/<?php echo $bid;?>",
			data: material_data,
				success: function(data){
					console.log(data);
					data = jQuery.parseJSON(data);
					jQuery('#mat_identy_desc').html(data);
				}
			});
		}
		
	
	function addSubRow(rowID,sid){
		var x = 1;
		var max_fields      = 10;
		var assignedRoleId = new Array();
		var assignedRolevalue = new Array();
		jQuery('#systems option').each(function(){
			assignedRoleId.push(this.value);
			assignedRolevalue.push(this.text);
		});	
	
		
		
		var numbers = assignedRoleId;
		var numbersd = assignedRolevalue;
		var option = '';
		for (var i=0;i < numbers.length;i++){
		   option += '<option value="'+ numbers[i] + '">' + numbersd[i] + '</option>';
		}
		
		if(x < max_fields){
			x++;
			jQuery(rowID).find('td').each(function(){
				jQuery(this).attr('rowspan', parseInt(jQuery(this).attr('rowspan')) + 1);
			});
			/* jQuery(rowID).after('<tr id="myTableRow"><td><input class="span1" type="text" name="sample_number" id="sample_number" value=""></td><td><input class="span1" type="text" id="location_id" name="location_id" onkeyup="return get_location(this);" value=""><div id="suggesstion-box"></div></td><td><select onChange="return system_id()" name="system" id="system">'+option+'</select></td><td><input class="span1" type="text" onkeyup="return get_material(this);" name="mat_id" id="mat_id" value=""><div id="suggesstion-box1"></div></td><td><select onChange="return mat_desc()" id="mat_identy" name="mat_identy"></select></td><td><textarea name="mat_identy_desc" id="mat_identy_desc"></textarea></td><td></td><td></td><td></td><td><input type="hidden" name="sid" id="sid" value="'+sid+'"></td><td><textarea id="comments" name="comments"></textarea></td><td><a href="javascript:void(0);" onclick="save_sample_data()" id="save_sample_number" class="btn btn-small btn-primary">Save</a><a href="javascript:void(0);" onclick="remove_row('+sid+')" class="remove_field btn btn-small btn-primary">Remove</a></td></tr>'); */
			
			/*========Getting autofill data==========*/
		
			var sids = {'sid' : sid}

			jQuery.ajax({
					type: "POST",
					url: base_url+"sample/get_sample_data_first_child",
					data: sids,
						success: function(response){
							console.log(response);
							jQuery(rowID).after(response);
						}
			});
			/*============== / End ======================*/
			
		}
	}
	
	function save_sample_data()
	{
		
		var sample_number 	= jQuery( '#sample_number' ).val();
		var location_id 	= jQuery( '#location_id' ).val();
		var system 			= jQuery( '#system' ).val();
		var mat_id 			= jQuery( '#mat_id' ).attr('data-id');
		var mat_identy 		= jQuery( '#mat_identy' ).val();
		
		var layer_one_type 			= jQuery( '#layer_one_type' ).val();
		var layer_one_percent 		= jQuery( '#layer_one_percent' ).val();
		var layer_two_type 			= jQuery( '#layer_two_type' ).val();
		var layer_two_percent 		= jQuery( '#layer_two_percent' ).val();
		
		var comments 		= jQuery( '#comments' ).val();
		var sid 			= jQuery( '#sids' ).val();
		
		
		var error = 0;
		if( sample_number == '' )
		{
			error = 1;
			jQuery( '#sample_number' ).css('border-color', 'red');
		}else{
			jQuery( '#sample_number' ).css('border-color', '');
		}
		
		if( location_id == '' )
		{
			error = 1;
			jQuery( '#location_id' ).css('border-color', 'red');
		}else{
			jQuery( '#location_id' ).css('border-color', '');
		}
		if( system == '' || system == 'Please Select' )
		{
			error = 1;
			jQuery( '#system' ).css('border-color', 'red');
		}else{
			jQuery( '#system' ).css('border-color', '');
		}
		if( typeof( mat_id ) == "undefined" || mat_id == '' )
		{
			error = 1;
			jQuery( '#mat_id' ).css('border-color', 'red');
		}else{
			jQuery( '#mat_id' ).css('border-color', '');
		}
		if( mat_identy == '' || mat_identy == 'Please Select' )
		{
			error = 1;
			jQuery( '#mat_identy' ).css('border-color', 'red');
		}else{
			
			jQuery( '#mat_identy' ).css('border-color', '');
		}
		if( layer_one_type == 'Please Select')
		{
			layer_one_type = '7';
		}
		if( layer_two_type == 'Please Select')
		{
			layer_two_type = '7';
		}
		
		
		
		var location_name = { 'location_id' : location_id }
			jQuery.ajax({
				type: "POST",
				url: base_url+"sample/check_location/<?php echo $bid;?>",
				data: location_name,
					success: function(data)
					{
						console.log(data);
						if(data=='error')
						{
								//alert('No Location found! Please Check and put it again!');
								jQuery( '#location_id' ).css('border-color', 'red');
								error = 1;
						}	
						if( error == 0 )
						{
							jQuery('.load-wrapper').show();
							jQuery('#load').html(loaderimg);
							var myKeyVals = { 'sample_number' : sample_number, 'location_id' : location_id, 'system' : system, 'mat_id' : mat_id,'mat_identy' : mat_identy, 'comments' : comments, 'sid' : sid, 'layer_one_type' : layer_one_type, 'layer_one_percent' : layer_one_percent, 'layer_two_type' : layer_two_type, 'layer_two_percent' : layer_two_percent }
						
							jQuery.ajax({
								type: "POST",
								url: base_url+"sample/add_sampledata_number/<?php echo $bid;?>",
								data: myKeyVals,
									success: function(data){
										jQuery('.load-wrapper').show();
										jQuery('#load').hide();
										console.log(data);
										if(data=='success')
										{
											location.reload();
										}
									}
							});
						}
					}
			});		
	}
	
	function remove_row( sampID )
	{
		var rowID = '#sample-id-'+sampID;
		jQuery('#myTableRow').remove();
		location.reload();
	}
	
	function addDBRow( bid )
	{
		var x = 1;
		var max_fields      = 10;
		var assignedRoleId 	= new Array();
		var assignedRolevalue = new Array();
		
		var assignedlayerId 	= new Array();
		var assignedlayervalue = new Array();
		
		jQuery('#systems option').each(function(){
			assignedRoleId.push(this.value);
			assignedRolevalue.push(this.text);
		});	
		
		var numbers = assignedRoleId;
		var numbersd = assignedRolevalue;
		var option = '';
		for (var i=0;i < numbers.length;i++){
		   option += '<option value="'+ numbers[i] + '">' + numbersd[i] + '</option>';
		}
		
		jQuery('#layers option').each(function(){
			assignedlayerId.push(this.value);
			assignedlayervalue.push(this.text);
		});
		
		var numbers_layer = assignedlayerId;
		var numbersd_layer = assignedlayervalue;
		var options = '';
		for (var i=0;i < numbers_layer.length;i++){
		   options += '<option value="'+ numbers_layer[i] + '">' + numbersd_layer[i] + '</option>';
		}
		
		if(x < max_fields){
			x++;
			/* jQuery(rowID).find('td').each(function(){
				jQuery(this).attr('rowspan', parseInt(jQuery(this).attr('rowspan')) + 1);
			}); */
			jQuery('.table-bordered tr:last').after('<tr id="myTableRow"><td></td><td><input autocomplete="off" class="span1" type="text" name="db_sample_number" id="db_sample_number" value=""></td><td><input autocomplete="off" class="span1" type="text" name="sample_number" id="sample_number" value=""></td><td><input autocomplete="off" class="span1" type="text" id="location_id" name="location_id" onkeyup="return get_location(this);" value=""><div id="suggesstion-box"></div></td><td><select onChange="return system_id()" name="system" id="system">'+option+'</select></td><td><input autocomplete="off" class="span1" type="text" onkeyup="return get_material(this);" name="mat_id" id="mat_id" value=""><div id="suggesstion-box1"></div><td><select onChange="return mat_desc()" id="mat_identy" name="mat_identy"></select></td><td><textarea name="mat_identy_desc" id="mat_identy_desc"></textarea></td><td><select onChange="get_drop_value_l();" name="layer_one_type" id="layer_one_type">'+options+'</select></td><td id="layer_one_percent_td"><input autocomplete="off" type="text" name="layer_one_percent" id="layer_one_percent" value=""></td><td><select onChange="get_drop_value_l2();" name="layer_two_type" id="layer_two_type">'+options+'</select></td><td id="layer_two_percent_td"><input autocomplete="off" type="text" name="layer_two_percent" id="layer_two_percent" value=""></td><td><input type="hidden" name="bid" id="bid" value="'+bid+'"></td><td><textarea id="comments" name="comments"></textarea></td><td><a href="javascript:void(0);" onclick="save_sample()" id="save_sample" class="btn btn-small btn-primary">Save</a><a href="javascript:void(0);" onclick="remove_row('+bid+')" class="remove_field btn btn-small btn-primary">Remove</a></td></tr>'); //add input boxes
		}
	}
	
	function save_sample()
	{
		var db_sample 		= jQuery( '#db_sample_number' ).val();
		var bid 			= jQuery( '#bid' ).val();
		
		var sample_number 	= jQuery( '#sample_number' ).val();
		var location_id 	= jQuery( '#location_id' ).val();
		var system 			= jQuery( '#system' ).val();
		var mat_id 			= jQuery( '#mat_id' ).attr('data-id');
		var mat_identy 		= jQuery( '#mat_identy' ).val();
		var comments 		= jQuery( '#comments' ).val();
		
		var layer_one_type 		= jQuery( '#layer_one_type' ).val();
		
		var layer_one_percent 	= jQuery( '#layer_one_percent' ).val();
		var layer_two_type 		= jQuery( '#layer_two_type' ).val();
		var layer_two_percent 	= jQuery( '#layer_two_percent' ).val();
		
		var error = 0;		
		
		if( db_sample == '' )
		{
			error = 1;
			jQuery( '#db_sample_number' ).css('border-color', 'red');
		}else{
			jQuery( '#db_sample_number' ).css('border-color', '');
		}		
		if( sample_number == '' )
		{
			error = 1;
			jQuery( '#sample_number' ).css('border-color', 'red');
		}else{
			jQuery( '#sample_number' ).css('border-color', '');
		}		
		if( location_id == '' )
		{
			error = 1;
			jQuery( '#location_id' ).css('border-color', 'red');
		}else{
			jQuery( '#location_id' ).css('border-color', '');
		}
		if( system == '' || system == 'Please Select' )
		{
			error = 1;
			jQuery( '#system' ).css('border-color', 'red');
		}else{
			jQuery( '#system' ).css('border-color', '');
		}
		if( typeof( mat_id ) == "undefined" || mat_id == '' )
		{
			error = 1;
			jQuery( '#mat_id' ).css('border-color', 'red');
		}else{
			jQuery( '#mat_id' ).css('border-color', '');
		}
		if( mat_identy == '' || mat_identy == 'Please select' )
		{
			error = 1;
			jQuery( '#mat_identy' ).css('border-color', 'red');
		}else{
			
			jQuery( '#mat_identy' ).css('border-color', '');
		}
		
		if( layer_one_type == 'Please Select')
		{
			layer_one_type = '7';
		}
		if( layer_two_type == 'Please Select')
		{
			layer_two_type = '7';
		}
		
		var location_name = { 'location_id' : location_id }
		jQuery.ajax({
				type: "POST",
				url: base_url+"sample/check_location/<?php echo $bid;?>",
				data: location_name,
					success: function(data)
					{
						console.log(data);
						if(data=='error')
						{
								//alert('No Location found! Please Check and put it again!');
								jQuery( '#location_id' ).css('border-color', 'red');
								error = 1;
						}		
						if( error == 0 )
						{
							jQuery('.load-wrapper').show();
							jQuery('#load').html(loaderimg);
							var myKeyVals = { 'db_sample' : db_sample, 'sample_number' : sample_number, 'location_id' : location_id, 'system' : system, 'mat_id' : mat_id, 'mat_identy' : mat_identy, 'comments' : comments, 'bid' : <?php echo $bid;?>, 'layer_one_type' : layer_one_type, 'layer_one_percent' : layer_one_percent, 'layer_two_type' : layer_two_type, 'layer_two_percent' : layer_two_percent }
							
							console.log(myKeyVals);
						
							jQuery.ajax({
								type: "POST",
								url: base_url+"sample/add_dbsample_number",
								data: myKeyVals,
									success: function(data){
										jQuery('.load-wrapper').show();
										jQuery('#load').hide();
										console.log(data);
										if(data=='success')
										{
											location.reload();
										}
									}
							});
						}
						
					}
			});
		
		
		
	}
	
	function dblfunction_percent( identifier )
	{
	
		var smid 		=  jQuery(identifier).attr('data-id');
		var field_name 	=  jQuery(identifier).attr('data-type');
		var data_value 	=  jQuery(identifier).attr('data-value');
		
		if(field_name == 'layer_one_percent'){
			var sid = jQuery(identifier).attr('data-sid');
			var sids = { 'sid' : smid }
			jQuery.ajax({
				type: "POST",
				url: base_url+"sample/check_layer_one_type",
				data: sids,
					success: function(data){
						if( data == '7' )
						{
							var form_html 	= '<span class="inline-edit"><select id="save_field" name="save_field"><option value="N/A">N/A</option><option value="L.O.D">&lt;L.O.D</option><option value="Not Analyzed">Not Analyzed</option><option value="None Detected">None Detected</option></select><input type="hidden" id="smid" name="smid" value="'+smid+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><input type="hidden" id="sid" name="sid" value="'+sid+'"><a href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a href="javascript:void(0);" onclick="return cancel(this);" data-value="'+data_value+'" id="cancel"><i class="icon-remove icon-2"></i></a></span>';
							jQuery( identifier ).after(form_html);
							jQuery( identifier ).hide();
						}else{
							var form_html 	= '<span class="inline-edit"><input autocomplete="off" type="text" id="save_field" name="save_field" value="'+data_value+'"><input type="hidden" id="smid" name="smid" value="'+smid+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><input type="hidden" id="sid" name="sid" value="'+sid+'"><a href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a href="javascript:void(0);" onclick="return cancel(this);" id="cancel" data-value="'+data_value+'" ><i class="icon-remove icon-2"></i></a></span>';
							jQuery( identifier ).after(form_html);
							jQuery( identifier ).hide();
						}
						
					}
			});
			/* var form_html 	= '<span class="inline-edit"><input type="text" id="save_field" name="save_field" value="'+data_value+'"><input type="hidden" id="smid" name="smid" value="'+smid+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><input type="hidden" id="sid" name="sid" value="'+sid+'"><a href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a href="javascript:void(0);" onclick="return cancel(this);" id="cancel" data-value="'+data_value+'" ><i class="icon-remove icon-2"></i></a></span>';	 */
		}else if(field_name == 'layer_two_percent'){
			var sid = jQuery(identifier).attr('data-sid');
			var sids = { 'sid' : smid }
			jQuery.ajax({
				type: "POST",
				url: base_url+"sample/check_layer_two_type",
				data: sids,
					success: function(data){
						console.log(data);
						if( data == '7' )
						{							
							var form_html 	= '<span class="inline-edit"><select id="save_field" name="save_field"><option value="N/A">N/A</option><option value="L.O.D">&lt;L.O.D</option><option value="Not Analyzed">Not Analyzed</option><option value="None Detected">None Detected</option></select><input type="hidden" id="smid" name="smid" value="'+smid+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><input type="hidden" id="sid" name="sid" value="'+sid+'"><a href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a href="javascript:void(0);" onclick="return cancel(this);" data-value="'+data_value+'" id="cancel"><i class="icon-remove icon-2"></i></a></span>';
							jQuery( identifier ).after(form_html);
							jQuery( identifier ).hide();
						}else{ 
							var form_html 	= '<span class="inline-edit"><input autocomplete="off" type="text" id="save_field" name="save_field" value="'+data_value+'"><input type="hidden" id="smid" name="smid" value="'+smid+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><input type="hidden" id="sid" name="sid" value="'+sid+'"><a href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a href="javascript:void(0);" onclick="return cancel(this);" id="cancel" data-value="'+data_value+'" ><i class="icon-remove icon-2"></i></a></span>';
							jQuery( identifier ).after(form_html);
							jQuery( identifier ).hide();
						}
						
					}
			});
			/* var form_html 	= '<span class="inline-edit"><input type="text" id="save_field" name="save_field" value="'+data_value+'"><input type="hidden" id="smid" name="smid" value="'+smid+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><input type="hidden" id="sid" name="sid" value="'+sid+'"><a href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a href="javascript:void(0);" onclick="return cancel(this);" id="cancel" data-value="'+data_value+'" ><i class="icon-remove icon-2"></i></a></span>'; */
		}
		
	}	
	
	function dblfunction( identifier )
	{
	
		var smid 		=  jQuery(identifier).attr('data-id');
		var field_name 	=  jQuery(identifier).attr('data-type');
		var data_value 	=  jQuery(identifier).attr('data-value');
		
		if(field_name == 'mat_id'){
			var form_html 	= '<span class="inline-edit"><input autocomplete="off" type="text" onblur="blurField(this)" onkeyup="return get_material_edit(this);" id="save_field" name="save_field" value="'+data_value+'"><div id="suggesstion-box1"></div><input type="hidden" id="smid" name="smid" value="'+smid+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a href="javascript:void(0)" onclick="save_fields_mat_id()"><i class="icon-ok icon-2"></i></a>&nbsp;<a href="javascript:void(0);" onclick="return cancel(this);" data-value="'+data_value+'" id="cancel"><i class="icon-remove icon-2"></i></a></span>';
		}else if(field_name == 'locationID'){
			var form_html 	= '<span class="inline-edit"><input autocomplete="off" type="text" onkeyup="return get_location_edit(this);" id="save_field" name="save_field" value="'+data_value+'"><div id="suggesstion-box"></div><input type="hidden" id="smid" name="smid" value="'+smid+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a href="javascript:void(0);" onclick="return cancel(this);" data-value="'+data_value+'" id="cancel"><i class="icon-remove icon-2"></i></a></span>';
		}else if(field_name == 's_result'){
			
			var sel1 = ((data_value == 'Confirmed Asbestos') ? "selected" : "");
			var sel2 = ((data_value == 'L.O.D') ? "selected" : "");
			var sel3 = ((data_value == 'None Detected') ? "selected" : "");
			
			var form_html 	= '<span class="inline-edit"><select id="save_field" name="save_field"><option '+sel1+' value="Confirmed Asbestos">Confirmed Asbestos</option><option '+sel2+' value="L.O.D">&lt;L.O.D</option><option '+sel3+' value="None Detected">None Detected</option></select><input type="hidden" id="smid" name="smid" value="'+smid+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a href="javascript:void(0);" onclick="return cancel(this);" data-value="'+data_value+'" id="cancel"><i class="icon-remove icon-2"></i></a></span>';
		}else{
			var form_html 	= '<span class="inline-edit"><input autocomplete="off" type="text" id="save_field" name="save_field" value="'+data_value+'"><input type="hidden" id="smid" name="smid" value="'+smid+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a href="javascript:void(0);" onclick="return cancel(this);" id="cancel" data-value="'+data_value+'" ><i class="icon-remove icon-2"></i></a></span>';
		}
		
		jQuery( identifier ).after(form_html);
		jQuery( identifier ).hide();
		
	}
	
	function cancel(obj)
	{
		var text = jQuery(obj).parent().parent().find('a:first');
		jQuery(text).show();
		jQuery( obj ).parent().parent().html(text);		
	}
	
	function dbl_list_function( identifier )
	{
		var smid 		=  jQuery(identifier).attr('data-id');
		var field_name 	=  jQuery(identifier).attr('data-type');
		var data_value 	=  jQuery(identifier).attr('data-value');
		
		
		var assignedlayerId 	= new Array();
		var assignedlayervalue = new Array();
		
		if(field_name == 'system_id'){
			jQuery('#systems option').each(function(){
				assignedlayerId.push(this.value);
				assignedlayervalue.push(this.text);
			});
		}else{
			jQuery('#layers option').each(function(){
				assignedlayerId.push(this.value);
				assignedlayervalue.push(this.text);
			});
		}
		
		
		var numbers_layer = assignedlayerId;
		var numbersd_layer = assignedlayervalue;
		var opt = '';
		for (var i=0;i < numbers_layer.length;i++){
			var conditions = ((numbersd_layer[i] == data_value) ? "selected" : "");
			opt += '<option '+conditions+' value="'+numbers_layer[i]+'">'+numbersd_layer[i]+'</option>';
		}
		
		var form_html 	= '<span class="inline-edit"><select id="save_field" name="save_field">'+opt+'</select><input type="hidden" id="smid" name="smid" value="'+smid+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a class="savei" href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a href="javascript:void(0)" data-value="'+data_value+'"  id="cancel" onclick="return cancel(this);" ><i class="icon-remove icon-2"></i></a></span>';
		
		jQuery( identifier ).after(form_html);
		jQuery( identifier ).hide();
		
	}
	
	function dbl_list_ide_function( identifier )
	{	
		var system_id 	=  jQuery(identifier).attr('id');
		var smid 		=  jQuery(identifier).attr('data-id');
		var field_name 	=  jQuery(identifier).attr('data-type');
		var data_value 	=  jQuery(identifier).attr('data-value');
		var mat_id 		=  jQuery(identifier).attr('data-jugard');
		var data_sample_id 	=  jQuery(identifier).attr('data-save');
		
		var myKeyVals = { 'system_id' : system_id, 'smid' : smid, 'field_name' : field_name, 'field_value' : data_value, 'sample_id' : mat_id, 'bid' : <?php echo $bid;?>}
		
		
			jQuery.ajax({
				type: "POST",
				url: base_url+"sample/get_identity_list_from_system",
				data: myKeyVals,
					success: function(data){
						console.log(data);
						var form_html 	= '<span class="inline-edit"><select id="save_field" name="save_field">'+data+'</select><input type="hidden" id="smid" name="smid" value="'+data_sample_id+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a id="savei" href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a data-value="'+data_value+'"  href="javascript:void(0)" id="cancel" onclick="return cancel(this);" ><i class="icon-remove icon-2"></i></a></span>';
		
						jQuery( identifier ).after(form_html);
						jQuery( identifier ).hide();
						
					}
			});
			
		
	}
	
	function save_fields()
	{
		var smid 			=  jQuery('#smid').val();
		var field_name 		=  jQuery('#field_name').val();
		var field_value 	=  jQuery('#save_field').val();
		
		var sid 			=  jQuery('#sid').val();
		
		if(sid != ''){
			var myKeyVals = { 'smid' : smid, 'field_name' : field_name, 'field_value' : field_value, 'bid' : <?php echo $bid;?>, 'sid' : sid}
		}else{
			var myKeyVals = { 'smid' : smid, 'field_name' : field_name, 'field_value' : field_value, 'bid' : <?php echo $bid;?>}
		}
		
			jQuery.ajax({
				type: "POST",
				url: base_url+"sample/update_sampledata_field",
				data: myKeyVals,
					success: function(data){
						console.log(data);
						if( data=='success' )
						{
							location.reload( );
						}
						if( data == 'error')
						{
							jQuery( '#save_field' ).css('border-color', 'red');
						}
					}
			});
	}
	
	function save_fields_mat_id()
	{
		var smid 			=  jQuery('#smid').val();
		var field_name 		=  jQuery('#field_name').val();
		var field_value 	=  jQuery('#save_field').val();
		var mat_id 			=  jQuery('#save_field').attr('data-id');
		
		var myKeyVals = { 'smid' : smid, 'field_name' : field_name, 'field_value' : field_value, 'mat_id' : mat_id}
		
			jQuery.ajax({
				type: "POST",
				url: base_url+"sample/update_sampledata_field_mat",
				data: myKeyVals,
					success: function(data){
						console.log(data);
						if( data=='success' )
						{
							location.reload( );
						}
					}
			});
	}
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
<?php $session_data_enter = $this->session->userdata('enter_in');
			$client_id_enter = $session_data_enter['client_id'];?>
	<div class="main-inner">
		<div class="container">
			<div class="row">
				
				<div class="span12">
					<div class="widget-contents">
							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th> Portfolio </th>
										<th> District </th>
										<th> Development </th>
										<th> Address </th>
										<th> City/Town </th>
										<th> Building Type </th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $building_name->portfolio;?></td>
										<td><?php echo $building_name->district;?></td>
										<td><?php echo $building_name->development;?></td>
										<td><?php echo $building_name->address;?></td>
										<td><?php echo $building_name->city;?></td>
										<td><?php echo $building_name->building_type;?></td>
									</tr>	
								</tbody>		
							</table>  
					</div>
				</div>
				
				<div class="span12">
					<div class="widget">
						<h3><?php echo $building_name->building_name;?></h3><br/>
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>location/index/<?php echo $bid;?>">Back</a>
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>building/index/<?php echo $client_id_enter; ?>">All Buildings</a>
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>location/index/<?php echo $bid; ?>">All Locations</a>
						
						<a class="btn btn-small btn-primary" style="float:right;margin-right:10px;" href="<?php echo base_url();?>sample/list_trashed_samples/<?php echo $bid;?>" title="Trashed samples">Trashed samples</a>
						
						<a class="btn btn-small btn-primary" style="float:right;margin-right:10px;" href="<?php echo base_url();?>sample/hazard_setting/<?php echo $bid;?>" title="Hazard Settings">Hazard Settings</a>
						
						<a title="Import Samples" class="btn btn-small btn-primary fancybox" style="float:right;margin-right:10px;" href="#inline1">Import samples</a>
						
						<a data-toggle="modal" role="button" style="float:right;margin-right:10px;" class="btn btn-success btn-small add_field_button" href="javascript:void(0)"  title="Add DB Sample" onClick="addDBRow(<?php echo $bid; ?>)">Add DB Sample</a>
						
						<div id="inline1" style="width:400px;display: none;">
							<?php echo form_open_multipart('sample/import'); ?>
								<input type="file" name="filename" value="">
								<input type="hidden" name="bid" value="<?php echo $bid; ?>">
								<input type="submit" name="submit" value="Upload" class="btn btn-small btn-primary" >
							<?php echo form_close();?>
						</div>
						
					</div>
					
					<?php echo form_open('sample/export');?>
						<input type="hidden" name="bid" value="<?php echo $bid;?>">
						<input type="submit" class="btn btn-small btn-primary"  name="export_sample" value="Export Samples">
						
					<div class="widget widget-table action-table">
						<div class="widget-header"> <i class="icon-file"></i>
							<h3>All Materials Identification</h3>
						</div>
						<?php 
							$CI =& get_instance();
						?>
						<!-- /widget-header -->
						<div class="widget-content">
							<table class="table table-striped table-bordered">
							<?php if(isset($list_samples)){  ?>
									<thead>
										<tr>
											<th> Select All <input type="checkbox" id="selecctall" name="select_all" value=""></th>
											<th> Db Sample Number </th>
											
											<th> Sample Number </th>
											<th> Location Number </th>
											<th> System </th>
											<th> Material </th>
											<th> Material Identification </th>
											<th> Material Description </th>
											<th> Layer One Type </th>
											<th> Layer One Percent % </th>
											<th> Layer Two Type </th>
											<th> Layer Two Percent % </th>
											<th> Hazard </th>
											<th> Comments </th>
											<th> </th>
											<th> </th>
										</tr>
									</thead>
								<tbody>
								<?php 
								
								foreach( $list_samples as $list_sample ){
								?>
									<tr id="sample-id-<?php echo $list_sample->s_id; ?>">
										<td rowspan="<?php echo $CI->get_sample_data_count( $list_sample->s_id );?>"><input type="checkbox" name="check[]" id="check" class="check" value="<?php echo $list_sample->s_id; ?>"></td>
										
										<td rowspan="<?php echo $CI->get_sample_data_count( $list_sample->s_id );?>"><a data-type="db_sample" data-id="<?php echo $list_sample->s_id;?>" data-value="<?php echo $list_sample->db_sample;?>" ondblclick="dblfunction(this);"><?php echo $list_sample->db_sample;?></a></td>
										
										<?php $CI->get_sample_data( $list_sample->s_id); ?>
										
									</tr>
									<?php 
									
								}?>
								</tbody>
								
							<?php }else{ ?>
								<thead>
										<tr>
											<th> Select All <input type="checkbox" id="selecctall" name="select_all" value=""></th>
											<th> Db Sample Number </th>
											
											<th> Sample Number </th>
											<th> Location Number </th>
											<th> System </th>
											<th> Material </th>
											<th> Material Identification </th>
											<th> Material Description </th>
											<th> Layer One Type </th>
											<th> Layer One Percent % </th>
											<th> Layer Two Type </th>
											<th> Layer Two Percent % </th>
											<th> Hazard </th>
											<th> Comments </th>
											<th>  </th>
										</tr>
									</thead>
								<tbody>
							<tr></tr>
							</tbody>
							<?php } ?>
							</table>
							<div class="load-wrapper" style="display:none;">
								<div id="load"> </div>
							</div>
							<select name="system[]" id="systems" style="display:none;">
								<option>Please Select</option>
								<?php foreach($list_system as $list_systems){ ?>
									<option value="<?php echo $list_systems->id;?>"><?php echo $list_systems->system_name;?></option>
								<?php } ?>	
							</select>
							<select name="layer_type[]" id="layers" style="display:none;">
								<option>Please Select</option>
								<?php foreach($list_layers as $list_layer){ ?>
									<option onclick="sad();" value="<?php echo $list_layer->layer_id;?>"><?php echo $list_layer->layer_type;?></option>
								<?php } ?>	
							</select>
							
							<?php 
								
							/* }else{
									echo "No Result Found!";
								} */
								?>
								
							
						</div>
						
					</div>
					<?php echo form_close();?>
					<div class="widget">
							<?php //echo $pagination;?>
					</div>
				</div>
			</div>
		</div>
	</div>