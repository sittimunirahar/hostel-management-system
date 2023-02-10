<?php
include 'upperbodyfinance2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	require 'templates/nav_finance.php';
?>

	</div>
	<div class="content">

		<form action="" method="post">
			<h3>Add Fee Structure</h3>
			<em>Insert new fee structure for every first working day of the month</em>
			<hr>
			<div class="panel panel-default">
				<div class="panel-body">
					<table id="typical">
						<tr>
							<th colspan=2 style="padding:10px;background-color:#267871;color:white;">Details</th>
						</tr>
						<tr>
							<th>Type: </th>

							<td>
								<div class="col-xs-12">
									<select id="feetype" name="feetype" onchange="feetypef()" class="form-control" style="margin:0px" required>
										<option>Select</option>
										<option value="hostel">Hostel Fee</option>
									</select>
								</div>
							</td>
						</tr>

						<tr>
							<th>Description: </th>
							<td>
								<div class="col-xs-12">
									<select class="form-control" style="margin:0px" id="desc" name="desc" onchange="descr();" required>
										<option>Select</option>
									</select>
								</div>
							</td>
						</tr>

						<?php
						$query = "SELECT * FROM sem_list GROUP BY semester";
						$record = mysqli_query($link, $query);
						?>


						<tr>
							<th colspan=2 style="padding:10px;background-color:#267871;color:white;">Charges</th>
						</tr>

						<tr>
							<th>Date Applicable: </th>
							<!-- onchange="dateapp();" -->
							<td>
								<div class="col-xs-12">
									<select class="form-control" style="margin:0px" id="mnthapp" name="mnthapp" required>

										<option></option>
									</select>
								</div>
							</td>
						</tr>

						<tr>
							<th>Rate Setting: </th>
							<td>
								<div class="col-xs-12">
									<select class="form-control" style="margin:0px" id="rset" name="rset" required onchange="setrate();">
										<option>Select</option>
										<option required value="old">Old Rate</option>
										<option required value="new">New Rate</option>
									</select>
								</div>
							</td>
						</tr>

						<tr>
							<th>Rate: </th>
							<td>
								<div class="col-xs-12">
									<input name="rental" type="number" placeholder="0.00" id="rental" class="form-control" required>
									<em>Please insert correct rate for the month</em>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>


			<div class="addfee-option">
				<p>
					<input name="add" type="submit" value="Add" class="btn btn-primary" />
					<input name="cancel" type="button" value="Cancel" class="btn btn-primary" onClick="window.history.back();" />
				</p>
		</form>
	</div>

	<?php


	if (isset($_POST['add'])) {
		extract($_REQUEST);
		$desc = $_POST['desc'];
		$feetype = $_POST['feetype'];
		// $sem=$_POST['semmm'];
		$mnapp = $_POST['mnthapp'];
		$chg_status = 'Y';
		//$exp=$_POST['exp'];
		$rental = $_POST['rental'];

		$semid = '';

		//split month and year
		$app = explode("-", $mnapp);
		$mapp = date("m", strtotime($app[0]));
		$yapp = $app[1];

		$sql = "SELECT sem_id FROM sem_duration WHERE month='$mapp' AND year='$yapp'";
		$record = mysqli_query($link, $sql);
		while ($row = mysqli_fetch_assoc($record)) {
			$semid = $row['sem_id'];
		}

		$m_iss1 = (string)($yapp . '-' . $mapp . '-01');
		$m_iss = date("Y-m-d", strtotime($m_iss1));

		//chg exp to proper date format
		//$expmnth=date("Y-m-d", strtotime($exp));

		//check if fee type is hostel
		if ($rental < 999) {
			if ($feetype == 'hostel') {

				//insert into fees setting
				$query = "INSERT INTO fees_setting (type, description, year, month, sem_id, fees_per_month) 
			 VALUES ('HOSTEL', '$desc', '$yapp', '$mapp', '$semid', '$rental')";
				$record = mysqli_query($link, $query);

				if ($record && $chg_status == 'Y') {
					$fid = "";
					//get fees id
					$query = "SELECT * FROM fees_setting WHERE description='$desc' AND year='$yapp' AND month='$mapp'";
					$record = mysqli_query($link, $query);
					while ($row = mysqli_fetch_assoc($record)) {
						$fid = $row['fees_id'];
					}

					//echo $fid;
					//select student who is still staying in hostel for that month to invoice them 
					$query = "SELECT * FROM stay_latest WHERE status='CI' AND hos_name='$desc'";
					$record = mysqli_query($link, $query);

					while ($row = mysqli_fetch_assoc($record)) {
						$mat = $row['matric'];
						$unno = $row['unit_no'];
						$hname = $row['hos_name'];

						$query2 = "INSERT INTO pay_details(payer_id, payer_type, payee_type, payee_name, 
					 amount, fee_type, date_issued, pay_type, status, fees_id, unit_no, hos_name) 
					 VALUES ('$mat', 'STUDENT', 'COLLEGE', 'STADD', '$rental', 'FIX', '$m_iss', 'HOSTEL', 'INVOICED', '$fid', 
					 '$unno', '$hname')";
						$record2 = mysqli_query($link, $query2);
					}
				}

	?>
				<script>
					alert('Record added');
					window.location.href = "financestructure.php";
				</script>

			<?php

			}
		} else {
			?>
			<script>
				alert('Please enter rental rate correctly');
			</script>

	<?php

		}
	}

	?> </div><?php
						require 'lowerbody.php';
					} else {
						require 'warninglogin.php';
					} ?>