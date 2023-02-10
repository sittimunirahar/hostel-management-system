<?php
include 'upperbodyhead.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	require 'templates/nav_sem.php';
?>


	</div>
	<div class="content">
		<h3>STAFF PROFILE</h3>
		<hr>

		<?php
		$query = "SELECT * FROM admin_acc JOIN staff_acc ON admin_acc.username = staff_acc.id 
		LEFT JOIN uploads ON admin_acc.username=uploads.description
		WHERE admin_acc.username='$username'";
		$record = mysqli_query($link, $query);
		while ($row = mysqli_fetch_assoc($record)) {
		?>
			<div class="panel panel-default">
				<div class="panel-body">
					<img src="img/<?php echo $row['file'] ?>" width="117" height="120" style="float:left;border-radius:85px;border:2px solid white">
					<table id="typical" style="float:center;">
						<tr>

						<tr>
							<th>&nbsp; Name: </th>
							<td><?php echo $row['name'] ?></td>
						</tr>
						<tr>
							<th>&nbsp; Username: </th>
							<td><?php echo $row['username'] ?></td>
						</tr>
						<tr>
							<th>&nbsp; Position: </th>
							<td><?php echo $row['position'] ?></td>
						</tr>
						<tr>
							<th>&nbsp; Status: </th>
							<td><?php echo $row['status'] ?></td>
						</tr>
						</tr>

					</table>
				</div>

			</div>

			<input name="edit" id="edit" type="button" value="Edit" class="btn btn-primary" onClick="openCenteredWindow('edituser.php?user=<?php echo $row['username'] ?>');" />
		<?php } ?>
		</p>
	</div>
	</div>
<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>