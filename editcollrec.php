<?php
include 'upperbody3.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) { ?>
	<div class="list-group">
		<a href="index.php" class="list-group-item active">
			<i class="fa fa-building"></i>HOSTEL</a>
		<a href="allocation.php" class="list-group-item">
			<i class="fa fa-key"></i>ALLOCATION</a>
		<a href="services.php" class="list-group-item">
			<i class="fa fa-bar-chart"></i>REPORT</a>
		<a href="managesem.php?sem=<?php echo $sem ?>&ses=<?php echo $ses ?>" class="list-group-item">
			<i class="fa fa-list"></i>SEMESTER</a>
		<a href="home.php?sem=<?php echo $sem ?>&ses=<?php echo $ses ?>" class="list-group-item">
			<i class="fa fa-list"></i>HOME</a>
	</div>

	</div>
	<div class="content">
		<form action="editcollrec.php" method="get">
			<br>
			<h3>Edit College Record</h3>
			<hr>


			<table class="table" id="typical">
				<tr>
					<th>Payee Name:</th>
					<td> <input name="payee_name" type="text" id="payee_name" class="form-control"></td>
				</tr>

				<tr>
					<th>Payment Type:</th>
					<td> <input name="pay_type" type="text" id="pay_type" class="form-control"></td>
				</tr>

				<tr>
					<th>Reference No:</th>
					<td> <input name="pay_voucher" type="text" id="pay_voucher" class="form-control"></td>
				</tr>

				<tr>
					<th>Total Charged:</th>
					<td> <input name="amt_chg" type="text" id="amt_chg" class="form-control"></td>
				</tr>

				<tr>
					<th>Total Paid:</th>
					<td> <input name="amt_paid" type="text" id="amt_paid" class="form-control"></td>
				</tr>

				<tr>
					<th>Total Due:</th>
					<td> <input name="amt_due" type="text" id="amt_due" class="form-control"></td>
				</tr>
		</form>

		</table><br>
		<div class="editcollrec-option">
			<p>
				<input name="save" type="button" value="Save" class="btn btn-primary" onClick="document.location.href=('payment-college.php');" />
				<input name="cancel" type="button" value="Cancel" class="btn btn-primary" onClick="window.history.back();" />
			</p>
		</div>
	</div>
<?php

	if (isset($_POST['add'])) {
		extract($_REQUEST);
		$payee_name = $_POST['payee_name'];
		$pay_type = $_POST['pay_type'];
		$pay_voucher = $_POST['pay_voucher'];
		$amt_chg = $_POST['amt_chg'];
		$amt_paid = $_POST['amt_paid'];
		$amt_due = $_POST['amt_due'];
	}

	require 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>