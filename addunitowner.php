<?php

require 'upperbody3.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) { ?>
	<div class="list-group">
		<a href="index.php" class="list-group-item active">
			<i class="fa fa-building"></i>HOSTEL</a>
		<a href="allocation.php" class="list-group-item">
			<i class="fa fa-key"></i>ALLOCATION</a>
		<a href="payment.php" class="list-group-item">
			<i class="fa fa-credit-card"></i>FINANCIAL</a>
		<a href="services.php" class="list-group-item">
			<i class="fa fa-bar-chart"></i>REPORT</a>
		<a href="home.php" class="list-group-item">
			<i class="fa fa-home"></i>HOME</a>
	</div>

	</div>
	<div class="content">
		<form action="addunitowner.php" method="get">
			<br>
			<h3>Owner Information</h3>
			<hr>
			<div class="panel panel-default">
				<div class="panel-body">
					<table id="typical">
						<tr>
							<th>Unit No:</th>
							<td> <input name="hostelname" type="text" id="hostelname" class="form-control"></td>
						</tr>

						<tr>
							<th>Owner Name:</th>
							<td> <textarea name="hostelname" type="text" id="hostelname" class="form-control"></textarea></td>
						</tr>

						<tr>
							<th>Rental Fee: </th>
							<td> <input name="totalocc" type="text" id="totalocc" class="form-control"></td>
						</tr>

						<tr>
							<th>Expired Date: </th>
							<td> <input name="totalocc" type="text" id="totalocc" class="form-control"></td>
						</tr>

						<tr>
							<th>Email: </th>
							<td> <input name="totalocc" type="text" id="totalocc" class="form-control"></td>
						</tr>

						<tr>
							<th>Phone No: </th>
							<td> <input name="totalocc" type="text" id="totalocc" class="form-control"></td>
						</tr>

						<tr>
							<th>Total Occupant: </th>
							<td> <input name="totalocc" type="text" id="totalocc" class="form-control"></td>
						</tr>

						<!--	<tr><td>Picture:</td>
			<td> <input name="hostelname" type="button" class="btn" id="hospic" value="Upload"></td></tr>
		  -->

					</table>
				</div>
			</div>
		</form>

		<div class="addunitowner-option">
			<p>
				<input name="add" type="button" value="Add" class="btn btn-primary" onClick="document.location.href=('index.php');" />
				<input name="cancel" type="button" value="Cancel" class="btn btn-primary" onClick="document.location.href=('index.php');" />
			</p>
		</div>
	</div>
<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>