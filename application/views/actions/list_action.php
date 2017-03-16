<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="widget">
<?php 
	$session_data_enter = $this->session->userdata('enter_in');
			$client_id_enter = $session_data_enter['client_id'];
	?>
			<a class="btn btn-small btn-primary" onclick="goBack()" href="javascript:void(0);">Back</a>
			<a data-toggle="modal" role="button" style="float:right;margin-right:10px;" class="btn btn-success btn-small add_field_button" href="<?php echo base_url();?>location/add_action/<?php if(!empty($client_id_enter)){ echo $client_id_enter;} ?>"  title="Add Actions">Add Actions</a>
<a data-toggle="modal" role="button" style="float:right;margin-right:10px;" class="btn btn-success btn-small add_field_button" href="<?php if($client_id_enter !="") { echo base_url();?>building/index/<?php echo $client_id_enter;}else{echo base_url();?>client<?php }?>"  title="Add Actions">Building List</a>
					</div>
					<div class="widget widget-table action-table">
						<div class="widget-header"> <i class="icon-file"></i>
							<h3>All Actions</h3>
						</div>
						<!-- /widget-header -->
						<div class="widget-content">
							<?php if(isset($list_action)){  ?>
							<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th> Action Number </th>
											<th> Action Name </th>
											<th>  </th>
										</tr>
									</thead>
								<tbody>
								<?php 
								//$i=1;
								foreach( $list_action as $list_actions ){
								?>
									<tr>
										<td><?php echo $list_actions->action_number; ?></td>
										<td><?php echo $list_actions->action_name; ?></td>										
										<td>
											<a href="<?php echo base_url();?>location/edit_action/<?php echo $list_actions->a_id; ?>" class="btn btn-small btn-success" title="Edit"><i class="btn-icon-only icon-pencil"> </i></a>
											
											<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="<?php echo base_url();?>location/remove_action/<?php echo $list_actions->a_id; ?>" title="Delete"><i class="btn-icon-only icon-remove"> </i></a>
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