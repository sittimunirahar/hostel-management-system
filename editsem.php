<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	$ss = '';
	$sm = '';
	$status = '';
	$admin = '';
	$m = array();
	$sid = '';


	if (!empty($_GET['ss']) && !empty($_GET['sm']) && !empty($_GET['sid'])) {
		$ss = $_GET['ss'];
		$sm = $_GET['sm'];
		$sid = $_GET['sid'];
	}

	$query = "SELECT * FROM sem_list JOIN sem_duration USING (sem_id)
		  WHERE sem_list.session='$ss' AND  sem_list.semester='$sm'";
	$record = mysqli_query($link, $query);

	while ($row = mysqli_fetch_assoc($record)) {
		$status = $row['status'];
		$admin = $row['username'];
		$dt = '01-' . $row['month'] . '-' . $row['year'];
		$dte = date('Y-m', strtotime($dt));
		// echo $dte;
		array_push($m, $dte);
		//$y=array_push($y, $row['year']);
	}
?>
	</div>

	<!-- Close div sideleft-->
	</div>

	<div class="content2">
		<form action="" method="post">


			<h3>Edit Semester</h3>
			<hr>

			<div class="panel panel-default">
				<div class="panel-body">
					<table id="typical">

						<tr>
							<th>Semester:</th>
							<td colspan=2> <?php echo $sm; ?></td>
						</tr>

						<tr>
							<th>Session:</th>
							<td colspan=2><?php echo $ss; ?></td>
						</tr>

						<tr>
							<th>Status: </th>
							<td colspan=2> <select name="stat" class="form-control" style="margin-left:0px" required>
									<?php if ($status == 'OFF') { ?>
										<option value='OFF' selected>OFF</option>
										<option value='DEFAULT'>DEFAULT</option>
									<?php } else { ?>
										<option value='OFF'>OFF</option>
										<option value='DEFAULT' selected>DEFAULT</option>
									<?php } ?>

								</select>
								<em>(Selecting default will automatically off the previous default semester)</em>
							</td>
						</tr>

						<tr>
							<th>Month: </th>
							<td colspan=2>

								<?php
								//print_r($m);
								//echo '<br>'.sizeof($m);
								for ($i = 0; $i < sizeof($m); $i++) { ?>
									<input name="<?php echo 'm' . $i ?>" type="month" id="<?php echo 'm' . $i ?>" value="<?php echo $m[$i]; ?>" class="form-control">
								<?php } ?>
							</td>
						</tr>


					</table>
				</div>
			</div>


			<input name="save" type="submit" value="Save" class="btn btn-primary" />
			<input name="cancel" type="button" value="Cancel" class="btn btn-primary" onClick="document.location.href=('viewsem.php?sm=<?php echo $sm; ?>&ss=<?php echo $ss; ?>');" />
		</form>
	</div>
	<?php

	if (isset($_POST['save'])) {
		extract($_REQUEST);

		$stat = $_POST['stat'];
		$new = array();
		$dont = 0;
		$upd = 0;

		for ($i = 0; $i < sizeof($m); $i++) {
			//echo $i;
			$g = 'm' . $i;
			$d = $_POST[$g];
			array_push($new, $d);

			$ans = 'true';
			if ($i != 0) {
				if ($d != $new[$i - 1]) {
					$ans = 'true';
				} else {
					$ans = 'false';
				}
				//echo $d.' vs '.$new[$i-1].'<br> => ans: '.$ans.'<br>';
			}

			if ($ans == 'false') {
				$dont++;
			}
		}

		$olmon = '';
		$olye = '';
		$mon = '';
		$ye = '';
		$mmm = '';

		if ($dont != 0) {
	?>
			<script>
				alert('You entered the same date!');
			</script>
			<?php
		} else {
			for ($i = 0; $i < sizeof($m); $i++) {
				//echo $i;
				$g = 'm' . $i;
				$d = $_POST[$g];
				//array_push($new, $d);

				$ans = 'true';

				if ($d != $m[$i]) {

					$olmon = date('m', strtotime($m[$i]));
					$olye = date('Y', strtotime($m[$i]));
					$mon = date('m', strtotime($d));
					$ye = date('Y', strtotime($d));
					//echo $mon.$ye;
					$query3 = "UPDATE sem_duration SET month='$mon', year='$ye' WHERE month='$olmon' AND year='$olye' AND sem_id='$sid'";
					$record3 = mysqli_query($link, $query3);
					if ($record3) {

						$upd++;
					}
				}
			}

			if ($stat == 'DEFAULT' && $stat != $status) {
				$querye = "UPDATE sem_list SET status='OFF' WHERE status='DEFAULT'";
				$recorde = mysqli_query($link, $querye);

				$querye = "UPDATE sem_list SET status='DEFAULT' WHERE sem_id='$sid'";
				$recorde = mysqli_query($link, $querye);
				if ($recorde) {
					$upd++;
				}
			} else if ($stat == 'OFF' && $stat != $status) {
				$querye = "UPDATE sem_list SET status='OFF' WHERE sem_id='$sid'";
				$recorde = mysqli_query($link, $querye);
				if ($recorde) {
					$upd++;
				}
			}

			if ($upd != 0) {
			?>
				<script>
					alert('Record updated!');
					window.location.replace("viewsem.php?sm=<?php echo $sm; ?>&ss=<?php echo $ss; ?>");
				</script>
			<?php
			} else {
			?>
				<script>
					alert('No changes made, returning to previous page.');
					window.location.replace("viewsem.php?sm=<?php echo $sm; ?>&ss=<?php echo $ss; ?>");
				</script>
<?php
			}
		}
	}

	require 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>