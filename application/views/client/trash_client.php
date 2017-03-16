<script type="text/javascript">
	var url="<?php echo base_url();?>";
    function delete_cfm(id){
       var r=confirm("Are you sure, you want to Permanently delete this?")
        if (r==true)
          window.location = url+"client/remove_client/"+id;
        else
          return false;
        } 
</script>

	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>client">Back</a>
					</div>
					<div class="widget widget-table action-table">
						<div class="widget-header"> <i class="icon-file"></i>
							<h3>All Clients</h3>
						</div>
						<!-- /widget-header -->
						<div class="widget-content">
							<?php if(isset($list_clients)){  ?>
							<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th> Client Name </th>
											<th> Username </th>
											<th> Email </th>
											<th> Permissions </th>
											<th> Created </th>
											<th class="td-actions"> </th>
										</tr>
									</thead>
								<tbody>
								<?php 
								foreach( $list_clients as $list_client ){
								?>
									<tr>
										<td><?php echo ucfirst($list_client->client_name);?></td>
										<td><?php echo ucfirst($list_client->username);?></td>
										<td><?php echo $list_client->email;?></td>
										<td><?php if( $list_client->permission == '1'){echo "Read/Write";}else{echo "Read";} ?></td>
										<td><?php echo $list_client->created_date;?></td>
										<td class="td-actions">
											<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="<?php echo base_url();?>client/restore_client/<?php echo $list_client->id; ?>" title="Restore"><i class="fa fa-undo"></i></a>
											<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="javascript:void(0)" onclick="delete_cfm(<?php echo $list_client->id; ?>)" title="Delete"><i class="btn-icon-only icon-remove"> </i></a>
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
				</div>
			</div>
		</div>
	</div>