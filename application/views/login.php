<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Ecoh | Environmental Consulting</title>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/bootstrap-responsive.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/css.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/dashboard.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/signin.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/js/jquery-1.js"></script> 
</head>
<body>


<div class="account-container">
	
	<div class="content clearfix">
		<img src="<?php echo base_url();?>assets/images/logo.jpg" class="login_logo">
			<div class="errors"><?php echo validation_errors(); ?></div>
			<?php echo form_open('login'); ?>		
			
			<div class="login-fields">
				
				<p>Please provide your Login details</p>
				<div class="field">
					<label for="username">Username</label>
                    <input name="username" value="<?php //echo $this->post->input('username');?>" id="username" class="login username-field" placeholder="Username" type="text">
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password:</label>
					 <input name="password" value="" id="password" class="login password-field" placeholder="Password" type="password">
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<input class="button btn btn-primary btn-large" type="submit" value="Login"/>
				
			</div> <!-- .actions -->
			
			
			
		<?php echo form_close(); ?>
		
	</div> <!-- /content -->
		
</div> <!-- /account-container -->

</body>
</html>