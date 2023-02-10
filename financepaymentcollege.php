<?php
require 'upperbodyfinance.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	require 'templates/nav_finance.php';
?>

	</div>

	<div class="tabsfin">
		<ul class="nav nav-tabs ">
			<li><a href="financepayment.php">Student Payment</a></li>
			<li class="active"><a href="financepaymentcollege.php">College Payment</a></li>
		</ul>
	</div>

	<br><br>
	<div class="content">
		</p>
		<h3>PAYMENT RECORD</h3>
		<hr>


		<?php
		if (($month == null || $month == "all") && ($year == null || $year == "all")) {
			$query = "select payee_name, payee_type,
				  sum(case when status='INVOICED' then amount else 0 end) as amt_due, 
				  sum(case when status='PAID' then amount else 0 end) as amt_paid,
				  sum(amount) as amt_chg
				  FROM pay_details_college
				  WHERE payer_type='COLLEGE'
				  GROUP BY payee_name";
		}

		//ade tahun je, month all
		else if (($month == null || $month == "all") && ($year != null || $year != "all")) {
			$query = "select payee_name, payee_type,
				  sum(case when status='INVOICED' then amount else 0 end) as amt_due, 
				  sum(case when status='PAID' then amount else 0 end) as amt_paid,
				  sum(amount) as amt_chg
				  FROM pay_details_college
				  WHERE payer_type='COLLEGE' AND YEAR(date_issued)='$year'
				  GROUP BY payee_name";
		}

		//ade tahun dan ade month
		else {
			$query = "select payee_name, payee_type,
				  sum(case when status='INVOICED' then amount else 0 end) as amt_due, 
				  sum(case when status='PAID' then amount else 0 end) as amt_paid,
				  sum(amount) as amt_chg
				  FROM pay_details_college
				  WHERE payer_type='COLLEGE' AND YEAR(date_issued)='$year' AND MONTH(date_issued)='$month'
				  GROUP BY payee_name";
		}
		$record = mysqli_query($link, $query); ?>

		<table class="display table" id="tabledata2">
			<thead>
				<tr>
					<th>Payee Name</th>
					<th>Payee Type</th>
					<th>Total Charged</th>
					<th>Total Paid</th>
					<th>Total Due</th>

				</tr>
			</thead>
			<tbody>
				<?php
				while ($row = mysqli_fetch_assoc($record)) { ?>
					<tr>
						<td><a href="viewcollegepayment2.php?pn=<?php echo $row['payee_name']; ?>" id="feehref"></a><?php echo $row['payee_name']; ?></td>
						<td><?php echo $row['payee_type']; ?></td>
						<td><?php echo $row['amt_chg']; ?></td>
						<td><?php echo $row['amt_paid']; ?></td>
						<td><?php echo $row['amt_due']; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>


		<div class="paymentcollege-option">
			<p>
				<input name="add" type="button" value="Add" class="btn btn-primary" onClick="document.location.href=('addcolrec.php');" />
				<!--<input name="print" type="button" value="Print" class="btn btn-primary"/>-->
			</p>
		</div>
	</div>
<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>