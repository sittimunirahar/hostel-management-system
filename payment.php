<?php
include 'upperbody.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {

?>
	<div class="list-group">
		<a href="hostel.php" class="list-group-item ">
			<i class="fa fa-building"></i>HOSTEL</a>
		<a href="allocation.php" class="list-group-item">
			<i class="fa fa-key"></i>ALLOCATION</a>
		<a href="payment.php" class="list-group-item active">
			<i class="fa fa-credit-card"></i>FINANCIAL</a>
		<a href="services.php" class="list-group-item ">
			<i class="fa fa-bar-chart"></i>REPORT</a>
		<a href="dashboardhostel.php" class="list-group-item">
			<i class="fa fa-dashboard"></i>DASHBOARD</a>
		<a href="home.php" class="list-group-item">
			<i class="fa fa-home"></i>HOME</a>
	</div>

	</div>

	<div class="tabs">
		<ul class="nav nav-tabs ">
			<li class="active"><a href="payment.php">Student Payment</a></li>
			<li><a href="payment-college.php">College Payment</a></li>
		</ul>
	</div>
	<br><br>
	<div class="content">
		<p>
		<h3>HOSTEL FINANCIAL</h3>
		<hr>
		<?php

		if (($month == null || $month == "all") && ($year == null || $year == "all")) {
			$query = "select pay_details.payer_id as matric, student_list.first_name as fname, student_list.last_name as lname, 
			  sum(case when pay_details.status='INVOICED' then pay_details.amount else 0 end) as amt_due, 
			  sum(case when pay_details.status='PAID' then pay_details.amount else 0 end) as amt_paid,
			  sum(pay_details.amount) as amt_chg
			  FROM student_list JOIN pay_details ON student_list.matric = pay_details.payer_id
			  WHERE pay_details.pay_type='HOSTEL'
			  GROUP BY pay_details.payer_id ";
		}

		//ade tahun je, month all
		else if (($month == null || $month == "all") && ($year != null || $year != "all")) {
			$query = "select pay_details.payer_id as matric, student_list.first_name as fname, student_list.last_name as lname, 
	  sum(case when pay_details.status='INVOICED' AND year(pay_details.date_issued)='$year' then pay_details.amount else 0 end) as amt_due, 
	  sum(case when pay_details.status='PAID' AND year(pay_details.date_issued)='$year' then pay_details.amount else 0 end) as amt_paid,
	  sum(case when year(pay_details.date_issued)='$year' then pay_details.amount else 0 end) as amt_chg
	  FROM student_list JOIN pay_details ON student_list.matric = pay_details.payer_id
	  WHERE pay_details.pay_type='HOSTEL'
	  GROUP BY pay_details.payer_id";
		}

		//ade tahun dan ade month
		else {
			$query = "select pay_details.payer_id as matric, student_list.first_name as fname, student_list.last_name as lname, 
	  sum(case when pay_details.status='INVOICED' AND month(pay_details.date_issued)='$month' AND year(pay_details.date_issued)='$year' then pay_details.amount else 0 end) as amt_due, 
	  sum(case when pay_details.status='PAID' AND month(pay_details.date_issued)='$month' AND year(pay_details.date_issued)='$year' then pay_details.amount else 0 end) as amt_paid,
	  sum(case when month(pay_details.date_issued)='$month' AND year(pay_details.date_issued)='$year' then pay_details.amount else 0 end) as amt_chg
	  FROM student_list JOIN pay_details ON student_list.matric = pay_details.payer_id
	  WHERE pay_details.pay_type='HOSTEL'
	  GROUP BY pay_details.payer_id ";
		}



		$record = mysqli_query($link, $query);
		?>

		<table class="display table" id="tabledata2">
			<thead>
				<tr>
					<th>Matric</th>
					<th>Name</th>
					<th>Amount Charged</th>
					<th>Amount Paid</th>
					<th>Amount Due</th>

				</tr>
			</thead>
			<tbody>
				<?php
				while ($row = mysqli_fetch_assoc($record)) { ?>
					<tr>
						<td><a href="viewstudentpayment.php?m=<?php echo $row['matric']; ?>"></a><?php echo $row['matric'] ?></td>
						<td><?php echo $row['fname'] . ' ' . $row['lname'] ?></td>
						<td><?php echo $row['amt_chg'] ?></td>
						<td><?php echo $row['amt_paid'] ?></td>
						<td><?php echo $row['amt_due'] ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>


		<!--<div class="paymentstud-option">
    <p>
       <input name="print" type="button" value="Print" class="btn btn-primary"/>
    </p>
	</div>-->
	</div>
<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>