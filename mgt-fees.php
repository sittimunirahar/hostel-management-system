<?php
require 'upperbody.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	$hi = "";
	$hn = "";
	if (!empty($_GET['hi']) && !empty($_GET['hn'])) {
		$hi = $_GET['hi'];
		$hn = $_GET['hn'];
	}

	require 'templates/nav_hostel.php';
?>


	</div>

	<div class="tabs">
		<ul class="nav nav-tabs ">
			<li><a href="mgt-details.php?hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Details</a></li>
			<li><a href="mgt-hostelunit.php?hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Unit</a></li>
			<!--<li><a href="mgt-unitowner.php?hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Unit Owner</a></li>-->
			<li><a href="mgt-occup.php?hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Occupant</a></li>
			<li class="active"><a href="mgt-fees.php?hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Fee</a></li>
		</ul>
	</div>

	<br><br>
	<div class="content">
		<h3>Fees - <?php echo $hn ?></h3>
		<hr>


		<?php
		$query2 = "SELECT hos_managed_by FROM hostel_details WHERE hos_name='$hn'";
		$record2 = mysqli_query($link, $query2);

		if (($month == null || $month == "all") && ($year == null || $year == "all")) {
			$query = "SELECT * FROM fees_setting JOIN sem_list USING (sem_id) WHERE description='$hn' ORDER BY month";
		}

		//ade tahun je, month all
		else if (($month == null || $month == "all") && ($year != null || $year != "all")) {
			$query = "SELECT * FROM fees_setting  JOIN sem_list USING (sem_id) WHERE description='$hn' AND year = '$year' ORDER BY month";
		}

		//ade tahun dan ade month
		else {
			$query = "SELECT * FROM fees_setting  JOIN sem_list USING (sem_id) WHERE description='$hn' AND year = '$year' AND month='$month' ORDER BY month";
		}
		$record = mysqli_query($link, $query);


		while ($row2 = mysqli_fetch_assoc($record2)) {
			if ($row2['hos_managed_by'] == 'Other') { ?>
				<em>This hostel fee is not handled by IIC</em>
			<?php
			} else {
			?>

				<table class="display table" id="tabledata">
					<thead>
						<tr>
							<th>Month</th>
							<th>Year</th>
							<th>Semester</th>
							<th>Session</th>
							<th>Rental</th>

						</tr>
					</thead>
					<tbody>
						<?php
						while ($row = mysqli_fetch_assoc($record)) { ?>
							<tr>
								<td><a href=""></a><?php echo date('F', mktime(0, 0, 0, $row['month'], 10)); ?></td>
								<td><?php echo $row['year'] ?></td>
								<td><?php echo $row['semester'] ?></td>
								<td><?php echo $row['session'] ?></td>
								<td><?php echo $row['fees_per_month'] ?></td>

							</tr>
						<?php } ?>
					</tbody>
				</table>

				<br>
				<div class="fees-option">
					<p>
						<!--<input name="addfees" type="button" value="Add" class="btn btn-primary"/>
	  <input name="printfees" type="button" value="Print" class="btn btn-primary"/>-->
					</p>
				</div>
	</div>
<?php }
		}
		include 'lowerbody.php';
	} else {
		require 'warninglogin.php';
	} ?>