<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
?>
	<br>
	<div class="content2">

		<h3>Check In/Check Out Slip</h3>
		<hr>
		<form action="checkinoutslip.php" method="POST">

			<div class="panel panel-default">
				<div class="panel-body">
					<table class="filterrep typical" id="studlist">

						<tr>
							<td>
								<label>Matric No: </label>
							</td>
							<td><input type="text" class="form-control" name="matric" required />
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