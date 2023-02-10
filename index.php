<?php
session_start();
// remove all session variables
session_unset();
require 'database/credentials.php';


if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$query = "SELECT sem_id, semester, session, status FROM sem_list WHERE status='DEFAULT'";
	$record = mysqli_query($link, $query);

	while ($row = mysqli_fetch_assoc($record)) {
		$sid = $row['sem_id'];
		$sem = $row['semester'];
		$ses = $row['session'];
		$stat = $row['status'];
	}

	$query2 = "SELECT * FROM admin_acc WHERE username='$username' AND password='$password'";
	$record2 = mysqli_query($link, $query2);

	$staffpos = "";

	if (mysqli_num_rows($record2) == 1) {

		while ($row2 = mysqli_fetch_assoc($record2)) {
			$staffpos = $row2['status'];
		}

		$_SESSION['password'] = $password;
		$_SESSION['username'] = $username;
		$_SESSION['sid'] = $sid;
		$_SESSION['sem'] = $sem;
		$_SESSION['ses'] = $ses;
		$_SESSION['stat'] = $stat;
		$_SESSION['mnth'] = 'all';
		$_SESSION['position'] = $staffpos;


		header("Location: home.php");
		exit;
	} else {
?><script>
			alert("Wrong username or password!");
		</script><?php
						}
					}
					require 'templates/header.php';
							?>

<!-- Page Content -->
<div class="wrap">

	<form action="" method="post" name="loginform" id="loginform">
		<br>
		<!-- <br> -->

		<div class="panel" style="width:50%; float:right; margin: 5% 25% 10% 25%">
			<!-- <center> -->
			<div class="panel-header" style="background-color:#11999e;color:white;padding:7px; border-radius:0px;">
				<h3 style="text-align:center; ">SIGN IN</h3>
			</div>

			<div class="panel-body" style="border: 1px solid #29A19C;box-shadow: 5px 5px 1px #eee;">
				<div class="row">
					<div class="col-md-4" style="padding:8%"><i class="fa fa-bed" style="font-size:120px; color:#00CDAC"></i></div>
					<div class="col-md-8">
						<table class="login-form">

							<tr>
								<!-- <td><label>Username: </label></td> -->
								<td><label>Username: </label></td>
							</tr>
							<tr>
								<td><input name="username" type="text" id="name" placeholder="username" class="form-control"></td>
							</tr>
							<tr>
								<td><label>Password:</label></td>
							</tr>
							<tr>
								<td><input name="password" type="password" id="password" placeholder="password" class="form-control"></td>
							</tr>
							<tr>
								<td><input name="submit" style="float: left;" type="submit" value="Sign in" class="btn btn-primary"></td>
							</tr>
						</table>
					</div>
				</div>

			</div>
			<!-- </center> -->
		</div>

	</form>

	<?php


	require 'lowerbody.php';
	?>