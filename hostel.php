<?php
require 'upperbody.php';
$totout = 0;
if (!empty($_SESSION['password']) && !empty($_SESSION['username']) && !empty($_SESSION['position']) && $_SESSION['position'] != 'fstaff') {

	require 'templates/nav_hostel.php';

?>


	</div>

	<div class="content">
		<h3>HOSTEL MANAGEMENT</h3>
		<hr>
		<?php

		$query = "SELECT hos_id, hos_name from hostel_list ";
		$record = mysqli_query($link, $query);
		?>
		<div id="wannascroll">
			<table class="display table tmain" id="tabledata">
				<thead>
					<tr>
						<th>Hostel Name</th>
						<th>Total Units</th>
						<th>Total Occupants</th>
						<th>Rental Fees</th>
						<th>Capacity</th>
					</tr>
				</thead>
				<tbody>

					<?php


					while ($row = mysqli_fetch_assoc($record)) {
						$hn = $row['hos_name'];

						$totunit = 0;
						$totocc = 0;
						$totrent = 0;
						$totmax = 0;

						if (($month == null || $month == "all") && ($year == null || $year == "all")) {

							$query_occ = "SELECT DISTINCT payer_id as totocc FROM pay_details
		  				WHERE hos_name='$hn'";
						} else if (($month == null || $month == "all") && ($year != null || $year != "all")) {

							$query_occ = "SELECT DISTINCT payer_id as totocc FROM pay_details
		  				WHERE hos_name='$hn' AND year(date_issued)='$year'";
						} else {
							//total checked out
							$query_outocc = "SELECT DISTINCT matric, date_out
							FROM check_out
							WHERE hos_name =  '$hn'
							AND MONTH( date_out ) =  '$month'
							AND YEAR( date_out ) =  '$year'";

							$query_occ = "SELECT DISTINCT payer_id as totocc FROM pay_details
							WHERE hos_name='$hn' AND month(date_issued)='$month'
							AND year(date_issued)='$year'";

							$record_outocc = mysqli_query($link, $query_outocc);
							$totout = mysqli_num_rows($record_outocc);
						}


						$record_occ = mysqli_query($link, $query_occ);
						$totocc = mysqli_num_rows($record_occ) - $totout;

						$q_exp = "select unit_list.unit_no as unit_no, unit_list.rental as rental, owner_list.owner_name as owner,
						MONTH(owner_list.expiry_date) as m, YEAR(owner_list.expiry_date) as y, owner_list.expiry_date as expiry,hostel_details.unit_max_occ
						from owner_list 
						JOIN unit_list ON owner_list.owner_id =unit_list.owner_id
						JOIN hostel_details ON unit_list.hos_name = hostel_details.hos_name 
						WHERE unit_list.hos_name='$hn'";
						$r_exp = mysqli_query($link, $q_exp);

						//both year & month
						while ($row_exp = mysqli_fetch_assoc($r_exp)) {
							if (($month == null || $month == "all") && ($year == null || $year == "all")) {
								$totunit++;
								$totrent += $row_exp['rental'];
								$totmax += $row_exp['unit_max_occ'];
							}

							//year only, month all
							else if (($month == null || $month == "all") && ($year != null || $year != "all")) {
								if ($row_exp['y'] >= $year) {
									$totunit++;
									$totrent += $row_exp['rental'];
									$totmax += $row_exp['unit_max_occ'];
								}
							}

							//ade tahun dan ade month
							else {
								//year lagi besar dri year specified = belum expired
								if ($row_exp['y'] > $year) {
									$totunit++;
									$totrent += $row_exp['rental'];
									$totmax += $row_exp['unit_max_occ'];
								}
								//year same dgn year specified 2016=2016
								else if ($row_exp['y'] == $year) {

									if ($row_exp['m'] >= $month) {
										$totunit++;
										$totrent += $row_exp['rental'];
										$totmax += $row_exp['unit_max_occ'];
									}
								}
							}
						} ?>

						<tr>
							<td><a href="mgt-details.php?hi=<?php echo $row['hos_id']; ?>&hn=<?php echo $row['hos_name']; ?> "></a>
								<?php echo $row['hos_name']; ?></td>
							<td align="center"><?php echo $totunit; ?></td>
							<td align="center"><?php echo $totocc; ?></td>
							<td align="center"><?php echo 'RM ' . number_format($totrent); ?></td>
							<?php
							if ($month == null || $month == "all") { ?>

								<td><?php echo $totocc; ?></td>
							<?php } else { ?>

								<td><?php echo $totocc . '/' . $totmax; ?></td>


						</tr>

					<?php } ?>

				<?php } ?>
				</tbody>

			</table>


			<br>
			<?php if ($stat == 'DEFAULT') { ?>
				<input name="addhostel" type="button" value="Add" class="btn btn-primary" onClick="document.location.href=('addhostel.php');" />
			<?php } ?></p>

		</div>
	</div>


<?php

	require 'lowerbody.php';
} else {
	require 'warninglogin.php';
}
?>