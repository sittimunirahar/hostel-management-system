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
			$hosn = $_POST['hos_n'];

			if (!empty($_POST['matric'])) {
				$matric2 = $_POST['matric'];
			} else {
				$matric2 = "";
			}

			$search_start = date_create($start);
			$search_end = date_create($end);

			$interval5 = date_diff($search_start, $search_end);

			if ($interval5->format('%R') == '+') {
		?>

				<br>
				<h3>Student Payment (<?php echo $starter . ' - ' . $ender; ?>)</h3>
				<hr>
				<?php

				if ($radio == 'Name') {

					$query = "SELECT *, pay_details.status as status, MONTH(pay_details.date_issued) as month, YEAR (pay_details.date_issued) AS year
					 FROM pay_details JOIN student_list
					 ON student_list.matric=pay_details.payer_id
					 WHERE pay_details.payer_id like '%$matric2' AND pay_details.status LIKE '%$status' 
					 AND pay_details.hos_name like '%$hosn' ORDER BY student_list.first_name";
				} else if ($radio == 'UnitNo') {
					$query = "SELECT *,  pay_details.status as status, MONTH(pay_details.date_issued) as month, YEAR (pay_details.date_issued) AS year
					 FROM pay_details JOIN student_list
					 ON student_list.matric=pay_details.payer_id
					 WHERE pay_details.payer_id like '%$matric2' AND pay_details.status LIKE '%$status' 
					  AND pay_details.hos_name like '%$hosn' ORDER BY pay_details.unit_no";
				} else {
					$query = "SELECT *, pay_details.status as status, MONTH(pay_details.date_issued) as month, YEAR (pay_details.date_issued) AS year
					 FROM pay_details JOIN student_list
					 ON student_list.matric=pay_details.payer_id
					 WHERE pay_details.payer_id like '%$matric2' AND pay_details.status LIKE '%$status' 
					  AND pay_details.hos_name like '%$hosn' ORDER BY pay_details.hos_name";
				}
				$record = mysqli_query($link, $query);

				$i = 0;

				?>
				<div id="reportexcel">
					<table style="border:1px solid black;" id="report">

						<tr>
							<th>No.</th>
							<th>Matric</th>
							<th>Name</th>
							<th>Month</th>
							<th>Year</th>
							<th>Hostel</th>
							<th>Unit</th>
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

									if ($interval1->format('%R%a') == '+0') {
										$matric = $row['payer_id'];
									} else {
										$matric = "";
									}
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
									<td><?php echo $row['payer_id'] ?></td>
									<td><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></td>
									<td><?php echo date('F', mktime(0, 0, 0, $row['month'], 10)); ?></td>
									<td><?php echo $row['year'] ?></td>
									<td><?php echo $row['hos_name'] ?></td>
									<td><?php echo $row['unit_no'] ?></td>
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