<?php
require 'upperbody3.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {

	require 'templates/nav_hostel.php';
?>

	</div>
	<div class="content">

		<h3>REPORT</h3>
		<hr>
		<table class="table-hover tablereport" style="width:100%;float:left; border:1px solid #267871">
			<tr>
				<th style="background-color:#267871">HOSTEL</th>
			</tr>
			<tr>
				<td><a onClick="openCenteredWindow('rep1.php');">List of Student in Hostel</a></td>
			</tr>
			<tr>
				<td><a onClick="openCenteredWindow('rep2.php');">List of Unit Rented</a></td>
			</tr>
			<tr>
				<td><a onClick="openCenteredWindow('rep8.php');">List of Unit Owner </a></td>
			</tr>
			<tr>
				<td><a onClick="openCenteredWindow('rep9.php');">List of Unit Rental</a></td>
			</tr>

			<tr>
				<th style="background-color:#267871">STUDENT</th>
			</tr>
			<tr>
				<td><a onClick="openCenteredWindow('rep3.php');">Financial Statement</a></td>
			</tr>
			<tr>
				<td><a onClick="openCenteredWindow('rep4.php');">Check-in/Check-out Slip</a></td>
			</tr>

			<tr>
				<th style="background-color:#267871">FINANCIAL AND PAYMENT</th>
			</tr>
			<tr>
				<td><a onClick="openCenteredWindow('rep5.php');">Student Payment Record</a></td>
			</tr>
			<tr>
				<td><a onClick="openCenteredWindow('rep6.php');">College Payment Record</a></td>
			</tr>
			<tr>
				<td><a onClick="openCenteredWindow('rep7.php');">Hostel Profit and Loss</a></td>
			</tr>

			<tr>
				<th style="background-color:#267871">SUMMARY</th>
			</tr>
			<tr>
				<td style="border:1px solid #267871"><a onClick="openCenteredWindow('rep10.php');">Number of Students Staying in Hostel</a></td>
			</tr>

		</table>
		<br>

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