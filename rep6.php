<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {

?>
	<br>
	<div class="content2">

		<h3>College Payment Record</h3>
		<hr>
		<form action="paylistcol.php" method="POST">

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
								<input type="radio" value="Name" name="radio" checked="checked">Name &nbsp;
								<input type="radio" value="d_iss" name="radio">Date Issued &nbsp;
							</td>
						</tr>

						<tr>
							<td><label>Status: </label></td>
							<td>
								<select class='form-control' name="status" style="margin-left:0px">
									<option value="">All</option>
									<option value="INVOICED">Invoiced</option>
									<option value="PAID">Paid</option>
								</select>
							</td>
						</tr>

						<tr>
							<td><label>Pay Type: </label></td>
							<td>
								<select id="pay_t" name="pay_t" class="form-control" style="margin-left:0px">
									<option value="">All</option>
									<option value="HOSTEL">Hostel</option>
									<option value="ELECTRICITY">Electricity Bill</option>
									<option value="WATER">Water Bill</option>
									<option value="CARETAKER">Caretaker</option>
									<option value="STORE">Store</option>
									<option value="CAFE">Cafeteria</option>
									<option value="BUS">Bus</option>
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