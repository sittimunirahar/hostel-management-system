<?php
require 'upperbody3.php';

if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	$hi = $_GET['hi'];
	$hn = $_GET['hn'];

	require 'templates/nav_hostel.php';
?>

	</div>

	<div class="tabs">
		<ul class="nav nav-tabs ">
			<li class="active"><a href="mgt-details.php?hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Details</a></li>
			<li><a href="mgt-hostelunit.php?hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Unit</a></li>
			<li><a href="mgt-occup.php?hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Occupant</a></li>
			<li><a href="mgt-fees.php?hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Fee</a></li>
		</ul>

	</div>
	<br>

	<div class="content">
		<BR>
		<h3>Details - <?php echo $hn ?></h3>
		<hr>

		<?php
		$query = "SELECT * FROM hostel_details WHERE hos_name='$hn'";
		$record = mysqli_query($link, $query);
		?>

		<div class="panel panel-default">
			<div class="panel-body">
				<table id="typical">
					<tr>
						<?php
						while ($row = mysqli_fetch_assoc($record)) {

							$query2 = "SELECT file FROM uploads WHERE description='$hn'";
							$record2 = mysqli_query($link, $query2);
							while ($row2 = mysqli_fetch_assoc($record2)) { ?>
								<td rowspan=9 style="padding-right:30px"><img src="img/<?php echo $row2['file'] ?>" width="190" height="202" style="border:2px solid white;"></td>
							<?php } ?>
							<td>
					<tr>
						<td width=17%><label>Address:</label></td>
						<td><?php echo $row['hos_address'] ?></td>
					</tr>
					<tr>
						<td width=17%><label>Type:</label></td>

						<?php if ($row['hos_gender'] == 'F') { ?>
							<td>Female</td>
						<?php } else if ($row['hos_gender'] == 'M') { ?>
							<td>Male</td>
						<?php } else { ?>
							<td>Male & Female</td>
						<?php } ?>
					</tr>

					<tr>
						<td width=17%><label>Managed By:</label></td>
						<td><?php echo $row['hos_managed_by'] ?></td>
					</tr>

					<tr>
						<td width=17%><label>Unit Capacity:</label></td>
						<td><?php echo $row['unit_max_occ'] ?></td>
					</tr>
					<!-- Max occupant dalam form edit-->
					<tr>
						<td colspan=2></td>
					</tr>
					</td>

				<?php } ?>
				</tr>
				</table>
			</div>
		</div>
		<br>


		<input name="editdetails" type="button" value="Edit" class="btn btn-primary" onClick="document.location.href=('editdetails.php?hn=<?php echo $hn; ?>&hi=<?php echo $hi; ?>')" />

		<!-- <a href="" class="btn btn-primary" id="print"  onClick="window.print();">Print</a>-->

	</div>
<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>