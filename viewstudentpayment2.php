<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	if ($_GET['m'] != null)
		$matric = $_GET['m'];
?>


	<div class="content2">

		<br>
		<h3><?php echo $matric; ?></h3>
		<hr>

		<?php
		$query = "SELECT
		MONTH(pay_details.date_issued) as month, 
		YEAR(pay_details.date_issued) as year,
		pay_details.unit_no as unit,
		hos_name as hos,
			pay_details.pay_rec_id as rid,
		pay_details.amount as amt,
		pay_details.status as stat,
		pay_voucher, date_of_payment
		FROM pay_details 
		WHERE pay_details.payer_id =  '$matric'";
		$record = mysqli_query($link, $query);
		?>

		<table class="display table" id="tabledata2">
			<thead>
				<tr>
					<th>Month</th>
					<th>Year</th>
					<th>Hostel</th> <!-- if greater than date in in check in & status latest CI-> get hos, unit-->
					<th>Unit</th>
					<th>Fee</th>
					<th>Status</th>
					<th>Reference No</th>
					<th>Date of Payment</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while ($row = mysqli_fetch_assoc($record)) { ?>
					<tr>
						<td><a href="editpaydetails.php?m=<?php echo $matric ?>&mon=<?php echo $row['month'] ?>&yr=<?php echo $row['year'] ?>&id=<?php echo $row['rid'] ?>"></a>
							<?php echo date('F', mktime(0, 0, 0, $row['month'], 10)); ?></td>
						<td><?php echo $row['year'] ?></td>
						<td><?php echo $row['hos'] ?></td>
						<td><?php echo $row['unit'] ?></td>
						<td><?php echo floatval($row['amt']); ?></td>
						<td><?php echo $row['stat'] ?></td>
						<td><?php echo $row['pay_voucher'] ?></td>
						<td><?php echo date("d-m-Y", strtotime($row['date_of_payment'])) ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>

		<br>

		<!--<input name="update" type="button" value="Update" class="btn btn-primary" onClick="document.location.href=('addpayment.php');"/>-->
		<input name="ok" type="button" value="Close" class="btn btn-primary" onClick="window.close();" style="float:right;" />
		</p>
	</div>

	</div>
<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>