<?php
require 'upperbody2.php';

if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
?>
	<div class="content2">
		<?php
		$staffname = '';
		$title = "";

		if (isset($_POST['gorep1'])) {
			if (!empty($_POST['matric'])) {
				$matric2 = $_POST['matric'];
			} else {
				$matric2 = "";
			}
		?>

			<?php
			$query = "SELECT * FROM stay_latest
						 WHERE matric='$matric2'";
			$record = mysqli_query($link, $query);

			$query2 = "SELECT first_name, last_name, year, program, status FROM student_list WHERE matric='$matric2'";
			$record2 = mysqli_query($link, $query2);
			$i = 0;

			?>
			<div id="reportexcel">


				<?php
				while ($row = mysqli_fetch_assoc($record)) {

					if ($row['status'] == 'CI') {
						$title = 'CHECK IN';
					} else {
						$title = 'CHECK OUT';
					}
				}
				?><br>

				<table width=100% style="text-align:center;border:1px solid green">
					<tr>
						<td><img src="img/IIC.png" width="290" height="80"></td>
					</tr>
				</table>

				<br>
				<h4><?php echo $title ?> SLIP</h4>
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
							<th>Date:</th>
							<td><?php echo date('d M Y'); ?></td>
						</tr>
					<?php } ?>
				</table>
				<hr><br>

				<table style="border:1px solid black;" id="report">

					<!--<tr>
						<th>Hostel Name</th>
						<th>Unit No</th>
						<th>Date In</th>
						<th>Date Out</th>
					</tr>-->

					<?php
					if ($title == "CHECK IN") {
						$query = "SELECT * FROM stay_latest JOIN check_in USING (ci_id)
					WHERE stay_latest.matric='$matric2'";
					} else if ($title == null) {
						echo "The entered student has no record";
					} else {
						$query = "SELECT * FROM stay_latest JOIN check_out USING (co_id) JOIN check_in USING (ci_id)
					WHERE stay_latest.matric='$matric2'";
					}
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
							<td><?php echo $title ?></td>
						</tr>
				<?php
					}
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