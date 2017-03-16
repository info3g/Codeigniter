<script type="text/javascript">
	var url="<?php echo base_url();?>";
    function delete_cfm(id){
       var r=confirm("Are you sure, you want to delete this?")
        if (r==true)
          window.location = url+"client/remove_client_trash/"+id;
        else
          return false;
        } 
</script>

	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>client/add_client">Add New client</a>
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>client/list_client_trash">Trashed clients</a>
						
						<div style="float:right;">						
							<?php echo form_open('client/index/'); ?>
								<input type="text" name="search" value="" class="span2 search" >
								<input type="submit" name="submit" class="btn btn-primary" value="search" >
							<?php echo form_close(); ?>
						</div>
					</div>
					<div class="widget widget-table action-table">
						<div class="widget-header"> <i class="icon-file"></i>
							<h3>All Clients</h3>
						</div>
						<?php 
							$CI =& get_instance();
						?>
						<!-- /widget-header -->
						<div class="widget-content">
							<?php if(isset($list_clients)){  ?>
							<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th> Client Name </th>
											<th> Client Project Number </th>
											<th> Username </th>
											<th> Email </th>
											<th> Permissions </th>
											<th> Created </th>
											<th> Total Buildings </th>
											<th class="td-actions"> </th>
										</tr>
									</thead>
								<tbody>
								<?php 
								foreach( $list_clients as $list_client ){
								?>
									<tr>
										<td><a href="<?php echo base_url();?>building/index/<?php echo $list_client->id; ?>"><?php echo ucfirst($list_client->client_name);?></a></td>
										<td><?php echo ucfirst($list_client->c_project_number);?></td>
										<td><?php echo ucfirst($list_client->username);?></td>
										<td><?php echo $list_client->email;?></td>
										<td><?php if( $list_client->permission == '1'){echo "Read/Write";}else{echo "Read";} ?></td>
										<td><?php echo $list_client->created_date;?></td>
										<td><?php $CI->get_building_cnt( $list_client->id); ?></td>
										<td class="td-actions">
											<a href="<?php echo base_url();?>client/edit_client/<?php echo $list_client->id; ?>" class="btn btn-small btn-success" title="Edit"><i class="btn-icon-only icon-pencil"> </i></a>
											<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="javascript:void(0)" onclick="delete_cfm(<?php echo $list_client->id; ?>)" title="Delete"><i class="btn-icon-only icon-remove"> </i></a>
											<a href="<?php echo base_url();?>building/index/<?php echo $list_client->id; ?>" class="btn btn-small btn-primary" title="Buildings">Buildings</a>
											<a href="<?php echo base_url();?>building/map_view/<?php echo $list_client->id; ?>" class="btn btn-small btn-primary" title="Maps">Map View</a>
										</td>
									</tr>
								<?php } ?>
								
								</tbody>
							</table>  
							<?php  }else{
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