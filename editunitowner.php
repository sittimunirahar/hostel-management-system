<?php
include 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	$un = $_GET['un'];
	$hn = $_GET['hn'];
	$ownid = "";
?>

	<div class="content2">
		<form action="" method="post">

			<h3>Unit Information</h3>
			<hr>

			<?php
			$query = "SELECT * FROM owner_list JOIN unit_list
	  USING (owner_id)
	  WHERE unit_list.unit_no='$un' AND unit_list.hos_name='$hn'";
			$record = mysqli_query($link, $query);

			if (mysqli_num_rows($record) == 1) {
				while ($row = mysqli_fetch_assoc($record)) {
					$ownid = $row['owner_id'];
			?>

					<div class="panel panel-default">
						<div class="panel-body">
							<table id="typical">

								<tr>
									<th colspan=2 style="padding:10px;margin-top:4px;background-color:#267871;color:white;">Unit Details</th>
								</tr>

								<tr>
									<th><label>Unit No:</label></th>
									<td><input name="unitno" type="text" id="unitno" class="form-control" value="<?php echo $row['unit_no'] ?>" required></td>
								</tr>

								<tr>
									<th><label>Hostel Name:</label></th>
									<td>
										<?php echo $hn; ?>
									</td>
								<tr>
									<th><label>Rental:</label></th>
									<td><input name="rent" type="number" id="rent" class="form-control" value="<?php echo $row['rental'] ?>" required></td>
								</tr>

								<tr>
									<th>Expired Date: </th>
									<td> <input name="exp" type="date" id="exp" class="form-control" value="<?php echo $row['expiry_date'] ?>" required></td>
								</tr>

								<tr>
									<th>Remarks: </th>
									<td> <input name="rmk" type="text" id="rmk" class="form-control" value="<?php echo $row['remarks'] ?>"></td>
								</tr>



								<tr>
									<th colspan=2 style="padding:10px;margin-top:4px;background-color:#267871;color:white;">Owner Details</th>
								</tr>

								<tr>
									<th>Name:</th>
									<td> <input name="name" type="text" id="name" class="form-control" value="<?php echo $row['owner_name'] ?>" required></td>
								</tr>

								<tr>
									<th>H/P: </th>
									<td> <input name="hpno" type="text" id="hpno" class="form-control" value="<?php echo $row['owner_hp'] ?>" required></td>
								</tr>

								<tr>
									<th>Email: </th>
									<td> <input name="email" type="email" id="email" class="form-control" value="<?php echo $row['owner_email'] ?>" required></td>
								</tr>



						<?php }
				} ?>
							</table>
						</div>
					</div>



					<input name="save" type="submit" value="Save" class="btn btn-primary" />
					<input name="cancel" type="button" value="Cancel" class="btn btn-primary" onClick="window.history.back();" />
					<input name="ok" type="button" value="Close" style="float:right" class="btn btn-primary" onClick="window.close();" />
		</form>
	</div>
	<?php

	if (isset($_POST['save'])) {
		extract($_REQUEST);
		$unitno = $_POST['unitno'];
		$rent = $_POST['rent'];
		$exp = $_POST['exp'];
		$rmk = $_POST['rmk'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$hp = $_POST['hpno'];


		$query2 = "UPDATE owner_list SET owner_name='$name', owner_hp='$hp', owner_email='$email', 
			expiry_date='$exp', remarks='$rmk' WHERE owner_id=$ownid";
		$record2 = mysqli_query($link, $query2);

		$query2 = "UPDATE unit_list SET owner_id='$ownid', hos_name='$hn', rental='$rent' WHERE unit_no='$un'";
		$record2 = mysqli_query($link, $query2);

		if ($unitno != $un) {

			$query = "SELECT * FROM unit_list WHERE unit_no='$unitno' AND hos_name='$hn'";
			$record = mysqli_query($link, $query);

			if (mysqli_num_rows($record) > 0) {
	?>
				<script>
					alert('Unit number already exists!');
				</script>
		<?php
			} else {

				$query = "UPDATE unit_list SET unit_no='$unitno' WHERE unit_no='$un' and hos_name='$hn'";
				$record = mysqli_query($link, $query);

				$query = "UPDATE check_in SET unit_no='$unitno' WHERE unit_no='$un' and hos_name='$hn'";
				$record = mysqli_query($link, $query);

				$query = "UPDATE check_out SET unit_no='$unitno' WHERE unit_no='$un' and hos_name='$hn'";
				$record = mysqli_query($link, $query);

				$query = "UPDATE stay_latest SET unit_no='$unitno' WHERE unit_no='$un' and hos_name='$hn'";
				$record = mysqli_query($link, $query);

				$query = "UPDATE pay_details SET unit_no='$unitno' WHERE unit_no='$un' and hos_name='$hn'";
				$record = mysqli_query($link, $query);
			}
		}

		?>
		<script>
			window.onunload = refreshParent;

			function refreshParent() {
				window.opener.location.reload();
			}
			window.close();
		</script>
<?php

	}




	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>