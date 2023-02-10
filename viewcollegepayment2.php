<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	$pn = '';
	if (!empty($_GET['pn']))
		$pn = $_GET['pn'];
?>


	<div class="content2">

		<br>
		<h3><?php echo $pn; ?></h3>
		<hr>

		<?php
		$query = "select *, MONTH(date_issued) as month, YEAR(date_issued) as year FROM pay_details_college
		     WHERE payer_type='COLLEGE' AND payee_name='$pn'";
		$record = mysqli_query($link, $query);
		?>

		<table class="display table" id="tabledata2">
			<thead>
				<tr>
					<th>Month</th>
					<th>Year</th>
					<th>Amount</th>
					<th>Pay Type</th>
					<th>Hostel Name</th>
					<th>Status</th>
					<th>Reference No</th>
					<th>Date of Payment</th>

				</tr>
			</thead>
			<tbody>
				<?php
				while ($row = mysqli_fetch_assoc($record)) { ?>
					<tr>

						<td><a href="viewpaydetailscol.php?pid=<?php echo $row['pay_rec_id'] ?>&pn=<?php echo $pn ?>&m=<?php echo $row['month'] ?>&y=<?php echo $row['year'] ?>"></a>
							<?php echo date('F', mktime(0, 0, 0, $row['month'], 10)); ?></td>
						<td><?php echo $row['year'] ?></td>
						<td><?php echo $row['amount'] ?></td>
						<td><?php echo $row['pay_type'] ?></td>
						<td><?php echo $row['hos_name'] ?></td>
						<td><?php if ($row['status'] == 'INVOICED') echo 'BILLED';
								else echo $row['status'] ?></td>
						<td><?php echo $row['pay_voucher'] ?></td>
						<td><?php echo $row['date_of_payment'] ?></td>
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