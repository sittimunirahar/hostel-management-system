<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	$ss = '';
	$sm = '';

	if (!empty($_GET['ss']) && !empty($_GET['sm'])) {
		$ss = $_GET['ss'];
		$sm = $_GET['sm'];
	}
?>


	<div class="content2">

		<br>
		<h3><?php echo 'Semester ' . $sm . ' Session ' . $ss; ?></h3>
		<hr>

		<?php
		$status = '';
		$admin = '';

		$query = "SELECT * FROM sem_list JOIN sem_duration USING (sem_id)
		     WHERE sem_list.session='$ss' AND  sem_list.semester='$sm'";
		$record = mysqli_query($link, $query);


		while ($row = mysqli_fetch_assoc($record)) {
			$status = $row['status'];
			$admin = $row['username'];
			$sid = $row['sem_id'];
		}
		$totm = 0;
		$totm = mysqli_num_rows($record);

		$query = "SELECT * FROM sem_list JOIN sem_duration USING (sem_id)
		     WHERE sem_list.session='$ss' AND  sem_list.semester='$sm'";
		$record = mysqli_query($link, $query);
		?>

		<table id="typical">

			<tr>
				<th>Status:</th>
				<td><?php echo $status ?></td>
				<th>Total Months:</th>
				<td><?php echo $totm ?></td>
				<th>Last Edited By:</th>
				<td><?php echo $admin ?></td>
			</tr>

		</table>

		<hr><br>
		<table class="display table" id="tabledata">
			<thead>
				<tr>

					<th style="background-color:#267871; color:white">Month</th>
					<th style="background-color:#267871; color:white">Year</th>

				</tr>
			</thead>
			<tbody>
				<?php
				while ($row = mysqli_fetch_assoc($record)) { ?>
					<tr>

						<td style="background-color:#fff;">
							<?php echo date('F', mktime(0, 0, 0, $row['month'], 10)); ?></td>
						<td style="background-color:#fff;"><?php echo $row['year'] ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<br>
		<form method="post">
			<input name="editsem" type="button" value="Edit" class="btn btn-primary" onClick="document.location.href=('editsem.php?sm=<?php echo $sm; ?>&ss=<?php echo $ss; ?>&sid=<?php echo $sid; ?>');" />

			<input name="del" type="submit" value="Delete" class="btn btn-primary" />

			<input name="ok" type="button" value="Close" class="btn btn-primary" onClick="window.close();" style="float:right;" />
		</form>
	</div>

	</div>
	<?php

	if (isset($_POST['del'])) {
		extract($_REQUEST);
		$query = "SELECT * FROM fees_setting WHERE sem_id='$sid'";
		$record = mysqli_query($link, $query);
		if (mysqli_num_rows($record) != 0) {
	?>

			<script>
				alert('You are not allowed to delete this semester!');
			</script>
		<?php
		} else {
		?>
			<script>
				if (confirm("Are you sure to delete this semester record?")) {
					window.location.href = "deletesem.php?sid=<?php echo $sid; ?>";
				}
			</script>
<?php
		}
	}

	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>