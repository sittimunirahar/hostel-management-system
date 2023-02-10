<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width = device-width, initial-scale = 1.0, minimum-scale = 1.0, maximum-scale = 1.0, user-scalable = no"/>
    <meta name="description" content="">
    <meta name="author" content="">
	<title>HMS</title>
	  <!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="css/business-frontpage.css" rel="stylesheet">
	<!-- Custom CSS for font awesome-->
	<link href="font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="DataTables/media/css/jquery.dataTables.min.css">
	
	<link rel="stylesheet" type="text/css" href="jquery.dynameter-0.5.6/jquery.dynameter.css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="jquery.dynameter-0.5.6/jquery.dynameter.js"></script>
	
	<script type="text/javascript" src="js/canvasjs.min.js"></script>
	 <link rel="stylesheet"  media="print" href="css/media-specific-easy.css">
	 
	
</head>

<body id="menu1">

  <input type="hidden" id="semid" value="<?php echo $sid;?>">

	<div class="nav">
	  <div class="container">
	  	<ul class="ub3" >
		  <!-- <li><img src="img/iic-logo.png" width="40" height="40" style="border:0px "></li> -->
		  <li class="pull-left">HOSTEL MANAGEMENT SYSTEM</li>
		  <?php
			
			if(isset($record)){
				while($row=mysqli_fetch_assoc($record)){
			?>

	          <li class="pull-right">
				<a style="color:white;" href="staffprofile.php" >
				
				<?php echo 'Welcome, '.strtoupper($row['name']);?></a>

				 | 
	          	<a style="color:white;" onClick="logout()" id="handplease"><i class="fa fa-sign-out" ></i>Log Out</a>
	          </li>
	          <!-- <li class="pull-right"> -->
			    <img class="pull-right" src="img/<?php echo $row['file']?>" width="40" height="40" style="margin-right:6px;border-radius:27px">
	          <!-- </li> -->

	      	<?php } 
			}
		?>
	    </ul>
		</div>
	</div>