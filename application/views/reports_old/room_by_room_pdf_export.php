<?php ini_set("memory_limit","512M");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $location_data->location_name;?></title>

<link href="<?php echo base_url();?>assets/css/bootstrap-responsive.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/css.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/dashboard.css" rel="stylesheet">
</head>
<body style="background-color:#fff !important;">
<?php 
									$CI =& get_instance();
									
									/* if( $room_by_room->unit != "" )
									{
										$units = $room_by_room->unit;	
										$uni = $CI->get_units_code( $units );
									}else{
										$units = $room_by_room->units;
										$uni = $CI->get_units_code( $units );
									} */
								?>
								
								
								<h3 style="text-align:center;">Location Summary Report</h3>
								
								<table class="table  table-bordered bot_mar"  style="border:1px solid #333;">
									<thead>
										<tr>
											<td rowspan="2" colspan="2" style="text-align:left !important;"><b>Client Name:</b> <?php echo $client_info->client_name;?></td>
											<td rowspan="1" colspan="5" style="text-align:left !important;"><b>Building Address:</b> <?php echo $list_building->address;?></td>
										</tr>   
										<tr>    
											<td rowspan="1" colspan="5" style="text-align:left !important;"><b>Building Name / Description:</b> <?php echo $list_building->building_name;?> / <?php echo $list_building->building_desc;?></td>
										</tr>							
									</thead>
									<tbody>
										<tr>
											<td style="background-color:#fff !important;text-align:left !important;" rowspan="1" colspan="2"><b>Location Name:</b> <?php echo $location_data->location_name;?></td>
											<td style="background-color:#fff !important;text-align:left !important;" rowspan="1" colspan="2"><b>Location Number:</b> <?php echo $location_data->location_id;?></td>
											<td style="background-color:#fff !important;text-align:left !important;" rowspan="1" colspan="2"><b>Area of Location:</b> <?php echo $location_data->square_feet;?></td>
											<td style="background-color:#fff !important;text-align:left !important;" rowspan="1" colspan="1"><b>Floor:</b> <?php echo $location_data->floor;?></td>
										</tr>
										<tr>
											<td rowspan="1" colspan="2" style="text-align:left !important;"><b>Consultant Name:</b> <?php echo $location_data->consultant_name;?></td>
											<td rowspan="1" colspan="2" style="text-align:left !important;"><b>Last Survey Date:</b> <?php echo $location_data->survey_date;?></td>
											<td rowspan="1" colspan="3" style="text-align:left !important;"><b>Last Re-assessment Date:</b> <?php //echo $location_data->;?></td>
										</tr>
									</tbody>
								</table>
								
								<style>
									table{ background-color: #fff;}
									tr{ background-color: #fff; border:1px solid #ddd;}
									td{ background-color: #fff; border:1px solid #ddd;}
								</style>
								
								<!--<div style="width:1240px; float:left;overflow-x:scroll;">-->
                                <div>
								
								<table class="table table-striped table-bordered bot_mar"  style="border:1px solid #333;">
									<thead>
										<tr>
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" rowspan="2" class="span1"> SN </th>
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" rowspan="2" class="span1"> System </th>
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" rowspan="2" class="span1"> Material </th>
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" rowspan="2" class="span1"> Material <br/>ID </th>
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" rowspan="2" class="span1"> Material Description </th>
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" rowspan="2" class="span1"> Friability <br/>(Y/N)</th>
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" rowspan="2" class="span1"> Access </th>
											<th style="background:#1398DA !important;color:#fff !important;text-align:center;font-size:14px !important;" colspan="7" class="span1"> Quantity/Condition </th>
											<!--th rowspan="2" class="span1"> Sample #</th-->
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" rowspan="2" colspan="2" class="span1"> Sample <br/>Number </th>
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" rowspan="2" class="span1"> Results </th>
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" rowspan="2" class="span1"> Hazard </th>
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" rowspan="2" class="span1"> Action </th>
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" rowspan="2" class="span1"> Estimated <br/>Cost</th>
										</tr>
										<tr>
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" class="span1"> Good </th>
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" class="span1"> Fair </th>
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" class="span1"> Poor </th>
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" class="span1"> Total </th>
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" class="span1"> Units </th>
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" class="span1"> Debris </th>
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" class="span1"> Units </th>
										</tr>
									</thead>
									
									
									<tbody>
																					
										<?php if(!empty($list_room_by_room_data))
										{
											$i=1.0;
											foreach( $list_room_by_room_data as $list_room_by_room_datas ){
											?>
											<tr id="room_by-id-<?php echo $list_room_by_room_datas->r_id; ?>">
												<td><?php echo $i.'.0'; ?></td>
												<td>
													<?php echo $list_room_by_room_datas->system_name;?>
												</td>
												<td>
													<?php echo $list_room_by_room_datas->material_name;?>
												</td>
												<td>
												<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<?php echo $list_room_by_room_datas->m_identification;?>
												<?php } ?>	
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<?php if($list_room_by_room_datas->m_description == "" ){ echo $list_room_by_room_datas->material_desc;}else{echo $list_room_by_room_datas->m_description;}?>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<?php echo ucfirst($list_room_by_room_datas->friability);?>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<?php echo ucfirst($list_room_by_room_datas->access);?>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<?php echo $list_room_by_room_datas->good;?>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<?php echo $list_room_by_room_datas->fair;?>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<?php echo $list_room_by_room_datas->poor;?>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<?php echo $list_room_by_room_datas->total;?>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<?php if(!empty($list_room_by_room_datas->units)) {$CI->get_units_code( $list_room_by_room_datas->units);}?>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<?php echo $list_room_by_room_datas->debris;?>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<?php if(!empty($list_room_by_room_datas->unit)) {$CI->get_units_code( $list_room_by_room_datas->unit);}?>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<?php echo $list_room_by_room_datas->sample_rst;?>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<?php echo $list_room_by_room_datas->db_sample;?>
													<?php } ?>
												</td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<?php echo $list_room_by_room_datas->rst;?>
													<?php } ?>
												</td>													
												<td><?php echo $list_room_by_room_datas->r_hazard;?></td>
												<td>
													<?php if($list_room_by_room_datas->db_sample == "dash00"){echo "-";}else{?>
													<?php echo $list_room_by_room_datas->action_number;?>
													<?php } ?>
												</td>
												<td></td>
											</tr>
											
											<!--============Child List==============-->
											<tr>
												<?php $CI->list_room_by_room_data_child( $list_room_by_room_datas->r_id, $location_data->l_id, $i );?>
											</tr>	
											<?php 
											
											$i++;
											}
										}else{ ?>	<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>											
										<?php }?>
									</tbody>
								</table>
								</div>	
								<table class="table table-bordered" style="border:1px solid #333;">
									<tr>
										<td style="text-align:left !important;"><b>Comments :</b> <?php echo nl2br($location_data->note);?></td>
									</tr>
								</table>		
								
	</body>
</html>	