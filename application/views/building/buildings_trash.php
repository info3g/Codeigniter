<script type="text/javascript">
	var url="<?php echo base_url();?>";
    function delete_confirm( id, cid ){
       var r=confirm( "Are you sure, you want to permanently delete this?" )
        if (r==true)
          window.location = url+"building/remove_building/"+id+"/"+cid;
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
							<a class="btn btn-small btn-primary" href="<?php echo base_url();?>building/index/<?php echo $cid;?>">Back</a>
						</div>
					</div>
					<div class="widget widget-table action-table">
						<div class="widget-header"> <i class="icon-file"></i>
							<h3>All Buildings</h3>
						</div>
						<!-- /widget-header -->
						<div class="widget-content">
							<?php if(isset($list_building)){ ?>
							<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th> Building Name </th>
											<th> Provision </th>
											<th> Created </th>
											<th class="td-actions"> </th>
										</tr>
									</thead>
								<tbody>
								<?php 
								foreach( $list_building as $list_buildings ){
								?>
									<tr>
										<td><?php echo $list_buildings->building_name;?></td>
										<td><?php echo $list_buildings->region;?></td>
										<td><?php echo $list_buildings->building_added_date;?></td>
										<td class="td-actions">
											<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="<?php echo base_url();?>building/restore_building/<?php echo $list_buildings->id; ?>/<?php echo $cid;?>" title="Restore"><i class="fa fa-undo"></i></a>
											<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="javascript:void(0)" onclick="delete_confirm( <?php echo $list_buildings->id; ?>, <?php echo $cid;?> )" title="Delete"><i class="btn-icon-only icon-remove"> </i></a>
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
				</div>
			</div>
		</div>
	</div>