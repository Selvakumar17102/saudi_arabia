<?php
error_reporting(0);
include("inc/dbconn.php");
$user = $_SESSION["username"];
$control = $_SESSION["control"];


$sqlside = "SELECT * FROM login WHERE username='$user'";
$resultside = $conn->query($sqlside);
$rowside = $resultside->fetch_assoc();
$designation = $rowside['designation'];
?>
<div class="ttr-sidebar">
	<div class="ttr-sidebar-wrapper content-scroll">
		<div class="ttr-sidebar-logo">
			<div class="ttr-sidebar-toggle-button">
				<span style="color: #000;">Welcome </span><?php echo $_SESSION["username"]; ?> <i class="ti-arrow-left"></i>
			</div>
		</div>
		<nav class="ttr-sidebar-navi">
			<ul>
				<li>
					<a href="dashboard.php" class="ttr-material-button">
						<span class="ttr-icon"><img src="assets/images/icon/dashboard.png"></span>
						<span class="ttr-label">Dashboard</span>
						<span class="ttr-arrow-icon"><i class="fa fa-caret-right"></i></span>
					</a>
				</li>
				<?php
				if ($control == "1" || $control == "3") {
					if($designation != "2" && $designation != "4" && $designation != "5" ){
				?>
					<li>
						<a href="#" class="ttr-material-button">
							<span class="ttr-icon"><img src="assets/images/icon/enquiry.png"></span>
							<span class="ttr-label">Enquiry</span>
							<span class="ttr-arrow-icon"><i class="fa fa-caret-down"></i></span>
						</a>
						<ul>
							<?php
							if ($rowside["id"] != 2) {
							?>
								<li>
									<a href="new-enquiry.php" class="ttr-material-button"><span class="ttr-label">Add New Enquiry</span></a>
								</li>
							<?php
							}
							?>
							<li>
								<a href="all-enquiry-old.php" class="ttr-material-button"><span class="ttr-label">Enquiry Followup</span></a>
							</li>
							<li>
								<a href="entire-enquiry.php" class="ttr-material-button"><span class="ttr-label">All Enquiry</span></a>
							</li>
							<li>
								<a href="add-scope.php" class="ttr-material-button"><span class="ttr-label">Add Scope</span></a>
							</li>
							<li>
								<a href="set_vat.php" class="ttr-material-button"><span class="ttr-label">Set VAT</span></a>
							</li>
						</ul>
					<?php
					}
				}
					?>
					</li>
					<li>
						<?php
						if ($control != 2 && $control != 4 && $control != 5) {
							if($designation != "2" && $designation != "4" && $designation != "5" ){
						?>
							<a href="#" class="ttr-material-button">
								<span class="ttr-icon"><img src="assets/images/icon/client.png"></span>
								<span class="ttr-label">Proposal</span>
								<span class="ttr-arrow-icon"><i class="fa fa-caret-down"></i></span>
							</a>
							<ul>
								<?php
								if ($control == "1"  || $control == "3" || $control == "2") {
								?>
									<li>
										<a href="client.php" class="ttr-material-button"><span class="ttr-label">Proposal Followup</span></a>
									</li>
								<?php
								}
								?>
								<li>
									<a href="add-client.php" class="ttr-material-button"><span class="ttr-label">All Clients</span></a>
								</li>
								<li>
									<a href="deadline-report.php" class="ttr-material-button"><span class="ttr-label">Late Submitted Proposal Report</span></a>
								</li>
							</ul>
						<?php
							}
						}
						?>
					</li>
					<?php
						if($control == 2 || $control == 4 || $control == 5){
							?>
							<li>
								<a href="#" class="ttr-material-button">
									<span class="ttr-icon"><img src="assets/images/icon/client.png"></span>
									<span class="ttr-label">Proposal</span>
									<span class="ttr-arrow-icon"><i class="fa fa-caret-down"></i></span>
								</a>
								<ul>
									<li>
										<a href="all-client-reports.php" class="ttr-material-button"><span class="ttr-label">All Clients</span></a>
									</li>
								</ul>
							</li>
							<?php
						}
					?>

					<?php
					if ($control == "1" || $control == "2" || $control == "3" || $control == "4" || $control == "5") {
					?>
						<li>
							<a href="#" class="ttr-material-button">
								<span class="ttr-icon"><img src="assets/images/icon/projects.png"></span>
								<span class="ttr-label">Projects</span>
								<span class="ttr-arrow-icon"><i class="fa fa-caret-down"></i></span>
							</a>
							<ul>
								<li><a href="all-projects.php" class="ttr-material-button"><span class="ttr-label">View All Projects</span></a></li>
								<!-- <li><a href="add-dept.php" class="ttr-material-button"><span class="ttr-label">Department</span></a></li> -->
							</ul>
						</li>
					<?php
					}
					?>

<!-- invoice -->
					<?php
					if ($control == "1" || $control == "3") {
						if($designation != "2" && $designation != "4" && $designation != "5" ){
					?>
						<li>
							<a href="#" class="ttr-material-button">
								<span class="ttr-icon"><img src="assets/images/icon/invoice.png"></span>
								<span class="ttr-label">Invoice</span>
								<span class="ttr-arrow-icon"><i class="fa fa-caret-down"></i></span>
							</a>
							<ul>

								<li>
									<a href="invoice-projects.php?id=1" class="ttr-material-button"><span class="ttr-label">MileStone Invoice</span></a>
								</li>
								<li>
									<a href="invoice-projects.php?id=2" class="ttr-material-button"><span class="ttr-label">Monthly Invoice</span></a>
								</li>
								<li>
									<a href="invoice-projects.php?id=3" class="ttr-material-button"><span class="ttr-label">Prorata Invoice</span></a>
								</li>
								<li>
									<a href="tracker-projects.php" class="ttr-material-button"><span class="ttr-label">Invoice Tracking</span></a>
								</li>
							</ul>
						</li>
					<?php
						}
					}
					?>
<!-- invoice end  -->
					<?php
						if($designation != "2" & $designation != "4" & $designation != "5" ){
					?>
					<li>
						<a href="expence_dashboard.php" class="ttr-material-button">
							<span class="ttr-icon"><img src="assets/images/icon/charity.png"></span>
							<span class="ttr-label">Income & Expense</span>
							<!-- <span class="ttr-arrow-icon"><i class="fa fa-caret-down"></i></span> -->
						</a>
					</li>	
					<?php
						}
					?>
<!-- s0A -->
					<li>
						<a href="#" class="ttr-material-button">
							<span class="ttr-icon"><img src="assets/images/icon/account.png"></span>
							<span class="ttr-label">Statement Of Accounts</span>
							<span class="ttr-arrow-icon"><i class="fa fa-caret-down"></i></span>
						</a>
						<ul>
							<li>
								<a href="statement.php?id=1" class="ttr-material-button"><span class="ttr-label">Engineering</span></a>
							</li>
							<li>
								<a href="statement.php?id=2" class="ttr-material-button"><span class="ttr-label">Simulation & Analysis</span></a>
							</li>
							<li>
								<a href="statement.php?id=3" class="ttr-material-button"><span class="ttr-label">Sustainability</span></a>
							</li>
							<!-- <li>
								<a href="statement.php?id=4" class="ttr-material-button"><span class="ttr-label">Environmental</span></a>
							</li> -->
							<li>
								<a href="statement.php?id=5" class="ttr-material-button"><span class="ttr-label">Acoustics</span></a>
							</li>
							<li>
								<a href="statement.php?id=6" class="ttr-material-button"><span class="ttr-label">Laser Scanning</span></a>
							</li>
							<li>
								<a href="statement.php?id=7" class="ttr-material-button"><span class="ttr-label">Oil & Gas</span></a>
							</li>
							<li>
								<a href="all_client.php" class="ttr-material-button"><span class="ttr-label">All clients</span></a>
							</li>
						</ul>
					</li>
					<!-- sOA -->
					<!-- reports -->
					<li>
						<a href="#" class="ttr-material-button">
							<span class="ttr-icon"><img src="assets/images/icon/report.png"></span>
							<span class="ttr-label">Reports</span>
							<span class="ttr-arrow-icon"><i class="fa fa-caret-down"></i></span>
						</a>
						<ul>

							<?php
							if ($control == "1"  || $control == "3" || $control == "2" || $control == "5") {
							?>
								<li>
									<a href="enquiry-reports.php" class="ttr-material-button"><span class="ttr-label">Enquiry Report</span></a>
								</li>
							<?php
							}
							?>

							<?php
							if ($control == "1"  || $control == "3" || $control == "2" || $control == "5") {
							?>
								<li>
									<a href="followup-reports.php" class="ttr-material-button"><span class="ttr-label">Proposal Report</span></a>
								</li>
							<?php
							}
							?>

							<?php
							if ($control == "1" || $control == "2" || $control == "3") {
								if($designation != "4" & $designation != "5" ){
							?>
								<li>
									<a href="project-reports.php" class="ttr-material-button"><span class="ttr-label">Project Report</span></a>
								</li>
							<?php
								}
							}
							?>
								<li>
									<a href="vat-reports.php" class="ttr-material-button"><span class="ttr-label">VAT Report</span></a>
								</li>
								<?php
									if($designation != "4" & $designation != "5" ){
								?>
								<li>
									<a href="invoice-tracker.php" class="ttr-material-button"><span class="ttr-label">Invoice Tracker</span></a>
								</li>
								<?php
									}

									if($designation != "4" & $designation != "5" ){
								?>
								<li>
									<a href="po_tracker.php" class="ttr-material-button"><span class="ttr-label">PO Tracker</span></a>
								</li>
								<?php
									}
								?>
								<li>
									<a href="client-dept-outstanding.php" class="ttr-material-button"><span class="ttr-label">Payment Followup Tracker</span></a>
								</li>
								<li>
									<a href="payment_tracker.php" class="ttr-material-button"><span class="ttr-label">Payment Tracker</span></a>
								</li>
								<?php
									if($designation != "4" && $designation != "5" ){
								?>
								<li>
									<a href="consolidate.php" class="ttr-material-button"><span class="ttr-label">Consolidated Report</span></a>
								</li>
								<?php
									}
								?>
								<!-- <li>
									<a href="tds-reports.php" class="ttr-material-button"><span class="ttr-label">TDS Report</span></a>
								</li> -->
							<!-- already<li>
		                		<a href="invoice-reports.php" class="ttr-material-button"><span class="ttr-label">Invoice Report</span></a>
		                	</li> -->
							<!-- <li>
		                		<a href="pending.php" class="ttr-material-button"><span class="ttr-label">Project Alerts</span></a>
		                	</li> -->
							<!-- <li>
		                		<a href="invoice-due1.php" class="ttr-material-button"><span class="ttr-label">Invoice Due Reports</span></a>
		                	</li> already-->
							<?php
							if ($control == "1" || $control == "2" || $control == "3") {
							?>
								<!-- <li>
									<a href="invoice-tracker.php" class="ttr-material-button"><span class="ttr-label">Invoice Tracker</span></a>
								</li> -->
							<?php
							}
							?>
							<?php
							if ($control == "1" || $control == "2" || $control == "3") {
							?>
								<!-- <li>
									<a href="po_tracker.php" class="ttr-material-button"><span class="ttr-label">PO Tracker</span></a>
								</li> -->
							<?php
							}
							?>

							<?php
							if ($control == "1" || $control == "2" || $control == "3" || $control == "4" || $control == "5") {
							?>
								<!-- <li>
									<a href="client-dept-outstanding.php" class="ttr-material-button"><span class="ttr-label">Payment Followup Tracker</span></a>
								</li>
								<li>
									<a href="client-followup-traker.php" class="ttr-material-button"><span class="ttr-label">Client Followup Tracker</span></a>
								</li> -->
							<?php
							}
							?>

							<?php
							if ($control == "1" || $control == "2" || $control == "3") {
							?>
								<!-- <li>
									<a href="consolidate.php" class="ttr-material-button"><span class="ttr-label">Consolidated Report</span></a>
								</li> -->
							<?php
							}
							?>



						</ul>
					</li>
					<?php
					if ($control == "1" || $control == "3") {
					?>
						<li>
							<a href="#" class="ttr-material-button">
								<span class="ttr-icon"><img src="assets/images/icon/projects.png"></span>
								<span class="ttr-label">Controls</span>
								<span class="ttr-arrow-icon"><i class="fa fa-caret-down"></i></span>
							</a>
							<ul>
								<li><a href="newemployees.php" class="ttr-material-button"><span class="ttr-label">New Employees</span></a></li>
								<li><a href="all-Controls.php" class="ttr-material-button"><span class="ttr-label">All Employees</span></a></li>
							</ul>
						</li>
					<?php
					}
					?>
			</ul>
		</nav>
	</div>
</div>