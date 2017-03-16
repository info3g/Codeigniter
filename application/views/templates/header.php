<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Ecoh | Environmental Consulting</title>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/bootstrap-responsive.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/css.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/style-new.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/dashboard.css" rel="stylesheet">

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url();?>assets/js/jquery-1.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-ui-1.js"></script>
<script src="<?php echo base_url();?>assets/js/base.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>
<!--script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEapfu8jsUUkYLpRpwPG7wFZDy54uq4hw" async defer></script-->
<!--script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDEapfu8jsUUkYLpRpwPG7wFZDy54uq4hw&sensor=false" type="text/javascript"></script-->
<script src="https://cdn.rawgit.com/googlemaps/js-marker-clusterer/gh-pages/src/markerclusterer.js"></script>

<script src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/jquery.fancybox.css?v=2.1.5" media="screen" />

<script>
	$(function() {
		$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
		$('.fancybox').fancybox();
		$('[data-toggle="tooltip"]').tooltip();
		$('#test').tooltip();
	});
	function goBack() {
		window.history.back();
	}
	
	
</script>
</head>
<style>


.nav {
 background: #f0f0f0;
  border: 1px solid #ccc;
  border-right: none;
  width: 100%;
  margin-bottom: 20px;
}

.nav ul {
  margin: 0;
  padding: 0;
}

.nav ul li {
  list-style: none;
  text-align: center;
  border-left: 1px solid #fff;
  border-right: 1px solid #ccc;
}

.nav ul li:first-child {
  border-left: none;
}

.nav ul li a {
  display: block;
  text-decoration: none;
  color: #616161;
  padding: 10px 0;
}
.nav .open > a, .nav .open > a:focus, .nav .open > a:hover, .dropdown.open .dropdown-toggle{
	background:none !important;
	background-color:transparent !important;
}

.nav {
  display: table;
  table-layout: fixed;
}

.nav ul {
  display: flex;
  flex-direction: row;
}

ul li {
    flex-grow: 1;
}

@media (max-width: 430px) {
  
  ul {
    display: block;
  }

  .nav {
    font-size: .8em;
  }
  
  .nav ul li {
    display: block;
    border-bottom: 1px solid #ccc;
  }

}
</style>
<body>
<?php $session_data = $this->session->userdata('logged_in');?>

<div class="top-header">
	<div class="wrapper">
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<div class="site-logo"> <img src="<?php echo base_url();?>assets/images/logo.png" alt=""> </div>
			</div>
			<div class="col-md-6 col-sm-6">
				<div class="visit">
					<div class="logout"> <span><a href="<?php echo base_url();?>login/logout">Logout</a></span> </div>
					<div class="user"> <span>Hi, Ecoh<?php //echo $session_data['username'];?></span> </div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="process">
	<div class="wrapper">
	<?php 
	$session_data_enter = $this->session->userdata('enter_in');
			$client_id_enter = $session_data_enter['client_id'];
	?>
		<?php $user_type = $session_data['user_type'];
			if($user_type == 'admin'){ ?>
			
		<div class="row">
        	<div class="col-md-12 col-sm-12">	
				<div class="service nav">
					<ul>
						<?php $url = $this->uri->segment('1');
						$url2 = $this->uri->segment('2');
						if($url=='' || $url=='dashboard' && $url2==''){ ?>
							<li class="active"><a href="<?php echo base_url();?>dashboard"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
						<?php }else{?>
							<li><a href="<?php echo base_url();?>dashboard"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
						<?php }?>
						
						<?php if($url=='client'){ ?>
						<li class="dropdown active"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i><span>Clients <b class="caret"></b></span></a>
						<?php }else{ ?>
						<li class="dropdown "><a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i><span>Clients <b class="caret"></b></span> </a>
						<?php } ?>
								<ul class="dropdown-menu">
									<li><a href="<?php echo base_url();?>client">All Clients</a></li>
									<li class="subnavbar-open-right"><a href="<?php echo base_url();?>client/add_client">Add New Client</a></li>
								</ul>
							</li>					
							
						<?php if($url=='location' && $this->uri->segment('2') == 'units'){ ?>
							<li class="active"><a href="<?php echo base_url();?>location/units"> <i class="icon-file"></i><span>Units</span> </a></li>
						<?php }else{ ?>
							<li class=""><a href="<?php echo base_url();?>location/units"> <i class="icon-file"></i><span>Units</span> </a></li>
						<?php } ?>
						
						<?php if($url=='location' && $this->uri->segment('2') == 'location_action'){ ?>
							<li class="active"><a href="<?php echo base_url();?>location/location_action/<?php if(!empty($client_id_enter)){ echo $client_id_enter;} ?>"> <i class="icon-file"></i><span>Actions</span> </a></li>
						<?php }else{ ?>
							<li class=""><a href="<?php echo base_url();?>location/location_action/<?php if(!empty($client_id_enter)){ echo $client_id_enter;} ?>"> <i class="icon-file"></i><span>Actions</span> </a></li>
						<?php } ?>
						
						<?php if($url=='dashboard' && $this->uri->segment('2') == 'materials'){ ?>
							<li class="active"><a href="<?php echo base_url();?>dashboard/materials/<?php echo $this->uri->segment('3');?>"> <i class="fa fa-paper-plane" aria-hidden="true"></i><span>Materials</span> </a></li>
						<?php }else{ ?>
							<li class=""><a href="<?php echo base_url();?>dashboard/materials/<?php echo $this->uri->segment('3');?>"> <i class="fa fa-paper-plane" aria-hidden="true"></i><span>Materials</span> </a></li>
						<?php } ?>
						
				
						
						
						
					<?php if($url=='location' && $url2=='index'  || $url2=='material_identification'|| $url=='sample' ){ ?>
						
						
						
						<?php if($url=='dashboard' && $this->uri->segment('2') == 'material_identification'){ ?>
							<li class="active"><a href="<?php echo base_url();?>dashboard/material_identification/<?php echo $this->uri->segment('3');?>"> <i class="fa fa-paper-plane" aria-hidden="true"></i><span>Materials Identification</span> </a></li>
						<?php }else{ ?>
							<li class=""><a href="<?php echo base_url();?>dashboard/material_identification/<?php echo $this->uri->segment('3');?>"> <i class="fa fa-paper-plane" aria-hidden="true"></i><span>Materials Identification</span> </a></li>
						<?php } ?>
						
						<?php if($url=='sample'){ ?>
							<li class="active"><a href="<?php echo base_url();?>sample/index/<?php echo $this->uri->segment('3');?>"> <i class="fa fa-search" aria-hidden="true"></i><span>Asbestos Samples</span> </a></li>
						<?php }else{ ?>
							<li class=""><a href="<?php echo base_url();?>sample/index/<?php echo $this->uri->segment('3');?>"> <i class="fa fa-search" aria-hidden="true"></i><span>Asbestos Samples</span> </a></li>
						<?php } ?>
					
					
							</li>
							
						<?php } ?>		
						
						<?php if($url=='building' && $url2=='index' || $url=='location' && $url2=='index'  || $url2=='material_identification'|| $url=='sample' || $url=='reports'){ ?>	
						
						
						<?php if($url=='reports'){ ?>
							<li class="active"><a href="<?php echo base_url();?>reports/all_list_report/<?php echo $client_id_enter;?>" > <i class="icon-share"></i><span>Reports </span> </a>
							<?php }else{ ?>
							<li class=""><a href="<?php echo base_url();?>reports/all_list_report/<?php echo $client_id_enter;?>" > <i class="icon-share"></i><span>Reports </span> </a>
							<?php } ?>								
							</li>
					<?php } ?>
			
					</ul>
				</div>
            </div>
        </div>	
					
		<?php }else{?>
			
			
		<div class="row">
        	<div class="col-md-12 col-sm-12">
            	<div class="service">
                	<ul>
                    	<?php $url = $this->uri->segment('1');
						$url2 = $this->uri->segment('2');
						if($url=='' || $url=='dashboard' && $url2==''){ ?>
							<li class="active"><a href="<?php echo base_url();?>users/dashboard"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
						<?php }else{?>
							<li><a href="<?php echo base_url();?>users/dashboard"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
						<?php }?>
                    </ul>
                </div>
            </div>
        </div>	
			
<?php } ?>
<div class="main">

	
