<script type="text/javascript">
	var url="<?php echo base_url();?>";
    function delete_confirm( id, bid ){
       var r=confirm( "Are you sure, you want to permanently delete this?" )
        if (r==true)
          window.location = url+"dashboard/remove_material/"+bid+"/"+id;
        else
          return false;
        } 
</script>
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>dashboard/materials/<?php echo $bid;?>">Back</a>
					</div>
					<div class="widget widget-table action-table">
						<div class="widget-header"> <i class="icon-file"></i>
							<h3>All Trashed Materials</h3>
						</div>
						<!-- /widget-header -->
						<div class="widget-content">
							<?php if(isset($list_materials)){  ?>
							<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th> Material Name </th>
											<th> Material Desc </th>
											<th> Action </th>
										</tr>
									</thead>
								<tbody>
								<?php 
								foreach( $list_materials as $list_material ){
								?>
									<tr>
										<td><?php echo $list_material->material_name;?></td>
										<td><?php echo $list_material->material_name;?></td>
										<td class="td-actions">
											<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="<?php echo base_url();?>dashboard/restore_material/<?php echo $list_material->m_building_id; ?>/<?php echo $list_material->id; ?>" title="Restore"><i class="fa fa-undo"></i></a>
											<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="javascript:void(0)" onclick="delete_confirm( <?php echo $list_material->id; ?>,<?php echo $list_material->m_building_id; ?> )" title="Delete"><i class="btn-icon-only icon-remove"> </i></a>
										</td>
									</tr>
								<?php } ?>
								
								</tbody>
							</table>
							<?php 
								
							}else{
									echo "No Result Found!";
								}
								?>
						</div>		
					</div>
					<div class="widget">
							<?php echo $pagination;?>
					</div>
				</div>
			</div>
		</div>
	</div>