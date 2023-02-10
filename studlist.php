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
				<h3>List of student staying in Hostel (<?php echo $starter . ' - ' . $ender; ?>)</h3>
				<hr>
				<?php

				if ($radio == 'Name') {

					$query = "SELECT student_list.matric as matric, CONCAT_WS(' ', student_list.first_name, student_list.last_name) as name, 
				    check_in.unit_no, check_in.hos_name, check_in.date_in,
					check_out.date_out FROM student_list JOIN check_in ON check_in.matric=student_list.matric
					LEFT JOIN check_out ON check_in.matric=check_out.matric
					 AND check_in.unit_no=check_out.unit_no AND check_in.hos_name=check_out.hos_name
					 AND check_in.date_in<=check_out.date_out
					 WHERE check_in.hos_name like '%$hosn' ORDER BY name
					";
				} else if ($radio == 'UnitNo') {
					$query = "SELECT student_list.matric as matric, CONCAT_WS(' ', student_list.first_name, student_list.last_name) as name, 
				    check_in.unit_no, check_in.hos_name, check_in.date_in,
					check_out.date_out FROM student_list JOIN check_in ON check_in.matric=student_list.matric
					LEFT JOIN check_out ON check_in.matric=check_out.matric
					 AND check_in.unit_no=check_out.unit_no AND check_in.hos_name=check_out.hos_name
					 AND check_in.date_in<=check_out.date_out
					 WHERE check_in.hos_name like '%$hosn' ORDER BY check_in.unit_no";
				} else {
					$query = "SELECT student_list.matric as matric, CONCAT_WS(' ', student_list.first_name, student_list.last_name) as name, 
				    check_in.unit_no, check_in.hos_name, check_in.date_in,
					check_out.date_out FROM student_list JOIN check_in ON check_in.matric=student_list.matric
					LEFT JOIN check_out ON check_in.matric=check_out.matric
					AND check_in.unit_no=check_out.unit_no AND check_in.hos_name=check_out.hos_name
					AND check_in.date_in<=check_out.date_out
					WHERE check_in.hos_name like '%$hosn' ORDER BY check_in.unit_no";
				}
				$record = mysqli_query($link, $query);

				$i = 0;
				$matric = "";
				?>
				<div id="reportexcel">
					<table style="border:1px solid black;" id="report">

						<tr>
							<th>No.</th>
							<th>Name</th>
							<th>Matric</th>
							<th>Date In</th>
							<th>Date Out</th>
							<th>Hostel Name</th>
							<th>Unit No</th>
						</tr>

						<?php
						while ($row = mysqli_fetch_assoc($record)) {
							//echo $row['date_in'];

							$date_in1 = $row['date_in'];

							if ($row['date_out'] != null || $row['date_out'] != '') {
								$date_out1 = $row['date_out'];
							} else {
								$date_out1 = null;
							}

							$date_in = date_create($date_in1);
							$date_out = date_create($date_out1);


							//echo $start;
							//echo $end;
							$interval1 = date_diff($date_in, $search_start); //start date eg feb 2015 - jan 2016 = -
							$interval3 = date_diff($date_in, $search_end);


							//if the student once stayed
							if ($date_in1 != null) {

								if ($date_out1 == null || $date_out1 == '') {
									if ($interval1->format('%R') == '-' && $interval3->format('%R') == '-') { //if that particular date in after the search start

										$matric = "";
									} else {
										$matric = $row['matric'];
									}
								} else {
									$interval2 = date_diff($search_start, $date_out);
									$interval4 = date_diff($search_end, $date_out);

									if ($interval2->format('%R') == '-' && $interval1->format('%R') == '+') {
										// if date in after search start
										$matric = "";
									} else if ($interval3->format('%R') == '+' && $interval4->format('%R') == '+') {
										$matric = "";
									} else {
										if ($interval1->format('%R') == '-' && $interval3->format('%R') == '-') { //if that particular date in after the search start

											$matric = "";
										} else {
											$matric = $row['matric'];
										}
									}
								}
							}

							if ($matric != null) {
								$i++;

						?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row['name'] ?></td>
									<td><?php echo $row['matric']; ?></td>
									<td><?php echo $row['date_in']; ?></td>
									<td><?php echo $row['date_out']; ?></td>
									<td><?php echo $row['hos_name']; ?></td>
									<td><?php echo $row['unit_no']; ?></td>
								</tr>
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