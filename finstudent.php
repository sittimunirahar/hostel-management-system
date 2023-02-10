<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	$matric = $_GET['m'];
	$hi = "";
	$hn = "";

	if (!empty($_GET['hi']) && !empty($_GET['hn'])) {
		$hi = $_GET['hi'];
		$hn = $_GET['hn'];
	}
?>

	<div class="tabs2">
		<ul class="nav nav-tabs ">
			<?php if ($hn == null || $hi == null) { ?>
				<li><a href="viewstudent.php?m=<?php echo $matric ?>">Particulars</a></li>
				<li class="active"><a href="finstudent.php?m=<?php echo $matric ?>">Hostel Charges</a></li>
				<li><a href="finalloc.php?m=<?php echo $matric ?>">Allocation Records</a></li>
			<?php } else { ?>
				<li><a href="viewstudent.php?m=<?php echo $matric ?>&hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Particulars</a></li>
				<li class="active"><a href="finstudent.php?m=<?php echo $matric ?>&hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Hostel Charges</a></li>
				<li><a href="finalloc.php?m=<?php echo $matric ?>&hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Allocation Records</a></li>
				<?php }

			$query = "SELECT student_list.matric, stay_latest.status from student_list LEFT JOIN stay_latest ON 
			 student_list.matric = stay_latest.matric where student_list.matric='$matric'";
			$record = mysqli_query($link, $query);
			while ($row = mysqli_fetch_assoc($record)) {
				if ($row['status'] == "CI") {
				?>
					<input name="Check Out" type="button" value="Check Out" class="btn btn-primary" style="float:right;margin-right:70px;margin-top:2px;
		margin-bottom:2px;" onClick="window.location.href='check-out.php?m=<?php echo $matric ?>';" />
					<?php } else {
					if ($hn == null || $hi == null) { ?>
						<input name="Check In" type="button" value="Check In" class="btn btn-primary" style="float:right;margin-right:70px;margin-top:2px;
		margin-bottom:2px;" onClick="window.location.href='check-in.php?m=<?php echo $matric ?>';" />
					<?php } else { ?>
						<input name="Check In" type="button" value="Check In" class="btn btn-primary" style="float:right;margin-right:70px;margin-top:2px;
		margin-bottom:2px;" onClick="window.location.href='check-in.php?m=<?php echo $matric ?>&hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>';" />

			<?php }
				}
			} ?>
		</ul>
	</div>

	<br>

	<div class="content2">

		<br><br>
		<h3>Hostel Charges</h3>
		<hr>

		<?php
		$query = "SELECT
		MONTH(pay_details.date_issued) as month, 
		YEAR(pay_details.date_issued) as year,
		pay_details.unit_no as unit,
		hos_name as hos,
		pay_details.amount as amt,
		pay_details.fee_type as ftype,
		pay_details.status as stat
		FROM pay_details 
		WHERE pay_details.payer_id =  '$matric'";
		$record = mysqli_query($link, $query);

		?>
		<div>
			<table class="display table" id="tabledata">
				<thead>
					<tr>

						<th>Month</th>
						<th>Year</th>
						<th>Hostel</th> <!-- if greater than date in in check in & status latest CI-> get hos, unit-->
						<th>Unit</th>
						<th>Fee</th>
						<th>Status</th>
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
							<td><?php echo $row['stat'] ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<br>

		<input name="close" type="button" value="Close" style="float:right;margin-left:5px" class="btn btn-primary" onClick="window.close();" />
		<input name="back" type="button" value="Back" style="float:right; " class="btn btn-primary" onClick="window.history.back();">
		</p>
	</div>

	</div>
<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>