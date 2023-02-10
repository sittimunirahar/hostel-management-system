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
			//$radio=$_POST['radio'];
			$hosn = $_POST['hos_n'];
			$mo = 0;
			$yo = 0;
			$t = 0;
			$maxhos = 0;
			$k = 0;
			$l = 0;
			$mok = '';
			$tok = 0;

			$query = "select hostel_details.hos_name, hostel_details.hos_gender from hostel_details LEFT JOIN hostel_closed ON hostel_details.hos_name=hostel_closed.hos_name
				where hostel_closed.date_closed IS NULL";
			$record = mysqli_query($link, $query);
			$maxhos = mysqli_num_rows($record);

			$search_start = date_create($start);
			$search_end = date_create($end);

			$interval5 = date_diff($search_start, $search_end);

			if ($interval5->format('%R') == '+') {
		?>

				<br>
				<h3>List of student staying in Hostel (<?php echo $starter . ' - ' . $ender; ?>)</h3>
				<hr>
				<?php

				$maxmon = round(floatval($interval5->format('%a')) / 30);
				//$l=$maxmon*$maxhos;
				//echo $maxmon;

				$query = "SELECT DISTINCT sem_duration.month, sem_duration.year, hostel_details.hos_name FROM sem_duration JOIN hostel_details";

				$record = mysqli_query($link, $query);


				$i = 0;
				$matric = "";
				?>
				<div id="reportexcel">
					<table style="border:1px solid black;" id="report">
						<tr>
							<th>No. </th>
							<th>Hostel Name</th>


							<?php

							while ($row = mysqli_fetch_assoc($record)) {
								//echo $row['date_in'];
								$m = $row['month'];
								$y = $row['year'];
								$hn = $row['hos_name'];
								$date = $y . '-' . $m . '-' . '01';
								$date_is = date("Y-m-t", strtotime($date));
								$pid;


								$date_exp = date_create($date_is);

								$interval1 = date_diff($date_exp, $search_start);
								$interval3 = date_diff($date_exp, $search_end);

								if ($date_exp != null) {

									if ($interval1->format('%R') == '+' && $interval3->format('%R') == '+') {
										$pid = "";
									} else if ($interval1->format('%R') == '-' && $interval3->format('%R') == '-') {
										$pid = "";
									} else {
										$pid = $row['hos_name'];
									}
								}
								//$uno=$row['unit_no'];
								if ($pid != null) {
									$i++;

									//echo $mo;
									if (($row['month'] != $mo) || ($row['year'] != $yo)) {

										$mo = $row['month'];
										$yo = $row['year'];
										$t = 1;
									} else {
										$t = 0;
									}


									if ($t == 1) { ?>
										<th style="text-align:center;background-color:#ddd"><?php echo date('F', mktime(0, 0, 0, $row['month'], 10)); ?>
											<?php echo $row['year'] ?></th>

							<?php
									}
								}
							}
							?>
						</tr><?php





									$query = "SELECT DISTINCT sem_duration.month, sem_duration.year, hostel_details.hos_name FROM sem_duration JOIN hostel_details
				ORDER BY hostel_details.hos_name, sem_duration.month, sem_duration.year";

									$record = mysqli_query($link, $query);



									while ($row = mysqli_fetch_assoc($record)) {
										//echo $row['date_in'];
										$m = $row['month'];
										$y = $row['year'];
										$hn = $row['hos_name'];
										$date = $y . '-' . $m . '-' . '01';
										$date_is = date("Y-m-t", strtotime($date));
										$pid;

										$query_occ = "SELECT DISTINCT payer_id as totocc FROM pay_details
					WHERE hos_name='$hn' AND month(date_issued)='$m'
					AND year(date_issued)='$y'";
										$record_occ = mysqli_query($link, $query_occ);
										$totocc = mysqli_num_rows($record_occ);

										$date_exp = date_create($date_is);

										$interval1 = date_diff($date_exp, $search_start); //start date eg feb 2015 - jan 2016 = -
										$interval3 = date_diff($date_exp, $search_end);

										if ($date_exp != null) {

											if ($interval1->format('%R') == '+' && $interval3->format('%R') == '+') {
												$pid = "";
											} else if ($interval1->format('%R') == '-' && $interval3->format('%R') == '-') {
												$pid = "";
											} else {
												$pid = $row['hos_name'];
											}
										}
										//$uno=$row['unit_no'];
										if ($pid != null) {
											$k++;
											// echo $row['hos_name'];


											if (($row['hos_name'] != $mok)) {
												$mok = $row['hos_name'];
												$tok = 1;
												$l++;
											} else {
												$tok = 0;
											}

											if ($tok == 1) { ?>
									<td><?php echo $l; ?></td>
									<td><?php echo $row['hos_name']; ?></td> <?php } ?>
								<td><?php echo $totocc ?></td>
								<?php if ($k % $maxmon == 0) { ?>
									</tr>
									<tr>
							<?php
											}
										}
									}
								} else {
							?><script>
								alert('Please enter the time interval correctly');
								window.history.back();
							</script><?php
											}
										} ?>
									</tr>
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