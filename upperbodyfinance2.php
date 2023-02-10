<?php
require 'database/credentials.php';
require 'templates/user_login.php';

if ($online) {
	require 'templates/header.php';

?>

	<div class="nav">
		<div class="container">

			<ul class="pull-right">
				<li><a style="text-decoration:none;"><i class="fa fa-calendar"></i><?php echo date('l') . ',  ' . date('d-m-Y'); ?></a></li>
			</ul>
		</div>
	</div>


	<!-- Page Content -->
	<div class="wrap">

		<div id="sideleft">

		<?php

	} ?>