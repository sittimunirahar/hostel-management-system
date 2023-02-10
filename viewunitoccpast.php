<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	$un = $_GET['un'];
	$hn = $_GET['hn'];

?>

	<div class="tabs2">
		<ul class="nav nav-tabs ">
			<li><a href="viewunitowner.php?un=<?php echo $un; ?>&hn=<?php echo $hn ?>">Details</a></li>
			<li class="active"><a href="viewunitocc.php?un=<?php echo $un; ?>&hn=<?php echo $hn ?>">Occupant</a></li>
		</ul>
	</div>


	<div class="content2">

		<br><br><br>
		<a href="viewunitocc.php?un=<?php echo $un; ?>&hn=<?php echo $hn ?>" style="float:right;padding-top:22px">CURRENT OCCUPANT</a>
		<h3>Occupant <?php echo $un ?></h3>
		<hr>

		<!-- finhead size 50% each -->

		<?php
		$query = "SELECT student_list.matric, student_list.first_name, student_list.last_name, student_list.program, student_list.year,
	  stay_latest.status, check_in.date_in
	  FROM student_list JOIN pay_details ON  student_list.matric=pay_details.payer_id
	  LEFT JOIN stay_latest ON pay_details.payer_id=stay_latest.matric
	  LEFT JOIN check_in ON pay_details.payer_id=check_in.matric
	  WHERE pay_details.unit_no='$un' AND pay_details.hos_name='$hn'
	  AND stay_latest.status <> 'CI'
	  GROUP BY pay_details.payer_id";

		$record = mysqli_query($link, $query);
		?>

		<table class="display table" id="tabledata2">
			<thead>
				<tr>
					<th scope="col">Matric</th>
					<th scope="col">Name</th>
					<th scope="col">Program</th>
					<th scope="col">Year</th>
					<th scope="col">Status</th>
					<th scope="col">Unit</th>
					<th scope="col">Check-in</th>

				</tr>
			</thead>
			<tbody>
				<?php
				if ($record) {
					while ($row = mysqli_fetch_assoc($record)) { ?>

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
							<td><?php echo $un ?></td>
							<td><?php echo date("d-m-Y", strtotime($row['date_in'])) ?></td>
						</tr>

				<?php }
				} ?>

			</tbody>
		</table>
		<br>

		<!--<input name="addocc" type="button" value="Add" class="btn btn-primary" />-->

		<input name="close" type="button" style="float:right;margin-left:5px" value="Close" class="btn btn-primary" onClick="window.close();" />
		<input name="back" type="button" value="Back" style="float:right; " class="btn btn-primary" onclick="window.history.back();">
		<br>
	</div>
	<br>
	</div>
<?php

	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>