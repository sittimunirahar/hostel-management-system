<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	$matric = $_GET['m']; ?>

	<div class="content2">
		<br>
		<h3>Check-out <?php echo $matric; ?></h3>
		<hr>

		<!-- student info here -->
		<?php
		$hos = "";
		$uno = "";

		$query = "select student_list.first_name, student_list.matric, student_list.last_name, stay_latest.hos_name, stay_latest.unit_no, check_in.date_in
  from student_list LEFT JOIN stay_latest ON student_list.matric = stay_latest.matric
  LEFT JOIN check_in ON stay_latest.ci_id=check_in.ci_id
  WHERE student_list.matric='$matric'";
		$record = mysqli_query($link, $query);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form method="post">
					<table id="typical">
						<?php
						if (mysqli_num_rows($record) == 1) {
							while ($row = mysqli_fetch_assoc($record)) {

						?>
								<tr>
									<td><label>Name: </label></td>
									<td><?php echo $row['first_name'] ?> <?php echo $row['last_name'] ?></td>
								</tr>

								<tr>
									<td><label>Matric no: </label></td>
									<td><?php echo $row['matric'] ?></td>
								</tr>

								<tr>
									<td><label>Hostel: </label></td>
									<td><?php echo $row['hos_name'];
											$hos = $row['hos_name'];
											?></td>
								</tr>

								<tr>
									<td><label>Unit: </label></td>
									<td><?php echo $row['unit_no'];
											$uno = $row['unit_no'];
											?></td>
								</tr>

								<tr>
									<td><label>Date In: </label></td>
									<td><?php echo date("d-m-Y", strtotime($row['date_in'])) ?></td>
								</tr>

								<tr>
									<td><label>Date out: </label></td>
									<td><?php echo date('d-m-Y');
											$date_out = date('Y-m-d');
											?></td>
								</tr>

								<tr>
									<td><label>Last Month Charged: </label></td>
									<td>
										<?php
										$d_iss = '';
										$day = date('d');
										$mnth = date('m');
										$yr = date('Y');
										$hos = $row['hos_name'];
										$sql1 = "SELECT * FROM fees_setting WHERE description='$hos' AND year='$yr' AND month='$mnth'";
										$record1 = mysqli_query($link, $sql1);

										$rental = '';
										$rent_chg = '';
										$feetype = 'FIX';
										if (mysqli_num_rows($record1) == 1) {
											while ($row1 = mysqli_fetch_assoc($record1)) {
												$rental = $row1['fees_per_month'];
											}
										}

										$sql2 = "SELECT amount, DAY(date_issued) as d_iss, status FROM pay_details WHERE payer_id='$matric' AND YEAR(date_issued)='$yr' AND MONTH(date_issued)='$mnth'";
										$record2 = mysqli_query($link, $sql2);
										if (mysqli_num_rows($record2) == 1) {
											while ($row2 = mysqli_fetch_assoc($record2)) {
												$rent_chg = $row2['amount'];
												$rent_real = $row2['amount'];
												$d_iss = $row2['d_iss'];
												$stat = $row2['status'];
											}
										}

										if ($rental == $rent_chg) {
											$rent_chg = $day * 10; //can be changed in the future
											if ($rent_chg > $rental) {
												$rent_chg = $rental;
											} else {
												$feetype = 'DAY';
											}
										}
										//dia masuk lambat, msuk chg by day and nak keluar awal same month
										else {
											$rent_chg = ($day - $d_iss) * 10; //RM10 per day, to be changed in the future
											$feetype = 'DAY';
										}

										echo 'RM ' . $rent_chg;

										?>
									</td>
								</tr>


						<?php }
						} ?>
					</table>

			</div>
		</div>


		<input name="confirm" type="submit" value="Confirm" class="btn btn-primary" />

		<input name="Cancel" type="button" value="Cancel" class="btn btn-primary" onClick="window.history.back();" />
		<input name="close" type="button" value="Close" style="float:right;margin-left:5px" class="btn btn-primary" onClick="window.close();" />

		</form>
	</div>
	</div>
	<?php

	if (isset($_POST['confirm'])) {
		extract($_REQUEST);
		$status = 'CO';
		$semid = '';
		$co_id = '';

		if ($rent_chg != null) {
			$sql = "SELECT sem_id FROM sem_duration WHERE month='$mnth' AND year='$yr'";
			$record = mysqli_query($link, $sql);
			while ($row = mysqli_fetch_assoc($record)) {
				$semid = $row['sem_id'];
			}

			$sql = "INSERT INTO check_out(date_out, month, hos_name, unit_no, matric)
			VALUES ('$date_out','$mnth', '$hos','$uno','$matric')";
			$record = mysqli_query($link, $sql);

			if ($record) {

				$sql = "SELECT co_id FROM check_out WHERE matric='$matric' AND date_out='$date_out'";
				$record = mysqli_query($link, $sql);
				while ($row = mysqli_fetch_assoc($record)) {
					$co_id = $row['co_id'];
				}

				$sql = "UPDATE stay_latest SET status='$status', co_id='$co_id' WHERE matric='$matric'";
				$record = mysqli_query($link, $sql);


				if ($feetype == 'DAY') {

					if ($status == 'PAID') {
						$rent_chg = $rent_real - $rent_chg;
						$query2 = "UPDATE pay_details SET amount='$rent_chg', fee_type='$feetype', status='ADVANCED', date_issued='$date_out', fees_id=''
				WHERE payer_id='$matric' AND YEAR(date_issued)='$yr' AND MONTH(date_issued)='$mnth'";
					} else {
						$query2 = "UPDATE pay_details SET amount='$rent_chg', date_issued='$date_out'
			    WHERE payer_id='$matric' AND YEAR(date_issued)='$yr' AND MONTH(date_issued)='$mnth'";
					}
					$record2 = mysqli_query($link, $query2);
				}

	?>
				<script>
					alert('Student checked out.');
					window.location.href = "check-out-slip.php?matric=<?php echo $matric ?>";
				</script>
			<?php

			}
		} else { ?>
			<script>
				alert('Check out failed. Please update hostel rate for this month');
				window.close();
			</script>
<?php }
	}


	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>