<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
?>

	<br>
	<div class="content2">

		<h3>List of Unit</h3>
		<hr>
		<form action="unitlist.php" method="POST">

			<div class="panel panel-default">
				<div class="panel-body">
					<table class="filterrep typical" id="studlist">


						<tr>
							<td>
								<label>Start: </label>
							</td>
							<td><input type="month" class="form-control" name="strt" required>
							</td>

							<td>
								<label>End: </label>
							</td>
							<td><input type="month" class="form-control" name="end" required></td>
						</tr>

						<tr>
							<td><label>Sort By: </label></td>
							<td>&nbsp;
								<input type="radio" value="UnitNo" name="radio">Unit No &nbsp;
								<input type="radio" value="Hostel" name="radio" checked="checked">Hostel
								<input type="radio" value="RentalF" name="radio">Rental
								<input type="radio" value="Exp" name="radio">Expiry

							</td>
						</tr>

						<tr>
							<td><label>Hostel: </label></td>
							<td>
								<select class='form-control' name="hos_n" style="margin-left:0px">
									<option value="">All</option>
									<?php
									$query = "select hostel_details.hos_name, hostel_details.hos_gender from hostel_details LEFT JOIN hostel_closed ON hostel_details.hos_name=hostel_closed.hos_name
			where hostel_closed.date_closed IS NULL";
									$record = mysqli_query($link, $query);
									while ($row = mysqli_fetch_assoc($record)) {
									?>
										<option value="<?php echo $row['hos_name']; ?>"> <?php echo $row['hos_name']; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>

					</table>

				</div>
			</div>
			<input name="gorep1" id="gorep" type="submit" value="Go" class="btn btn-primary" />
			<input name="ok" type="button" value="Close" class="btn btn-primary" onClick="window.close();" style="float:right;" />

		</form>

	</div>

	</div>
<?php
	include 'lowerbody.php';
} else {
	require 'warninglogin.php';
} ?>