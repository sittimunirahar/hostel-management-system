<?php
require 'upperbody.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	$hi = "";
	$hn = "";

	if (!empty($_GET['hi']) && !empty($_GET['hn'])) {
		$hi = $_GET['hi'];
		$hn = $_GET['hn'];
	}
	require 'templates/nav_hostel.php';
?>


	</div>
	<div class="tabs">
		<ul class="nav nav-tabs ">
			<li><a href="mgt-details.php?hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Details</a></li>
			<li><a href="mgt-hostelunit.php?hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Unit</a></li>
			<li class="active"><a href="mgt-occup.php?hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Occupant</a></li>
			<li><a href="mgt-fees.php?hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Fee</a></li>
		</ul>

	</div>
	<br><br>
	<div class="content">


		<h3>Occupants - <?php echo $hn ?></h3>

		<hr>
		<?php
		if (($month == null || $month == "all") && ($year == null || $year == "all")) {
			$query_occ = "SELECT DISTINCT stay_latest.matric as matric, student_list.first_name, student_list.last_name, student_list.program, student_list.year,
		  stay_latest.status as status, check_in.date_in, check_in.unit_no
		  FROM stay_latest
		  JOIN student_list ON stay_latest.matric=student_list.matric
		  JOIN pay_details ON pay_details.payer_id=student_list.matric
		  JOIN check_in ON check_in.ci_id=stay_latest.ci_id
		  WHERE stay_latest.hos_name='$hn' AND stay_latest.status='CI'";
		} else if (($month == null || $month == "all") && ($year != null || $year != "all")) {
			$query_occ = "SELECT DISTINCT stay_latest.matric as matric, student_list.first_name, student_list.last_name, student_list.program, student_list.year,
		  stay_latest.status as status, check_in.date_in, check_in.unit_no
		  FROM stay_latest
		  JOIN student_list ON stay_latest.matric=student_list.matric
		  JOIN pay_details ON pay_details.payer_id=student_list.matric
		  JOIN check_in ON check_in.ci_id=stay_latest.ci_id
		  WHERE stay_latest.hos_name='$hn' AND stay_latest.status='CI'
		  AND year(pay_details.date_issued)='$year'";
		} else {
			$query_occ = "SELECT DISTINCT stay_latest.matric as matric, student_list.first_name, student_list.last_name, student_list.program, student_list.year,
		  stay_latest.status as status, check_in.date_in,  check_in.unit_no
		  FROM stay_latest
		  JOIN student_list ON stay_latest.matric=student_list.matric
		  JOIN pay_details ON pay_details.payer_id=student_list.matric
		  JOIN check_in ON check_in.ci_id=stay_latest.ci_id
		  WHERE stay_latest.hos_name='$hn' AND stay_latest.status='CI'
		  AND month(pay_details.date_issued)='$month'
		  AND year(pay_details.date_issued)='$year'";
		}

		$record = mysqli_query($link, $query_occ);
		?>
		<div id="wannascroll2">
			<table class="display table" id="tabledata2">
				<thead>
					<tr>
						<th scope="col">Matric No</th>
						<th scope="col">Student name</th>
						<th scope="col">Program</th>
						<th scope="col">Year</th>
						<th scope="col">Status</th>
						<th scope="col">Unit number</th>
						<th scope="col">Check-in date</th>

					</tr>
				</thead>


				<tbody>
					<?php while ($row = mysqli_fetch_assoc($record)) { ?>
						<tr>
							<td><a href="viewstudent.php?m=<?php echo $row['matric'] ?>"></a><?php echo $row['matric'] ?></td>
							<td><?php echo $row['first_name'] ?> <?php echo $row['last_name'] ?></td>
							<td><?php echo $row['program'] ?></td>
							<td><?php echo $row['year'] ?></td>
							<?php
							if ($row['status'] == "CI") {
							?>
								<td>Live In</td>
							<?php } else {
							?><td>Live Out</td>
							<?php } ?>
							<td><?php echo $row['unit_no'] ?></td>
							<td><?php echo date("d-m-Y", strtotime($row['date_in'])) ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>

		</div>

	</div>
	</div>
<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>