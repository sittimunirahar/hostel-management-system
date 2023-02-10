<?php
require 'upperbodyfinance.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
?>

	<div class="list-group">
		<a href="financepayment.php" class="list-group-item active">
			<i class="fa fa-credit-card"></i>PAYMENT</a>
		<a href="financestructure.php" class="list-group-item">
			<i class="fa fa-cog"></i>RATE</a>
		<a href="dashboardfinance.php" class="list-group-item">
			<i class="fa fa-dashboard"></i>DASHBOARD</a>
		<a href="home.php" class="list-group-item">
			<i class="fa fa-home"></i>HOME</a>
	</div>

	</div>
	<div class="content">
		<form action="" method="POST">

			<h3>Add College Payment Record</h3>
			<hr>

			<div class="panel panel-default">
				<div class="panel-body">
					<table id="typical">
						<tr>
							<th>Payer ID:</th>
							<td>IIC</td>
						</tr>

						<tr>
							<th>Payer Type:</th>
							<td>COLLEGE</td>
						</tr>

						<tr>
							<th>Payee Name:</th>
							<td>
								<?php
								$query = "SELECT DISTINCT(payee_name) FROM pay_details_college WHERE payee_type='HOSTEL' AND payer_type='COLLEGE'";
								$record = mysqli_query($link, $query);
								?>
								<select name="payee_name" id="payee_name" class="form-control" style="margin-left:0px" onChange="payeecol()" required>

									<?php while ($row = mysqli_fetch_assoc($record)) { ?>
										<option value="<?php echo $row['payee_name'] ?>"><?php echo $row['payee_name'] ?></option>
									<?php } ?>
									<option value="Other">Other</option>

								</select>
							</td>
						</tr>

						<tr>
							<th>Other Payee Name:</th>
							<td> <input name="new_payee_name" type="text" id="new_payee_name" class="form-control" disabled></td>
						</tr>

						<tr>
							<th>Pay Type:</th>
							<td>
								<select id="pay_type" name="pay_type" class="form-control" style="margin-left:0px" onChange="chgpayeetype();" required>
									<option>Select</option>
									<option value="HOSTEL">Hostel</option>
									<option value="ELECTRICITY">Electricity Bill</option>
									<option value="WATER">Water Bill</option>
									<option value="CARETAKER">Caretaker</option>
									<option value="STORE">Store</option>
									<option value="CAFE">Cafeteria</option>
									<option value="BUS">Bus</option>
								</select>
							</td>
						</tr>

						<?php
						$query = "select hostel_details.hos_name, hostel_details.hos_gender from hostel_details LEFT JOIN hostel_closed ON hostel_details.hos_name=hostel_closed.hos_name where hostel_closed.date_closed IS NULL AND hos_managed_by='IIC'";
						$record = mysqli_query($link, $query);
						?>

						<tr>
							<th>Hostel Name:</th>
							<td> <select id="hos_n" name="hos_n" class="form-control" style="margin-left:0px" disabled>
									<option value="" selected>Select</option>
									<?php
									while ($row = mysqli_fetch_assoc($record)) {
									?>
										<option value="<?php echo $row['hos_name']; ?>"> <?php echo $row['hos_name']; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>

						<tr>
							<th>Amount:</th>
							<td> <input name="amt_chg" type="number" placeholder="0.00" id="amt_chg" class="form-control" required></td>
						</tr>

						<tr>
							<th>Date Issued:</th>
							<td> <input name="date_is" type="date" id="date_is" class="form-control" required></td>
						</tr>

						<tr>
							<th>Status:</th>
							<td>
								<select id="pay_status" name="pay_status" class="form-control" style="margin-left:0px" onChange="statcol()" required>
									<option value="INVOICED">BILLED</option>
									<option value="PAID">PAID</option>
								</select>
							</td>
						</tr>

						<tr>
							<th>Reference No:</th>
							<td> <input name="pay_voucher" type="text" id="pay_voucher" class="form-control" disabled></td>
						</tr>

						<tr>
							<th>Date of Payment:</th>
							<td><input name="date_pay" type="date" id="date_pay" class="form-control" disabled></td>
						</tr>



					</table>
				</div>
			</div>

			<input name="save" type="submit" value="Save" class="btn btn-primary" />
			<input name="cancel" type="button" value="Cancel" class="btn btn-primary" onClick="window.history.back();" />
		</form>
	</div>
	<?php

	if (isset($_POST['save'])) {
		extract($_REQUEST);
		$payer_name = 'IIC';
		$payer_type = 'COLLEGE';
		$payee_type = 'HOSTEL';
		$payee_name = $_POST['payee_name'];
		$pay_status = $_POST['pay_status'];

		if (!empty($_POST['new_payee_name'])) {
			$payee_name = $_POST['new_payee_name'];
		}
		$pay_type = $_POST['pay_type'];
		$hos_n = '';
		if (!empty($_POST['hos_n'])) {
			$hos_n = $_POST['hos_n'];
		}

		$date_is = $_POST['date_is'];
		$pay_voucher = '';
		$date_pay = '';
		if (!empty($_POST['pay_voucher']) && !empty($_POST['date_pay'])) {
			$pay_voucher = $_POST['pay_voucher'];
			$date_pay = $_POST['date_pay'];
		}

		$amt_chg = $_POST['amt_chg'];

		$query2 = "INSERT INTO pay_details_college(payer_id, payer_type, payee_type, payee_name, 
				amount, date_issued, pay_type, status, pay_voucher, date_of_payment, hos_name) 
				VALUES ('$payer_name', '$payer_type', '$payee_type', '$payee_name', '$amt_chg', '$date_is', '$pay_type', '$pay_status', 
				'$pay_voucher', '$date_pay', '$hos_n')";
		$record2 = mysqli_query($link, $query2);

		if ($record2) { ?>
			<script>
				alert('Record added.');
				window.location.href = "financepaymentcollege.php";
			</script><?php
							}
						}

						require 'lowerbody.php';
					} else {
						require 'warninglogin.php';
					} ?>