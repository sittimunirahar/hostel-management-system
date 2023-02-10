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
			 AND pay_rec_id='$pid'";
		$record = mysqli_query($link, $query);
		?>

		<div class="panel panel-default">
			<div class="panel-body">

				<form method="post">
					<table id="typical">
						<?php
						while ($row = mysqli_fetch_assoc($record)) { ?>
							<tr>
							<tr>
								<th>Date Issued</th>
								<td><?php echo $row['date_issued'] ?></td>
							</tr>

							<tr>
								<th>Pay Type:</th>
								<td>
									<?php echo $row['pay_type']; ?>
								</td>
							</tr>


							<tr>
								<th>Hostel Name:</th>
								<?php if ($row['pay_type'] != 'BUS') { ?>

									<td><?php echo $row['hos_name']; ?></td>
								<?php
								} else { ?>
									<td></td>
								<?php }
								?>
							</tr>

							<tr>
								<th>Amount</th>
								<td><?php echo $row['amount'] ?></td>
							</tr>

							<tr>
								<th>status:</th>
								<td>
									<?php if ($row['status'] == 'INVOICED') echo 'BILLED';
									else echo $row['status'] ?>
								</td>
							</tr>

							<tr>

								<th>Reference No:</th>
								<td><?php echo $row['pay_voucher'] ?></td>
							</tr>

							<tr>
								<th>Date:</th>
								<td>
									<?php echo $row['date_of_payment']; ?>
								</td>
							</tr>
						<?php } ?>

					</table>
			</div>
		</div>

		<input name="edit" type="button" value="Edit" class="btn btn-primary" onClick="document.location.href=('editpaydetailscol.php?pid=<?php echo $pid ?>&pn=<?php echo $pn ?>&m=<?php echo $m ?>&y=<?php echo $y ?>');" />
		<input name="del" type="submit" value="Delete" class="btn btn-primary" />
		<input name="close" type="button" value="Close" style="float:right;margin-left:5px" class="btn btn-primary" onClick="window.close();" />
		<input name="back" type="button" value="Back" style="float:right; " class="btn btn-primary" onClick="window.history.back();"> </p>
		</form>
	</div>

	</div>
	<?php

	if (isset($_POST['del'])) {
		extract($_REQUEST);
	?>
		<script>
			if (confirm("Are you sure to delete this record?")) {
				window.location.href = "deletepaycol.php?pid=<?php echo $pid; ?>";
			}
		</script>
<?php
	}

	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>