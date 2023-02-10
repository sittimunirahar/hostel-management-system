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
	<div class="content2">
		<br>
		<h3>Check-in <?php echo $matric; ?></h3>
		<hr>

		<!-- student info here -->
		<?php
		$gender = "";
		$query = "select * from student_list where matric='$matric'";
		$record = mysqli_query($link, $query); ?>
		<form method="post">
			<?php while ($row = mysqli_fetch_assoc($record)) {
				$matric = $row['matric'];
			?>
				<div class="panel panel-default">
					<div class="panel-body">
						<table id="typical">
							<tr>
								<th colspan=2 style="padding:10px;margin-top:4px;background-color:#267871;color:white;">Check In Details</th>
							</tr>

							<tr>
								<th>Name </th>
								<td><?php echo $row['first_name'] ?> <?php echo $row['last_name'] ?>&nbsp;&nbsp;</td>
							</tr>

							<tr>
								<th>Matric No </th>
								<td><?php echo $row['matric'] ?></td>
							</tr>

							<tr>
								<th>Year </th>
								<td><?php echo $row['year'] ?></td>
							</tr>


							<?php $gender = $row['gender']; ?>
						<?php }
					$hos;
					$query = "select hostel_details.hos_name, hostel_details.hos_gender, hostel_details.hos_managed_by from hostel_details LEFT JOIN hostel_closed ON hostel_details.hos_name=hostel_closed.hos_name where hostel_closed.date_closed IS NULL";
					$record = mysqli_query($link, $query);
						?>

						<tr>
							<th>Hostel </th>
							<td>
								<select class="form-control" name="selectedhostel" id="selectedhostel" style="margin:0px">

									<option>Select</option>

									<?php
									while ($row = mysqli_fetch_assoc($record)) {
										if (($hi == null || $hn == null) && ($row['hos_gender'] == $gender || $row['hos_gender'] == 'A') && ($row['hos_managed_by'] == 'IIC')) { ?>
											<option value="<?php echo $row['hos_name']; ?>"> <?php echo $row['hos_name']; ?></option>
											<?php } else {
											if ($row['hos_name'] == $hn && ($row['hos_gender'] == $gender || $row['hos_gender'] == 'A') && ($row['hos_managed_by'] == 'IIC')) { ?>
												<option selected value="<?php echo $row['hos_name']; ?>"> <?php echo $row['hos_name']; ?></option>
									<?php }
										}
									} ?>
								</select>
							</td>
						</tr>

						<tr>
							<th>Unit </th>
							<td>
								<select class="form-control" id="selectunit" name="selectunit" style="margin:0px">
									<option>Select</option>
									<?php if ($hi == null || $hn == null) { ?>
										<option>Please choose hostel</option>
										<?php } else {
										$query = "SELECT unit_list.unit_no AS unitno, unit_list.hos_name AS hosname, COUNT(DISTINCT CASE WHEN stay_latest.status='CI' THEN stay_latest.matric END) AS tot_occ,hostel_details.unit_max_occ as umo FROM unit_list LEFT JOIN stay_latest ON unit_list.unit_no = stay_latest.unit_no LEFT JOIN hostel_details ON unit_list.hos_name = hostel_details.hos_name where unit_list.hos_name='$hn' GROUP BY unit_list.unit_no";

										$record = mysqli_query($link, $query);
										while ($row = mysqli_fetch_assoc($record)) {
											$totavail = $row['umo'] - $row['tot_occ'];
										?>
											<option value="<?php echo $row['unitno']; ?>"> <?php echo $row['unitno'] . ": " . $totavail . " availability"; ?></option>
									<?php }
									} ?>
								</select>
							</td>
						</tr>

						<tr>
							<th>Date In </th>
							<td><?php echo date('d-m-Y'); ?></td>
						</tr>

						<tr>
							<th colspan=2 style="padding:10px;margin-top:4px;background-color:#267871;color:white;">Fees</th>
						</tr>
						<tr>
							<td colspan=2>

								<div id="feesdet"><em>Amount Charged</em></div>
								<input type="hidden" name="totfees" id="totfees">
							</td>
						</tr>

						<tr>
							<th colspan=2 style="padding:10px;margin-top:4px;background-color:#267871;color:white;">Occupants Details</th>
						</tr>
						<tr>
							<td colspan=2>
								<div id="hosdet"><em>Occupants of selected unit</em></div>
							</td>
						</tr>
						</table>
					</div>
				</div>
				</table>

				<input name="confirm" type="submit" value="Confirm" class="btn btn-primary" />
				<input name="cancel" type="button" value="Cancel" class="btn btn-primary" onClick="window.history.back();" />
				<input name="close" type="button" value="Close" style="float:right;margin-left:5px" class="btn btn-primary" onClick="window.close();" />
				<br><br>
	</div>
	</form>
	<?php
	if (isset($_POST['confirm'])) {
		extract($_REQUEST);
		$date_in = date('Y-m-d');
		$mnth = date('m');
		$yr = date('Y');
		$selectedhostel = $_POST['selectedhostel'];
		$selectunit = $_POST['selectunit'];
		$status = 'CI';
		$semid = '';
		$totfees = $_POST['totfees'];

		$sql = "SELECT sem_id FROM sem_duration WHERE month='$mnth' AND year='$yr'";
		$record = mysqli_query($link, $sql);
		while ($row = mysqli_fetch_assoc($record)) {
			$semid = $row['sem_id'];
		}

		if ($totfees != 0) {
			$sql = "INSERT INTO check_in(date_in, month, hos_name, unit_no, matric)
			VALUES ('$date_in','$mnth', '$selectedhostel','$selectunit','$matric')";
			$record = mysqli_query($link, $sql);

			if ($record) {

				$sql = "SELECT ci_id FROM check_in WHERE matric='$matric' AND date_in='$date_in'";
				$record = mysqli_query($link, $sql);
				while ($row = mysqli_fetch_assoc($record)) {
					$ci_id = $row['ci_id'];
				}

				$sql = "SELECT matric FROM stay_latest WHERE matric='$matric'";
				$record = mysqli_query($link, $sql);

				if (mysqli_num_rows($record) == 0) {
					$sql1 = "INSERT INTO stay_latest(matric, status, unit_no, hos_name, ci_id) 
				VALUES ('$matric','$status','$selectunit','$selectedhostel','$ci_id')";
					$record1 = mysqli_query($link, $sql1);
				} else {
					$sql1 = "UPDATE stay_latest SET status='$status', unit_no='$selectunit', hos_name='$selectedhostel', ci_id='$ci_id' 
				WHERE matric='$matric'";
					$record1 = mysqli_query($link, $sql1);
				}

				//add fees 		
				$sql = "SELECT * FROM fees_setting WHERE description='$selectedhostel' AND year='$yr' AND month='$mnth' AND sem_id='$semid'";
				$record = mysqli_query($link, $sql);

				$rental = '';
				$feetype = 'FIX';
				if (mysqli_num_rows($record) == 1 && $totfees != 0) {
					while ($row = mysqli_fetch_assoc($record)) {
						$rental = $row['fees_per_month'];
						$fid = $row['fees_id'];
					}

					if ($rental != $totfees) {
						$fid = 0;
						$rental = $totfees;
						$feetype = "DAY";
					}

					$query2 = "INSERT INTO pay_details(payer_id, payer_type, payee_type, payee_name, amount, fee_type, date_issued, pay_type, status, fees_id, unit_no, hos_name) 
						 VALUES ('$matric', 'STUDENT', 'COLLEGE', 'STADD', '$rental', '$feetype', '$date_in', 'HOSTEL', 'INVOICED', '$fid', 
						 '$selectunit', '$selectedhostel')";
					$record2 = mysqli_query($link, $query2);
					if ($record2) { ?>
						<script>
							alert('Record added.');
							window.location.href = "check-in-slip.php?matric=<?php echo $matric ?>";
						</script>
			<?php
					}
				}
			}
		} else { ?>
			<script>
				alert('Check in failed. Please add new fee rate of the hostel for this month.');
			</script>
<?php
		}
	}
	require 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>