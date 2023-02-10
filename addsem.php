<?php
require 'upperbodyhead.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	require 'templates/nav_sem.php';
?>

	<!-- Close div sideleft-->
	</div>

	<div class="content">
		<form action="" method="post">


			<h3>Add Semester</h3>
			<hr>

			<div class="panel panel-default">
				<div class="panel-body">
					<table id="typical">

						<tr>
							<th>Semester:</th>
							<td colspan=2> <select name="semes" id="semes" class="form-control" style="margin-left:0px" required onchange="chgm()">
									<option value='1'>1</option>
									<option value='2'>2</option>
									<option value='3'>3</option>
								</select>
							</td>
						</tr>

						<tr>
							<th>Session:</th>
							<td> <input name="session1" type="number" id="session1" class="form-control" placeholder='Year 1' maxlength=4 required></td>
							<td> <input name="session2" type="number" id="session2" class="form-control" placeholder='Year 2' maxlength=4 required></td>
						</tr>

						<tr>
							<th>Status: </th>
							<td colspan=2> <select name="status" class="form-control" style="margin-left:0px" required>
									<option value='OFF'>OFF</option>
									<option value='DEFAULT'>DEFAULT</option>
								</select>
								<em>(Selecting default will automatically off the previous default semester)</em>
							</td>
						</tr>

						<tr>
							<th>Month: </th>
							<td colspan=2>
								<input name="m1" type="month" id="m1" class="form-control">
								<input name="m2" type="month" id="m2" class="form-control">
								<input name="m3" type="month" id="m3" class="form-control">
								<input name="m4" type="month" id="m4" class="form-control">
								<input name="m5" type="month" id="m5" class="form-control">
							</td>
						</tr>

					</table>
				</div>
			</div>

			<input name="add" type="submit" value="Add" class="btn btn-primary" />
			<input name="cancel" type="button" value="Cancel" class="btn btn-primary" onClick="document.location.href=('managesem.php');" />
		</form>
	</div>
	<?php

	if (isset($_POST['add'])) {
		extract($_REQUEST);
		$semester = $_POST['semes'];
		$session1 = $_POST['session1'];
		$session2 = $_POST['session2'];
		$status = $_POST['status'];
		$m1 = $_POST['m1'];
		$m2 = $_POST['m2'];
		$m3 = $_POST['m3'];
		$m4 = 'm4';
		$m5 = 'm5';
		$semid = '';


		$m1m = date('m', strtotime($m1));
		$m2m = date('m', strtotime($m2));
		$m3m = date('m', strtotime($m3));
		$m4m = 'm4m';
		$m5m = 'm5m';

		$m1y = date('Y', strtotime($m2));
		$m2y = date('Y', strtotime($m2));
		$m3y = date('Y', strtotime($m2));
		$m4y = 'm4y';
		$m5y = 'm5y';
		$sess = $session1 . '/' . $session2;

		if (!empty($_POST['m4']) && !empty($_POST['m5'])) {
			$m4 = $_POST['m4'];
			$m5 = $_POST['m5'];
			$m4m = date('m', strtotime($m4));
			$m5m = date('m', strtotime($m5));
			$m4y = date('Y', strtotime($m4));
			$m5y = date('Y', strtotime($m5));
		}

		if (
			$m1 != $m2 && $m2 != $m3 && $m3 != $m4 && $m4 != $m5
			&& $m1 != $m3 && $m1 != $m4 && $m1 != $m5 && $m2 != $m4 && $m2 != $m5
			&& $m3 != $m5
		) {

			$query = "SELECT * FROM sem_list WHERE semester='$semester' AND session = '$sess'";
			$record = mysqli_query($link, $query);

			if (mysqli_num_rows($record) == 1) { ?>
				<script>
					alert('Record already exists!');
				</script>
			<?php
			} else if ($session1 >= $session2 || strlen($session1) != 4 || strlen($session2) != 4 || ($session2 - $session1 != 1)) {
			?>
				<script>
					alert('Please enter correct session!');
				</script>
			<?php
			} else if ($m1 == null || $m2 == null || $m3 == null || $m4 == null || $m5 == null) {
			?>
				<script>
					alert('Please select month!');
				</script>
				<?php
			} else {

				if ($status == 'DEFAULT') {
					$querye = "UPDATE sem_list SET status='OFF' WHERE status='DEFAULT'";
					$recorde = mysqli_query($link, $querye);
				}

				$query = "INSERT INTO `sem_list`(`semester`, `session`, `status`, `username`) 
				VALUES ('$semester','$sess','$status','$staffpos')";
				$record = mysqli_query($link, $query);

				if ($record) {
					$query2 = "SELECT sem_id from sem_list WHERE semester='$semester' AND session='$sess' ";
					$record2 = mysqli_query($link, $query2);

					while ($row2 = mysqli_fetch_assoc($record2)) {
						$semid = $row2['sem_id'];
					}

					$query3 = "INSERT INTO sem_duration (month, year, sem_id) VALUES ('$m1m', '$m1y', '$semid')";
					$record3 = mysqli_query($link, $query3);
					$query4 = "INSERT INTO sem_duration (month, year, sem_id) VALUES ('$m2m', '$m2y', '$semid')";
					$record4 = mysqli_query($link, $query4);
					$query5 = "INSERT INTO sem_duration (month, year, sem_id) VALUES ('$m3m', '$m3y', '$semid')";
					$record5 = mysqli_query($link, $query5);

					if ($semester != 3) {

						$query7 = "INSERT INTO sem_duration (month, year, sem_id) VALUES ('$m4m', '$m4y', '$semid')";
						$record7 = mysqli_query($link, $query7);
						$query8 = "INSERT INTO sem_duration (month, year, sem_id) VALUES ('$m5m', '$m5y', '$semid')";
						$record8 = mysqli_query($link, $query8);
					}
				?>
					<script>
						alert('Record Added');
						window.location.href = "managesem.php";
					</script>
			<?php
				}
			}
		} else {
			?>
			<script>
				alert('Please select month or enter different month');
			</script>
<?php
		}
	}
	require 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>