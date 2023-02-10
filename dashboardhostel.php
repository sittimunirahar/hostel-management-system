<?php
require 'database/credentials.php';
require 'templates/user_login.php';

if ($online) {
	require 'templates/header.php';
?>

	<?php
	$mon = date("m");
	$yer = date('Y');

	$rf = 0;
	$rev = 0;
	$salespercent = 0;
	$salespercent2 = 0;
	$date_is1 = '';
	$search_start = date_create(date('01-m-d'));
	$warning = "";
	$warning2 = "";
	$tot = 0;
	$tot_o = 0;
	$rev2 = 0;
	$gp = 0;
	$gp2 = 0;
	$paidocc = 0;
	$upaidocc = 0;
	$all_paidocc = 0;
	$all_upaidocc = 0;
	$occ = 0;
	$occtot = 0;
	$koi = "";

	$q_amt = "SELECT SUM(amount) as amt
					FROM pay_details
					WHERE month(date_issued)='$mon'
					AND year(date_issued)='$yer'";
	$record_qa = mysqli_query($link, $q_amt);
	while ($row_qa = mysqli_fetch_assoc($record_qa)) {
		$tot = $row_qa['amt'];
	}

	$qpaid = "SELECT * FROM pay_details WHERE status='PAID' AND month(date_issued)='$mon' AND year(date_issued)='$yer'";
	$rqp = mysqli_query($link, $qpaid);
	$paidocc = mysqli_num_rows($rqp);

	$qpaid = "SELECT * FROM pay_details WHERE status='INVOICED' AND month(date_issued)='$mon' AND year(date_issued)='$yer'";
	$rqp = mysqli_query($link, $qpaid);
	$upaidocc = mysqli_num_rows($rqp);

	$qpaid = "SELECT * FROM pay_details WHERE status='PAID'";
	$rqp = mysqli_query($link, $qpaid);
	$all_paidocc = mysqli_num_rows($rqp);

	$qpaid = "SELECT * FROM pay_details WHERE status='INVOICED'";
	$rqp = mysqli_query($link, $qpaid);
	$all_upaidocc = mysqli_num_rows($rqp);

	$q_amt2 = "SELECT SUM(amount) as amt
					FROM pay_details";
	$record_qa2 = mysqli_query($link, $q_amt2);
	while ($row_qa2 = mysqli_fetch_assoc($record_qa2)) {
		$tot_o = $row_qa2['amt'];
	}

	$totall = 0;
	$d = '';
	$date = '';
	$query = "SELECT distinct sem_duration.month, sem_duration.year FROM sem_duration JOIN fees_setting
	WHERE fees_setting.month = sem_duration.month AND fees_setting.year = sem_duration.year";
	$record_1 = mysqli_query($link, $query);
	while ($r = mysqli_fetch_assoc($record_1)) {
		//from db
		$date = $r['year'] . '-' . $r['month'] . '-1';
		$d = date("Y-m-d", strtotime($date));
		$s = date_create($d);

		//echo $d;

		$query_rf = "SELECT * FROM owner_list LEFT JOIN unit_list USING (owner_id)";
		$record_rf = mysqli_query($link, $query_rf);

		while ($row_rf = mysqli_fetch_assoc($record_rf)) {

			$date_is1 = $row_rf['expiry_date'];

			$date_exp1 = date_create($date_is1);

			$interval11 = date_diff($date_exp1, $s);
			$interval22 = date_diff($date_exp1, $search_start);
			//echo 'compare: '.$date.' with '.$date_is1;

			if ($date_exp1 != null) {
				if ($interval11->format('%R') == '+') {
					$totall += 0;
				} else {
					$totall += $row_rf['rental'];
					//echo '<center>'.$r['month'].' - '.$r['year'].' - '.$row_rf['rental'].' - '.$row_rf['owner_name'].'</center>';
				}
			}
		}
	}


	$occ = $paidocc + $upaidocc;


	$query_rf = "SELECT * FROM owner_list LEFT JOIN unit_list USING (owner_id)";
	$record_rf = mysqli_query($link, $query_rf);

	while ($row_rf = mysqli_fetch_assoc($record_rf)) {

		$date_is1 = $row_rf['expiry_date'];

		$date_exp1 = date_create($date_is1);

		$interval11 = date_diff($date_exp1, $search_start);

		if ($date_exp1 != null) {
			if ($interval11->format('%R') == '+') { //if that particular date in after the search start
				$rf += 0;
			} else {
				$rf += $row_rf['rental'];
				$koi = $row_rf['hos_name'];
				$query = "SELECT unit_max_occ FROM hostel_details WHERE hos_name='$koi'";
				$rec = mysqli_query($link, $query);
				while ($row_k = mysqli_fetch_assoc($rec)) {
					$occtot += $row_k['unit_max_occ'];
				}
			}
		}
	}


	$query = "SELECT * FROM pay_details where MONTH(date_issued)='$mon' and YEAR(date_issued)='$yer' and status='PAID'";
	$record = mysqli_query($link, $query);


	while ($row = mysqli_fetch_assoc($record)) {
		$rev += $row['amount'];
	}

	$query2 = "SELECT * FROM pay_details where status='PAID'";
	$record2 = mysqli_query($link, $query2);

	while ($row2 = mysqli_fetch_assoc($record2)) {
		$rev2 += $row2['amount'];
	}

	if (mysqli_num_rows($record) > 0) {
		$salespercent = round(($rev / $tot) * 100);
	} else {
		$salespercent = 0;
	}

	$salespercent2 = round(($rev2 / $tot_o) * 100);
	$gp = $rev - $rf;
	$gp2 = $rev2 - $totall;

	if ($salespercent <= 30) {
		$warning = "LOW SALES";
	} else if ($salespercent <= 70) {
		$warning = "MEDIUM SALES";
	} else {
		$warning = "HIGH SALES";
	}

	if ($salespercent2 <= 30) {
		$warning2 = "LOW SALES";
	} else if ($salespercent2 <= 70) {
		$warning2 = "MEDIUM SALES";
	} else {
		$warning2 = "HIGH SALES";
	}

	?>


	<!-- Page Content -->

	<div id="sideleft">
		<?php
		require 'templates/nav_hostel.php';
		?>
	</div>

	<div class="content">
		<h3>DASHBOARD</h3>
		<hr>
		<table style="width:100%;text-align:left;border:1px solid #267871;background-color:#ecf9f2" id="tb1">
			<tr>
				<th colspan=4 style="background-color:#267871;padding:5px 5px;">SALES</th>
			</tr>

			<tr>

				<td style="padding:1px 28px">
					<h3 align="center"><?php echo date('F Y') ?></h3>
					<div id="payloadMeterDiv"> </div>
					<?php echo '<br><b>STATUS:</b> ' . $warning . '<br><br>'; ?>
				</td>
				<td>
					<table id="typical" style="">
						<tr>
							<th>Sales </th>
							<td><?php echo '$' . number_format($tot); ?></td>
						</tr>
						<tr>
							<th>Revenue </th>
							<td><?php echo '$' . number_format($rev); ?></td>
						</tr>
						<tr>
							<th>Cost </th>
							<td><?php echo '$' . number_format($rf); ?></td>
						</tr>
						<tr>
							<th>Net Profit </th>
							<td>

								<?php if ($gp > 0) {
									echo '$' . number_format($gp);
								} else {
									echo '$(' . number_format($gp) . ')';
								} ?>

							</td>
						</tr>
					</table>
				</td>
				<td>
					<h3 align="center">OVERALL</h3>
					<div id="payloadMeterDiv2"> </div>
					<?php echo '<br><b>STATUS:</b> ' . $warning2 . '<br><br>'; ?>
				</td>
				<td>
					<table id="typical" style="">
						<tr>
							<th>Sales </th>
							<td><?php echo '$' . number_format($tot_o); ?></td>
						</tr>
						<tr>
							<th>Revenue </th>
							<td><?php echo '$' . number_format($rev2); ?></td>
						</tr>
						<tr>
							<th>Cost </th>
							<td><?php echo '$' . number_format($totall); ?></td>
						</tr>
						<tr>
							<th>Net Profit </th>
							<td>
								<?php if ($gp2 > 0) {
									echo '$' . number_format($gp2);
								} else {
									echo '$(' . number_format($gp2) . ')';
								} ?>
							</td>
						</tr>
					</table>
				</td>

			</tr>

		</table>

		<!--<h3 align="center"><br>INVOICED AND UNPAID STUDENTS&nbsp;&nbsp;</h3><hr style="width:93%">-->
		<br>
		<table style="width:100%;text-align:left;margin-left:0px;border:1px solid #267871;background-color:#ecf9f2" id="db">
			<tr>
				<th colspan=2 style="background-color:#267871;padding:3px 3px;">STUDENT'S PAYMENT</th>
				<th colspan=1 style="background-color:#267871;padding:3px 3px;">OCCUPANT</th>
			</tr>
			<tr>
				<td style="border-right:1px solid #267871" id="tb1">
					<h3 align="center"><?php echo date('F Y') ?></h3>
					<div id="chartContainer" style="height: 190px; "></div>
				</td>
				<td style="border-right:1px solid #267871" id="tb1">
					<h3 align="center">OVERALL</h3>
					<div id="chartContainer2" style="height: 190px; "></div>
				</td>

				<td>
					<h3 align="center"><?php echo date('F Y') ?></h3>
					<div id="chartContainer3" style="height: 190px; "></div>
				</td>

			</tr>
		</table>


		<br>
		<input id="printbut" type="button" value="Print" class="btn btn-primary" onClick="window.print();" style="float:right;" />

		<input type="hidden" id="salesperc" value="<?php echo $salespercent; ?>">
		<input type="hidden" id="salesperc2" value="<?php echo $salespercent2; ?>">
		<script type="text/javascript">
			var $myPayloadMeter;
			var $myPayloadMeter2;
			var $perc;
			$(function() {
				$perc = $('#salesperc').val();
				$myPayloadMeter = $('#payloadMeterDiv').dynameter({
					// REQUIRED.
					label: 'Sales',
					value: $perc,
					unit: 'Percent (%)',
					min: 0,
					max: 100,
					regions: {
						30: 'warn',
						0: 'error',
						70: 'normal'
					}
				});

			});

			$(function() {
				$perc2 = $('#salesperc2').val();
				$myPayloadMeter2 = $('#payloadMeterDiv2').dynameter({
					// REQUIRED.
					label: 'Sales',
					value: $perc2,
					unit: 'Percent (%)',
					min: 0,
					max: 100,
					regions: {
						30: 'warn',
						0: 'error',
						70: 'normal'
					}
				});

			});

			window.onload = function() {
				var chart = new CanvasJS.Chart("chartContainer", {
					title: {
						text: ""
					},
					animationEnabled: true,
					data: [{
						type: "doughnut",
						indexLabelFontSize: 12,
						startAngle: 60,
						toolTipContent: "{legendText}: {y} - <strong>#percent% </strong>",
						showInLegend: false,
						dataPoints: [{
								y: <?php echo $paidocc; ?>,
								indexLabel: "Paid #percent%",
								legendText: "<a href=\"#\" onClick=\"openCenteredWindow('dashboardlist.php?type=paid');\">Paid</a>"
							},
							{
								y: <?php echo $upaidocc; ?>,
								indexLabel: "Unpaid #percent%",
								legendText: "<a href=\"#\" onClick=\"openCenteredWindow('dashboardlist.php?type=upaid');\">Unpaid</a>"
							}
						]
					}]

				});
				chart.render();

				var chart2 = new CanvasJS.Chart("chartContainer2", {
					title: {
						text: ""
					},
					animationEnabled: true,
					data: [{
						type: "doughnut",
						indexLabelFontSize: 12,
						startAngle: 60,
						toolTipContent: "{legendText}: {y} - <strong>#percent% </strong>",
						showInLegend: false,
						dataPoints: [{
								y: <?php echo $all_paidocc; ?>,
								indexLabel: "Paid #percent%",
								legendText: "<a href=\"#\" onClick=\"openCenteredWindow('dashboardlist.php?type=paidall');\">Paid</a>"
							},
							{
								y: <?php echo $all_upaidocc; ?>,
								indexLabel: "Unpaid #percent%",
								legendText: "<a href=\"#\" onClick=\"openCenteredWindow('dashboardlist.php?type=upaidall');\">Unpaid</a>"
							}
						]
					}]

				});
				chart2.render();


				var chart3 = new CanvasJS.Chart("chartContainer3", {

					title: {
						text: ""
					},
					animationEnabled: true,
					data: [{
						type: "doughnut",
						indexLabelFontSize: 12,
						startAngle: 60,
						toolTipContent: "{legendText}: {y} - <strong>#percent% </strong>",
						showInLegend: false,
						dataPoints: [{
								y: <?php echo $occ; ?>,
								indexLabel: "Occupied #percent%",
								legendText: "<a href=\"#\" onClick=\"openCenteredWindow('dashboardlist.php?type=occmon');\">Occupied</a>"
							},
							{
								y: <?php echo $occtot - $occ; ?>,
								indexLabel: "Vacant #percent%",
								legendText: "Vaccant"
							}
						]
					}]
				});

				chart3.render();
			}

			function openCenteredWindow(url) {
				var width = 1000;
				var height = 580;
				var left = parseInt((screen.availWidth / 2) - (width / 2));
				var top = parseInt((screen.availHeight / 2) - (height / 2));
				var windowFeatures = "width=" + width + ",height=" + height + ",location,directories,status,resizable,toolbar,menubar,left=" + left + ",top=" + top + "screenX=" +
					left + ",screenY=" + top;
				myWindow = window.open(url, "subWind", windowFeatures);
			}
		</script>
	</div>

<?php

	require 'lowerbody.php';
} else {
	require 'warninglogin.php';
}
?>