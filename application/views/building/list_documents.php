<script type="text/javascript">
	var url="<?php echo base_url();?>";
    function delete_confirm( id,bid ){
       var r=confirm( "Are you sure, you want to delete this?" )
        if (r==true)
          window.location = url+"building/remove_document/"+id+"/"+bid;
        else
          return false;
        } 
</script>
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>building/index/<?php echo $client_id->client_building_id;?>">Back</a>
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>building/add_document/<?php echo $building_id;?>">Add New Document</a>
					</div>
					<div class="widget">
						Building : <b><?php echo $building_name->building_name;?></b>
					</div> 
					<div class="widget widget-table action-table">
						<div class="widget-header"> <i class="icon-file"></i>
							<h3>All Documents</h3>
						</div>
						<!-- /widget-header -->
						<div class="widget-content">
							<?php if(isset($list_documents)){  ?>
							<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th> Document Title </th>
											<th> Document Description </th>
											<th> Uploaded </th>
											<th class="td-actions"> </th>
										</tr>
									</thead>
								<tbody>
								<?php 
								foreach( $list_documents as $list_document ){
								?>
									<tr>
										<td><?php echo $list_document->document_name;?></td>
										<td><?php echo $list_document->document_desc;?></td>
										<td><?php echo $list_document->date_uploaded;?></td>
										<td class="td-actions">
											<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="javascript:void(0)" onclick="delete_confirm(<?php echo $list_document->d_id; ?>,<?php echo $building_id;?>)" title="Delete"><i class="btn-icon-only icon-remove"> </i></a>
											<a href="<?php echo base_url();?>building/download/<?php echo $list_document->d_id; ?>" class="btn btn-small btn-primary" title="Download">Download</a>
											<a target="_blank" href="<?php echo base_url();?>uploads/<?php echo $list_document->document_path;?>" class="btn btn-small btn-primary" title="View">View</a>
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