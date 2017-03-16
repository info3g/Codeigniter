<div class="main-inner">
		<div class="container">
			<div class="row">
				<style>th{font-size:13px !important;}</style>
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>building/index/<?php echo $client_info->id;?>">Back</a>
					</div>		
				</div>		
							
				<div class="span12">
						<div class="widget widget-table action-table">
						
						<div class="widget-content">
							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th> Portfolio </th>
										<th> District </th>
										<th> Development </th>
										<th> Address </th>
										<th> City/Town </th>
										<th> Building Type </th>
										<th>  </th>
									</tr>
								</thead>
								<?php echo form_open('building/filter_result/'.$client_info->id);?>
								<tbody>
									<tr>
										<td>
											<select name="portfolio[]" id="portfolio" class="span2" multiple>
												<option value="0">--Please Select--</option>
												<option value="PH">PH</option>
												<option value="NPS">NPS</option>
												<option value="NPF">NPF</option>
											</select>
										</td>
										<td>
											<select name="district[]" id="district" class="span2" multiple>
												<option value="0">--Please Select--</option>
												<?php for($i=1;$i<=6;$i++){?>
													<option value="<?php echo $i?>"><?php echo $i?></option>
												<?php } ?>
											</select>
										</td>
										<td>
											<select name="development[]" id="development" class="span2" multiple>
												<option value="0">--Please Select--</option>
												<?php 
												$de = array_unique($develop, SORT_REGULAR);
												foreach($de as $dev){
													$develops = $dev[0];
													if($develops->development != ""){
													?>
														<option value="<?php echo $develops->development;?>"><?php echo $develops->development;?></option>
													<?php } ?>
												<?php } ?>
											</select>
										</td>
										<td>
											<select name="address[]" id="address" class="span2" multiple>
												<option value="0">--Please Select--</option>
												<?php 
												$addr = array_unique($address, SORT_REGULAR);
												foreach($addr as $add){
													$addresss = $add[0];
													if($addresss->address != ""){
													?>
														<option value="<?php echo $addresss->address;?>"><?php echo $addresss->address;?></option>
													<?php } ?>
												<?php } ?>
											</select>
										</td>
										<td>
											<select name="city[]" id="city" class="span2" multiple>
												<option value="0">--Please Select--</option>
												<?php 
												$cit = array_unique($city, SORT_REGULAR);
												foreach($cit as $cityss){
													$citys = $cityss[0];
													if($citys->city != ""){
													?>
														<option value="<?php echo $citys->city;?>"><?php echo $citys->city;?></option>
													<?php } ?>
												<?php } ?>
											</select>
										</td>
										<td>
											<select name="building_type[]" id="building_type" class="span2" multiple>
												<option value="0">--Please Select--</option>
												<?php 
												$btype = array_unique($building_type, SORT_REGULAR);
												foreach($btype as $building_typess){
													$building_types = $building_typess[0];
													if($building_types->building_type != ""){
													?>
														<option value="<?php echo $building_types->building_type;?>"><?php echo $building_types->building_type;?></option>
													<?php } ?>
												<?php } ?>
											</select>
										</td>
										<td>
											<input type="submit" name="submit" value="Filter" class="btn btn-small btn-primary" />
										</td>
									</tr>	
								</tbody>
								<?php echo form_close();?>
							</table>  
						</div>
				</div>
			</div>
				
				<div class="span12">		
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
											<th> Portfolio </th>
											<th> District </th>
											<th> Development </th>
											<th> Address </th>
											<th> City/Town </th>
											<th> Building Type </th>
											<th class="td-actions"> </th>
										</tr>
									</thead>
								<tbody>
								<?php 
								foreach( $list_building as $list_buildings ){
								?>
									<tr>
										<td><?php echo $list_buildings->portfolio;?></td>
										<td><?php echo $list_buildings->district;?></td>
										<td><?php echo $list_buildings->development;?></td>
										<td><?php echo $list_buildings->address;?></td>
										<td><?php echo $list_buildings->city;?></td>
										<td><?php echo $list_buildings->building_type;?></td>
										<td class="td-actions">
											<a href="<?php echo base_url();?>building/edit_building/<?php echo $list_buildings->id; ?>" class="btn btn-small btn-success" title="Edit"><i class="btn-icon-only icon-pencil"> </i></a>
											<a data-toggle="modal" role="button" class="btn btn-danger btn-small" href="javascript:void(0)" onclick="delete_confirm( <?php echo $list_buildings->id; ?> )" title="Delete"><i class="btn-icon-only icon-remove"> </i></a>
											<a href="<?php echo base_url();?>building/list_documents/<?php echo $list_buildings->id; ?>" class="btn btn-small btn-primary" title="Documents">Documents</a>
											<a href="<?php echo base_url();?>location/index/<?php echo $list_buildings->id; ?>" class="btn btn-small btn-primary" title="Locations">Locations</a>
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