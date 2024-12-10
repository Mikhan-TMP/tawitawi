<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<title>webdamn.com - Demo Export Data to Excel in CodeIgniter with Example</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
<link rel="icon" type="image/png" href="https://webdamn.com/wp-content/themes/v2/webdamn.png">
</head>
<body>
	<div role="navigation" class="navbar navbar-default navbar-static-top">
	  <div class="container">
		<div class="navbar-header">
		  <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a href="http://www.webdamn.com" class="navbar-brand">WEBDAMN.COM</a>
		</div>
		<div class="navbar-collapse collapse">
		  <ul class="nav navbar-nav">
			<li class="active"><a href="http://www.webdamn.com">Home</a></li>	   
		  </ul>	 
		</div>
	  </div>
	</div> 
	<div class="container">		
		<div class="row ">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- Responsive Header -->
		<ins class="adsbygoogle"
			 style="display:block"
			 data-ad-client="ca-pub-1169273815439326"
			 data-ad-slot="1311700855"
			 data-ad-format="auto"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
			<br>
			<div class="table-responsive">
				<h2>Example: Export Data to Excel in CodeIgniter</div>
				<table class="table table-hover tablesorter">
					<thead>
						<tr>
							<th class="header">QRcode</th>
							<th class="header">RFID</th> 
							<th class="header">SRCode</th>
							<th class="header">Name</th>  
							<th class="header">Building</th>
							<th class="header">Time In</th>     
							<th class="header">Date</th> 
							<th class="header">Image</th> 
						</tr>
					</thead>
					<a class="pull-right btn btn-warning btn-large" style="margin-right:40px" href="<?php echo site_url(); ?>Attend_export/createexcel"><i class="fa fa-file-excel-o"></i> Export to Excel</a>
					<tbody>
						<?php
						if (isset($studentData) && !empty($studentData)) {
							foreach ($studentData as $key => $emp) {
								?>
								<tr>
									<td><?php echo $emp['qrcode']; ?></td>   
									<td><?php echo $emp['RFID']; ?></td> 
									<td><?php echo $emp['username']; ?></td>
									<td><?php echo $emp['srcode']; ?></td> 
									<td><?php echo $emp['building']; ?></td>
									<td><?php echo $emp['in_time']; ?></td>     
									<td><?php echo $emp['date']; ?></td>                
								</tr>
								<?php
							}
						} else {
							?>
							<tr>
								<td colspan="5" class="alert alert-danger">No Records founds</td>    
							</tr>
						<?php } ?>
			 
					</tbody>
				</table>   
			</div> 
			<div style="margin:20px 0px 0px 0px;">
				<a class="btn btn-default read-more" style="background:#3399ff;color:white" href="http://www.webdamn.com/export-data-to-excel-in-codeigniter-with-example/">Back to Tutorial</a>		
			</div>	
		</div>
	</div>
</body>
</html>