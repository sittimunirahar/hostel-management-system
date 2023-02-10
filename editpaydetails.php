<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	if ($_GET['m'] != null && $_GET['mon'] != null && $_GET['yr'] != null)
		$matric = $_GET['m'];
	$mon = $_GET['mon'];
	$yr = $_GET['yr'];
	$rid = $_GET['id'];
?>


	<div class="content2">

		<br>
		<h3>Edit Record</h3>
		<hr>

		<?php
		$query = "SELECT
		MONTH(pay_details.date_issued) as month, 
		YEAR(pay_details.date_issued) as year,
		pay_details.pay_rec_id as prid,
		pay_details.unit_no as unit,
		pay_details.hos_name as hos,
		pay_details.amount as amt,
		pay_details.date_of_payment as date_of_payment,
		pay_details.fee_type as ftype,
		pay_details.status as stat,
		pay_details.pay_voucher as referno
		FROM pay_details 
		WHERE month(date_issued) = '$mon' 
		AND year(date_issued) = '$yr' 
		AND pay_details.payer_id =  '$matric'
		AND pay_rec_id='$rid'";
		$record = mysqli_query($link, $query);
		?>
		<div class="panel panel-default">
			<div class="panel-body">

				<form method="post">
					<table id="typical">
						<?php
						$prid = '';
						$oristatus = '';
						while ($row = mysqli_fetch_assoc($record)) {
							$prid = $row['prid'];

						?>

							<tr>
								<th colspan=2 style="padding:10px;background-color:#267871;color:white;">Details</th>
							</tr>
							<tr>
								<th>Month:</th>
								<td><?php echo date('F', mktime(0, 0, 0, $row['month'], 10)); ?></td>
							</tr>
							<tr>
								<th>Year:</th>
								<td><?php echo $row['year'] ?></td>
							</tr>

							<tr>
								<th>hostel name:</th>
								<td><?php echo $row['hos'] ?></td>
							</tr>
							<tr>
								<th>unit:</th>
								<td><?php echo $row['unit'] ?></td>
							</tr>
							<tr>
								<th colspan=2 style="padding:10px;background-color:#267871;color:white;">Invoice Details</th>
							</tr>


							<tr>
								<th>amount:</th>
								<td><?php echo $row['amt']; ?></td>
							</tr>
							<tr>
								<th>status:</th>
								<td>
									<select class="form-control" style="margin-left:0px" id="selectstat" name="selectstat" onChange="chgpaystat();">

										<?php
										if ($row['stat'] == 'INVOICED') { ?>
											<option selected value="<?php echo $row['stat'] ?>"><?php echo $row['stat'] ?></option>
											<option value="PAID">PAID</option>
										<?php } else { ?>
											<option selected value="<?php echo $row['stat'] ?>"><?php echo $row['stat'] ?></option>
											<option value="INVOICED">INVOICED</option>
										<?php

											$oristatus = $row['stat'];
										} ?>
									</select>
								</td>
							</tr>
							<tr>
								<th>Reference No:</th>
								<?php
								if ($row['stat'] == 'INVOICED') { ?>
									<td><input type="text" id="payid" name="payid" class="form-control" placeholder="e.g BIMB2345678" disabled></td>
								<?php } else { ?>
									<td><input type="text" id="payid" name="payid" class="form-control" value="<?php echo $row['referno'] ?>"></td>
								<?php } ?>

							</tr>

							<tr>
								<th>Date:</th>
								<?php
								if ($row['stat'] == 'INVOICED') { ?>
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
					</table>

			</div>
		</div>
	<?php
							$referno = $row['referno'];
						} ?>

	<input name="update" type="submit" value="Save" class="btn btn-primary" />
	<input name="cancel" type="button" value="Cancel" class="btn btn-primary" onClick="window.history.back();" />
	<input name="ok" type="button" value="Close" class="btn btn-primary" onClick="window.close();" style="float:right;" />
	</form>
	</div>

	</div>
	<?php

	if (isset($_POST['update'])) {
		extract($_REQUEST);

		//status
		$ssatt = $_POST['selectstat'];

		if (!empty($_POST['payid'])) {
			$referno = $_POST['payid'];
			$datepay = $_POST['datepay'];
		} else {
			$referno = '';
			$datepay = '';
		}

		if ($ssatt == 'PAID') {
			if ($datepay == null) {
				$datepay = date('Y-m-d');
			}

			if ($referno != null && $datepay != null) {

				$query = "UPDATE pay_details SET status='PAID', pay_voucher='$referno', date_of_payment='$datepay' WHERE pay_rec_id='$prid'";
				$record = mysqli_query($link, $query);
				if ($record) {
	?>
					<script>
						alert('Record added.');
						window.location.replace("viewstudentpayment2.php?m=<?php echo $matric ?>");
					</script>
				<?php
				}
			} else {
				?>
				<script>
					alert('Please enter receipt/cheque number');
					window.location.replace(document.referrer);
				</script>
				<?php
			}
		} else {
			if ($ssatt != $oristatus && $ssatt == 'INVOICED') {
				$query = "UPDATE pay_details SET status='INVOICED', pay_voucher='$referno', date_of_payment='' WHERE pay_rec_id='$prid'";
				$record = mysqli_query($link, $query);
				if ($record) {
				?>
					<script>
						alert('Record added.');
						window.location.replace("viewstudentpayment2.php?m=<?php echo $matric ?>");
					</script>
				<?php
				}
			} else {
				?>
				<script>
					alert('Record added.');
					window.location.replace("viewstudentpayment2.php?m=<?php echo $matric ?>");
				</script>
<?php
			}
		}
	}
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>