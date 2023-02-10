<?php
include 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	$fid = '';
	if (!empty($_GET['fid'])) {
		$fid = $_GET['fid'];
	}
?>

	</div>
	<div class="content2">

		<form action="" method="post">

			<h3>View Fee Structure</h3>
			<hr>

			<div class="panel panel-default">
				<div class="panel-body">

					<table id="typical">
						<?php
						$query = "SELECT * FROM fees_setting WHERE fees_id='$fid'";
						$record = mysqli_query($link, $query);
						while ($row = mysqli_fetch_assoc($record)) { ?>
							<tr>
								<th colspan=2 style="padding:10px;background-color:green;color:white;">Details</th>
							</tr>
							<tr>
								<th>Type: </th>

								<td>
									<div class="col-xs-12">
										<?php echo $row['type']; ?>
									</div>
								</td>
							</tr>

							<tr>
								<th>Description: </th>
								<td>
									<div class="col-xs-12">
										<?php echo $row['description']; ?>
									</div>
								</td>
							</tr>

							<?php
							$sem_id = $row['sem_id'];
							$query2 = "SELECT * FROM sem_list WHERE sem_id='$sem_id'";
							$record2 = mysqli_query($link, $query2);

							?>
							<tr>
								<th>Semester: </th>
								<td>
									<div class="col-xs-12">

										<?php
										while ($row2 = mysqli_fetch_assoc($record2)) {
											echo $row2['semester'] . " " . $row2['session'] . ' - ' . $row2['status'];
										} ?>

									</div>
								</td>
							</tr>

							<tr>
								<th colspan=2 style="padding:10px;background-color:green;color:white;">Charges</th>
							</tr>

							<tr>
								<th>Date Applicable: </th>

								<td>
									<div class="col-xs-12">
										<?php echo date('F', mktime(0, 0, 0, $row['month'], 10)) . '-' . $row['year']; ?>
									</div>
								</td>
							</tr>
							<tr>
								<th>Rate: </th>
								<td>
									<div class="col-xs-12">
										<?php echo $row['fees_per_month']; ?>
										<!--<input name="rental" type="number" step="0.01" placeholder="0.00" id="rental" 
				value="" class="form-control" required >
				?>-->
									</div>
								</td>
							</tr>


						<?php } ?>
					</table>
				</div>
			</div>


			<div class="addfee-option">
				<p>
					<!-- <input name="edit" type="submit" value="Save" class="btn btn-primary"/>-->
					<input name="close" type="button" value="Close" class="btn btn-primary" style="float:right" onClick="window.close();" />
				</p>
		</form>
	</div>

	<?php

	?> </div><?php
						require 'lowerbody.php';
					} else {
						require 'warninglogin.php';
					} ?>