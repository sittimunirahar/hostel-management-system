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

				<h3>Hostel Profit & Loss (<?php echo '<b>' . $starter . '</b> to <b>' . $ender . '</b>'; ?>)</h3>
				<hr>
				<?php

				if ($radio == 'RentalF') {

					$query = "SELECT * FROM fees_setting WHERE description LIKE '%$hosn' ORDER BY fees_per_month";
				} else if ($radio == 'mn') {
					$query = "SELECT * FROM fees_setting WHERE description LIKE '%$hosn' ORDER BY year, month ASC";
				}
				//hostel
				else {
					$query = "SELECT * FROM fees_setting WHERE description LIKE '%$hosn' ORDER BY description";
				}
				$record = mysqli_query($link, $query);

				$i = 0;

				?>
				<div id="reportexcel" style="text-align:center">
					<table style="border:1px solid black;" id="report">

						<tr>
							<th>No.</th>
							<th>Hostel</th>
							<th>Month</th>
							<th>Year</th>
							<th>No of Student</th>
							<th>Fee/Student</th>
							<th>Sales</th>
							<th>Revenue</th>
							<th>Unpaid</th>
							<th>No of Unit</th>
							<th>Hostel Cost</th>
							<th>Net Profit</th>

						</tr>

						<?php

						$amt2 = 0;
						$amt3 = 0;

						while ($row = mysqli_fetch_assoc($record)) {
							//echo $row['date_in'];

							$m = $row['month'];
							$y = $row['year'];
							$hn = $row['description'];
							$date = $y . '-' . $m . '-' . '01';
							$date_is = date("Y-m-t", strtotime($date));
							$date_is1 = date("Y-m-t", strtotime($date));
							$fid;
							$uno = 0;
							$rf = 0;

							$query_rf = "SELECT * FROM owner_list LEFT JOIN unit_list
						  USING (owner_id) WHERE unit_list.hos_name LIKE '%$hn'";
							$record_rf = mysqli_query($link, $query_rf);



							while ($row_rf = mysqli_fetch_assoc($record_rf)) {
								$date_is1 = $row_rf['expiry_date'];

								$date_exp1 = date_create($date_is1);

								$interval11 = date_diff($date_exp1, $search_start); //start date eg feb 2015 - jan 2016 = -
								$interval31 = date_diff($date_exp1, $search_end);

								if ($date_exp1 != null) {

									if ($interval11->format('%R') == '+' && $interval31->format('%R') == '+') { //if that particular date in after the search start
										$uno += 0;
										$rf += 0;
									} else {
										$uno++;
										$rf += $row_rf['rental'];
									}
								}
							}

							$query_occ = "SELECT DISTINCT payer_id as totocc FROM pay_details
					WHERE hos_name='$hn' AND month(date_issued)='$m'
					AND year(date_issued)='$y'";
							$record_occ = mysqli_query($link, $query_occ);
							$totocc = mysqli_num_rows($record_occ);

							$query_sum = "SELECT SUM(amount) as amt,
					sum(case when pay_details.status='INVOICED' then pay_details.amount else 0 end) as amt_due, 
					sum(case when pay_details.status='PAID' then pay_details.amount else 0 end) as amt_paid
					FROM pay_details
					WHERE hos_name='$hn' AND month(date_issued)='$m'
					AND year(date_issued)='$y'";
							$record_sum = mysqli_query($link, $query_sum);

							$amt = 0;
							$amt_due = 0;
							$amt_paid = 0;

							while ($row_sum = mysqli_fetch_assoc($record_sum)) {
								$amt = $row_sum['amt'];
								$amt_due = $row_sum['amt_due'];
								$amt_paid = $row_sum['amt_paid'];
							}


							$date_exp = date_create($date_is);

							$interval1 = date_diff($date_exp, $search_start); //start date eg feb 2015 - jan 2016 = -
							$interval3 = date_diff($date_exp, $search_end);

							if ($date_exp != null) {

								if ($interval1->format('%R') == '+' && $interval3->format('%R') == '+') { //if that particular date in after the search start
									$fid = "";
								} else if ($interval1->format('%R') == '-' && $interval3->format('%R') == '-') { //if that particular date in after the search start
									$fid = "";
								} else {
									$fid = $row['fees_id'];
								}
							}
							//$uno=$row['unit_no'];
							if ($fid != null) {
								$i++;
								//$real=($row['fees_per_month']*$totocc)-$amt;
								$proflos = 0;

						?>

								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row['description'] ?></td>
									<td><?php echo date('F', mktime(0, 0, 0, $row['month'], 10)); ?></td>
									<td><?php echo $row['year'] ?></td>
									<td><?php echo $totocc ?></td>
									<td><?php echo '$' . number_format($row['fees_per_month']); ?></td>
									<td style="background-color:#E2FFE9"><?php echo '$' . number_format($amt); ?></td> <!--sales-->
									<td style="background-color:#E2FFE9"><?php echo '$' . number_format($amt_paid); ?></td> <!--revenue-->
									<td><?php echo '$' . number_format($amt_due); ?></td> <!--accrued-->
									<td><?php echo $uno; ?></td>
									<td><?php echo '$' . number_format($rf); ?></td>
									<td style="background-color:#E2FFE9"><?php echo '$' . number_format(($amt - $amt_due) - $rf); ?></td>
									<?php $amt2 += (($amt - $amt_due) - $rf); ?>
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
				<tr>
					<td colspan=11 style="background-color:#80ff9b">
						<b>Total Profit/Loss: </b>
					</td>
					<td style="background-color:#80ff9b">
						<?php echo '$' . number_format($amt2); ?>
					</td>
				</tr>
					</table>
					<br>

					<div style="text-align:left">
						* <b>Sales</b>: Total profit acquired from charging student by fixed rate per month
						<br>* <b>Revenue: </b> Total sales - Unpaid fees
						<br>* <b>Net profit: </b> Total revenue - Hostel cost
					</div>

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