<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	$matric = $_GET['m'];
	$hi = "";
	$hn = "";
	$no = 1;

	if (!empty($_GET['hi']) && !empty($_GET['hn'])) {
		$hi = $_GET['hi'];
		$hn = $_GET['hn'];
	}
?>

	<div class="tabs2">
		<ul class="nav nav-tabs ">
			<?php if ($hn == null || $hi == null) { ?>
				<li><a href="viewstudent.php?m=<?php echo $matric ?>">Particulars</a></li>
				<li><a href="finstudent.php?m=<?php echo $matric ?>">Hostel Charges</a></li>
				<li class="active"><a href="finalloc.php?m=<?php echo $matric ?>">Allocation Records</a></li>
			<?php } else { ?>
				<li><a href="viewstudent.php?m=<?php echo $matric ?>&hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Particulars</a></li>
				<li><a href="finstudent.php?m=<?php echo $matric ?>&hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Hostel Charges</a></li>
				<li class="active"><a href="finalloc.php?m=<?php echo $matric ?>&hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Allocation Records</a></li>
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
		<h3>Hostel Records</h3>
		<hr>

		<?php

		$query2 = "SELECT check_in.matric, check_in.hos_name as hosname, check_in.unit_no as uno, check_in.date_in, 
	 check_out.unit_no, check_out.hos_name, check_out.date_out
	 FROM check_in
	 LEFT JOIN check_out ON check_in.matric=check_out.matric
	 AND check_in.unit_no=check_out.unit_no AND check_in.hos_name=check_out.hos_name
	 AND check_in.date_in<=check_out.date_out
	 WHERE check_in.matric='$matric'";

		$record2 = mysqli_query($link, $query2);

		?>
		<div>
			<table class="display table" id="tabledata">
				<thead>
					<tr>
						<th>No.</th>
						<th>Hostel Name</th>
						<th>Unit No</th>
						<th>Date In</th>
						<th>Date Out</th>

						<!-- if greater than date in in check in & status latest CI-> get hos, unit-->
					</tr>
				</thead>
				<tbody>
					<?php
					while ($row = mysqli_fetch_assoc($record2)) {
						$do = '';
						if ($row['date_out'] != null) {
							$do = date('d-m-Y', strtotime($row['date_out']));
						} else {
							$do = "";
						} ?>
						<tr>
							<td><?php echo $no++; ?></td>
							<td><?php echo $row['hosname'] ?></td>
							<td><?php echo $row['uno'] ?></td>
							<td><?php echo date('d-m-Y', strtotime($row['date_in'])); ?></td>
							<td><?php echo $do ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>

		</div>
		<br>
		<input name="close" type="button" value="Close" style="float:right;margin-left:5px" class="btn btn-primary" onClick="window.close();" />
		<input name="back" type="button" value="Back" style="float:right; " class="btn btn-primary" onClick="window.history.back();" />

	</div>

	</div>
<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>