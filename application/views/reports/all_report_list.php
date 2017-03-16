<style>
	.reports_list{float:left;width:100%;}
	.reports_list ul li{border:1px solid #ccc;float:left;list-style: outside none none;margin-right: 20px; width: 18%; margin-bottom:20px;text-align:center;min-height:115px;}
	.reports_list ul li a span{float:left;width:100%;text-align:center;}
	.reports_list ul li i{font-size:35px;}
	.reports_list a {
		float: left;
		padding: 20px;
		width: 100%;
	}
</style>
<?php 
	$session_data_enter = $this->session->userdata('enter_in');
			$client_id_enter = $session_data_enter['client_id'];
	?>
<div class="main-inner">
		<div class="container">
			<div class="row">     
				<div class="span12">
					<div class="widget">
						<a class="btn btn-small btn-primary" href="javascript:void(0);" onclick="goBack();">Back</a>
						<a class="btn btn-small btn-primary" href="<?php echo base_url();?>/building/index/<?php echo $client_id_enter;?>">Building List</a>
					</div>
					<div class="widget">
						<div class="widget-header"> <i class="icon-cog"></i>
						  <h3>All Report Types</h3>
						</div>
						
						<div class="widget-content">
							
							<div class="reports_list">
								<ul>
									<li>
										<a href="<?php echo base_url();?>reports/room_by_room_b/<?php echo $client_id;?>">
											<i class="fa fa-home" aria-hidden="true"></i>
											<span>Room By Room</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url();?>reports/samples_b/<?php echo $client_id;?>">
											<img src="<?php echo base_url();?>assets/images/microscope-blue.png" >
											<span>Samples</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url();?>reports/all_location_report_b/<?php echo $client_id;?>">
											<i class="fa fa-map-marker" aria-hidden="true"></i>
											<span>All Locations</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url();?>reports/building_summary/<?php echo $client_id;?>">
											<i class="fa fa-building" aria-hidden="true"></i>
											<span>Building Summary</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url();?>reports/district_summary/<?php echo $client_id;?>">
											<i class="fa fa-thumb-tack" aria-hidden="true"></i>
											<span>District Summary</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url();?>reports/material_identi_summary/<?php echo $client_id;?>">
											<i class="fa fa-paper-plane" aria-hidden="true"></i>
											<span>Material Identification Summary</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url();?>reports/development_summary/<?php echo $client_id;?>">
											<i class="fa fa-tasks" aria-hidden="true"></i>
											<span>Development Summary</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url();?>reports/good_poor_summary/<?php echo $client_id;?>">
											<i class="fa fa-tasks" aria-hidden="true"></i>
											<span>Material Condition Summary</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url();?>reports/confirmed_presumed_summary/<?php echo $client_id;?>">
											<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
											<span>Confirmed and Presumed Asbestos Report</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url();?>reports/custom_report/<?php echo $client_id;?>">
											<i class="fa fa-wrench" aria-hidden="true"></i>
											<span>Custom Report</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url();?>reports/custom_m_report/<?php echo $client_id;?>">
											<i class="fa fa-wrench" aria-hidden="true"></i>
											<span>Custom Multiple Report</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url();?>reports/action_summary/<?php echo $client_id;?>">
											<i class="fa fa-wrench" aria-hidden="true"></i>
											<span>Action Report</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url();?>reports/location_not_assessed/<?php echo $client_id;?>">
											<i class="fa fa-building" aria-hidden="true"></i>
											<span>Location Not Assessed</span>
										</a>
									</li>
								</ul>
							</div>
							
						</div> 
					</div>
					<!-- /widget -->
 
         
				</div>
			</div>
			<!-- /row --> 
		</div>
		<!-- /container --> 
  </div>