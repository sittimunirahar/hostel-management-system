<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	$pn = '';
	$m = '';
	$y = '';
	$pid = '';
	if (!empty($_GET['pn']) && !empty($_GET['m']) && !empty($_GET['y']) && !empty($_GET['pid'])) {
		$pn = $_GET['pn'];
		$m = $_GET['m'];
		$y = $_GET['y'];
		$pid = $_GET['pid'];
	}
?>


	<div class="content2">

		<br>
		<h3><?php echo $pn; ?></h3>
		<hr>

		<?php
		$query = "select * FROM pay_details_college
		     WHERE payee_name='$pn'
			 AND month(date_issued)='$m' AND year(date_issued)='$y'";
		$record = mysqli_query($link, $query);
		?>

		<div class="panel panel-default">
			<div class="panel-body">

				<form method="post">
					<table id="typical">
						<?php
						while ($row = mysqli_fetch_assoc($record)) { ?>

							<tr>
								<th>Date Issued:</th>
								<td> <input name="date_is" type="date" id="date_is" class="form-control" value="<?php echo $row['date_issued'] ?>" required></td>
							</tr>

							<tr>
								<th>Pay Type:</th>
								<td>
									<select id="pay_type" name="pay_type" class="form-control" style="margin-left:0px" onChange="chgpayeetype();" required>
										<option value="<?php echo $row['pay_type']; ?>"><?php echo $row['pay_type']; ?></option>
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
							$query1 = "select hostel_details.hos_name, hostel_details.hos_gender from hostel_details LEFT JOIN hostel_closed ON hostel_details.hos_name=hostel_closed.hos_name
	where hostel_closed.date_closed IS NULL AND hos_managed_by='IIC'";
							$record1 = mysqli_query($link, $query1);
							?>

							<tr>
								<th>Hostel Name:</th>
								<?php if ($row['pay_type'] != 'BUS') { ?>

									<td> <select id="hos_n" name="hos_n" class="form-control" style="margin-left:0px" value="<?php echo $row['hos_name']; ?>">
											<option value="">Select</option>
											<?php
											while ($row1 = mysqli_fetch_assoc($record1)) {
											?>
												<option selected value="<?php echo $row1['hos_name']; ?>"> <?php echo $row1['hos_name']; ?></option>

											<?php } ?>
										</select>

									</td>

								<?php } else { ?>
									<td> <select id="hos_n" name="hos_n" class="form-control" style="margin-left:0px" disabled>
											<option value="" selected>Select</option>
											<?php
											while ($row1 = mysqli_fetch_assoc($record1)) {
											?>
												<option value="<?php echo $row1['hos_name']; ?>"> <?php echo $row1['hos_name']; ?></option>
											<?php } ?>
										</select>

									</td>
								<?php } ?>
							</tr>
							<tr>
								<th>Amount</th>
								<td><input type="text" id="am" name="am" class="form-control" value="<?php echo $row['amount'] ?>"></td>
							</tr>

							<tr>
								<th>Status:</th>
								<td>
									<select class="form-control" style="margin-left:0px" id="selectstat" name="selectstat" onChange="chgpaystat();">

										<?php
										if ($row['status'] == 'INVOICED') { ?>
											<option selected value="<?php echo $row['status'] ?>">INVOICED</option>
											<option value="PAID">PAID</option>
										<?php } else { ?>
											<option selected value="<?php echo $row['status'] ?>"><?php echo $row['status'] ?></option>
											<option value="INVOICED">BILLED</option>
										<?php

											$oristatus = $row['status'];
										} ?>
									</select>
								</td>
							</tr>
							<tr>
								<th>Reference No:</th>
								<?php
								if ($row['status'] == 'INVOICED') { ?>
									<td><input type="text" id="payid" name="payid" class="form-control" placeholder="e.g BIMB2345678" disabled></td>
								<?php } else { ?>
									<td><input type="text" id="payid" name="payid" class="form-control" value="<?php echo $row['pay_voucher'] ?>"></td>
								<?php } ?>

							<tr>
								<th>Date of Payment:</th>
								<?php
								if ($row['status'] == 'INVOICED') { ?>
									<td><input type="date" id="datepay" name="datepay" class="form-control" disabled></td>
									<?php } else {
									if ($row['date_of_payment'] == null) {
									?>

										<td><input type="date" id="datepay" name="datepay" class="form-control" value="<?php echo date('Y-m-d'); ?>"></td>
									<?php

									} else { ?>

										<td><input type="date" id="datepay" name="datepay" class="form-control" value="<?php echo $row['date_of_payment'] ?>"></td>
								<?php }
								} ?>

							</tr>
						<?php } ?>

					</table>
			</div>
		</div>

		<input name="update" type="submit" value="Save" class="btn btn-primary" />
		<input name="cancel" type="button" value="Cancel" class="btn btn-primary" onClick="window.history.back();" />
		<input name="ok" type="button" value="Close" class="btn btn-primary" onClick="window.close();" style="float:right;" />
		</p>
		</form>
	</div>

	</div>
	<?php
	if (isset($_POST['update'])) {
		$pay_type = $_POST['pay_type'];
		$hos_n = '';
		if (!empty($_POST['hos_n'])) {
			$hos_n = $_POST['hos_n'];
		}
		$date_is = $_POST['date_is'];
		$pay_voucher = '';
		$date_pay = '';
		if (!empty($_POST['payid']) && !empty($_POST['datepay'])) {
			$pay_voucher = $_POST['payid'];
			$date_pay = $_POST['datepay'];
		}

		$amt = $_POST['am'];
		$pay_status = $_POST['selectstat'];

		$query2 = "UPDATE pay_details_college SET pay_type='$pay_type', amount='$amt', date_issued='$date_is', 
				status='$pay_status', pay_voucher='$pay_voucher', date_of_payment='$date_pay', hos_name='$hos_n'
				WHERE payee_name='$pn' AND pay_rec_id='$pid'";
		$record2 = mysqli_query($link, $query2);

		if ($record2) { ?>
			<script>
				alert('Record updated.');
				window.location.href = "viewpaydetailscol.php?pid=<?php echo $pid ?>&pn=<?php echo $pn ?>&m=<?php echo $m ?>&y=<?php echo $y ?>";
			</script><?php
							} else {
								?>
			<script>
				alert('Update failed.');
			</script><?php
							}
						}

						include 'lowerbody.php';
					} else {
						require 'warninglogin.php';
					} ?>