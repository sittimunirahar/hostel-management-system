<?php
include 'upperbody.php';
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
			<li class="active"><a href="mgt-hostelunit.php?hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Unit</a></li>
			<li><a href="mgt-occup.php?hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Occupant</a></li>
			<li><a href="mgt-fees.php?hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Fee</a></li>
		</ul>

	</div>
	<br><br>
	<div class="content">
		<h3>Unit - <?php echo $hn ?></h3>


		<hr>

		<?php

		$query = "select unit_list.unit_no as unit_no, unit_list.rental as rental, owner_list.owner_name as owner,
	  MONTH(owner_list.expiry_date) as m, YEAR(owner_list.expiry_date) as y, owner_list.expiry_date as expiry,hostel_details.unit_max_occ
	  as max_occ from owner_list
	  JOIN unit_list ON owner_list.owner_id =unit_list.owner_id
	  JOIN hostel_details ON unit_list.hos_name = hostel_details.hos_name 
	  WHERE unit_list.hos_name='$hn'
	  ORDER BY owner_list.expiry_date";
		$record = mysqli_query($link, $query);
		$totocc = 0;
		$totout = 0;
		$query_occ = "";
		?>
		<table class="display table" id="tabledata2">
			<thead>
				<tr>
					<th scope="col">Unit number</th>
					<th scope="col">Owner name</th>
					<th scope="col">Rental Fee</th>
					<th scope="col">Expired date</th>
					<th scope="col">Total Occupants</th>
				</tr>
			</thead>
			<tbody>
				<?php


				$correct = 'n';
				while ($row_exp = mysqli_fetch_assoc($record)) {
					$un = $row_exp['unit_no'];

					if (($month == null || $month == "all") && ($year == null || $year == "all")) {
						$correct = 'y';
						$query_occ = "SELECT DISTINCT payer_id as totocc FROM pay_details
		     WHERE hos_name='$hn' AND unit_no='$un';";
					}

					//ade tahun je, month all
					else if (($month == null || $month == "all") && ($year != null || $year != "all")) {
						if ($row_exp['y'] >= $year) {
							$correct = 'y';
							$query_occ = "SELECT DISTINCT payer_id as totocc FROM pay_details
				WHERE hos_name='$hn' AND year(date_issued)='$year' AND unit_no='$un';";
						}
					}

					//ade tahun dan ade month
					else {
						//year lagi besar dri year specified = belum expired
						if ($row_exp['y'] > $year) {
							$correct = 'y';
							//total checked out
							$query_outocc = "SELECT DISTINCT matric, date_out
				FROM check_out
				WHERE hos_name =  '$hn'
				AND MONTH( date_out ) =  '$month'
				AND YEAR( date_out ) =  '$year'
				AND unit_no='$un';";

							$query_occ = "SELECT DISTINCT payer_id as totocc FROM pay_details
			  WHERE hos_name='$hn' AND month(date_issued)='$month'
			  AND year(date_issued)='$year' AND unit_no='$un';";

							$record_outocc = mysqli_query($link, $query_outocc);
							$totout = mysqli_num_rows($record_outocc);
						}

						//year same dgn year specified 2016=2016
						else if ($row_exp['y'] == $year) {

							if ($row_exp['m'] >= $month) {
								$correct = 'y';

								//total checked out
								$query_outocc = "SELECT DISTINCT matric, date_out
			FROM check_out
			WHERE hos_name =  '$hn'
			AND MONTH( date_out ) =  '$month'
			AND YEAR( date_out ) =  '$year' AND unit_no='$un';";

								$query_occ = "SELECT DISTINCT payer_id as totocc FROM pay_details
		  WHERE hos_name='$hn' AND month(date_issued)='$month'
		  AND year(date_issued)='$year' AND unit_no='$un';";

								$record_outocc = mysqli_query($link, $query_outocc);
								$totout = mysqli_num_rows($record_outocc);
							}
						}
					}

					if ($query_occ != null) {
						$record_occ = mysqli_query($link, $query_occ);
						$totocc = (mysqli_num_rows($record_occ)) - $totout;
					}

					if ($correct == 'y') {
				?>
						<tr>

							<td><a href="viewunitowner.php?un=<?php echo $row_exp['unit_no']; ?>&hn=<?php echo $hn ?>"></a><?php echo $row_exp['unit_no']; ?></td>
							<td><?php echo $row_exp['owner'] ?></td>
							<td><?php echo $row_exp['rental'] ?></td>
							<td><?php echo date("d-m-Y", strtotime($row_exp['expiry'])); ?></td>

							<?php
							if ($month == null || $month == "all") { ?>

								<td><?php echo $totocc; ?></td>
							<?php } else { ?>

								<td><?php echo $totocc . '/' . $row_exp['max_occ'] ?></td>
							<?php } ?>

						</tr>
				<?php
					}
				}
				?>
			</tbody>
		</table>
		<br>
		<?php //if ($stat=='DEFAULT'){
		?>
		<input name="addunit" type="button" value="Add" class="btn btn-primary" onClick="document.location.href=('addhostelunit.php?hn=<?php echo $hn; ?>');" /><?php //}
																																																																														?>
		<!--<input name="editunit" type="button" value="Edit" class="btn btn-primary" onClick="document.location.href=('edit.php');"/>-->
		<!--<input name="printunit" type="button" value="Print" class="btn btn-primary"  onClick="window.print();"/>-->

	</div>
<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>