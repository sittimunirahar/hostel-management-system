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

				<h3>List of Fees (<?php echo $starter . ' - ' . $ender; ?>)</h3>
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
				<div id="reportexcel">
					<table style="border:1px solid black;" id="report">

						<tr>
							<th>No.</th>
							<th>Hostel</th>
							<th>Month</th>
							<th>Year</th>
							<th>Fee/Student</th>
							<th>No of Student</th>
							<th>Unpaid</th>
							<th>Paid</th>
							<th>Sales</th>

						</tr>

						<?php


						while ($row = mysqli_fetch_assoc($record)) {
							//echo $row['date_in'];

							$m = $row['month'];
							$y = $row['year'];
							$hn = $row['description'];
							$date = $y . '-' . $m . '-' . '01';
							$date_is = date("Y-m-t", strtotime($date));
							$fid;

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

								if ($interval1->format('%R') == '+' && $interval3->format('%R') == '+') {
									$fid = "";
								} else {
									$fid = $row['fees_id'];
								}
							}
							//$uno=$row['unit_no'];
							if ($fid != null) {
								$i++;
								$real = ($row['fees_per_month'] * $totocc) - $amt;

						?>

								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row['description'] ?></td>
									<td><?php echo date('F', mktime(0, 0, 0, $row['month'], 10)); ?></td>
									<td><?php echo $row['year'] ?></td>
									<td><?php echo '$' . $row['fees_per_month'] ?></td>
									<td><?php echo $totocc ?></td>
									<td><?php echo '$' . number_format($amt_due) ?></td>
									<td><?php echo '$' . number_format($amt_paid) ?></td>
									<td><?php echo '$' . number_format($amt); ?></td>
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