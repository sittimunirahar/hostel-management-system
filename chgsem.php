<?php
require 'upperbody3.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
?>
	<div class="list-group">
		<a href="index.php" class="list-group-item">
			<i class="fa fa-building"></i>HOSTEL</a>
		<a href="allocation.php" class="list-group-item">
			<i class="fa fa-key"></i>ALLOCATION</a>
		<a href="payment.php" class="list-group-item">
			<i class="fa fa-credit-card"></i>FINANCIAL</a>
		<a href="services.php" class="list-group-item">
			<i class="fa fa-bar-chart"></i>REPORT</a>
		<a href="home.php" class="list-group-item">
			<i class="fa fa-home"></i>HOME</a>
	</div>

	</div>

	<!-- Close div sideleft-->
	</div>

	<div class="content">

		<br>
		<h3>Change Semester</h3>
		<hr>

		<!-- semester table -->


		<form method="post">
			<?php
			$query = "SELECT * FROM sem_list";
			$record = mysqli_query($link, $query);
			?>
			<table class="display table" id="tabledata">
				<thead>
					<tr>
						<th scope="col"></th>
						<th scope="col">Semester</th>
						<th scope="col">Session</th>
						<th scope="col">Status</th>
						<th scope="col">Students in Hostel</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($row = mysqli_fetch_assoc($record)) { ?>
						<tr>
							<td><input type="radio" id="chgsemrad" name="chgsemrad" value="<?php echo $row['sem_id'] ?>"></td>
							<td><?php echo $row['semester'] ?></td>
							<td><?php echo $row['session'] ?></td>
							<td><?php echo $row['status'] ?></td>
							<td></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<br>

			<div class="addhostel">
				<p>
					<input id="chgsem" name="chgsem" type="submit" value="OK" class="btn btn-primary" />
				</p>
			</div>
		</form>
	</div>

	<?php
	if (isset($_POST['chgsem'])) {
		$message = "You are about to change from semester " . $sem . " " . $ses;

		$sid = $_POST['chgsemrad'];
		$ses = "";
		$sem = "";

		$query = "SELECT * FROM sem_list WHERE sem_id='$sid'";
		$record = mysqli_query($link, $query);
		while ($row = mysqli_fetch_assoc($record)) {
			$ses = $row['session'];
			$sem = $row['semester'];
			$stat = $row['status'];
		}
		$message = $message . " to semester " . $sem . " " . $ses;
		echo "<script type='text/javascript'>alert('$message');</script>";
		$_SESSION['sid'] = $sid;
		$_SESSION['sem'] = $sem;
		$_SESSION['ses'] = $ses;
		$_SESSION['stat'] = $stat;
		$month = "all";

	?>
		<script>
			window.location = 'index.php';
		</script>
	<?php
	}
	?>

	</div>

<?php


	require 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>