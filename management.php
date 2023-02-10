<?php
include 'upperbody.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
?>
	<div class="list-group">
		<a href="index.php" class="list-group-item active">Hostel Management</a>
		<a href="allocation.php" class="list-group-item">Hostel Allocation</a>
		<a href="payment.php" class="list-group-item">Manage Payment</a>
		<a href="services.php" class="list-group-item">Services</a>
	</div>

	</div>
	<div class="content">
		<ul class="nav nav-tabs nav-justified">
			<li class="active"><a href="mgt-hostelunit.php">Hostel Unit</a></li>
			<li><a href="mgt-unitowner.php">Unit Owner</a></li>
			<li><a href="mgt-occup.php">Occupants</a></li>
			<li><a href="mgt-fees.php">Fees</a></li>
		</ul>
	</div>

<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>