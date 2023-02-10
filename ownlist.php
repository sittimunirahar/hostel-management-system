<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
?><br>
	<div class="content2">
		<?php
		if (isset($_POST['gorep1'])) {
			$start = $_POST['strt'];
			$start = date("Y-m-01", strtotime($start));
			$starter = date("F Y", strtotime($start));
			$end = $_POST['end'];
			$end = date("Y-m-t", strtotime($end));
			$ender = date("F Y", strtotime($end));
			$radio = $_POST['radio'];
			$hosn = $_POST['hos_n'];

			$search_start = date_create($start);
			$search_end = date_create($end);

			$interval5 = date_diff($search_start, $search_end);

			if ($interval5->format('%R') == '+') {
		?>

				<br>
				<h3>List of Unit (<?php echo $starter . ' - ' . $ender; ?>)</h3>
				<hr>
				<?php

				if ($radio == 'RentalF') {

					$query = "SELECT * FROM owner_list JOIN unit_list
						  USING (owner_id) WHERE unit_list.hos_name LIKE '%$hosn' ORDER BY unit_list.rental";
				} else if ($radio == 'UnitNo') {
					$query = "SELECT * FROM owner_list JOIN unit_list
						  USING (owner_id) WHERE unit_list.hos_name LIKE '%$hosn' 
						  ORDER BY unit_list.unit_no";
				} else if ($radio == 'Exp') {
					$query = "SELECT * FROM owner_list JOIN unit_list
						  USING (owner_id) WHERE unit_list.hos_name LIKE '%$hosn' ORDER BY owner_list.expiry_date";
				}
				//hostel
				else {
					$query = "SELECT * FROM owner_list JOIN unit_list
						  USING (owner_id) WHERE unit_list.hos_name LIKE '%$hosn' ORDER BY unit_list.hos_name";
				}
				$record = mysqli_query($link, $query);

				$i = 0;

				?>
				<div id="reportexcel">
					<table style="border:1px solid black;" id="report">

						<tr>
							<th>No.</th>
							<th>Name of Owner</th>
							<th>Phone No</th>
							<th>Email</th>
							<th>Unit No</th>
							<th>Hostel Name</th>
							<th>Expiry Date</th>
							<th>Remarks</th>
						</tr>

						<?php
						while ($row = mysqli_fetch_assoc($record)) {
							//echo $row['date_in'];

							$date_is = $row['expiry_date'];

							$date_exp = date_create($date_is);

							$interval1 = date_diff($date_exp, $search_start); //start date eg feb 2015 - jan 2016 = -
							$interval3 = date_diff($date_exp, $search_end);

							if ($date_exp != null) {

								if ($interval1->format('%R') == '+' && $interval3->format('%R') == '+') { //if that particular date in after the search start
									$uno = "";
								} else {
									$uno = $row['unit_no'];
								}
							}


							//$uno=$row['unit_no'];
							if ($uno != null) {
								$i++;

						?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row['owner_name'] ?></td>
									<td><?php echo $row['owner_hp'] ?></td>
									<td><?php echo $row['owner_email'] ?></td>
									<td><?php echo $row['unit_no'] ?></td>
									<td><?php echo $row['hos_name'] ?></td>
									<td><?php echo $row['expiry_date'] ?></td>
									<td><?php echo $row['remarks'] ?></td>

							<?php
							}
						}
					} else {
							?><script>
								alert('Please enter the time interval correctly');
								window.history.back();
							</script><?php
											}
										} ?>

					</table>
				</div>
				<br>
				<div id="buttonspace">
					<input id="printbut" type="button" value="Print" class="btn btn-primary" onClick="window.print();" />
					<input type="button" id="btnExport" value="Excel" class="btn btn-primary" />
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