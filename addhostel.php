<?php
require 'upperbody3.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
?>
	<div class="list-group">
		<a href="hostel.php" class="list-group-item active">
			<i class="fa fa-building"></i>HOSTEL</a>
		<a href="allocation.php" class="list-group-item">
			<i class="fa fa-key"></i>ALLOCATION</a>
		<a href="payment.php" class="list-group-item">
			<i class="fa fa-credit-card"></i>FINANCIAL</a>
		<a href="services.php" class="list-group-item">
			<i class="fa fa-bar-chart"></i>REPORT</a>
		<a href="dashboardhostel.php" class="list-group-item">
			<i class="fa fa-dashboard"></i>DASHBOARD</a>
		<a href="home.php" class="list-group-item">
			<i class="fa fa-home"></i>HOME</a>
	</div>

	</div>
	<div class="content">
		<form action="" method="post" enctype="multipart/form-data">
			<h3>Add Hostel</h3>
			<hr>

			<div class="panel panel-default">
				<div class="panel-body">
					<table id="typical">
						<tr>
							<th>Name:</th>
							<td colspan=3> <input name="hosname" type="text" id="hosname" class="form-control"></td>
						</tr>

						<tr>
							<th>Address:</th>
							<td colspan=3> <textarea name="hosadd" type="text" id="hosadd" class="form-control"></textarea></td>
						</tr>

						<tr>
							<th>Gender: </th>
							<td colspan=3>
								<input name="gender" value="M" type="radio" id="gender"> Male &nbsp;
								<input name="gender" value="F" type="radio" id="gender"> Female &nbsp;
								<input name="gender" value="A" type="radio" id="gender"> All
							</td>
						</tr>

						<tr>
							<th>Managed By: </th>
							<td colspan=3>
								IIC
								</select>
							</td>
						</tr>

						<tr>
							<th>Max Occupants per Unit: </th>
							<td colspan=3> <input name="totalocc" type="number" id="totalocc" class="form-control" required></td>
						</tr>

						<tr>
							<th>Picture:</th>
							<td colspan=3><input type="file" name="file" required></td>
						</tr>

					</table>
				</div>
			</div>

			<input name="add" type="submit" value="Add" class="btn btn-primary" />
			<input name="cancel" type="button" value="Cancel" class="btn btn-primary" onClick="document.location.href=('hostel.php');" />
		</form>
	</div>

	<?php
	if (isset($_POST['add'])) {
		extract($_REQUEST);
		//$file=$_POST['file'];
		$hosname = $_POST['hosname'];
		$hosadd = $_POST['hosadd'];
		$totalocc = $_POST['totalocc'];
		$gender = $_POST['gender'];
		$manager = 'IIC';

		$file = rand(1000, 100000) . "-" . $_FILES['file']['name'];
		$file_loc = $_FILES['file']['tmp_name'];
		$file_size = $_FILES['file']['size'];
		$file_type = $_FILES['file']['type'];
		$folder = "img/";

		// new file size in KB
		$new_size = $file_size / 1024;

		// make file name in lower case
		$new_file_name = strtolower($file);

		$final_file = str_replace(' ', '-', $new_file_name);

		if (move_uploaded_file($file_loc, $folder . $final_file)) {

			$sql = "SELECT description FROM uploads WHERE description='$hosname'";
			$record = mysqli_query($link, $sql);

			if (mysqli_num_rows($record) != 0) {
				$sql1 = "DELETE FROM uploads WHERE description='$hosname'";
				$record1 = mysqli_query($link, $sql1);
			}
			$sql = "INSERT INTO uploads(file,type,size,description) VALUES ('$final_file','$file_type','$new_size', '$hosname')";
			$record = mysqli_query($link, $sql);

			$sql = "INSERT INTO hostel_details(hos_name, hos_address, unit_max_occ, hos_gender, hos_managed_by) VALUES ('$hosname', '$hosadd',
			  '$totalocc', '$gender', '$manager')";
			$record = mysqli_query($link, $sql);
			$sql = "INSERT INTO hostel_list(hos_name) VALUES ('$hosname')";
			$record = mysqli_query($link, $sql);
	?>
			<script>
				alert('successfully added');
				window.location.href = "hostel.php";
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

	require 'lowerbody.php';
} else {
	require 'warninglogin.php';
}
?>