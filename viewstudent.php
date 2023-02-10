<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	$matric = $_GET['m'];
	$p = "";
	if (!empty($_GET['p'])) {
		$p = $_GET['p'];
	}

	$hi = "";
	$hn = "";

	if (!empty($_GET['hi']) && !empty($_GET['hn'])) {
		$hi = $_GET['hi'];
		$hn = $_GET['hn'];
	}

?>

	<div class="tabs2">
		<ul class="nav nav-tabs ">
			<?php if ($hn == null || $hi == null) { ?>
				<li class="active"><a href="viewstudent.php?m=<?php echo $matric ?>">Particulars</a></li>
				<li><a href="finstudent.php?m=<?php echo $matric ?>">Hostel Charges</a></li>
				<li><a href="finalloc.php?m=<?php echo $matric ?>">Allocation Record</a></li>
			<?php } else { ?>
				<li class="active"><a href="viewstudent.php?m=<?php echo $matric ?>&hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Particulars</a></li>
				<li><a href="finstudent.php?m=<?php echo $matric ?>&hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Hostel Charges</a></li>
				<li><a href="finalloc.php?m=<?php echo $matric ?>&hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>">Allocation Records</a></li>
				<?php }

			$query = "SELECT student_list.matric, stay_latest.status from student_list LEFT JOIN stay_latest ON 
			 student_list.matric = stay_latest.matric where student_list.matric='$matric'";
			$record = mysqli_query($link, $query);
			while ($row = mysqli_fetch_assoc($record)) {
				if ($row['status'] == "CI") {
				?>
					<input name="Check Out" type="button" value="Check Out" class="btn btn-primary" style="float:right;margin-right:0px;margin-top:2px;
		margin-bottom:2px;" onClick="window.location.href='check-out.php?m=<?php echo $matric ?>';" />
					<?php } else {
					if ($hn == null || $hi == null) { ?>
						<input name="Check In" type="button" value="Check In" class="btn btn-primary" style="float:right;margin-right:0px;margin-top:2px;
		margin-bottom:2px;" onClick="window.location.href='check-in.php?m=<?php echo $matric ?>';" />
					<?php } else { ?>
						<input name="Check In" type="button" value="Check In" class="btn btn-primary" style="float:right;margin-right:0px;margin-top:2px;
		margin-bottom:2px;" onClick="window.location.href='check-in.php?m=<?php echo $matric ?>&hi=<?php echo $hi; ?>&hn=<?php echo $hn; ?>';" />

			<?php }
				}
			} ?>
		</ul>
	</div>

	<br>
	<div class="content2">

		<br><br>
		<h3>Particulars</h3>
		<hr>

		<?php
		$query = "SELECT * FROM student_list where matric='$matric'";
		$record = mysqli_query($link, $query);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<table id="typical">
					<?php
					if (mysqli_num_rows($record) == 1) {
						while ($row = mysqli_fetch_assoc($record)) { ?>

							<tr>

								<th width="20%"><label>Name:</label></th>
								<td><?php echo $row['first_name'] ?> <?php echo $row['last_name'] ?></td>
							</tr>
							<tr>
								<th><label>Matric No:</label></th>
								<td><?php echo $row['matric'] ?></td>
							</tr>
							<tr>
								<th><label>Gender:</label></th>
								<td><?php echo $row['gender'] ?></td>
							</tr>
							<tr>
								<th><label>Program:</label></td>
								<td><?php echo $row['program'] ?></th>
							</tr>
							<tr>
								<th><label>Year:</label></th>
								<td><?php echo $row['year'] ?></td>
							</tr>
							<tr>
								<th><label>Status:</label></th>
								<td><?php echo $row['status'] ?></td>
							</tr>
							<tr>
								<th><label>Phone:</label></th>
								<td><?php echo $row['hp_no'] ?></td>
							</tr>
							<tr>
								<th><label>Email:</label></th>
								<td><?php echo $row['email'] ?></td>
							</tr>
					<?php }
					} ?>
				</table>
			</div>
		</div>

		<input name="ok" type="button" value="Close" style="float:right;margin-left:5px" class="btn btn-primary" onClick="window.close();" />

		<?php if ($p != 1) { ?>
			<input name="back" type="button" value="Back" style="float:right; " class="btn btn-primary" onclick="window.history.back();">
		<?php } ?>
		</p>
	</div>

<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>