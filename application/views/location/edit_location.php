<script>
	var base_url="<?php echo base_url();?>";
	
	function delete_room_data( id )
	{
		 var r=confirm( "Are you sure, you want to delete this?" )
        if (r==true)
          window.location = base_url+"location/remove_room_by_room_data/"+id+"/<?php echo $location_data->l_id;?>";
        else
          return false;
	}

	function get_material(object){
		jQuery.ajax({
		type: "POST",
		url: base_url+"sample/list_material_fn/<?php echo $location_data->building_id;?>",
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
		jQuery("#suggesstion-box1").hide();
		
		jQuery.ajax({
			type: "POST",
			url: base_url+"sample/check_system_mat_identy/<?php echo $location_data->building_id;?>",
			data:'system_id='+id,
				success: function(data){
					data = jQuery.parseJSON(data);
					jQuery('#mat_identy').html(data);
				}
			});
	}
	
	/*=================== Material Description ======================*/
	
	function system_id()
	{
		var vals = jQuery("#system").val();
		/* jQuery.ajax({
		type: "POST",
		url: base_url+"sample/check_system_mat_identy/<?php echo $location_data->building_id;?>",
		data:'system_id='+vals,
			success: function(data){
				data = jQuery.parseJSON(data);
				jQuery('#mat_identy').html(data);
			}
		}); */
	}
	
	function mat_desc()
	{
		
		var material_id = jQuery("#mat_id").attr('data-id');
		var vals = jQuery("#mat_identy").val();
		
		var material_data = { 'material_id' : material_id, 'material_identy' : vals }
		
		jQuery.ajax({
		type: "POST",
		url: base_url+"sample/check_mat_desc/<?php echo $location_data->building_id;?>",
		data: material_data,
			success: function(data){
				data = jQuery.parseJSON(data);
				/* console.log(data); */
				jQuery('#mat_identy_desc').html(data);
			}
		});
	}
	
	function get_rst()
	{
		var dbsample = jQuery("#sample_number").val();
		
		var dbsample_data = { 'dbsample' : dbsample }
		
		jQuery.ajax({
		type: "POST",
		url: base_url+"location/get_db_sample_rst",
		data: dbsample_data,
			success: function(data){
				console.log(data);
				data = jQuery.parseJSON(data);
				if(data.type =='s_rst'){
					jQuery('#s_rst').html(data.rst);
					jQuery('#s_hazard_txt').html(data.hzd);
					jQuery('#s_hazard').val();
				}else{
					jQuery('#s_hazard_txt').html(data.rst);
					jQuery('#s_hazard').val(data.rst);
					jQuery('#s_rst').html(data.rst_both);
				}
			}
		});
	}
	
	function get_rst_edit()
	{
		var dbsample = jQuery("#save_field").val();
		
		var dbsample_data = { 'dbsample' : dbsample }
		
		jQuery.ajax({
		type: "POST",
		url: base_url+"location/get_db_sample_rst",
		data: dbsample_data,
			success: function(data){
				data = jQuery.parseJSON(data);
				console.log(data);
				jQuery('#s_rst').val(data);
			}
		});
	}	
	
	function addLCRow( bid, lid )
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
		
		var assignedaccessId 	= new Array();
		var assignedaccessvalue = new Array();
		
		jQuery('#accesss option').each(function(){
			assignedaccessId.push(this.value);
			assignedaccessvalue.push(this.text);
		});
		
		var numbers_access = assignedaccessId;
		var numbersd_access = assignedaccessvalue;
		var access_opt = '';
		for (var i=0;i < numbers_access.length;i++){
		   access_opt += '<option value="'+ numbers_access[i] + '">' + numbersd_access[i] + '</option>';
		}
		
		var assignedunitsId 	= new Array();
		var assignedunitsvalue = new Array();
		
		jQuery('#unitss option').each(function(){
			assignedunitsId.push(this.value);
			assignedunitsvalue.push(this.text);
		});
		
		var numbers_units = assignedunitsId;
		var numbersd_units = assignedunitsvalue;
		var units_opt = '';
		for (var i=0;i < numbers_units.length;i++){
		   units_opt += '<option value="'+ numbers_units[i] + '">' + numbersd_units[i] + '</option>';
		}
		
		var assigneds_numberId 	= new Array();
		var assigneds_numbervalue = new Array();
		
		jQuery('#sample_numbers option').each(function(){
			assigneds_numberId.push(this.value);
			assigneds_numbervalue.push(this.text);
		});
		
		var numbers_sample_number = assigneds_numberId;
		var numbersd_sample_number = assigneds_numbervalue;
		var samples_opt = '';
		for (var i=0;i < numbers_sample_number.length;i++){
		   samples_opt += '<option value="'+ numbers_sample_number[i] + '">' + numbersd_sample_number[i] + '</option>';
		}
		samples_opt += '<option value="1">0000</option>';
		samples_opt += '<option value="2">9000</option>';
		samples_opt += '<option value="3">9500</option>';
		
		var assignedactionsId 	= new Array();
		var assignedactionsvalue = new Array();
		
		jQuery('#actions option').each(function(){
			assignedactionsId.push(this.value);
			assignedactionsvalue.push(this.text);
		});
		
		var numbers_actions = assignedactionsId;
		var numbersd_actions = assignedactionsvalue;
		var actions_opt = '';
		for (var i=0;i < numbers_actions.length;i++){
		   actions_opt += '<option value="'+ numbers_actions[i] + '">' + numbersd_actions[i] + '</option>';
		}
		
		if(x < max_fields){
			x++;
			/* jQuery(rowID).find('td').each(function(){
				jQuery(this).attr('rowspan', parseInt(jQuery(this).attr('rowspan')) + 1);
			}); */
			/* jQuery('.table-bordered tr:last').after('<tr id="myTableRow"><td></td><td><select onChange="return system_id()" name="system" id="system">'+option+'</select></td><td><input onkeyup="return get_material(this);" type="text" id="mat_id" name="mat_id" value=""><div id="suggesstion-box1"></div></td><td><select onChange="return mat_desc()" id="mat_identy" name="mat_identy"></select></td><td><textarea id="mat_identy_desc" name="mat_identy_desc" ></textarea></td><td><select id="friability" name="friability"><option>Please Select</option><option value="y">Yes</option><option value="n">No</option></select><td><select id="access" name="access">'+access_opt+'</select></td><td><input onkeyup="calculate(this);" class="cal" type="text" name="good" value="" id="good"></td><td><input onkeyup="calculate(this);" class="cal" type="text" name="fair" value="" id="fair"></td><td><input onkeyup="calculate(this);"  class="cal" type="text" name="poor" value="" id="poor"></td><td><input type="text" name="total" value="" id="total"></td><td><select name="units" id="units">'+units_opt+'</select></td><td><input type="text" name="debris" value="" id="debris"></td><td><select name="unit" id="unit">'+units_opt+'</select></td><td><select data-id="" name="sample_rst" id="sample_rst" ><option>Please Select</option><option value="v">V</option><option value="s">S</option></select></td><td><select onchange="return get_rst(this);" data-id="" name="sample_number" id="sample_number" >'+samples_opt+'</select></td><td id="s_rst"></td><td id="s_hazard_txt"></td><td><select name="action" id="action">'+actions_opt+'</select></td><td><a href="javascript:void(0);" onclick="save_room_by_room( '+bid+', '+lid+')" id="save_sample" class="btn btn-small btn-primary">Save</a><a href="javascript:void(0);" onclick="remove_row('+bid+')" class="remove_field btn btn-small btn-primary">Remove</a></td><td></td></tr>'); */
			
			jQuery("html, body").animate({ scrollTop: jQuery(document).height() }, 1000);
		}
	}
	
	function remove_row( sampID )
	{
		var rowID = '#sample-id-'+sampID;
		jQuery('#myTableRow').remove();
		location.reload();
	}
	
	function calculate( obj )
	{
		var sum = 0;
		$(".cal").each(function() {
 
            //add only if the value is number
            if(!isNaN(this.value) && this.value.length!=0) {
                sum += parseFloat(this.value);
            }
 
        });
        $("#total").val(sum.toFixed(2));
	}
	
	function save_room_by_room( bid, lid )
	{
	
		var system_ID 			= jQuery( '#system' ).val();
		var material_ID 		= jQuery( '#mat_id' ).attr('data-id');
		var material_ident 		= jQuery( '#mat_identy' ).val();
		var friability 			= jQuery( '#friability' ).val();
		var access 				= jQuery( '#access' ).val();
		
		var good 				= jQuery( '#good' ).val();
		var fair 				= jQuery( '#fair' ).val();
		var poor 				= jQuery( '#poor' ).val();
		var total 				= jQuery( '#total' ).val();
		
		var units 				= jQuery( '#units' ).val();
		var debris 				= jQuery( '#debris' ).val();
		var unit 				= jQuery( '#unit' ).val();
		
		var sample_rst 			= jQuery( '#sample_rst' ).val();
		var s_number 			= jQuery( '#sample_number' ).val();
		var rst 				= jQuery( '#s_rst' ).text();
		var r_hazzard 			= jQuery( '#s_hazard_txt' ).text();
		var action 				= jQuery( '#action' ).val();
		
		
		var error = 0;
		
		if( system_ID == '' || system_ID == 'Please Select' )
		{
			error = 1;
			jQuery( '#system' ).css('border-color', 'red');
		}else{
			jQuery( '#system' ).css('border-color', '');
		}
		
		if( typeof( material_ID ) == "undefined" || material_ID == '' )
		{
			error = 1;
			jQuery( '#mat_id' ).css('border-color', 'red');
		}else{
			jQuery( '#mat_id' ).css('border-color', '');
		}
		
		if( material_ident == '' || material_ident == 'Please Select' )
		{
			error = 1;
			jQuery( '#mat_identy' ).css('border-color', 'red');
		}else{
			
			jQuery( '#mat_identy' ).css('border-color', '');
		}
		
		
			if( error == 0 )
			{
				/* jQuery('.load-wrapper').show();
				jQuery('#load').html(loaderimg); */
				
				var myKeyVals = { 'building_ID' : bid, 'location_ID' : lid, 'system_ID' : system_ID, 'material_ID' : material_ID,'material_ident' : material_ident, 'friability' : friability, 'access' : access, 'good' : good, 'fair' : fair, 'poor' : poor, 'total' : total, 'units' : units, 'debris' : debris, 'unit' : unit, 'sample_rst' : sample_rst,'s_number' : s_number, 'rst' : rst,'r_hazard':r_hazzard, 'action' : action }
			
				jQuery.ajax({
					type: "POST",
					url: base_url+"location/add_rmr_data",
					data: myKeyVals,
						success: function(data){
							console.log(data);
							/* jQuery('.load-wrapper').show();
							jQuery('#load').hide();	 */						
							if(data=='success')
							{
								location.reload();
							}
						}
				});
			}	
				
	}
	
	function add_sub_LCRow( roomID, chidID )
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
		
		var assignedaccessId 	= new Array();
		var assignedaccessvalue = new Array();
		
		jQuery('#accesss option').each(function(){
			assignedaccessId.push(this.value);
			assignedaccessvalue.push(this.text);
		});
		
		var numbers_access = assignedaccessId;
		var numbersd_access = assignedaccessvalue;
		var access_opt = '';
		for (var i=0;i < numbers_access.length;i++){
		   access_opt += '<option value="'+ numbers_access[i] + '">' + numbersd_access[i] + '</option>';
		}
		
		var assignedunitsId 	= new Array();
		var assignedunitsvalue = new Array();
		
		jQuery('#unitss option').each(function(){
			assignedunitsId.push(this.value);
			assignedunitsvalue.push(this.text);
		});
		
		var numbers_units = assignedunitsId;
		var numbersd_units = assignedunitsvalue;
		var units_opt = '';
		for (var i=0;i < numbers_units.length;i++){
		   units_opt += '<option value="'+ numbers_units[i] + '">' + numbersd_units[i] + '</option>';
		}
		
		var assigneds_numberId 	= new Array();
		var assigneds_numbervalue = new Array();
		
		jQuery('#sample_numbers option').each(function(){
			assigneds_numberId.push(this.value);
			assigneds_numbervalue.push(this.text);
		});
		
		var numbers_sample_number = assigneds_numberId;
		var numbersd_sample_number = assigneds_numbervalue;
		var samples_opt = '';
		for (var i=0;i < numbers_sample_number.length;i++){
		   samples_opt += '<option value="'+ numbers_sample_number[i] + '">' + numbersd_sample_number[i] + '</option>';
		}
		samples_opt += '<option value="1">0000</option>';
		samples_opt += '<option value="2">9000</option>';
		samples_opt += '<option value="3">9500</option>';
		
		var assignedactionsId 	= new Array();
		var assignedactionsvalue = new Array();
		
		jQuery('#actions option').each(function(){
			assignedactionsId.push(this.value);
			assignedactionsvalue.push(this.text);
		});
		
		var numbers_actions = assignedactionsId;
		var numbersd_actions = assignedactionsvalue;
		var actions_opt = '';
		for (var i=0;i < numbers_actions.length;i++){
		   actions_opt += '<option value="'+ numbers_actions[i] + '">' + numbersd_actions[i] + '</option>';
		}
		
		if(x < max_fields){
			x++;
			/* jQuery(roomID).find('td').each(function(){
				jQuery(this).attr('rowspan', parseInt(jQuery(this).attr('rowspan')) + 1);
			});  */
			jQuery(roomID).after('<tr id="myTableRow"><td></td><td><select onChange="return system_id()" name="system" id="system">'+option+'</select></td><td><input onkeyup="return get_material(this);" type="text" id="mat_id" name="mat_id" value=""><div id="suggesstion-box1"></div></td><td><select onChange="return mat_desc()" id="mat_identy" name="mat_identy"></select></td><td><textarea id="mat_identy_desc" name="mat_identy_desc" ></textarea></td><td><select id="friability" name="friability"><option>Please Select</option><option value="y">Yes</option><option value="n">No</option></select><td><select id="access" name="access">'+access_opt+'</select></td><td><input onkeyup="calculate(this);" class="cal" type="text" name="good" value="" id="good"></td><td><input onkeyup="calculate(this);" class="cal" type="text" name="fair" value="" id="fair"></td><td><input onkeyup="calculate(this);"  class="cal" type="text" name="poor" value="" id="poor"></td><td><input type="text" name="total" value="" id="total"></td><td><select name="units" id="units">'+units_opt+'</select></td><td><input type="text" name="debris" value="" id="debris"></td><td><select name="unit" id="unit">'+units_opt+'</select></td><td><select data-id="" name="sample_rst" id="sample_rst" ><option>Please Select</option><option value="v">V</option><option value="s">S</option></select></td><td><select onchange="return get_rst(this);" data-id="" name="sample_number" id="sample_number" >'+samples_opt+'</select></td><td id="s_rst"></td><td id="s_hazard_txt"></td><td><select name="action" id="action">'+actions_opt+'</select></td><td><a href="javascript:void(0);" onclick="save_room_by_room_sub( '+chidID+')" id="save_sample" class="btn btn-small btn-primary">Save</a><a href="javascript:void(0);" onclick="remove_row('+chidID+')" class="remove_field btn btn-small btn-primary">Remove</a></td><td></td></tr>');
		}
	}
	
	function save_room_by_room_sub( chidID )
	{
		
		var building_ID 		= <?php echo $location_data->building_id;?>;
		var location_ID 		= <?php echo $location_data->l_id ;?>;
		var system_ID 			= jQuery( '#system' ).val();
		var material_ID 		= jQuery( '#mat_id' ).attr('data-id');
		var material_ident 		= jQuery( '#mat_identy' ).val();
		var friability 			= jQuery( '#friability' ).val();
		var access 				= jQuery( '#access' ).val();
		
		var good 				= jQuery( '#good' ).val();
		var fair 				= jQuery( '#fair' ).val();
		var poor 				= jQuery( '#poor' ).val();
		var total 				= jQuery( '#total' ).val();
		
		var units 				= jQuery( '#units' ).val();
		var debris 				= jQuery( '#debris' ).val();
		var unit 				= jQuery( '#unit' ).val();
		
		var sample_rst 			= jQuery( '#sample_rst' ).val();
		var s_number 			= jQuery( '#sample_number' ).val();
		var rst 				= jQuery( '#s_rst' ).text();
		var r_hazzard 			= jQuery( '#s_hazard_txt' ).text();
		var action 				= jQuery( '#action' ).val();
		
		
		var error = 0;
		
		if( system_ID == '' || system_ID == 'Please Select' )
		{
			error = 1;
			jQuery( '#system' ).css('border-color', 'red');
		}else{
			jQuery( '#system' ).css('border-color', '');
		}
		
		if( typeof( material_ID ) == "undefined" || material_ID == '' )
		{
			error = 1;
			jQuery( '#mat_id' ).css('border-color', 'red');
		}else{
			jQuery( '#mat_id' ).css('border-color', '');
		}
		
		if( material_ident == '' || material_ident == 'Please Select' )
		{
			error = 1;
			jQuery( '#mat_identy' ).css('border-color', 'red');
		}else{
			
			jQuery( '#mat_identy' ).css('border-color', '');
		}
		
		if( sample_number == '' || sample_number == 'Please Select')
		{
			error = 1;
			jQuery( '#sample_number' ).css('border-color', 'red');
		}else{
			jQuery( '#sample_number' ).css('border-color', '');
		}
		
		
			if( error == 0 )
			{
				/* jQuery('.load-wrapper').show();
				jQuery('#load').html(loaderimg); */
				
				var myKeyVals = { 'building_ID': building_ID, 'location_ID' : location_ID, 'system_ID' : system_ID, 'material_ID' : material_ID,'material_ident' : material_ident, 'friability' : friability, 'access' : access, 'good' : good, 'fair' : fair, 'poor' : poor, 'total' : total, 'units' : units, 'debris' : debris, 'unit' : unit, 'sample_rst' :sample_rst,'s_number' : s_number, 'rst' : rst, 'r_hazard':r_hazzard, 'action' : action, 'parent' :chidID }
			
				jQuery.ajax({
					type: "POST",
					url: base_url+"location/add_rmr_data_child",
					data: myKeyVals,
						success: function(data){
							console.log(data);
							/* jQuery('.load-wrapper').show();
							jQuery('#load').hide();	 */						
							if(data=='success')
							{
								location.reload();
							}
						}
				});
			}
	}
	
	/*========================Double Click Functions =================================================*/
	
	
	function dbl_list_function( identifier )
	{
		var roomID 		=  jQuery(identifier).attr('data-id');
		var field_name 	=  jQuery(identifier).attr('data-type');
		var data_value 	=  jQuery(identifier).attr('data-value');
		
		var assignedlayerId 	= new Array();
		var assignedlayervalue = new Array();
		
		if(field_name == 'system_ID'){
			jQuery('#systems option').each(function(){
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
		
		var form_html 	= '<span class="inline-edit"><select id="save_field" name="save_field">'+opt+'</select><input type="hidden" id="roomID" name="roomID" value="'+roomID+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a class="savei" href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a href="javascript:void(0)" data-value="'+data_value+'"  id="cancel" onclick="return cancel(this);" ><i class="icon-remove icon-2"></i></a></span>';
		
		jQuery( identifier ).after(form_html);
		jQuery( identifier ).hide();
		
	}
	
	function cancel(obj)
	{
		var text = jQuery(obj).parent().parent().find('a:first');
		jQuery(text).show();
		jQuery( obj ).parent().parent().html(text);		
	}
	
	function save_fields( )
	{
		var roomID 			=  jQuery('#roomID').val();
		var field_name 		=  jQuery('#field_name').val();
		var field_value 	=  jQuery('#save_field').val();
		
		var myKeyVals = { 'roomID' : roomID, 'field_name' : field_name, 'field_value' : field_value}
		
			jQuery.ajax({
				type: "POST",
				url: base_url+"location/update_sytem_field",
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
	
	function save_field_s_numb()
	{
		var roomID 			=  jQuery('#roomID').val();
		var field_name 		=  jQuery('#field_name').val();
		var field_value 	=  jQuery('#save_field').val();
		var rst 			=  jQuery('#s_rst').val();
		
		var myKeyVals = { 'roomID' : roomID, 'field_name' : field_name, 'field_value' : field_value, 'rst': rst}
		
			jQuery.ajax({
				type: "POST",
				url: base_url+"location/update_sytem_field_sample_id",
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
	
	function dblfunction( identifier )
	{
	
		var roomID 		=  jQuery(identifier).attr('data-id');
		var field_name 	=  jQuery(identifier).attr('data-type');
		var data_value 	=  jQuery(identifier).attr('data-value');
		
		if( field_name == 'material_ID' ){
			var form_html 	= '<span class="inline-edit"><input type="text" onblur="blurField(this)" onkeyup="return get_material_edit(this);" id="save_field" name="save_field" value="'+data_value+'"><div id="suggesstion-box1"></div><input type="hidden" id="roomID" name="roomID" value="'+roomID+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a href="javascript:void(0)" onclick="save_fields_mat_id()"><i class="icon-ok icon-2"></i></a>&nbsp;<a href="javascript:void(0);" onclick="return cancel(this);" data-value="'+data_value+'" id="cancel"><i class="icon-remove icon-2"></i></a></span>';
		}else if( field_name == 'material_identi' ){
			var m_id 	=  jQuery(identifier).attr('id');
			var bid = <?php echo $location_data->building_id;?>;
			var myKeyVals = { 'roomID' : roomID, 'field_name' : field_name, 'field_value' : data_value, 'material_id' : m_id, 'bid' : bid}
		
			jQuery.ajax({
				type: "POST",
				url: base_url+"location/get_identity_list_from_mat",
				data: myKeyVals,
					success: function(data){
						console.log(data);
						var form_html 	= '<span class="inline-edit"><select id="save_field" name="save_field">'+data+'</select><input type="hidden" id="roomID" name="roomID" value="'+roomID+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a id="savei" href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a data-value="'+data_value+'"  href="javascript:void(0)" id="cancel" onclick="return cancel(this);" ><i class="icon-remove icon-2"></i></a></span>';
		
						jQuery( identifier ).after(form_html);
						jQuery( identifier ).hide();
						
					}
			});
		}else if( field_name == 'friability' ){
		
			var condition1 = ((data_value == 'y') ? "selected" : "");
			var condition2 = ((data_value == 'n') ? "selected" : "");
			
			var form_html 	= '<span class="inline-edit"><select id="save_field" name="save_field"><option '+condition1+' value="y">Yes</option><option  '+condition2+' value="n">No</option></select><input type="hidden" id="roomID" name="roomID" value="'+roomID+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a id="savei" href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a data-value="'+data_value+'"  href="javascript:void(0)" id="cancel" onclick="return cancel(this);" ><i class="icon-remove icon-2"></i></a></span>';
		
		}else if( field_name == 'access' ){
			var assignedaccessId 	= new Array();
			var assignedaccessvalue = new Array();
			
			jQuery('#accesss option').each(function(){
				assignedaccessId.push(this.value);
				assignedaccessvalue.push(this.text);
			});
			
			var numbers_access = assignedaccessId;
			var numbersd_access = assignedaccessvalue;
			var access_opt = '';
			for (var i=0;i < numbers_access.length;i++){
				var condition = ((numbers_access[i] == data_value) ? "selected" : "");
			   access_opt += '<option '+condition+' value="'+ numbers_access[i] + '">' + numbersd_access[i] + '</option>';
			}
			
			var form_html 	= '<span class="inline-edit"><select id="save_field" name="save_field">'+access_opt+'</select><input type="hidden" id="roomID" name="roomID" value="'+roomID+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a id="savei" href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a data-value="'+data_value+'"  href="javascript:void(0)" id="cancel" onclick="return cancel(this);" ><i class="icon-remove icon-2"></i></a></span>';
		}else if( field_name == 'good' ){
			var form_html 	= '<span class="inline-edit"><input type="text" id="save_field" name="save_field" value="'+data_value+'"><input type="hidden" id="roomID" name="roomID" value="'+roomID+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a href="javascript:void(0);" onclick="return cancel(this);" data-value="'+data_value+'" id="cancel"><i class="icon-remove icon-2"></i></a></span>';
		}else if( field_name == 'fair' ){
			var form_html 	= '<span class="inline-edit"><input type="text" id="save_field" name="save_field" value="'+data_value+'"><input type="hidden" id="roomID" name="roomID" value="'+roomID+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a href="javascript:void(0);" onclick="return cancel(this);" data-value="'+data_value+'" id="cancel"><i class="icon-remove icon-2"></i></a></span>';
		}else if( field_name == 'poor' ){
			var form_html 	= '<span class="inline-edit"><input type="text" id="save_field" name="save_field" value="'+data_value+'"><input type="hidden" id="roomID" name="roomID" value="'+roomID+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a href="javascript:void(0);" onclick="return cancel(this);" data-value="'+data_value+'" id="cancel"><i class="icon-remove icon-2"></i></a></span>';
		}else if( field_name == 'units'){
			var assignedaccessId 	= new Array();
			var assignedaccessvalue = new Array();
			
			jQuery('#unitss option').each(function(){
				assignedaccessId.push(this.value);
				assignedaccessvalue.push(this.text);
			});
			
			var numbers_access = assignedaccessId;
			var numbersd_access = assignedaccessvalue;
			var unitss_opt = '';
			for (var i=0;i < numbers_access.length;i++){
				var condition = ((numbers_access[i] == data_value) ? "selected" : "");
			   unitss_opt += '<option '+condition+' value="'+ numbers_access[i] + '">' + numbersd_access[i] + '</option>';
			}
			
			var form_html 	= '<span class="inline-edit"><select id="save_field" name="save_field">'+unitss_opt+'</select><input type="hidden" id="roomID" name="roomID" value="'+roomID+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a id="savei" href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a data-value="'+data_value+'"  href="javascript:void(0)" id="cancel" onclick="return cancel(this);" ><i class="icon-remove icon-2"></i></a></span>';
		}else if( field_name == 'unit'){
			var assignedaccessId 	= new Array();
			var assignedaccessvalue = new Array();
			
			jQuery('#unitss option').each(function(){
				assignedaccessId.push(this.value);
				assignedaccessvalue.push(this.text);
			});
			
			var numbers_access = assignedaccessId;
			var numbersd_access = assignedaccessvalue;
			var unitss_opt = '';
			for (var i=0;i < numbers_access.length;i++){
				var condition = ((numbers_access[i] == data_value) ? "selected" : "");
			   unitss_opt += '<option '+condition+' value="'+ numbers_access[i] + '">' + numbersd_access[i] + '</option>';
			}
			
			var form_html 	= '<span class="inline-edit"><select id="save_field" name="save_field">'+unitss_opt+'</select><input type="hidden" id="roomID" name="roomID" value="'+roomID+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a id="savei" href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a data-value="'+data_value+'"  href="javascript:void(0)" id="cancel" onclick="return cancel(this);" ><i class="icon-remove icon-2"></i></a></span>';
		}else if( field_name == 's_number'){
			var assignedaccessId 	= new Array();
			var assignedaccessvalue = new Array();
			
			jQuery('#sample_numbers option').each(function(){
				assignedaccessId.push(this.value);
				assignedaccessvalue.push(this.text);
			});
			
			var numbers_access = assignedaccessId;
			var numbersd_access = assignedaccessvalue;
			var samples_opt = '';
			for (var i=0;i < numbers_access.length;i++){
				var condition = ((numbers_access[i] == data_value) ? "selected" : "");
			   samples_opt += '<option '+condition+' value="'+ numbers_access[i] + '">' + numbersd_access[i] + '</option>';
			}
			samples_opt += '<option value="1">0000</option>';
			samples_opt += '<option value="2">9000</option>';
			samples_opt += '<option value="3">9500</option>';
			
			
			var form_html 	= '<span class="inline-edit"><select onchange="return get_rst_edit(this);" id="save_field" name="save_field">'+samples_opt+'</select><input type="hidden" id="roomID" name="roomID" value="'+roomID+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><input type="hidden" id="s_rst" name="rst" value=""><a id="savei" href="javascript:void(0)" onclick="save_field_s_numb()"><i class="icon-ok icon-2"></i></a>&nbsp;<a data-value="'+data_value+'"  href="javascript:void(0)" id="cancel" onclick="return cancel(this);" ><i class="icon-remove icon-2"></i></a></span>';
		}else if( field_name == 'action'){
			var assignedaccessId 	= new Array();
			var assignedaccessvalue = new Array();
			
			jQuery('#actions option').each(function(){
				assignedaccessId.push(this.value);
				assignedaccessvalue.push(this.text);
			});
			
			var numbers_access = assignedaccessId;
			var numbersd_access = assignedaccessvalue;
			var actions_opt = '';
			for (var i=0;i < numbers_access.length;i++){
				var condition = ((numbers_access[i] == data_value) ? "selected" : "");
			   actions_opt += '<option '+condition+' value="'+ numbers_access[i] + '">' + numbersd_access[i] + '</option>';
			}
			
			var form_html 	= '<span class="inline-edit"><select id="save_field" name="save_field">'+actions_opt+'</select><input type="hidden" id="roomID" name="roomID" value="'+roomID+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a id="savei" href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a data-value="'+data_value+'"  href="javascript:void(0)" id="cancel" onclick="return cancel(this);" ><i class="icon-remove icon-2"></i></a></span>';
		}else if( field_name == 'sample_rst'){
			var form_html 	= '<span class="inline-edit"><select id="save_field" name="save_field"><option>Please Select</option><option value="v">V</option><option value="s">S</option></select><input type="hidden" id="roomID" name="roomID" value="'+roomID+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a id="savei" href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a data-value="'+data_value+'"  href="javascript:void(0)" id="cancel" onclick="return cancel(this);" ><i class="icon-remove icon-2"></i></a></span>';
		}else{
			var form_html 	= '<span class="inline-edit"><input type="text" id="save_field" name="save_field" value="'+data_value+'"><input type="hidden" id="roomID" name="roomID" value="'+roomID+'"><input type="hidden" id="field_name" name="field_name" value="'+field_name+'"><a href="javascript:void(0)" onclick="save_fields()"><i class="icon-ok icon-2"></i></a>&nbsp;<a href="javascript:void(0);" onclick="return cancel(this);" data-value="'+data_value+'" id="cancel"><i class="icon-remove icon-2"></i></a></span>';
		}
		
		jQuery( identifier ).after(form_html);
		jQuery( identifier ).hide();
		
	}
	
	function get_material_edit(object){
		jQuery.ajax({
		type: "POST",
		url: base_url+"location/list_material_fn_edit",
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
	
	function save_fields_mat_id()
	{
		var roomID 			=  jQuery('#roomID').val();
		var field_name 		=  jQuery('#field_name').val();
		var field_value 	=  jQuery('#save_field').val();
		var mat_id 			=  jQuery('#save_field').attr('data-id');
		
		var myKeyVals = { 'roomID' : roomID, 'field_name' : field_name, 'field_value' : field_value, 'mat_id' : mat_id}
		
			jQuery.ajax({
				type: "POST",
				url: base_url+"location/update_field_materail",
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
	
	function copy_notes()
	{
		var location_id = jQuery('#copy_notes').val();
		if(location_id == 'Please Select')
		{
			alert('Please select any Location!');
		}else{
		
			var myKeyVals = { 'location_id' : location_id }
			
				jQuery.ajax({
					type: "POST",
					url: base_url+"location/get_location_notes",
					data: myKeyVals,
						success: function(data){
							if(data!=""){						
								jQuery('#note').val(data);
							}else{
								alert('The Notes for this Location is empty!');
							}	
						}
				});
			}	
	}
	
	function copy_room_by_room_data()
	{
		var location_id = jQuery('#copy_room_by_room_data').val();
		if(location_id == 'Please Select')
		{
			alert('Please select any Location!');
		}else{
		
			var myKeyVals = { 'location_id' : location_id }
			
				jQuery.ajax({
					type: "POST",
					url: base_url+"location/copy_room_by_room_data/<?php echo $location_data->l_id ;?>",
					data: myKeyVals,
						success: function(data){
							console.log(data);
							location.reload( );	
						}
				});
			}
	}
	function show_address_field()
	{
		jQuery('#l_address').toggle();
	}
	
		
	function no_access_click(){
		if (jQuery("#no_access").is(':checked')) {
			jQuery("#note").val("Location was not accessable.");
		}else{
			jQuery("#note").val("");
		}
	}
	function no_survey_click(){	
		if (jQuery("#no_survey").is(':checked')) {
			jQuery("#note").val("Location was not surveyed.");
		}else{
			jQuery("#note").val("");
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
						<a class="btn btn-small btn-primary" onclick="goBack()" href="javascript:void(0);">Back</a>
					</div>
					<div class="widget">
						<div class="widget-header"> <i class="icon-cog"></i>
						  <h3>Update Location</h3>
						</div>
						<?php 
							$CI =& get_instance();
						?>
						<div class="widget-content">
						
							<div class="errors"><?php echo validation_errors(); ?></div>
							<?php 
							echo form_open( 'location/edit_location/'.$location_data->l_id ); ?>
							
							<div class="span12">
								<div class="span4">
									<div class="control-group">														
										<label class="control-label" for="siteTitle">Building Name : <b><?php echo $building_data->building_name; ?><b></label>
									</div>
									
									<!--div class="control-group">														
										<label class="control-label" for="siteTitle">Client Building # : <b><?php //echo $building_data->client_building_id; ?><b></label>
									</div-->
								</div>
								<div class="span4">
									<div class="control-group">														
										<label class="control-label" for="siteTitle">Surveyor : <b><?php echo $building_data->surveyor; ?><b></label>
									</div>
								</div>
							</div>
							
							<div class="span12">	
									<div class="span4">
										<div class="control-group">														
											<label class="control-label" for="siteTitle">Consultant Name : </label>
											<div class="controls">
												<input type="text" name="consultant_name" value="<?php echo $building_data->consultant_name; ?>"" id="consultant_name" class="span4" >
											</div>
										</div>
									</div>
									<div class="span4">
										<div class="control-group">														
											<label class="control-label" for="siteTitle">Last Survey Date : </label>
											<div class="controls">
												<input type="text" name="survey_date" value="<?php echo $building_data->survey_date; ?>" id="datepicker" class="span4" >
											</div>
										</div>
									</div>
									<div class="span4">
										<div class="control-group">														
											<label class="control-label" for="siteTitle">Last Reassessment Date : </label>
											<div class="controls">
												<input type="text" name="reassessment_date" value="<?php echo $building_data->last_reassessment;?>" id="datepicker" class="span4" >
											</div>
										</div>
									</div>
									
								</div>
								
							<div class="span12">
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Floor : </label>
									<div class="controls">
										<input type="text" name="floor" value="<?php echo $location_data->floor;?>" id="floor" class="span5" >
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Square Feet : </label>
									<div class="controls">
										<input type="text" name="square_feet" value="<?php echo $location_data->square_feet;?>" id="square_feet" class="span5" >
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Room Prefix : </label>
									<div class="controls">
										<input type="text" name="room_prefix" value="<?php echo $location_data->room_prefix;?>" id="room_prefix" class="span5" >
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Room # : </label>
									<div class="controls">
										<input type="text" name="room_no" value="<?php echo $location_data->room_no;?>" id="room_no" class="span5" >
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Location Name : </label>
									<div class="controls">
										<input type="text" name="location_name" value="<?php echo $location_data->location_name;?>" id="location_name" class="span5" >
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Location # : </label>
									<div class="controls">
										<input type="text" name="location_id" value="<?php echo $location_data->location_id;?>" id="location_id" class="span5" >
									</div>
								</div>
								
								<div class="control-group">
									<div class="controls">
										<input type="checkbox" onclick="show_address_field();" <?php if($location_data->l_address !=""){echo "checked";}?> name="show_map" value="1"> Show On Map As Building
									</div>
								</div>
								<div class="control-group" id="l_address" <?php if($location_data->l_address ==""){?> style="display:none;" <?php }?>>														
									<label class="control-label" for="siteTitle">Address : </label>
									<div class="controls">
										<input type="text" name="l_address" value="<?php echo $location_data->l_address;?>" id="room_no" class="span5" >
									</div>
								</div>
								
								<!--============/////Validated//////================-->
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Validated? : </label>
									<div class="controls">
										<input type="checkbox" name="validated" value="y" <?php if($location_data->validated == 'y'){echo "checked";}?> /> YES
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">No Access to room? : </label>
									<div class="controls">
										<input type="checkbox" onclick="no_access_click();" id="no_access" name="no_access" value="no_access" <?php if($location_data->no_access == 'no_access'){echo "checked";}?> /> NAR
									</div>
								</div>
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Location Not Surveyed? : </label>
									<div class="controls">
										<input type="checkbox" onclick="no_survey_click();"  id="no_survey" name="no_survey" value="no_survey" <?php if($location_data->no_survey == 'no_survey'){echo "checked";}?> /> NS
									</div>
								</div>
								
								<!--====================/////========================-->
								
								
								<div class="control-group">														
									<label class="control-label" for="siteTitle">Note : </label>
									<div class="controls">
										<textarea name="note" id="note" class="span5" ><?php echo $location_data->note;?></textarea>
										<select name="copy_notes" id="copy_notes" class="span2">
												<option>Please Select</option>
											<?php if(isset($get_all_locations)){
												foreach($get_all_locations as $get_all_location){?>
														<option value="<?php echo $get_all_location->l_id; ?>"><?php echo $get_all_location->location_id;?></option>
											<?php }
											} ?>
										</select>
										<a href="javascript:void(0);" onclick="copy_notes();">Copy Notes</a>
									</div>
									
									<div style="float:left;width:100%;margin-top:17px;">
										<input type="hidden" id="bid" name="bid" value="<?php echo $location_data->building_id;?>">
										<input type="hidden" id="lid" name="lid" value="<?php echo $location_data->l_id;?>">
										<input name="submit" value="Update" id="submit" class="btn btn-primary" type="submit">
									</div>
								</div>
								
								
					<!--=========================== Room By Room Data =======================================-->
					
							<br/><br/><br/>
							
							<div class="control-group">		
								<div class="controls">
									<select name="copy_room_by_room_data" id="copy_room_by_room_data" class="span2">
											<option>Please Select</option>
										<?php if(isset($get_all_locations)){
											foreach($get_all_locations as $get_all_location){?>
													<option value="<?php echo $get_all_location->l_id; ?>"><?php echo $get_all_location->location_id;?></option>
										<?php }
										} ?>
									</select>
									<a href="javascript:void(0);" onclick="copy_room_by_room_data();">Copy Room By Room Data</a>
								</div>
							</div>
					
								<?php 
									$CI =& get_instance();
								?>
								
								<!--<div style="width:1240px; float:left;overflow-x:scroll;">-->
                                <div>
									<a data-toggle="modal" role="button" style="float:right; margin-bottom:12px;" class="btn btn-success btn-small add_field_button" href="javascript:void(0)"  title="Add Data" onClick="addLCRow(<?php echo $location_data->building_id;?>, <?php echo $location_data->l_id;?>)">Add Data</a>
									
								<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th rowspan="2" class="span1"> SN </th>
											<th rowspan="2" class="span1"> System </th>
											<th rowspan="2" class="span1"> Material </th>
											<th rowspan="2" class="span1"> Material <br/>ID </th>
											<th rowspan="2" class="span1"> Material Description </th>											
											<th rowspan="2" class="span1"> Friability <br/>(Y/N)</th>
											<th rowspan="2" class="span1"> Access </th>
											                           
											<th colspan="7" class="span1" style="text-align:center;"> Quantity/Condition </th>
											                           
											<!--th rowspan="2" class="span1"> Sample #</th-->
											<th rowspan="2" colspan="2" class="span1"> Sample <br/>Number </th>
											<th rowspan="2" class="span1"> Results</th>
											<th rowspan="2" class="span1"> Hazard </th>
											<th rowspan="2" class="span1"> Action </th>
											<th rowspan="2" class="span1"> </th>
											<th rowspan="2" class="span1"> Estimated <br/>Cost</th>
										</tr>
										<tr>
											<th class="span1"> Good </th>
											<th class="span1"> Fair </th>
											<th class="span1"> Poor </th>
											<th class="span1"> Total </th>
											<th class="span1"> Units </th>
											<th class="span1"> Debris </th>
											<th class="span1"> Units </th>
										</tr>
									</thead>
									
									
									<tbody>
																					
										<?php if(!empty($list_room_by_room_data))
										{
											$i=1.0;
											foreach( $list_room_by_room_data as $list_room_by_room_datas ){
											?>
											<tr id="room_by-id-<?php echo $list_room_by_room_datas->r_id; ?>">
												<td><?php echo $i.'.0'; ?></td>
												<td>
													<a data-type="system_ID" data-id="<?php echo $list_room_by_room_datas->r_id;?>" data-value="<?php echo $list_room_by_room_datas->system_name;?>" ondblclick="dbl_list_function(this);"><?php echo $list_room_by_room_datas->system_name;?></a>
												</td>
												<td>
													<a data-type="material_ID" data-id="<?php echo $list_room_by_room_datas->r_id;?>" data-value="<?php echo $list_room_by_room_datas->material_name;?>" ondblclick="dblfunction(this);"><?php echo $list_room_by_room_datas->material_name;?></a>
												</td>
												<td>
												<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<a href="javascript:void(0);" data-type="material_identi" data-mat="<?php echo $list_room_by_room_datas->m_id;?>" data-id="<?php echo $list_room_by_room_datas->r_id;?>" id="<?php echo $list_room_by_room_datas->material_ID;?>" data-value="<?php echo $list_room_by_room_datas->m_identification;?>" ondblclick="dblfunction(this);"><?php echo $list_room_by_room_datas->m_identification;?></a>
												<?php } ?>	
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<?php if($list_room_by_room_datas->m_description == "" ){ echo $list_room_by_room_datas->material_desc;}else{echo $list_room_by_room_datas->m_description;}?>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<a data-type="friability" data-id="<?php echo $list_room_by_room_datas->r_id;?>" data-value="<?php echo $list_room_by_room_datas->friability;?>" ondblclick="dblfunction(this);"><?php if(!empty($list_room_by_room_datas->friability)){echo ucfirst($list_room_by_room_datas->friability);}else{echo "Add Friability"; }?></a>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<a data-type="access" data-id="<?php echo $list_room_by_room_datas->r_id;?>" data-value="<?php echo $list_room_by_room_datas->access;?>" ondblclick="dblfunction(this);" ><?php if(!empty($list_room_by_room_datas->access)){echo ucfirst($list_room_by_room_datas->access);}else{echo "Add Access"; }?></a>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<a data-type="good" data-id="<?php echo $list_room_by_room_datas->r_id;?>" data-value="<?php echo $list_room_by_room_datas->good;?>" ondblclick="dblfunction(this);"><?php if(!empty($list_room_by_room_datas->good)){echo $list_room_by_room_datas->good;}else{echo "Add Good"; }?></a>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<a data-type="fair" data-id="<?php echo $list_room_by_room_datas->r_id;?>" data-value="<?php echo $list_room_by_room_datas->fair;?>" ondblclick="dblfunction(this);"><?php if(!empty($list_room_by_room_datas->fair)){ echo $list_room_by_room_datas->fair;}else{echo "Add Fair"; }?></a>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<a data-type="poor" data-id="<?php echo $list_room_by_room_datas->r_id;?>" data-value="<?php echo $list_room_by_room_datas->poor;?>" ondblclick="dblfunction(this);"><?php if(!empty($list_room_by_room_datas->poor)){ echo $list_room_by_room_datas->poor;}else{echo "Add Poor"; }?></a>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<?php echo $list_room_by_room_datas->total;?>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<a data-type="units" data-id="<?php echo $list_room_by_room_datas->r_id;?>" data-value="<?php echo $list_room_by_room_datas->units;?>" ondblclick="dblfunction(this);"><?php if(!empty($list_room_by_room_datas->units)) {$CI->get_units_code( $list_room_by_room_datas->units);}else{echo "Add Units"; }?></a>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<a data-type="debris" data-id="<?php echo $list_room_by_room_datas->r_id;?>" data-value="<?php echo $list_room_by_room_datas->debris;?>" ondblclick="dblfunction(this);"><?php if(!empty($list_room_by_room_datas->debris)) {echo $list_room_by_room_datas->debris;}else{echo "Add Debris"; }?></a>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<a data-type="unit" data-id="<?php echo $list_room_by_room_datas->r_id;?>" data-value="<?php echo $list_room_by_room_datas->unit;?>" ondblclick="dblfunction(this);"><?php if(!empty($list_room_by_room_datas->unit)) {$CI->get_units_code( $list_room_by_room_datas->unit);}else{echo "Add Unit"; }?></a>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<a data-type="sample_rst" data-id="<?php echo $list_room_by_room_datas->r_id;?>" data-value="<?php echo $list_room_by_room_datas->sample_rst;?>" ondblclick="dblfunction(this);"><?php if(!empty($list_room_by_room_datas->sample_rst)) { echo $list_room_by_room_datas->sample_rst;}else{echo "Add Sample Result"; }?></a>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<a data-type="s_number" data-id="<?php echo $list_room_by_room_datas->r_id;?>" data-value="<?php echo $list_room_by_room_datas->s_number;?>" ondblclick="dblfunction(this);"><?php if(!empty($list_room_by_room_datas->db_sample)) { echo $list_room_by_room_datas->db_sample;}else{echo "Add DB Sample"; }?></a>
													<?php } ?>
												</td>
												<td><?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{ echo $list_room_by_room_datas->rst; } ?></td>
												<td><?php echo $list_room_by_room_datas->r_hazard;?></td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<a data-type="action" data-id="<?php echo $list_room_by_room_datas->r_id;?>" data-value="<?php echo $list_room_by_room_datas->action;?>" ondblclick="dblfunction(this);" data-toggle="tooltip" title="<?php echo $list_room_by_room_datas->action_name; ?>" ><?php if(!empty($list_room_by_room_datas->action_number)) { echo $list_room_by_room_datas->action_number;}else{echo "Add Actioin"; }?></a>
													<?php } ?>
												</td>
												<td>
													<a data-toggle="modal" role="button" style="float:right;margin-right:10px;" class="btn btn-success btn-small add_field_button" href="javascript:void(0)" title="Add Data" onClick="add_sub_LCRow('#room_by-id-<?php echo $list_room_by_room_datas->r_id; ?>','<?php echo $list_room_by_room_datas->r_id; ?>')"><i class="icon-plus-sign-alt"></i></a>
													
													<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="javascript:void(0)" onclick="delete_room_data(<?php echo $list_room_by_room_datas->r_id;?>, <?php echo $location_data->l_id;?>)" title="Delete"><i class="btn-icon-only icon-remove"> </i></a>
												</td>
												<td></td>
											</tr>
											
											<!--============Child List==============-->
											<tr>
												<?php $CI->list_room_by_room_data_child( $list_room_by_room_datas->r_id, $location_data->l_id, $i );?>
											</tr>	
											<?php 
											
											$i++;
											}
										} ?>
										
										<tr id="myTableRow"><td></td><td><select onChange="return system_id()" name="system" id="system"><option>Please Select</option><?php foreach($list_system as $list_systems){ ?><option value="<?php echo $list_systems->id;?>"><?php echo $list_systems->system_name;?></option><?php } ?></select></td><td><input onkeyup="return get_material(this);" type="text" id="mat_id" name="mat_id" value=""><div id="suggesstion-box1"></div></td><td><select onChange="return mat_desc()" id="mat_identy" name="mat_identy"></select></td><td><textarea id="mat_identy_desc" name="mat_identy_desc" ></textarea></td><td><select id="friability" name="friability"><option>Please Select</option><option value="y">Yes</option><option value="n">No</option></select><td><select id="access" name="access"><option>Please Select</option><?php foreach($access_list as $access_lists){?>
												<option value="<?php echo $access_lists->access;?>"><?php echo ucfirst($access_lists->access);?>&nbsp; : <?php echo $access_lists->access_desc;?></option>
											<?php } ?></select></td><td><input onkeyup="calculate(this);" class="cal" type="text" name="good" value="" id="good"></td><td><input onkeyup="calculate(this);" class="cal" type="text" name="fair" value="" id="fair"></td><td><input onkeyup="calculate(this);"  class="cal" type="text" name="poor" value="" id="poor"></td><td><input type="text" name="total" value="" id="total"></td><td><select name="units" id="units"><option>Please Select</option><?php foreach($units_list as $units_lists){?>
												<option value="<?php echo $units_lists->u_id;?>"><?php echo $units_lists->unit_code;?></option>
											<?php } ?></select></td><td><input type="text" name="debris" value="" id="debris"></td><td><select name="unit" id="unit"><option>Please Select</option><?php foreach($units_list as $units_lists){?>
												<option value="<?php echo $units_lists->u_id;?>"><?php echo $units_lists->unit_code;?></option>
											<?php } ?></select></td><td><select data-id="" name="sample_rst" id="sample_rst" ><option>Please Select</option><option value="v">V</option><option value="s">S</option></select></td><td><select onchange="return get_rst(this);" data-id="" name="sample_number" id="sample_number" ><option>Please Select</option><?php foreach( $sample_list as $sample_lists ){ ?>
												<option value="<?php echo $sample_lists->s_id; ?>"><?php echo $sample_lists->db_sample; ?></option>
											<?php } ?><option value="1">0000</option><option value="2">9000</option><option value="3">9500</option></select></td><td id="s_rst"></td><td id="s_hazard_txt"></td><td><select name="action" id="action"><option>Please Select</option><?php foreach($action_list as $action_lists){?>
												<option value="<?php echo $action_lists->a_id;?>"><?php echo $action_lists->action_number;?>&nbsp; : <?php echo $action_lists->action_name;?></option>
											<?php } ?></select></td><td><a href="javascript:void(0);" onclick="save_room_by_room( <?php echo $location_data->building_id;?>, <?php echo $location_data->l_id;?>)" id="save_sample" class="btn btn-small btn-primary">Save</a><!--a href="javascript:void(0);" onclick="remove_row(<?php echo $location_data->building_id;?>)" class="remove_field btn btn-small btn-primary">Remove</a--></td><td></td></tr>	
											
										
										<!--========================= Hidden Fields ==============================-->
										<select name="system[]" id="systems" style="display:none;">
											<option>Please Select</option>
											<?php foreach($list_system as $list_systems){ ?>
												<option value="<?php echo $list_systems->id;?>"><?php echo $list_systems->system_name;?></option>
											<?php } ?>	
										</select>
										<select name="layer_type[]" id="layers" style="display:none;">
											<option>Please Select</option>
											<?php foreach($list_layers as $list_layer){ ?>
												<option value="<?php echo $list_layer->layer_id;?>"><?php echo $list_layer->layer_type;?></option>
											<?php } ?>	
										</select>
										<select id="accesss" name="access" style="display:none;">
											<option>Please Select</option>
											<?php foreach($access_list as $access_lists){?>
												<option value="<?php echo $access_lists->access;?>"><?php echo ucfirst($access_lists->access);?>&nbsp; : <?php echo $access_lists->access_desc;?></option>
											<?php } ?>
										</select>
										<select name="units" id="unitss" style="display:none;">
											<option value="0">Please Select</option>
											<?php foreach($units_list as $units_lists){?>
												<option value="<?php echo $units_lists->u_id;?>"><?php echo $units_lists->unit_code;?></option>
											<?php } ?>
										</select>
										<select name="sample_number" id="sample_numbers"  style="display:none;">
											<option>Please Select</option>
											<?php foreach( $sample_list as $sample_lists ){ ?>
												<option value="<?php echo $sample_lists->s_id; ?>"><?php echo $sample_lists->db_sample; ?></option>
											<?php } ?>	
										</select>
										<select name="action" id="actions"  style="display:none;">
											<option value="1">Please Select</option>
											<?php foreach($action_list as $action_lists){?>
												<option value="<?php echo $action_lists->a_id;?>"><?php echo $action_lists->action_number;?>&nbsp; : <?php echo $action_lists->action_name;?></option>
											<?php } ?>
										</select>
										<!--========================= Hidden Fields ==============================-->
									</tbody>	
								</table>
								</div>
								
							<hr>
																
							</div>
							
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