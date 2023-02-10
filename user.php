<?php
require 'upperbodyhead.php';

if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	require 'templates/nav_sem.php';
?>


	</div>
	<div class="content">
		<h3>MANAGE USER</h3>
		<hr>

		<div class="service-option">
			<p>
				<?php
				$query = "SELECT * FROM admin_acc LEFT JOIN staff_acc ON admin_acc.username=staff_acc.id
	LEFT JOIN uploads ON admin_acc.username=uploads.description WHERE admin_acc.status!='admin'";
				$record = mysqli_query($link, $query); ?>

			<div id="wannascroll">
				<table class="display table" id="tabledata2">
					<thead>
						<tr>
							<th>PICTURE</th>
							<th>USERNAME</th>
							<th>STATUS</th>
							<th>NAME</th>
							<th>POSITION</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$status = "";
						while ($row = mysqli_fetch_assoc($record)) { ?>
							<tr>
								<td><img src="img/<?php echo $row['file'] ?>" width="80" height="80" style="float:center;border-radius:40px;border:2px solid white;"></td>
								<td><a href="staffprofile2.php?username=<?php echo $row['username']; ?>" data-toggle="modal"></a>
									<?php echo $row['username']; ?></td>
								<?php if ($row['status'] == 'hstaff') {
									$status = "STADD Access";
								} else if ($row['status'] == 'fstaff') {
									$status = "Finance Access";
								} else {
									$status = "Admin Access";
								}
								?>
								<td><?php echo $status; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['position']; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>

				<!--<input name="edit" type="submit" value="Edit" class="btn btn-primary"/>-->
				<input name="add" type="button" value="Add" class="btn btn-primary" onClick="document.location.href=('adduser.php');" />
			</div>
			</p>

		</div>

	</div>

	</form>
	</body>

	</html>
<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>