<?php
require 'database/credentials.php';
require 'templates/user_login.php';

if ($online) {
	require 'templates/header.php';

?>

	<!-- Page Content -->
	<div id="menu">

		<div>
			<?php if ($pos == 'hstaff' || $pos == 'admin') { ?>
				<a href="dashboardhostel.php" class="button">
					<i class="fa fa-building" style="font-size:50px;"></i><br><br>HOSTEL</a>
			<?php } ?>
			<?php if ($pos == 'fstaff' || $pos == 'admin') { ?>

				<!-- <a href="dashboardfinance.php" class="button2" >
			<i class="fa fa-dashboard" style="font-size:50px;"></i><br><br>FINANCE DASHBOARD</a> -->
				<a href="dashboardfinance.php" class="button">
					<i class="fa fa-database" style="font-size:50px;"></i><br><br>FINANCE</a>
			<?php } ?>
			<!-- </div> -->
			<!-- <div> -->
			<?php if ($pos == 'admin') { ?>
				<a href="managesem.php" class="button" id="kitkat">
					<i class="fa fa-list" style="font-size:50px;"></i><br><br>SEMESTER</a>
				<a href="user.php" class="button">
					<i class="fa fa-user" style="font-size:50px;"></i><br><br>USER</a>

			<?php } ?>
		</div>

		<br>
	</div>



	<!-- Footer 
	<div class="footer">
           Copyright of IIC 2015
    </div>-->

	<!-- jQuery library -->
	<script type="text/javascript" src="js/jquery.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script type="text/javascript" src="js/bootstrap.min.js"></script>

	<!-- my Javascript-->
	<script type="text/javascript" src="js/index.js"></script>

	<!-- filter JavaScript -->
	<script language="javascript" type="text/javascript" src="js/1.4.4/jquery.min.js"></script>

	<script type="text/javascript" charset="utf8" src="DataTables/media/js/jquery-1.12.0.min.js"></script>

	<script type="text/javascript" charset="utf8" src="DataTables/media/js/jquery.dataTables.min.js"></script>



	</body>

	</html>
<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
}
?>