<?php
require 'upperbodyfinance.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	require 'templates/nav_finance.php';
?>

	</div>

	<div class="content">
		<h3>FEE RATE</h3>
		<hr>


		<?php


		if (($month == null || $month == "all") && ($year == null || $year == "all")) {
			$query = "SELECT * FROM fees_setting ORDER BY month";
		}

		//ade tahun je, month all
		else if (($month == null || $month == "all") && ($year != null || $year != "all")) {
			$query = "SELECT * FROM fees_setting WHERE year = '$year' ORDER BY month";
		}

		//ade tahun dan ade month
		else {
			$query = "SELECT * FROM fees_setting WHERE year = '$year' AND month='$month' ORDER BY month";
		}
		$record = mysqli_query($link, $query);
		?>


		<table class="display table" id="tabledata2">
			<thead>
				<tr>
					<th>Type</th>
					<th>Description</th>
					<th>Month</th>
					<th>Year</th>
					<th>Rate</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while ($row = mysqli_fetch_assoc($record)) { ?>
					<tr>
						<td><a href="editfee.php?fid=<?php echo $row['fees_id']; ?>" id="feehref"></a><?php echo $row['type'] ?></td>
						<td><?php echo $row['description'] ?></td>
						<td><?php echo date('F', mktime(0, 0, 0, $row['month'], 10)); ?></td>
						<td><?php echo $row['year'] ?></td>
						<td><?php echo 'RM ' . $row['fees_per_month'] ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>

		<div class="fees-option">
			<p>
				<input name="addfees" type="button" value="Add" class="btn btn-primary" onClick="document.location.href=('addfee.php');" />
				<input name="printfees" type="button" value="Print" class="btn btn-primary" onClick="window.print();" />
			</p>
		</div>
	</div>
<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>