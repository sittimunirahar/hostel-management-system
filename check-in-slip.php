<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
?>
	<div class="content2">
		<?php
		if (!empty($_GET['matric'])) {
			$matric2 = $_GET['matric'];
		} else {
			$matric2 = "";
		}
		?>

		<?php

		$query2 = "SELECT first_name, last_name, year, program, status FROM student_list WHERE matric='$matric2'";
		$record2 = mysqli_query($link, $query2);
		$i = 0;

		?>
		<div id="reportexcel">
			<br>
			<h4> CHECK IN SLIP</h4>
			<hr>

			<table id="typical">
				<?php
				while ($row2 = mysqli_fetch_assoc($record2)) { ?>
					<tr>
						<th>Name:</th>
						<td><?php echo $row2['first_name'] . ' ' . $row2['last_name'] ?></td>
						<th>Matric No:</th>
						<td><?php echo $matric2 ?></td>
						<th>Year:</th>
						<td><?php echo $row2['year'] ?></td>
					</tr>
					<tr>
						<th>Program:</th>
						<td><?php echo $row2['program'] ?></td>
						<th>Status:</th>
						<td><?php echo $row2['status'] ?></td>
					</tr>
				<?php } ?>
			</table>
			<hr><br>

			<table style="border:1px solid black;" id="report">
				<?php

				$query = "SELECT * FROM stay_latest JOIN check_in USING (ci_id)
							WHERE stay_latest.matric='$matric2'";

				$record = mysqli_query($link, $query);
				while ($row = mysqli_fetch_assoc($record)) {

					$datein = '';
					$dateout = '';
					if (!empty($row['date_in'])) {
						$datein = date('d-m-Y', strtotime($row['date_in']));
					}
					if (!empty($row['date_out'])) {
						$dateout = date('d-m-Y', strtotime($row['date_out']));
					}
				?>
					<tr>
						<th style="width:20%"><b>HOSTEL: </b></th>
						<td><?php echo $row['hos_name'] ?></td>
					</tr>
					<tr>
						<th style="width:20%"><b>UNIT: </b></th>
						<td><?php echo $row['unit_no'] ?></td>
					</tr>
					<tr>
						<th style="width:20%"><b>DATE IN: </b></th>
						<td><?php echo $datein; ?></td>
					</tr>
					<tr>
						<th style="width:20%"><b>DATE OUT: </b></th>
						<td><?php echo $dateout; ?></td>
					</tr>
					<tr>
						<th style="width:20%"><b>STATUS: </b></th>
						<td>CHECK IN</td>
					</tr>
				<?php
				}
				?>

			</table>
			<br>
			<hr>
			<em>This is computer generated document. No signature required. </em><br>

			<?php
			$query = "SELECT * FROM admin_acc JOIN staff_acc ON admin_acc.username = staff_acc.id 
			LEFT JOIN uploads ON admin_acc.username=uploads.description
			WHERE admin_acc.username='$username'";
			$record = mysqli_query($link, $query);
			while ($row = mysqli_fetch_assoc($record)) {
				$staffname = strtoupper($row['name']);
			} ?>
			<br>
			Printed by: <?php echo $staffname ?>
		</div>
		<br>
		<div id="buttonspace">
			<input id="printbut" type="button" value="Print" class="btn btn-primary" onClick="window.print();" />
			<input name="ok" type="button" value="Close" class="btn btn-primary" onClick="window.close();" style="float:right;margin-left:5px;" />
			<input name="back" type="button" style="float:right" value="Back" class="btn btn-primary" onClick="window.history.back();" />
		</div>
		<br><br>
	</div>
	</div>
<?php
	require 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>