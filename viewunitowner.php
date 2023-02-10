<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	$un = $_GET['un'];
	$hn = $_GET['hn'];
?>

	<div class="tabs2">
		<ul class="nav nav-tabs ">
			<li class="active"><a href="viewunitowner.php?un=<?php echo $un; ?>&hn=<?php echo $hn; ?>">Details</a></li>
			<li><a href="viewunitocc.php?un=<?php echo $un; ?>&hn=<?php echo $hn; ?>">Occupant</a></li>

		</ul>
	</div>

	<br>

	<div class="content2">

		<br>
		<h3>Unit <?php echo $un ?></h3>
		<hr>

		<?php
		$query = "SELECT * FROM owner_list JOIN unit_list
	  USING (owner_id)
	  WHERE unit_list.unit_no='$un' AND unit_list.hos_name='$hn'";
		$record = mysqli_query($link, $query);
		?>

		<div class="panel panel-default">
			<div class="panel-body">

				<?php if (mysqli_num_rows($record) == 1) {
					while ($row = mysqli_fetch_assoc($record)) { ?>

						<table id="typical">
							<tr>
								<th colspan=2 style="padding:10px;margin-top:4px;background-color:#267871;color:white;">Unit Details</th>
							</tr>

							<tr>
								<th><label>Unit No:</label></th>
								<td><?php echo $row['unit_no'] ?></td>
							</tr>

							<tr>
								<th><label>Hostel Name:</label></th>
								<td><?php echo $row['hos_name'] ?></td>
							</tr>

							<tr>
								<th><label>Rental:</label></th>
								<td><?php echo $row['rental'] ?></td>
							</tr>

							<tr>
								<th><label>Expiry:</label></th>
								<td><?php echo $row['expiry_date'] ?></td>
							</tr>

							<tr>
								<th><label>Remarks:</label></th>
								<td><?php echo $row['remarks'] ?></td>
							</tr>



							<tr>
								<th colspan=2 style="padding:10px;margin-top:4px;background-color:#267871;color:white;">Owner Details</th>
							</tr>
							<tr>
								<th><label>Name:</label></th>
								<td><?php echo $row['owner_name'] ?></td>
							</tr>

							<tr>
								<th><label>H/P:</label></th>
								<td><?php echo $row['owner_hp'] ?></td>
							</tr>

							<tr>
								<th><label>Email:</label></th>
								<td><?php echo $row['owner_email'] ?></td>
							</tr>


					<?php }
				} ?>

						</table>
			</div>
		</div>

		<input name="editown" type="button" value="Edit" class="btn btn-primary" onClick="document.location.href=('editunitowner.php?un=<?php echo $un ?>&hn=<?php echo $hn ?>');" />
		<a style="float:right" class="btn btn-primary" onClick="window.close();" />Close</a>

		</p>
	</div>

	</div>
<?php

	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>