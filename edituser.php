<?php
include 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	if ($_GET['user'] != null) {
		$user = $_GET['user'];
	}
	$pic = "";
?>

	<div class="content2">
		<form action="" method="post" enctype="multipart/form-data">
			<h3>Edit User</h3>
			<hr>

			<?php

			$query = "SELECT * FROM admin_acc LEFT JOIN staff_acc ON admin_acc.username=staff_acc.id 
	LEFT JOIN uploads ON admin_acc.username=uploads.description
	WHERE admin_acc.username='$user'";
			$record = mysqli_query($link, $query); ?>
			<div class="panel panel-default">
				<div class="panel-body">

					<table id="typical">
						<?php while ($row = mysqli_fetch_assoc($record)) {
							if ($staffpos == 'admin') {
						?>

								<tr>
									<th>Username</th>

									<td> <input name="username" type="text" id="username" class="form-control" value="<?php echo $row['username'] ?>"></td>
								</tr>

								<tr>
									<th>Password </th>
									<?php $oripass = $row['password']; ?>
									<td> <input name="password" type="password" id="password" class="form-control" value="<?php echo $row['password'] ?>"></td>
								</tr>

								<tr>
									<th>Confirm Password </th>
									<td> <input name="cpassword" type="password" id="cpassword" class="form-control" value="<?php echo $row['password'] ?>"></td>
								</tr>

								<tr>
									<th>Privilege</th>

									<td>
										<select name="pri" id="pri" class="form-control" style="margin-left:0px">
											<?php if ($row['status'] == 'hstaff') { ?>
												<option value="<?php echo $row['status'] ?>" selected>STADD</option>
												<option value="fstaff">FINANCE</option>
												<option value="admin">ADMIN</option>
											<?php } else if ($row['status'] == 'fstaff') { ?>
												<option value="<?php echo $row['status'] ?>" selected>FINANCE</option>
												<option value="hstaff">STADD</option>
												<option value="admin">ADMIN</option>
											<?php } else { ?>
												<option value="<?php echo $row['status'] ?>" selected>ADMIN</option>
												<option value="hstaff">STADD</option>
												<option value="fstaff">FINANCE</option>
											<?php } ?>
										</select>
									</td>
								</tr>
							<?php } ?>
							<tr>
								<th>Name </th>

								<td> <input name="name" type="text" id="name" class="form-control" value="<?php echo $row['name'] ?>"></td>
							</tr>

							<tr>
								<th>Position </th>

								<td> <input name="position" type="text" id="position" class="form-control" value="<?php echo $row['position'] ?>"></td>
							</tr>

							<tr>
								<th>Picture:</th>
								<td colspan=3>
									<img src="img/<?php echo $row['file'] ?>" width="50" height="50" style="border:1px solid #aaa;float:left;margin-right:6px;">
									<input type="file" name="file" style="float:left">
								</td>
							</tr>
						<?php

							if ($row['file'] == null) {
								$pic = "N";
							} else {
								$pic = "Y";
							}
						}

						?>
					</table><br>
				</div>
			</div>

			<div class="edituser-option">
				<p>
					<input name="save" type="submit" value="Save" class="btn btn-primary" />
					<input name="ok" type="button" value="Close" class="btn btn-primary" onClick="window.close();" />
					<input name="back" type="button" style="float:right" value="Back" class="btn btn-primary" onClick="window.history.back();" />
				</p>
		</form>
	</div>
	</div>

	<?php

	if (isset($_POST['save'])) {
		//extract($_REQUEST);

		$un = $_POST['username'];
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

			//cond for editing file
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
						$sql = "UPDATE uploads SET file='$final_file', type='$file_type', size='$new_size', description='$user' WHERE description='$user'";
						$record = mysqli_query($link, $sql);
					} else {
						$sql = "INSERT INTO uploads(file,type,size,description) VALUES ('$final_file','$file_type','$new_size', '$user')";
						$record = mysqli_query($link, $sql);
					}
			?>
					<script>
						alert('successfully uploaded');
						//window.location.href('index.php');
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

			$sql = "UPDATE admin_acc
			  SET username='$un', password='$passw', status='$pri'
			  WHERE username='$user'";
			$record = mysqli_query($link, $sql);

			$sql = "UPDATE staff_acc
			  SET id='$un', name='$name', position='$pos'
			  WHERE id='$user'";
			$record = mysqli_query($link, $sql);

			$sql = "UPDATE uploads
			  SET description='$un'
			  WHERE description='$user'";
			$record = mysqli_query($link, $sql);
			//check session. if user currently in, directly head to login again

			if ($username == $user && $password == $oripass) {
				if ($username != $un || $password != $passw || $stat != $pri || $staffpos != $pos) {
					$password = $passw;
					$username = $un;
					$stat = $pri;

					$staffpos = $pos;
				?>
					<script>
						alert('You have change your username/password. Please log in again.');
						window.onunload = refreshParent;

						function refreshParent() {
							window.opener.location.href = 'login.php';
						}
						window.close();
					</script>
				<?php
				}
			} else {
				if ($record) { ?>
					<script>
						window.onunload = refreshParent;

						function refreshParent() {
							window.opener.location.reload();
						}
						window.close();
					</script>
<?php }
			}
		} //close check password
	} //close if isset


	require 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>