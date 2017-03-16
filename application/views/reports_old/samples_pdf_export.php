<?php ini_set("memory_limit","512M");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $list_building->address;?></title>

<link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/bootstrap-responsive.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/css.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/dashboard.css" rel="stylesheet">
</head>
<body style="background-color:#fff !important;">
<?php $CI =& get_instance();?>

	<h3 style="text-align:center;">Summary of Asbestos Bulk Samples</h3>
	
	<table class="table table-striped table-bordered bot_mar" style="border:1px solid #333;">
		<thead>
			<tr>
				<td rowspan="2" colspan="2" style="text-align:left !important;"><b>Client Name:</b> <?php echo $client_info->client_name;?></td>
				<td rowspan="1" colspan="5" style="text-align:left !important;"><b>Building Address:</b> <?php echo $list_building->address;?></td>
				<tr>    
					<td rowspan="1" colspan="5" style="text-align:left !important;"><b>Building Name / Description:</b> <?php echo $list_building->building_name;?> / <?php echo $list_building->building_desc;?></td>
				</tr>
			</tr>
	</table>
	<style>
		.last td{
			border-bottom:1px solid #333;
		}
		.last_td{
			border-bottom:1px solid #333;
		}
	</style>
	<table class="table table-striped table-bordered bot_mar"  style="border:1px solid #333;">
		<?php if(isset($list_samples)){  ?>
				<thead>
					<tr>
						<th style="background:#1398DA !important;color:#fff !important;font-size:12px !important;" > Db Sample Number </th>
						<th style="background:#1398DA !important;color:#fff !important;font-size:12px !important;"> Sample Number </th>
						<th style="background:#1398DA !important;color:#fff !important;font-size:12px !important;"> Location Number </th>
						<th style="background:#1398DA !important;color:#fff !important;font-size:12px !important;"> System </th>
						<th style="background:#1398DA !important;color:#fff !important;font-size:12px !important;"> Material </th>
						<th style="background:#1398DA !important;color:#fff !important;font-size:12px !important;"> Material Identification </th>
						<th style="background:#1398DA !important;color:#fff !important;font-size:12px !important;"> Material Description </th>
						<th style="background:#1398DA !important;color:#fff !important;font-size:12px !important;"> Layer One Type </th>
						<th style="background:#1398DA !important;color:#fff !important;font-size:12px !important;"> Layer One Percent % </th>
						<th style="background:#1398DA !important;color:#fff !important;font-size:12px !important;"> Layer Two Type </th>
						<th style="background:#1398DA !important;color:#fff !important;font-size:12px !important;"> Layer Two Percent % </th>
						<th style="background:#1398DA !important;color:#fff !important;font-size:12px !important;"> Hazard </th>
						<th style="background:#1398DA !important;color:#fff !important;font-size:12px !important;"> Comments </th>
					</tr>
				</thead>
			<tbody>
			<?php 
			if(!empty($list_samples))
			{	
			foreach( $list_samples as $list_sample ){
			?>
				
				<tr id="sample-id-<?php echo $list_sample->s_id; ?>">
					
					<td class="last_td" rowspan="<?php echo $CI->get_sample_data_count( $list_sample->s_id );?>"><?php echo $list_sample->db_sample;?></td>
					
					<?php $CI->get_sample_data( $list_sample->s_id); ?>
					
				</tr>
				
				<?php 
				
			}?>
			</tbody>
		<?php } 
		} ?>
	</table>
	
	
</body>
</html>		