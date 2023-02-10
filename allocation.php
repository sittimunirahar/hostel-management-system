<?php
require 'upperbody3.php';
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


	<div class="content">

		<h3>HOSTEL ALLOCATION</h3>
		<hr>

		<?php

		$query = "select student_list.first_name, student_list.matric, student_list.year, student_list.last_name, stay_latest.status,
	  check_in.date_in, check_out.date_out
	  from student_list LEFT JOIN stay_latest ON student_list.matric = stay_latest.matric
	  LEFT JOIN check_in ON stay_latest.ci_id=check_in.ci_id LEFT JOIN check_out ON stay_latest.co_id=check_out.co_id
	  WHERE student_list.status='Active' AND (stay_latest.status NOT LIKE 'CI%' OR stay_latest.status IS NULL)";

		$record = mysqli_query($link, $query);
		?>
		<div id="wannascroll">
			<table class="display table" id="tabledata2">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Year </th>
						<th>Status</th>
						<th>Last checked-in</th>
						<th>Last checked-out</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ($row = mysqli_fetch_assoc($record)) { ?>
						<tr>
							<?php if ($hn == null || $hi == null) { ?>
								<td><a href="viewstudent.php?m=<?php echo $row['matric'] ?>&p=1" target="popup"></a><?php echo $row['matric'] ?></td>
							<?php } else { ?>
								<td><a href="viewstudent.php?m=<?php echo $row['matric'] ?>&p=1&hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>" target="popup"></a><?php echo $row['matric'] ?></td>
							<?php } ?>
							<td><?php echo $row['first_name'] . " " . $row['last_name'] ?></td>
							<td><?php echo $row['year'] ?></td>
							<?php
							if ($row['status'] == "CI") {
							?>
								<td>Live In</td>
							<?php } else {
							?><td>Live Out</td>
							<?php } ?>
							<td><?php echo implode('-', array_reverse(explode('-', $row['date_in']))); ?></td>
							<td><?php echo implode('-', array_reverse(explode('-', $row['date_out']))); ?></td>
						</tr>

					<?php } ?>
				</tbody>
			</table>
		</div>
		<br>
	</div>
<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>