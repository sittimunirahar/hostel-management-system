<?php
require 'upperbodyhead.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	require 'templates/nav_sem.php';
?>


	</div>

	<!-- Close div sideleft-->
	</div>

	<div class="content">

		<h3>MANAGE SEMESTER</h3>
		<hr>

		<!-- semester table -->


		<!--<form method="post">-->
		<?php
		$query = "SELECT semester,session, status, username, count(dur_id) as totm FROM sem_list JOIN sem_duration USING (sem_id) GROUP BY sem_id";
		$record = mysqli_query($link, $query);
		?>

		<table class="display table" id="tabledata2">
			<thead>
				<tr>

					<th>Semester</th>
					<th>Session</th>
					<th>Status</th>
					<th>Total Months</th>
					<th>Added By</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = mysqli_fetch_assoc($record)) { ?>
					<tr>
						<td style="padding-left:25px"><a href="viewsem.php?sm=<?php echo $row['semester']; ?>&ss=<?php echo $row['session']; ?>" id="feehref"></a>
							<?php echo $row['semester'] ?></td>
						<td><?php echo $row['session'] ?></td>
						<td><?php echo $row['status'] ?></td>
						<td><?php echo $row['totm'] ?></td>
						<td><?php echo $row['username'] ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>

		<input name="addsem" type="button" value="Add" class="btn btn-primary" onClick="document.location.href=('addsem.php');" />

	</div>

	</div>

	</form>
	</body>

	</html>
<?php

	require 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>