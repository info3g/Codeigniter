<script type="text/javascript">
	var url="<?php echo base_url();?>";
    function delete_confirm( id, bid ){
       var r=confirm( "Are you sure, you want to delete this?" )
        if (r==true)
          window.location = url+"dashboard/remove_material_trashed/"+bid+"/"+id;
        else
          return false;
        } 
</script>
	<div class="main-inner">
		<div class="container">
			<div class="row">

<?php 
	$session_data_enter = $this->session->userdata('enter_in');
			$client_id_enter = $session_data_enter['client_id'];
	?>
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" onclick="goBack()" href="javascript:void(0);">Back</a>
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>dashboard/add_material/<?php echo $bid;?>">Add New Material</a>
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>dashboard/trashed/<?php echo $bid;?>">Trashed Material</a>
<a class="btn btn-small btn-primary" href="<?php if($client_id_enter !="") { echo base_url();?>building/index/<?php echo $client_id_enter;}else{echo base_url();?>client<?php }?>">Building List</a>
						
						<div style="float:right;">						
							<?php echo form_open( 'dashboard/materials/'.$bid ); ?>
								<input type="text" name="search" value="" class="span2 search" >
								<input type="submit" name="submit" class="btn btn-primary" value="search" >
							<?php echo form_close(); ?>
						</div>	
						
					</div>
					
					<div class="widget widget-table action-table">
						<div class="widget-header"> <i class="icon-file"></i>
							<h3>All Materials</h3>
						</div>
						<!-- /widget-header -->
						<div class="widget-content">
							<?php if(isset($list_materials)){  ?>
							<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th> Material Name </th>
											<th> Material Description </th>
											<th> Action </th>
										</tr>
									</thead>
								<tbody>
								<?php 
								foreach( $list_materials as $list_material ){
								?>
									<tr>
										<td><?php echo $list_material->material_name;?></td>
										<td><?php echo $list_material->material_desc;?></td>
										<td class="td-actions">
											<a href="<?php echo base_url();?>dashboard/edit_material/<?php echo $list_material->m_building_id; ?>/<?php echo $list_material->id; ?>" class="btn btn-small btn-success" title="Edit"><i class="btn-icon-only icon-pencil"> </i></a>
											<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="javascript:void(0)" onclick="delete_confirm(<?php echo $list_material->id; ?>,<?php echo $list_material->m_building_id; ?>)" title="Delete"><i class="btn-icon-only icon-remove"> </i></a>
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
							<?php if(isset($pagination)) { echo $pagination;} ;?>
					</div>
				</div>
			</div>
		</div>
	</div>