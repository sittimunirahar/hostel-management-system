<?php
require 'upperbodyfinance2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {

	require 'templates/nav_finance.php';
?>
	</div>

	<?php
	$mon = date("m");
	$yer = date('Y');
	$tot = 0;
	$tot_due = 0;
	$tot_paid = 0;
	$otot = 0;
	$otot_due = 0;
	$otot_paid = 0;
	$bus = 0;
	$elec = 0;
	$hos = 0;
	$water = 0;
	$care = 0;
	$store = 0;
	$cafe = 0;
	$busu = 0;
	$elecu = 0;
	$hosu = 0;
	$wateru = 0;
	$careu = 0;
	$storeu = 0;
	$cafeu = 0;
	$obus = 0;
	$oelec = 0;
	$ohos = 0;
	$owater = 0;
	$ocare = 0;
	$ostore = 0;
	$ocafe = 0;
	$obusu = 0;
	$oelecu = 0;
	$ohosu = 0;
	$owateru = 0;
	$ocareu = 0;
	$ostoreu = 0;
	$ocafeu = 0;

	$q_amt = "SELECT SUM(amount) as amt,
					sum(case when pay_details.status='INVOICED' then pay_details.amount else 0 end) as amt_due, 
					sum(case when pay_details.status='PAID' then pay_details.amount else 0 end) as amt_paid
					FROM pay_details
					WHERE month(date_issued)='$mon'
					AND year(date_issued)='$yer'";
	$record_qa = mysqli_query($link, $q_amt);
	while ($row_qa = mysqli_fetch_assoc($record_qa)) {
		$tot += $row_qa['amt'];
		$tot_due += $row_qa['amt_due'];
		$tot_paid += $row_qa['amt_paid'];
	}

	$q_amt = "SELECT SUM(amount) as amt,
					sum(case when pay_details.status='INVOICED' then pay_details.amount else 0 end) as amt_due, 
					sum(case when pay_details.status='PAID' then pay_details.amount else 0 end) as amt_paid
					FROM pay_details";
	$record_qa = mysqli_query($link, $q_amt);
	while ($row_qa = mysqli_fetch_assoc($record_qa)) {
		$otot += $row_qa['amt'];
		$otot_due += $row_qa['amt_due'];
		$otot_paid += $row_qa['amt_paid'];
	}

	$q = "SELECT SUM(amount) as amt,
					sum(case when pay_type='BUS' AND status = 'PAID' then amount else 0 end) as amt_bus, 
					sum(case when pay_type='ELECTRICITY'  AND status = 'PAID' then amount else 0 end) as amt_elec,
					sum(case when pay_type='HOSTEL'  AND status = 'PAID' then amount else 0 end) as amt_hos,
					sum(case when pay_type='WATER'  AND status = 'PAID' then amount else 0 end) as amt_water,
					sum(case when pay_type='CARETAKER'  AND status = 'PAID' then amount else 0 end) as amt_caretaker,
					sum(case when pay_type='STORE'  AND status = 'PAID' then amount else 0 end) as amt_store,
					sum(case when pay_type='CAFE'  AND status = 'PAID' then amount else 0 end) as amt_cafe
					FROM pay_details_college
					WHERE month(date_issued)='$mon'
					AND year(date_issued)='$yer'";
	$record = mysqli_query($link, $q);
	while ($r = mysqli_fetch_assoc($record)) {
		$bus += $r['amt_bus'];
		$elec += $r['amt_elec'];
		$hos += $r['amt_hos'];
		$water += $r['amt_water'];
		$care += $r['amt_caretaker'];
		$store += $r['amt_store'];
		$cafe += $r['amt_cafe'];
	}

	$q = "SELECT SUM(amount) as amt,
					sum(case when pay_type='BUS' AND status = 'INVOICED' then amount else 0 end) as amt_bus, 
					sum(case when pay_type='ELECTRICITY'  AND status = 'INVOICED' then amount else 0 end) as amt_elec,
					sum(case when pay_type='HOSTEL'  AND status = 'INVOICED' then amount else 0 end) as amt_hos,
					sum(case when pay_type='WATER'  AND status = 'INVOICED' then amount else 0 end) as amt_water,
					sum(case when pay_type='CARETAKER'  AND status = 'INVOICED' then amount else 0 end) as amt_caretaker,
					sum(case when pay_type='STORE'  AND status = 'INVOICED' then amount else 0 end) as amt_store,
					sum(case when pay_type='CAFE'  AND status = 'INVOICED' then amount else 0 end) as amt_cafe
					FROM pay_details_college
					WHERE month(date_issued)='$mon'
					AND year(date_issued)='$yer'";
	$record = mysqli_query($link, $q);
	while ($r = mysqli_fetch_assoc($record)) {
		$busu += $r['amt_bus'];
		$elecu += $r['amt_elec'];
		$hosu += $r['amt_hos'];
		$wateru += $r['amt_water'];
		$careu += $r['amt_caretaker'];
		$storeu += $r['amt_store'];
		$cafeu += $r['amt_cafe'];
	}

	$q = "SELECT SUM(amount) as amt,
					sum(case when pay_type='BUS' AND status = 'PAID' then amount else 0 end) as amt_bus, 
					sum(case when pay_type='ELECTRICITY'  AND status = 'PAID' then amount else 0 end) as amt_elec,
					sum(case when pay_type='HOSTEL'  AND status = 'PAID' then amount else 0 end) as amt_hos,
					sum(case when pay_type='WATER'  AND status = 'PAID' then amount else 0 end) as amt_water,
					sum(case when pay_type='CARETAKER'  AND status = 'PAID' then amount else 0 end) as amt_caretaker,
					sum(case when pay_type='STORE'  AND status = 'PAID' then amount else 0 end) as amt_store,
					sum(case when pay_type='CAFE'  AND status = 'PAID' then amount else 0 end) as amt_cafe
					FROM pay_details_college";
	$record = mysqli_query($link, $q);
	while ($r = mysqli_fetch_assoc($record)) {
		$obus += $r['amt_bus'];
		$oelec += $r['amt_elec'];
		$ohos += $r['amt_hos'];
		$owater += $r['amt_water'];
		$ocare += $r['amt_caretaker'];
		$ostore += $r['amt_store'];
		$ocafe += $r['amt_cafe'];
	}

	$q = "SELECT SUM(amount) as amt,
					sum(case when pay_type='BUS' AND status = 'INVOICED' then amount else 0 end) as amt_bus, 
					sum(case when pay_type='ELECTRICITY'  AND status = 'INVOICED' then amount else 0 end) as amt_elec,
					sum(case when pay_type='HOSTEL'  AND status = 'INVOICED' then amount else 0 end) as amt_hos,
					sum(case when pay_type='WATER'  AND status = 'INVOICED' then amount else 0 end) as amt_water,
					sum(case when pay_type='CARETAKER'  AND status = 'INVOICED' then amount else 0 end) as amt_caretaker,
					sum(case when pay_type='STORE'  AND status = 'INVOICED' then amount else 0 end) as amt_store,
					sum(case when pay_type='CAFE'  AND status = 'INVOICED' then amount else 0 end) as amt_cafe
					FROM pay_details_college";
	$record = mysqli_query($link, $q);
	while ($r = mysqli_fetch_assoc($record)) {
		$obusu += $r['amt_bus'];
		$oelecu += $r['amt_elec'];
		$ohosu += $r['amt_hos'];
		$owateru += $r['amt_water'];
		$ocareu += $r['amt_caretaker'];
		$ostoreu += $r['amt_store'];
		$ocafeu += $r['amt_cafe'];
	}

	?>

	<div class="content">
		<h3>DASHBOARD</h3>
		<hr>
		<table style="width:100%;text-align:left;margin-left:0px;border:1px solid #267871;background-color:#ecf9f2" id="db">
			<tr>
				<th colspan=2 style="background-color:#267871;padding:5px 5px;">STUDENT PAYMENT</th>
			</tr>
			<tr>
				<td style="text-align:center;width:50%;border-right:1px solid #267871">
					<h3 align="center"><?php echo date('F Y') ?> (MYR)</h3>
					<div id="chartContainer" style="height: 160px;"></div>

				</td>

				<td style="text-align:center;width:50%">
					<h3 align="center">OVERALL</h3>
					<div id="chartContainer2" style="height: 160px;"></div>

				</td>

			</tr>
		</table>
		<br>
		<table style="width:100%;text-align:left;margin-left:0px;border:1px solid #267871;background-color:#ecf9f2" id="db">
			<tr>
				<th colspan=2 style="background-color:#267871;padding:5px 5px;">COLLEGE PAYMENT</th>
			</tr>
			<tr>
				<td style="text-align:center;width:50%;border-right:1px solid #267871">
					<h3 align="center"><?php echo date('F Y') ?> (RM)</h3>
					<div id="chartContainer3" style="height: 180px;background-color:#ecf9f2"></div>

				</td>

				<td style="text-align:center;width:50%">
					<h3 align="center">OVERALL (RM)</h3>
					<div id="chartContainer4" style="height: 180px;"></div>

				</td>

			</tr>
		</table>
		<!--<h3 align="center"><br>INVOICED AND UNPAID STUDENTS&nbsp;&nbsp;</h3><hr style="width:93%">-->
		<br>

	</div>

	<script type="text/javascript">
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
					toolTipContent: "{legendText}: RM {y} - <strong>#percent% </strong>",
					showInLegend: false,
					dataPoints: [{
							y: <?php echo $tot_paid; ?>,
							indexLabel: "Paid #percent%",
							legendText: "<a href=\"#\" onClick=\"openCenteredWindow('dashboardlist.php?type=paid');\">Paid</a>"
						},
						{
							y: <?php echo $tot_due; ?>,
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
					toolTipContent: "{legendText}: RM {y} - <strong>#percent% </strong>",
					showInLegend: false,
					dataPoints: [{
							y: <?php echo $otot_paid; ?>,
							indexLabel: "Paid #percent%",
							legendText: "<a href=\"#\" onClick=\"openCenteredWindow('dashboardlist.php?type=paidall');\">Paid</a>"
						},
						{
							y: <?php echo $otot_due; ?>,
							indexLabel: "Unpaid #percent%",
							legendText: "<a href=\"#\" onClick=\"openCenteredWindow('dashboardlist.php?type=upaidall');\">Unpaid</a>"
						}
					]
				}]
			});
			chart2.render();

			var chart3 = new CanvasJS.Chart("chartContainer3", {
				theme: "theme3",
				animationEnabled: true,
				title: {
					text: "",
					fontSize: 30
				},
				toolTip: {
					shared: true
				},
				axisY: {
					title: "Amount Paid (MYR)"
				},
				axisY2: {
					title: "Amount Billed (MYR)"
				},
				data: [{
						type: "column",
						name: "Amount Paid (MYR)",
						legendText: "Paid",
						color: "#267871",
						showInLegend: true,
						dataPoints: [{
								label: "Hostel Fees",
								y: <?php echo $hos; ?>
							},
							{
								label: "Electricity Bill",
								y: <?php echo $elec; ?>
							},
							{
								label: "Water Bill",
								y: <?php echo $water; ?>
							},
							{
								label: "Caretaker",
								y: <?php echo $care; ?>
							},
							{
								label: "Store",
								y: <?php echo $store; ?>
							},
							{
								label: "Cafetaria",
								y: <?php echo $cafe; ?>
							},
							{
								label: "Bus",
								y: <?php echo $bus; ?>
							}

						]
					},
					{
						type: "column",
						name: "Amount Billed (MYR)",
						legendText: "Billed",
						color: "orange",
						axisYType: "secondary",
						showInLegend: true,
						dataPoints: [{
								label: "Hostel Fees",
								y: <?php echo $hosu; ?>
							},
							{
								label: "Electricity Bill",
								y: <?php echo $elecu; ?>
							},
							{
								label: "Water Bill",
								y: <?php echo $wateru; ?>
							},
							{
								label: "Caretaker",
								y: <?php echo $careu; ?>
							},
							{
								label: "Store",
								y: <?php echo $storeu; ?>
							},
							{
								label: "Cafetaria",
								y: <?php echo $cafeu; ?>
							},
							{
								label: "Bus",
								y: <?php echo $busu; ?>
							}


						]
					}

				],
				legend: {
					cursor: "pointer",
					itemclick: function(e) {
						if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
							e.dataSeries.visible = false;
						} else {
							e.dataSeries.visible = true;
						}
						chart.render();
					}
				},
			});

			chart3.render();

			var chart4 = new CanvasJS.Chart("chartContainer4", {
				theme: "theme3",
				animationEnabled: true,
				title: {
					text: "",
					fontSize: 30
				},
				toolTip: {
					shared: true
				},
				axisY: {
					title: "Amount Paid (MYR)"
				},
				axisY2: {
					title: "Amount Billed (MYR)"
				},
				data: [{
						type: "column",
						name: "Amount Paid (MYR)",
						legendText: "Paid",
						color: "#267871",
						showInLegend: true,
						dataPoints: [{
								label: "Hostel Fees",
								y: <?php echo $ohos; ?>
							},
							{
								label: "Electricity Bill",
								y: <?php echo $oelec; ?>
							},
							{
								label: "Water Bill",
								y: <?php echo $owater; ?>
							},
							{
								label: "Caretaker",
								y: <?php echo $ocare; ?>
							},
							{
								label: "Store",
								y: <?php echo $ostore; ?>
							},
							{
								label: "Cafetaria",
								y: <?php echo $ocafe; ?>
							},
							{
								label: "Bus",
								y: <?php echo $obus; ?>
							}

						]
					},
					{
						type: "column",
						name: "Amount Billed (MYR)",
						legendText: "Billed",
						color: "orange",
						axisYType: "secondary",
						showInLegend: true,
						dataPoints: [{
								label: "Hostel Fees",
								y: <?php echo $ohosu; ?>
							},
							{
								label: "Electricity Bill",
								y: <?php echo $oelecu; ?>
							},
							{
								label: "Water Bill",
								y: <?php echo $owateru; ?>
							},
							{
								label: "Caretaker",
								y: <?php echo $ocareu; ?>
							},
							{
								label: "Store",
								y: <?php echo $ostoreu; ?>
							},
							{
								label: "Cafetaria",
								y: <?php echo $ocafeu; ?>
							},
							{
								label: "Bus",
								y: <?php echo $obusu; ?>
							}


						]
					}

				],
				legend: {
					cursor: "pointer",
					itemclick: function(e) {
						if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
							e.dataSeries.visible = false;
						} else {
							e.dataSeries.visible = true;
						}
						chart.render();
					}
				},
			});

			chart4.render();
		}
	</script>
<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>