<script type="text/javascript">
	var url="<?php echo base_url();?>";
    function delete_confirm( id, bid ){
       var r=confirm( "Are you sure, you want to delete this?" )
        if (r==true)
          window.location = url+"dashboard/remove_material_identy_trashed/"+bid+"/"+id;
        else
          return false;
        }
</script>
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
				<?php $session_data_enter = $this->session->userdata('enter_in');
			$client_id_enter = $session_data_enter['client_id'];?>
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" onclick="goBack()" href="javascript:void(0);">Back</a>
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>dashboard/add_material_identification/<?php echo $bid;?>">Add Material Identification</a>
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>dashboard/trash_material_identification/<?php echo $bid;?>">Trashed materials Identification</a>
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>building/index/<?php echo $client_id_enter; ?>">All Buildings</a>
					</div>
					<h4> These all Material Identification are based on a particular building. </h4>
					<div class="widget widget-table action-table">
						<div class="widget-header"> <i class="icon-file"></i>
							<h3>All Materials Identification</h3>
						</div>
						
						<!-- /widget-header -->
						<div class="widget-content">
							<?php if(isset($list_mat_identy)){  ?>
							<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th> System </th>
											<th> Material Name </th>
											<th> Material Identification </th>
											<th> Material Description </th>
											<th> Action </th>
										</tr>
									</thead>
								<tbody>
								<?php 
								foreach( $list_mat_identy as $list_material ){
								?>
									<tr>
										<td><?php echo $list_material->system_name;?></td>
										<td><?php echo $list_material->material_name;?></td>
										<td><?php echo $list_material->m_identification;?></td>
										<td><?php echo $list_material->m_description;?></td>
										<td class="td-actions">
											<a href="<?php echo base_url();?>dashboard/edit_material_identy/<?php echo $list_material->building_id; ?>/<?php echo $list_material->m_id; ?>" class="btn btn-small btn-success" title="Edit"><i class="btn-icon-only icon-pencil"> </i></a>
											
											<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="javascript:void(0)" onclick="delete_confirm(<?php echo $list_material->m_id; ?>,<?php echo $list_material->building_id; ?>)" title="Delete"><i class="btn-icon-only icon-remove"> </i></a>
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
							<?php //echo $pagination;?>
					</div>
				</div>
			</div>
		</div>
	</div>