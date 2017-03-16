<div class="main-inner">
<?php 
	$session_data_enter = $this->session->userdata('enter_in');
			$client_id_enter = $session_data_enter['client_id'];
	?>
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" onclick="goBack()" href="javascript:void(0);">Back</a>
						<a data-toggle="modal" role="button" style="float:right;margin-right:10px;" class="btn btn-success btn-small add_field_button" href="<?php echo base_url();?>location/add_unit"  title="Add DB Sample">Add Units</a>
<a data-toggle="modal" role="button" style="float:right;margin-right:10px;" class="btn btn-success btn-small add_field_button" href="<?php if($client_id_enter !="") { echo base_url();?>building/index/<?php echo $client_id_enter;}else{echo base_url();?>client<?php }?>	"  title="Add Actions">Building List</a>
					</div>
					<div class="widget widget-table action-table">
						<div class="widget-header"> <i class="icon-file"></i>
							<h3>All Units</h3>
						</div>
						<!-- /widget-header -->
						<div class="widget-content">
							<?php if(isset($list_unit)){  ?>
							<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th> Unit Code </th>
											<th> Unit Name </th>
											<th>  </th>
										</tr>
									</thead>
								<tbody>
								<?php
								//$i=1;
								foreach( $list_unit as $list_units ){
								?>
									<tr>
										<td><?php echo $list_units->unit_code; ?></td>
										<td><?php echo $list_units->unit_name; ?></td>
										<td>
											<a href="<?php echo base_url();?>location/edit_unit/<?php echo $list_units->u_id; ?>" class="btn btn-small btn-success" title="Edit"><i class="btn-icon-only icon-pencil"> </i></a>
											
											<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="<?php echo base_url();?>location/remove_unit/<?php echo $list_units->u_id; ?>" title="Delete"><i class="btn-icon-only icon-remove"> </i></a>
										</td>										
									</tr>
									<?php 
									//$i++;
								} 
								?>
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