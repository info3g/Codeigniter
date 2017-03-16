<script type="text/javascript">
	var url="<?php echo base_url();?>";
    function delete_confirm( id ){
       var r=confirm( "Are you sure, you want to delete this?" )
        if (r==true)
          window.location = url+"location/remove_location_trash/"+id+"/<?php echo $building_id;?>";
        else
          return false;
        } 
</script>
	<div class="main-inner">
		<div class="container">
			<div class="row">
			
				<style>th{font-size:13px !important;}</style>
				<div class="span12">
					<div class="widget-contents">
							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th> Client Logo </th>
										<th> Client Name </th>
										<th> Total Buildings </th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Client Logo</td>
										<td><?php echo $client_info->client_name;?></td>
										<td><?php echo $total_buildings;?></td>
									</tr>	
								</tbody>		
							</table>  
					</div>
				</div>
				
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
			
				<div class="span12">
					<div class="widget">
						
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>building/index/<?php echo $client_id->client_building_id;?>">Back</a>
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>location/add_location/<?php echo $building_id;?>">Add New Location</a>
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>location/trash_location/<?php echo $building_id;?>">Trash</a>
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>location/index/<?php echo $building_id;?>">All Locations</a>
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>building/index/<?php echo $client_id->client_building_id; ?>">All Buildings</a>
						
						<div style="float:right;">	
							
							<?php echo form_open('location/search_location/'.$building_id); ?>
								<input type="text" name="search" value="" class="span2 search" >
								<input type="submit" name="submit" class="btn btn-primary" value="search" >
							<?php echo form_close(); ?>
						</div>
						<div style="float:right;">						
							<?php echo form_open('location/filter_location/'.$building_id); ?>
								<select name="filter" class="span2">
									<option>Please Select</option>
									<option value="f_asc">Floor Ascending</option>
									<option value="f_desc">Floor Descending</option>
									<option value="l_asc">Location Name Ascending</option>
									<option value="l_desc">Location Name Descending</option>
									<option value="ln_asc">Location Number Ascending</option>
									<option value="ln_desc">Location Number Descending</option>
								</select>
								<input type="submit" name="submit" class="btn btn-primary" value="filter" >
							<?php echo form_close(); ?>
						</div>
					</div>
					
					<div class="widget widget-table action-table">
						<div class="widget-header"> <i class="icon-file"></i>
							<h3>All Locations</h3>
						</div>
						<!-- /widget-header -->
						<div class="widget-content">
							<?php if(isset($list_locations)){ ?>
							<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th> Floor </th>
											<th> Location Number </th>
											<th> Location Name </th>
											<th> Area </th>
											<th class="td-actions"> </th>
										</tr>
									</thead>
								<tbody>
								<?php 
								foreach( $list_locations as $list_location ){
								?>
									<tr>
										<td><?php echo $list_location->floor;?></td>
										<td><?php echo $list_location->location_id;?></td>
										<td><?php echo $list_location->location_name;?></td>
										<td><?php echo $list_location->square_feet;?></td>
										<td class="td-actions">
											<a href="<?php echo base_url();?>location/edit_location/<?php echo $list_location->l_id; ?>" class="btn btn-small btn-success" title="Edit"><i class="btn-icon-only icon-pencil"> </i></a>
											<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="javascript:void(0)" onclick="delete_confirm( <?php echo $list_location->l_id; ?> )" title="Delete"><i class="btn-icon-only icon-remove"> </i></a>
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