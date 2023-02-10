<?php
include 'upperbody3.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	if ($_GET['hn'] != null && $_GET['hi'] != null) {
		$hn = $_GET['hn'];
		$hi = $_GET['hi'];
	} else {
		$hn = "";
		$hi = "";
	}
	$managed = "";
	$pic = "";

	require 'templates/nav_hostel.php';
?>


	</div>
	<div class="content">
		<form action="" method="post" enctype="multipart/form-data">
			<h3>Edit Hostel Details</h3>
			<hr>

			<?php
			$query = "SELECT * FROM hostel_details LEFT JOIN uploads ON hostel_details.hos_name=uploads.description WHERE hostel_details.hos_name='$hn'";
			$record = mysqli_query($link, $query);
			?>
			<div class="panel panel-default">
				<div class="panel-body">
					<table id="typical">
						<?php
						while ($row = mysqli_fetch_assoc($record)) { ?>

							<tr>
								<th>Name:</th>
								<td colspan=3> <input name="hosname" type="text" id="hosname" class="form-control" value="<?php echo $row['hos_name'] ?>"></td>
							</tr>

							<tr>
								<th>Address:</th>
								<td colspan=3> <textarea name="hosadd" type="text" id="hosadd" class="form-control"><?php echo $row['hos_address'] ?></textarea></td>
							</tr>

							<tr>
								<th>Gender: </th>
								<td colspan=3>

									<?php if ($row['hos_gender'] == "M") { ?>
										<input name="gender" value="M" type="radio" id="gender" checked="checked"> Male &nbsp;
										<input name="gender" value="F" type="radio" id="gender"> Female &nbsp;
										<input name="gender" value="A" type="radio" id="gender"> All
									<?php } else if ($row['hos_gender'] == "F") { ?>
										<input name="gender" value="M" type="radio" id="gender"> Male &nbsp;
										<input name="gender" value="F" type="radio" id="gender" checked="checked"> Female &nbsp;
										<input name="gender" value="A" type="radio" id="gender"> All
									<?php } else { ?>
										<input name="gender" value="M" type="radio" id="gender"> Male &nbsp;
										<input name="gender" value="F" type="radio" id="gender"> Female &nbsp;
										<input name="gender" value="A" type="radio" id="gender" checked="checked"> All
									<?php } ?>
								</td>
							</tr>

							<tr>
								<th>Unit Occupants: </th>
								<td colspan=3> <input name="totalocc" type="number" id="totalocc" class="form-control" value="<?php echo $row['unit_max_occ'] ?>"></td>
							</tr>

							<tr>
								<th>Picture:</th>
								<td colspan=3><img src="img/<?php echo $row['file'] ?>" width="50" height="50" style="border:1px solid #aaa;float:left;margin-right:6px;"><input type="file" name="file" style="float:left"></td>
							</tr>
						<?php

							//$managed=$row['hos_managed_by'];

							if ($row['file'] == null) {
								$pic = "N";
							} else {
								$pic = "Y";
							}
						}


						?>
					</table>
				</div>
			</div>
			<input name="edit" type="submit" value="Save" class="btn btn-primary" />
			<input name="cancel" type="button" value="Cancel" class="btn btn-danger" onClick="document.location.href=('mgt-details.php?hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>');" />
		</form>
	</div>
	<?php

	if (isset($_POST['edit'])) {
		extract($_REQUEST);
		$hosname = $_POST['hosname'];
		$hosadd = $_POST['hosadd'];
		$totalocc = $_POST['totalocc'];
		$gender = $_POST['gender'];

		if ($managed == "Others") {
			$con1 = $_POST['con1'];
			$hp1 = $_POST['hp1'];
			$con2 = $_POST['con2'];
			$hp2 = $_POST['hp2'];
		} else {
			$con1 = "";
			$hp1 = "";
			$con2 = "";
			$hp2 = "";
		}

		if ($_FILES['file']['size'] != 0) {

			$file = rand(1000, 100000) . "-" . $_FILES['file']['name'];
			$file_loc = $_FILES['file']['tmp_name'];
			$file_size = $_FILES['file']['size'];
			$file_type = $_FILES['file']['type'];
			$folder = "img/";

			// new file size in KB
			$new_size = $file_size / 1024;
			// new file size in KB

			// make file name in lower case
			$new_file_name = strtolower($file);
			// make file name in lower case

			$final_file = str_replace(' ', '-', $new_file_name);

			if (move_uploaded_file($file_loc, $folder . $final_file)) {
				if ($pic == "Y") {
					$sql = "UPDATE uploads SET file='$final_file', type='$file_type', size='$new_size', description='$hosname' WHERE description='$hn'";
					$record = mysqli_query($link, $sql);
				} else {
					$sql = "INSERT INTO uploads(file,type,size,description) VALUES ('$final_file','$file_type','$new_size', '$hosname')";
					$record = mysqli_query($link, $sql);
				}
	?>
				<script>
					alert('successfully uploaded');
				</script>
			<?php
			} else {
			?>
				<script>
					alert('error while uploading file');
				</script>
			<?php
			}
		}

		$sql = "UPDATE hostel_details SET hos_address='$hosadd', unit_max_occ='$totalocc',
			  hos_gender='$gender' WHERE hos_name='$hn'";
		$record = mysqli_query($link, $sql);

		if ($hosname != $hn) {

			$sql = "SELECT hos_name FROM hostel_details WHERE hos_name='$hn'";
			$record = mysqli_query($link, $sql);

			if (mysqli_num_rows($record) == 0) {

				$sql = "UPDATE hostel_details SET hos_name='$hosname' WHERE hos_name='$hn'";
				$record = mysqli_query($link, $sql);

				$sql = "UPDATE hostel_list SET hos_name='$hosname' WHERE hos_name='$hn'";
				$record = mysqli_query($link, $sql);

				$sql = "UPDATE check_in SET hos_name='$hosname' WHERE hos_name='$hn'";
				$record = mysqli_query($link, $sql);

				$sql = "UPDATE check_out SET hos_name='$hosname' WHERE hos_name='$hn'";
				$record = mysqli_query($link, $sql);

				$sql = "UPDATE stay_latest SET hos_name='$hosname' WHERE hos_name='$hn'";
				$record = mysqli_query($link, $sql);

				$sql = "UPDATE unit_list SET hos_name='$hosname' WHERE hos_name='$hn'";
				$record = mysqli_query($link, $sql);

				$sql = "UPDATE hostel_closed SET hos_name='$hosname' WHERE hos_name='$hn'";
				$record = mysqli_query($link, $sql);

				$sql = "UPDATE fees_setting SET description='$hosname' WHERE description='$hn'";
				$record = mysqli_query($link, $sql);

				$sql = "UPDATE pay_details SET hos_name='$hosname' WHERE hos_name='$hn'";
				$record = mysqli_query($link, $sql);

				$sql = "UPDATE uploads SET description='$hosname' WHERE description='$hn'";
				$record = mysqli_query($link, $sql);
			} else {
			?>
				<script>
					alert('Hostel already exist!');
				</script>
		<?php
			}
		}

		?>
		<script>
			window.location.href = "mgt-details.php?hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>";
		</script>
<?php

	}

	require 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>