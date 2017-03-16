<script type="text/javascript">
	var base_url="<?php echo base_url();?>";
    function delete_confirm( id )
	{
       var r=confirm( "Are you sure, you want to delete this permanently?" )
        if (r==true)
          window.location = base_url+"sample/remove_sample_permanent/"+id;
        else
          return false;
    }
</script>
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>sample/index/<?php echo $bid;?>">Back</a>
					</div>
					
					
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
							<?php if(isset($list_samples)){  ?>
							<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Select All <input type="checkbox" id="selecctall" name="select_all" value=""></th>
											<th> Db Sample Number </th>
											
											<th> Sample Number </th>
											<th> Location Number </th>
											<th> System </th>
											<th> Material Identification </th>
											<th> Material Description </th>
											<th> Layer One Type </th>
											<th> Layer One Percent % </th>
											<th> Layer Two Type </th>
											<th> Layer Two Percent % </th>
											<th> Comments </th>
											<th> Results </th>
											<th> Action </th>
										</tr>
									</thead>
								<tbody>
								<?php 
								$i=1;
								foreach( $list_samples as $list_sample ){
								?>
									<tr id="sample-id-<?php echo $list_sample->s_id; ?>">
										<td rowspan="<?php echo $CI->get_sample_data_count( $list_sample->s_id );?>"><input type="checkbox" name="check[]" id="check" class="check" value="<?php echo $list_sample->s_id; ?>"></td>
										
										<td rowspan="<?php echo $CI->get_sample_data_count( $list_sample->s_id );?>"><?php echo $list_sample->db_sample;?></td>
										
										<?php $rst = $CI->get_sample_data_trashed( $list_sample->s_id); ?>
										
									</tr>
									<?php 
									$i++;
								}?>
								</tbody>
							</table>	
							<select name="system[]" id="systems" style="display:none;">
								<option>Please Select</option>
								<?php foreach($list_system as $list_systems){ ?>
									<option value="<?php echo $list_systems->id;?>"><?php echo $list_systems->system;?></option>
								<?php } ?>	
							</select>
							
							<?php 
								
							}else{
									echo "No Result Found!";
								}
								?>
								
							
						</div>
						
					</div>
					
					<div class="widget">
							<?php //echo $pagination;?>
					</div>
				</div>
			</div>
		</div>
	</div>