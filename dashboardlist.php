<?php
require 'upperbody2.php';
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {
	$type = "";
	if (!empty($_GET['type'])) {
		$type = $_GET['type'];
	}
	$i = 0;
	$matric = "";
	$mon = date("m");
	$yer = date('Y');
	$qpaid = '';
?><br>
	<div class="content2">

		<?php

		//occupant list for the month	
		if ($type == 'occmon') { ?>
			<h3>List of Occupants <?php echo date('F Y'); ?></h3>
			<hr>

			<?php

			$qpaid = "SELECT * FROM pay_details JOIN student_list ON pay_details.payer_id=student_list.matric 
					WHERE month(date_issued)='$mon' AND year(date_issued)='$yer' ORDER BY pay_details.hos_name, pay_details.unit_no";

			$rqp = mysqli_query($link, $qpaid);


			?>
			<div id="reportexcel">
				<table style="border:1px solid black;" id="report">

					<tr>
						<th>No.</th>
						<th>Hostel Name</th>
						<th>Unit No</th>
						<th>Name</th>
						<th>Matric</th>

					</tr>

					<?php
					while ($row = mysqli_fetch_assoc($rqp)) {
						$i++;

					?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $row['hos_name']; ?></td>
							<td><?php echo $row['unit_no']; ?></td>
							<td><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></td>
							<td><?php echo $row['payer_id']; ?></td>
						</tr>
					<?php
					}

					// UNPAID BY MONTH
				} else if ($type == 'upaid') { ?>

					<h3>List of Unpaid Records <?php echo date('F Y'); ?></h3>
					<hr><?php
							$qpaid = "SELECT * FROM pay_details JOIN student_list ON pay_details.payer_id=student_list.matric 
						  WHERE month(date_issued)='$mon' AND year(date_issued)='$yer'
						  AND pay_details.status='INVOICED'";

							$rqp = mysqli_query($link, $qpaid);

							?>
					<div id="reportexcel">
						<table style="border:1px solid black;" id="report">

							<tr>
								<th>No.</th>
								<th>Name</th>
								<th>Matric</th>
								<th>Hostel Name</th>
								<th>Unit No</th>
								<th>Amount</th>
								<th>Date Issued</th>
							</tr>

							<?php
							while ($row = mysqli_fetch_assoc($rqp)) {
								$i++;

							?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></td>
									<td><?php echo $row['payer_id']; ?></td>
									<td><?php echo $row['hos_name']; ?></td>
									<td><?php echo $row['unit_no']; ?></td>
									<td><?php echo 'RM ' . $row['amount']; ?></td>
									<td><?php echo $row['date_issued']; ?></td>
								</tr>
							<?PHP
							}
						}

						//UNPAID ALL
						else if ($type == 'upaidall') { ?>

							<h3>List of Unpaid Records Overall</h3>
							<hr><?php
									$qpaid = "SELECT * FROM pay_details JOIN student_list ON pay_details.payer_id=student_list.matric 
						WHERE pay_details.status='INVOICED'";

									$rqp = mysqli_query($link, $qpaid);

									?>
							<div id="reportexcel">
								<table style="border:1px solid black;" id="report">

									<tr>
										<th>No.</th>
										<th>Name</th>
										<th>Matric</th>
										<th>Hostel Name</th>
										<th>Unit No</th>
										<th>Amount</th>
										<th>Date Issued</th>
									</tr>

									<?php
									while ($row = mysqli_fetch_assoc($rqp)) {
										$i++;

									?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></td>
											<td><?php echo $row['payer_id']; ?></td>
											<td><?php echo $row['hos_name']; ?></td>
											<td><?php echo $row['unit_no']; ?></td>
											<td><?php echo 'RM ' . $row['amount']; ?></td>
											<td><?php echo $row['date_issued']; ?></td>
										</tr>
									<?PHP
									}
								}

								//PAID BY MONTH
								else if ($type == 'paid') { ?>

									<h3>List of Paid Records <?php echo date('F Y'); ?></h3>
									<hr><?php
											$qpaid = "SELECT *, pay_details.status as stat FROM pay_details JOIN student_list ON pay_details.payer_id=student_list.matric 
											WHERE month(date_issued)='$mon' AND year(date_issued)='$yer'
											AND pay_details.status='PAID'";

											$rqp = mysqli_query($link, $qpaid);

											?>
									<div id="reportexcel">
										<table style="border:1px solid black;" id="report">

											<tr>
												<th>No.</th>
												<th>Name</th>
												<th>Matric</th>
												<th>Hostel Name</th>
												<th>Unit No</th>
												<th>Amount</th>
												<th>Status</th>
												<th>Reference No.</th>
												<th>Date Issued</th>
											</tr>

											<?php
											while ($row = mysqli_fetch_assoc($rqp)) {
												$i++;

											?>
												<tr>
													<td><?php echo $i; ?></td>
													<td><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></td>
													<td><?php echo $row['payer_id']; ?></td>
													<td><?php echo $row['hos_name']; ?></td>
													<td><?php echo $row['unit_no']; ?></td>
													<td><?php echo 'RM ' . $row['amount']; ?></td>
													<td><?php echo $row['stat']; ?></td>
													<td><?php echo $row['pay_voucher']; ?></td>
													<td><?php echo $row['date_issued']; ?></td>
												</tr>
											<?PHP
											}
										}

										//PAID ALL
										else { ?>

											<h3>List of Paid Records Overall </h3>
											<hr><?php
													$qpaid = "SELECT *, pay_details.status as stat FROM pay_details JOIN student_list ON pay_details.payer_id=student_list.matric 
													WHERE pay_details.status='PAID'";

													$rqp = mysqli_query($link, $qpaid);

													?>
											<div id="reportexcel">
												<table style="border:1px solid black;" id="report">

													<tr>
														<th>No.</th>
														<th>Name</th>
														<th>Matric</th>
														<th>Hostel Name</th>
														<th>Unit No</th>
														<th>Amount</th>
														<th>Status</th>
														<th>Reference No.</th>
														<th>Date Issued</th>
													</tr>

													<?php
													while ($row = mysqli_fetch_assoc($rqp)) {
														$i++;

													?>
														<tr>
															<td><?php echo $i; ?></td>
															<td><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></td>
															<td><?php echo $row['payer_id']; ?></td>
															<td><?php echo $row['hos_name']; ?></td>
															<td><?php echo $row['unit_no']; ?></td>
															<td><?php echo 'RM ' . $row['amount']; ?></td>
															<td><?php echo $row['stat']; ?></td>
															<td><?php echo $row['pay_voucher']; ?></td>
															<td><?php echo $row['date_issued']; ?></td>
														</tr>
												<?PHP
													}
												} ?>

												</table>
											</div>
											<br>
											<div id="buttonspace">
												<input id="printbut" type="button" value="Print" class="btn btn-primary" onClick="window.print();" />
												<input type="button" id="btnExport" value="Excel" class="btn btn-primary" />
												<input name="ok" type="button" value="Close" class="btn btn-primary" onClick="window.close();" style="float:right;margin-left:5px;" />
											</div>
											<br><br>
									</div>

							</div>
						<?php
						require 'lowerbody.php';
					} else {
						require 'warninglogin.php';
					} ?>