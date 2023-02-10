<?php
require 'database/credentials.php';
require 'templates/user_login.php';

if ($online) {
	require 'templates/header.php';
?>


	<div class="nav small-header">
		<div class="container">

			<ul class="pull-right">
				<li><a style="text-decoration:none;"><i class="fa fa-calendar"></i><?php echo date('l') . ',  ' . date('d-m-Y'); ?></a></li>

				<li><a><i class="fa fa-calendar-check-o"></i>
						MONTH:</a>
					<select id="filterbymonth" onchange="addMonthParam();">

						<?php
						$query = "SELECT DISTINCT(month) FROM sem_duration ORDER BY month";
						$record = mysqli_query($link, $query); ?>
						<option value="all" selected>All</option> <?php
																											while ($row = mysqli_fetch_assoc($record)) {
																												if ($month == "all" || $month == "") { ?>

								<option value="<?php echo $row['month'] ?>"><?php echo date('F', mktime(0, 0, 0, $row['month'], 10)); ?></option><?php
																																																															} else {
																																																																if ($row['month'] == $month) { ?>
									<option value="<?php echo $row['month'] ?>" selected><?php echo date('F', mktime(0, 0, 0, $row['month'], 10)); ?></option>
								<?php } else { ?>
									<option value="<?php echo $row['month'] ?>"><?php echo date('F', mktime(0, 0, 0, $row['month'], 10)); ?></option><?php
																																																																}
																																																															}
																																																														} ?>

					</select>&nbsp;&nbsp;
				</li>

				<li><a style="text-decoration:none;">
						YEAR:</a>


					<select id="filterbyyear" onchange="addYearParam();">


						<?php
						$query = "SELECT DISTINCT(year) FROM sem_duration";
						$record = mysqli_query($link, $query);

						?><option value="all" selected>All</option> <?php
																									while ($row = mysqli_fetch_assoc($record)) {
																										if ($year == "all" || $year == "") { ?>

								<option value="<?php echo $row['year'] ?>"><?php echo $row['year']; ?></option><?php
																																														} else {
																																															if ($row['year'] == $year) { ?>
									<option value="<?php echo $row['year'] ?>" selected><?php echo $row['year']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $row['year'] ?>"><?php echo $row['year']; ?></option><?php
																																															}
																																														}
																																													} ?>

					</select>&nbsp;&nbsp;


				</li>

			</ul>
		</div>
	</div>


	<!-- Page Content -->
	<div class="wrap">
		<div id="sideleft">
		<?php
	}
		?>