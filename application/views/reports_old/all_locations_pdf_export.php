<style>
.page-break{page-break-after:always;} 
table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
	
table tr{background-color: #fff;border: 1px solid #ccc;}
table td{line-height: 18px;padding: 8px;text-align: center;}
td{ background-color: #fff;border-color: -moz-use-text-color #ccc #ccc -moz-use-text-color !important;border-style: none solid solid none !important;border-width: 0 1px 1px 0 !important;}
.bot_mar tbody tr:last-child td {border-bottom: 0 none !important;}
.table-bordered {border-collapse: separate;}
.table thead th {vertical-align: bottom;}
.table-bordered th {background: rgba(0, 0, 0, 0) -moz-linear-gradient(center top , #fafafa 0%, #e9e9e9 100%) repeat scroll 0 0;    color: #444;font-size: 10px;text-transform: uppercase;}
table .span1 {float: none;margin-left: 0;width: 44px;}
th{padding: 8px;}
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic);
</style>
<body style="background-color:#fff !important;font-family: 'Open Sans', sans-serif;color: #333333;">
					<?php $CI =& get_instance();?>
					<h3 style="text-align:center;font-size: 18px;line-height: 27px;">All Location Summary Report</h3>
					
				<?php
				$d=1;
				foreach( $location_data as $location_datas )
				{
					$location_id = $location_datas->l_id;	
					if($d>=2)
					{
						?>
						<div class="page-break"></div>
						<?php
					}
				?>
						<table>
							<tr>
								<td style="border:none;">
								<table class="table table-bordered bot_mar" style="border:1px solid #333;margin-bottom: 0 !important;width: 100%;background-color: #fff;">
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
										<?php $CI->get_location_data_listed( $location_id, $d );?>
									</tbody>
								</table>
								
								<style>
									table{ background-color: #fff;}
									tr{ background-color: #fff; border:1px solid #ccc;}
									td{ background-color: #fff; border:1px solid #ccc;}
								</style>
								
								<!--<div style="width:1240px; float:left;overflow-x:scroll;">-->
                                <div>
								
								<table class="table table-striped table-bordered bot_mar"  style="border:1px solid #333;margin-bottom: 0 !important;width: 100%;background-color: #fff;">
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
											<th style="background:#1398DA !important;color:#fff !important;font-size:14px !important;" rowspan="2" class="span1"> Results</th>
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
										<?php $CI->list_room_by_room_all_location( $location_id );?>
									</tbody>
								</table>
								</div>	
								<table class="table table-bordered" style="border:1px solid #333;margin-bottom: 0 !important;width: 100%;background-color: #fff;">
									<tr>
										<td style="text-align:left !important;"><b>Comments :</b> <?php $CI->get_notes( $location_id ); ?></td>
									</tr>
								</table>
								</td>
							</tr>
						</table>
						
			<?php
				$d++;
			} ?>				
