<?php
include 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username']) && $staffpos == 'admin') {
	if ($_GET['username'] != null) {
		$user = $_GET['username'];
	}
	$s = '';
?>

	</div>
	<div class="content2">
		<h3>STAFF PROFILE</h3>
		<hr>
		<br>
		<form method="post">
			<?php
			$query = "SELECT * FROM admin_acc JOIN staff_acc ON admin_acc.username = staff_acc.id 
		LEFT JOIN uploads ON admin_acc.username=uploads.description
		WHERE admin_acc.username='$user'";
			$record = mysqli_query($link, $query);
			while ($row = mysqli_fetch_assoc($record)) {
			?>
				<div class="panel panel-default">
					<div class="panel-body">
						<img src="img/<?php echo $row['file'] ?>" width="110" height="115" style="float:left;border-radius:55px;border:2px solid white;">
						<table id="typical" style="float:center;">
							<tr>


							<tr>
								<th>&nbsp; Name: </th>
								<td><?php echo $row['name'] ?></td>
							</tr>
							<tr>
								<th>&nbsp; Id: </th>
								<td><?php echo $row['username'] ?></td>
							</tr>
							<tr>
								<th>&nbsp; Position: </th>
								<td><?php echo $row['position'] ?></td>
							</tr>
							<tr>
								<th>&nbsp; Status: </th>
								<td><?php echo $row['status'];
										$s = $row['status']; ?></td>
							</tr>
							</tr>

						</table>
					</div>

				</div>
			<?php } ?>
			<input name="confirm" type="button" value="Edit" class="btn btn-primary" onClick="document.location.href=('edituser.php?user=<?php echo $user ?>');" />
			<!--<input name="delete" type="submit" value="Delete" class="btn btn-primary" />-->
			<?php if ($s != 'admin') { ?>
				<a class="btn btn-primary" onClick="javascript: return confirm('Are you sure to delete?');" href="deleteuser.php?username=<?php echo $user ?>">Delete</a>
			<?php } ?>
			<input name="ok" type="button" style="float:right" value="Close" class="btn btn-primary" onClick="window.close();" />

			</p>
	</div>
	</div>
	</form>
<?php



	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>