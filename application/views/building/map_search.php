<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="main-inner">
    <div class="container">
		<div class="row">
			<div class="span12">
				<div class="widget widget-table action-table">
						<div class="widget-header"> <i class="icon-file"></i>
							<h3>Client Information</h3>
						</div>
												<!-- /widget-header -->
						<div class="widget-content">
							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th> Client Logo </th>
										<th> Client Name </th>
										<th> Client Address </th>
										<th> Total Buildings </th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Client Logo</td>
										<td><?php echo $client_info->client_name;?></td>
										<td><?php echo $client_info->client_address;?></td>
										<td><?php echo $total_buildings;?></td>
									</tr>	
								</tbody>		
							</table>  
						</div>
						
						<?php  /*==================Below Table is for search result===================*/?>
						
						<?php 
							$arr = array();
							if(isset($get_search_parameters['portfolio']))
							{
								$arr[] = $get_search_parameters['portfolio'][0];
							}if(isset($get_search_parameters['district']))
							{
								$arr[] = $get_search_parameters['district'][0];
							}if(isset($get_search_parameters['development']))
							{
								$arr[] = $get_search_parameters['development'][0];
							}if(isset($get_search_parameters['address']))
							{
								$arr[] = $get_search_parameters['address'][0];
							}if(isset($get_search_parameters['city']))
							{
								$arr[] = $get_search_parameters['city'][0];
							}if(isset($get_search_parameters['building_type']))
							{
								$arr[] = $get_search_parameters['building_type'][0];
							}
							
							$search_paramerter = implode(',',$arr);
							if(isset($get_search_parameterss)){$search_paramerter = $get_search_parameterss;}
						?>
						<div class="widget-content">
							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th> Search </th>
										<th> Total Building Result </th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $search_paramerter; ?></td>
										<td><?php echo $total_count_rst;?></td>
									</tr>	
								</tbody>		
							</table>  
						</div>
				</div>
			</div>
			
			<div class="span12">
				<div class="widget">
					<div style="float:left;width:60%">
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>building/map_view/<?php echo $client_info->id; ?>">Back</a>
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>building/index/<?php echo $client_info->id; ?>">Building List View</a>
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>building/map_view/<?php echo $client_info->id; ?>">Building Map View</a>
					</div>
					<div style="float:right;">						
							<?php echo form_open( 'building/map_search/'.$client_info->id ); ?>
								<input type="text" name="search" value="" class="span2 search" >
								<input type="submit" name="submit" class="btn btn-primary" value="search" >
							<?php echo form_close(); ?>
						</div>
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
								<?php echo form_open('building/filter_result_map/'.$client_info->id);?>
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
				<div class="widget-content">
					<?php if(isset($map['js'])){echo $map['js'];} ?>
						<?php if(isset($map['html'])){echo $map['html'];}else{echo "No Result Found!";} ?>
					<?php ?>	
				</div>
			</div>
			
		</div>
	</div>
</div>