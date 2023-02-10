<?php

require 'upperbodyhead.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	require 'templates/nav_sem.php';
?>

	</div>
	<div class="content">
		<form action="" method="post" enctype="multipart/form-data">
			<h3>Add User</h3>
			<hr>
			<div class="panel panel-default">
				<div class="panel-body">

					<table id="typical">
						<tr>
							<th colspan=2 style="padding:10px;background-color:green;color:white;">Account</th>
						</tr>
						<tr>
							<th>Username:</th>
							<td> <input name="username" type="text" id="username" class="form-control" required></td>
						</tr>

						<tr>
							<th>Password: </th>
							<td> <input name="password" type="password" id="password" class="form-control" required></td>
						</tr>

						<tr>
							<th>Confirm Password: </th>
							<td> <input name="cpassword" type="password" id="cpassword" class="form-control" required></td>
						</tr>

						<tr>
							<th>Privilege:</th>
							<td>
								<select class="form-control" style="margin-left:0px" name="pri" required>
									<option value="hstaff">STADD</option>
									<option value="fstaff">FINANCE</option>
									<option value="admin">ADMIN</option>
								</select>
							</td>
						</tr>

						<tr>
							<th colspan=2 style="padding:10px;background-color:green;color:white;">Profile</th>
						</tr>

						<tr>
							<th>Name: </th>
							<td> <input name="name" type="text" id="name" class="form-control" required></td>
						</tr>

						<tr>
							<th>Position: </th>
							<td> <input name="position" type="text" id="position" class="form-control" required></td>
						</tr>

						<tr>
							<th>Picture:</th>
							<td><input type="file" name="file" required></td>
						</tr>
					</table>
				</div>
			</div>


			<input name="add" type="submit" value="Add" class="btn btn-primary" />
			<input name="cancel" type="button" value="Cancel" class="btn btn-primary" onClick="document.location.href=('user.php');" />
		</form>
	</div>
	<?php

	if (isset($_POST['add'])) {
		extract($_REQUEST);

		$un = $_POST['username'];

		$query = "SELECT * FROM admin_acc LEFT JOIN staff_acc ON admin_acc.username=staff_acc.id 
		LEFT JOIN uploads ON admin_acc.username=uploads.description
		WHERE admin_acc.username='$un'";
		$record = mysqli_query($link, $query);

		if (mysqli_num_rows($record) == 1) {
	?>
			<script>
				alert('Username already exist!');
			</script>
			<?php
		} else {

			$passw = $_POST['password'];
			$cpassword = $_POST['cpassword'];
			$pri = $_POST['pri'];
			$name = $_POST['name'];
			$pos = $_POST['position'];

			if ($passw != $cpassword) {
			?>
				<script>
					alert('Password does not match!');
				</script>
				<?php
			} else {
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

						$sql = "INSERT INTO uploads(file,type,size,description) VALUES ('$final_file','$file_type','$new_size', '$username')";
						$record = mysqli_query($link, $sql);
						$sql = "INSERT INTO staff_acc(id, name, position) VALUES ('$un', '$name',
						  '$pos')";
						$record = mysqli_query($link, $sql);
						$sql = "INSERT INTO admin_acc(username, password, status) VALUES ('$un', '$passw',
						  '$pri')";
						$record = mysqli_query($link, $sql);


				?>
						<script>
							alert('User successfully added!');
						</script>
					<?php
						header("Location: user.php");
					} else {
					?>
						<script>
							alert('Error while adding user, please try again.');
						</script>
<?php
					}
				}
			}
		}
	}


	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>