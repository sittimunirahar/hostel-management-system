<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {

?>
	<div class="content2">
		<?php
		if (isset($_POST['gorep1'])) {
			if (!empty($_POST['matric'])) {
				$matric2 = $_POST['matric'];
			} else {
				$matric2 = "";
			}

		?>
			<br>
			<table width=100% style="text-align:center;border:1px solid green">
				<tr>
					<td><img src="img/IIC.png" width="290" height="80"></td>
				</tr>
			</table>

			<br>
			<h3>Financial Statement <?php echo $matric2; ?></h3>
			<hr>


			<?php
			$query = "SELECT check_in.matric, check_in.hos_name as hosname, check_in.unit_no as uno, check_in.date_in, 
	 check_out.unit_no, check_out.hos_name, check_out.date_out
	 FROM check_in
	 LEFT JOIN check_out ON check_in.matric=check_out.matric
	 AND check_in.unit_no=check_out.unit_no AND check_in.hos_name=check_out.hos_name
	 AND check_in.date_in<=check_out.date_out
	 WHERE check_in.matric='$matric2'";

			$record = mysqli_query($link, $query);

			$query2 = "SELECT first_name, last_name, year, program, status FROM student_list WHERE matric='$matric2'";
			$record2 = mysqli_query($link, $query2);
			$i = 0;

			?>
			<div id="reportexcel">


				<table id="typical">
					<?php
					while ($row2 = mysqli_fetch_assoc($record2)) { ?>
						<tr>
							<th>Name:</th>
							<td><?php echo $row2['first_name'] . ' ' . $row2['last_name'] ?></td>
							<th>Year:</th>
							<td><?php echo $row2['year'] ?></td>
						</tr>
						<tr>
							<th>Program:</th>
							<td><?php echo $row2['program'] ?></td>
							<th>Status:</th>
							<td><?php echo $row2['status'] ?></td>
						</tr>
					<?php } ?>
				</table>
				<hr><br>

				<h5>HOSTEL ALLOCATION RECORD</h5>
				<table style="border:1px solid black;" id="report">

					<tr>
						<th>Hostel Name</th>
						<th>Unit No</th>
						<th>Date In</th>
						<th>Date Out</th>
					</tr>

					<?php
					while ($row = mysqli_fetch_assoc($record)) {
						//echo $row['date_in'];

					?>
						<tr>
							<td><?php echo $row['hosname'] ?></td>
							<td><?php echo $row['uno'] ?></td>
							<td><?php echo date('d-m-Y', strtotime($row['date_in'])); ?></td>
							<td><?php if ($row['date_out'] != null) echo date('d-m-Y', strtotime($row['date_out'])); ?></td>
						</tr>
					<?php
					}

					?>

				</table>


				<?php
				$query = "SELECT
							MONTH(pay_details.date_issued) as month, 
							YEAR(pay_details.date_issued) as year,
							pay_details.unit_no as unit,
							hos_name as hos,
							pay_details.amount as amt,
							pay_details.fee_type as ftype,
							pay_details.status as stat,
							pay_voucher, date_of_payment
							FROM pay_details 
							WHERE pay_details.payer_id =  '$matric2'";

				$record = mysqli_query($link, $query);

				$i = 0;

				?>
				<div id="reportexcel">
					<BR>
					<h5>HOSTEL FINANCIAL RECORD</h5>
					<table style="border:1px solid black;" id="report">

						<tr>
							<th>Month</th>
							<th>Year</th>
							<th>Hostel</th> <!-- if greater than date in in check in & status latest CI-> get hos, unit-->
							<th>Unit</th>
							<th>Fee Type</th>
							<th>Status</th>
							<th>Reference No</th>
							<th>Date of Payment</th>
							<th>Fee</th>
						</tr>

						<?php
						while ($row = mysqli_fetch_assoc($record)) {
							//echo $row['date_in'];

						?>
							<tr>
								<td><?php echo date('F', mktime(0, 0, 0, $row['month'], 10)); ?></td>
								<td><?php echo $row['year'] ?></td>
								<td><?php echo $row['hos'] ?></td>
								<td><?php echo $row['unit'] ?></td>
								<td><?php echo $row['ftype'] ?></td>
								<td><?php echo $row['stat'] ?></td>
								<td><?php echo $row['pay_voucher'] ?></td>
								<td><?php echo date('d-m-Y', strtotime($row['date_of_payment'])) ?></td>
								<td><?php echo 'RM ' . $row['amt'] ?></td>

							</tr>
					<?php
						}
					}

					$query_sum = "SELECT SUM(amount) as amt,
					sum(case when pay_details.status='INVOICED' then pay_details.amount else 0 end) as amt_due, 
					sum(case when pay_details.status='PAID' then pay_details.amount else 0 end) as amt_paid
					FROM pay_details
					WHERE payer_id='$matric2'";
					$record_sum = mysqli_query($link, $query_sum);

					$amt = 0;
					$amt_due = 0;
					$amt_paid = 0;

					while ($row_sum = mysqli_fetch_assoc($record_sum)) {
						$amt = $row_sum['amt'];
						$amt_due = $row_sum['amt_due'];
						$amt_paid = $row_sum['amt_paid'];
					}

					?>
					<tr>
						<td colspan=8 style="border-top:2px solid black"><b>Total Charged: </b></td>
						<td style="border-top:2px solid black"><?php echo 'RM ' . number_format($amt); ?></td>
					</tr>
					<tr>
						<td colspan=8 style="border-top:2px solid black"><b>Total Paid: </b></td>
						<td style="border-top:2px solid black"><?php echo 'RM ' . '(' . number_format($amt_paid) . ')'; ?></td>
					</tr>
					<tr>
						<td colspan=8><b>Total Due: </b></td>
						<td><?php echo 'RM ' . number_format($amt_due); ?></td>
					</tr>
					</table>
					<br>
					<em>This is computer generated document. No signature required. </em><br>

					<?php
					$query = "SELECT * FROM admin_acc JOIN staff_acc ON admin_acc.username = staff_acc.id 
			LEFT JOIN uploads ON admin_acc.username=uploads.description
			WHERE admin_acc.username='$username'";
					$record = mysqli_query($link, $query);
					while ($row = mysqli_fetch_assoc($record)) {
						$staffname = strtoupper($row['name']);
					} ?>
					<br>
					Printed by: <?php echo $staffname ?>
				</div>
				<br>
				<div id="buttonspace">
					<input id="printbut" type="button" value="Print" class="btn btn-primary" onClick="window.print();" />
					<input name="ok" type="button" value="Close" class="btn btn-primary" onClick="window.close();" style="float:right;margin-left:5px;" />
					<input name="back" type="button" style="float:right" value="Back" class="btn btn-primary" onClick="window.history.back();" />
				</div>


				<br><br>
			</div>

	</div>
<?php
	require 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>