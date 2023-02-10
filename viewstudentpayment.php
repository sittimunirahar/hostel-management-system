<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	$matric = $_GET['m'];
?>

	<div class="content2">


		<h3><?php echo $matric; ?></h3>
		<hr>

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
		WHERE pay_details.payer_id =  '$matric'";
		$record = mysqli_query($link, $query);
		?>

		<table class="display table" id="tabledata">
			<thead>
				<tr>
					<th>Month</th>
					<th>Year</th>
					<th>Hostel</th> <!-- if greater than date in in check in & status latest CI-> get hos, unit-->
					<th>Unit</th>
					<th>Fee</th>
					<th>Fee Type</th>
					<th>Status</th>
					<th>Reference No</th>
					<th>Date of Payment</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while ($row = mysqli_fetch_assoc($record)) { ?>
					<tr>

						<td><?php echo date('F', mktime(0, 0, 0, $row['month'], 10)); ?></td>
						<td><?php echo $row['year'] ?></td>
						<td><?php echo $row['hos'] ?></td>
						<td><?php echo $row['unit'] ?></td>
						<td><?php echo $row['amt'] ?></td>
						<td><?php echo $row['ftype'] ?></td>
						<td><?php echo $row['stat'] ?></td>
						<td><?php echo $row['pay_voucher'] ?></td>
						<td><?php echo date("d-m-Y", strtotime($row['date_of_payment'])) ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>

		<br>
		<input name="ok" type="button" value="Close" style="float:right" class="btn btn-primary" onClick="window.close();" />
		</p>
	</div>

	</div>
<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>