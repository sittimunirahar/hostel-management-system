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
			$status = $_POST['status'];
			$payt = $_POST['pay_t'];


			$search_start = date_create($start);
			$search_end = date_create($end);

			$interval5 = date_diff($search_start, $search_end);

			if ($interval5->format('%R') == '+') {
		?>


				<h3>College Payment (<?php echo $starter . ' - ' . $ender; ?>)</h3>
				<hr>
				<?php

				if ($radio == 'Name') {

					$query = "SELECT *, MONTH(date_issued) as month, YEAR (date_issued) AS year
					 FROM pay_details_college 
					 WHERE status LIKE '%$status' 
					 AND pay_type LIKE '%$payt'
					 ORDER BY payee_name";
				} else {
					$query = "SELECT *, MONTH(date_issued) as month, YEAR (date_issued) AS year
					 FROM pay_details_college 
					 WHERE status LIKE '%$status' 
					 AND pay_type LIKE '%$payt'
					 ORDER BY date_issued";
				}
				$record = mysqli_query($link, $query);

				$i = 0;

				?>
				<div id="reportexcel">
					<table style="border:1px solid black;" id="report">

						<tr>
							<th>No.</th>
							<th>Name</th>
							<th>Month</th>
							<th>Year</th>
							<th>Pay Type</th>
							<th>Fee</th>
							<th>Status</th>
							<th>Reference No</th>
							<th>Date of Payment</th>
						</tr>

						<?php
						while ($row = mysqli_fetch_assoc($record)) {
							//echo $row['date_in'];

							$date_is = $row['date_issued'];

							$date_issued = date_create($date_is);
							//$date_out=date_create($date_out1);


							//echo $start;
							//echo $end;
							$interval1 = date_diff($date_issued, $search_start); //start date eg feb 2015 - jan 2016 = -
							$interval3 = date_diff($date_issued, $search_end);


							//if the student once stayed
							if ($date_issued != null) {


								if ($interval1->format('%R') == '+' && $interval3->format('%R') == '+') { //if that particular date in after the search start
									$matric = "";
								} else if ($interval1->format('%R') == '-' && $interval3->format('%R') == '-') { //if that particular date in after the search start
									$matric = "";
								} else {
									$matric = $row['payer_id'];
								}
							}



							if ($matric != null) {
								$i++;

						?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row['payee_name'] ?></td>
									<td><?php echo date('F', mktime(0, 0, 0, $row['month'], 10)); ?></td>
									<td><?php echo $row['year'] ?></td>
									<td><?php echo $row['pay_type'] ?></td>
									<td><?php echo floatval($row['amount']); ?></td>
									<td><?php echo $row['status'] ?></td>
									<td><?php echo $row['pay_voucher'] ?></td>
									<td><?php echo $row['date_of_payment'] ?></td>
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