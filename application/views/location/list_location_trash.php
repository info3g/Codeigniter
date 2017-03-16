<script type="text/javascript">
	var url="<?php echo base_url();?>";
    function delete_confirm( id ){
       var r=confirm( "Are you sure, you want to permanently delete this?" )
        if (r==true)
          window.location = url+"location/remove_location/"+id+"/<?php echo $building_id;?>";
        else
          return false;
        } 
</script>
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="widget">
						<div style="float:left;width:60%">
							<a class="btn btn-small btn-primary" href="<?php echo base_url();?>location/index/<?php echo $building_id;?>">Back</a>
						</div>
					</div>
					<div class="widget widget-table action-table">
						<div class="widget-header"> <i class="icon-file"></i>
							<h3>All Buildings</h3>
						</div>
						<!-- /widget-header -->
						<div class="widget-content">
							<?php if(isset($list_locations)){ ?>
							<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th> Location Number </th>
											<th> Location Name </th>
											<th> Created </th>
											<th class="td-actions"> </th>
										</tr>
									</thead>
								<tbody>
								<?php 
								foreach($list_locations as $list_location){
								?>
									<tr>
										<td><?php echo $list_location->location_id;?></td>
										<td><?php echo $list_location->location_name;?></td>
										<td><?php echo $list_location->location_added;?></td>
										<td class="td-actions">
											<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="<?php echo base_url();?>location/restore_location/<?php echo $list_location->l_id; ?>/<?php echo $building_id;?>" title="Restore"><i class="fa fa-undo"></i></a>
											<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="javascript:void(0)" onclick="delete_confirm( <?php echo $list_location->l_id; ?> )" title="Delete"><i class="btn-icon-only icon-remove"> </i></a>
										</td>
									</tr>
								<?php } ?>
								
								</tbody>
							</table>  
							<?php }else{
									echo "No Result Found!";
								}
								?>
						</div>
					</div>
					<div class="widget">
							<?php if(isset($pagination)){echo $pagination;}?>
					</div>
				</div>
			</div>
		</div>
	</div>