<?php
	include("inc/dbconn.php");
	$user=$_SESSION["username"];

	$sqlside = "SELECT * FROM login WHERE username='$user'";
	$resultside = $conn->query($sqlside);
	$rowside = $resultside->fetch_assoc();
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
					<li>
						<a href="#" class="ttr-material-button">
							<span class="ttr-icon"><img src="assets/images/icon/enquiry.png"></span>
		                	<span class="ttr-label">Enquiry</span>
		                	<span class="ttr-arrow-icon"><i class="fa fa-caret-down"></i></span>
		                </a>
		                <ul>
							<?php
								if($rowside["id"] != 2)
								{
							?>
								<li>
									<a href="new-enquiry.php" class="ttr-material-button"><span class="ttr-label">Add New Enquiry</span></a>
								</li>
							<?php
								}
							?>
		                	<li>
		                		<a href="all-enquiry.php" class="ttr-material-button"><span class="ttr-label">Enquiry Followup</span></a>
		                	</li>
							<li>
		                		<a href="entire-enquiry.php" class="ttr-material-button"><span class="ttr-label">All Enquiry</span></a>
		                	</li>
		                </ul>
		            </li>
					<li>
						<a href="#" class="ttr-material-button">
							<span class="ttr-icon"><img src="assets/images/icon/client.png"></span>
		                	<span class="ttr-label">Proposal</span>
		                	<span class="ttr-arrow-icon"><i class="fa fa-caret-down"></i></span>
		                </a>
		                <ul>
		                	<li>
		                		<a href="client.php" class="ttr-material-button"><span class="ttr-label">Proposal Followup</span></a>
		                	</li>
							<li>
		                		<a href="all-clients.php" class="ttr-material-button"><span class="ttr-label">All Clients</span></a>
		                	</li>
		                </ul>
		            </li>
                    <li>
						<a href="#" class="ttr-material-button">
							<span class="ttr-icon"><img src="assets/images/icon/projects.png"></span>
		                	<span class="ttr-label">Projects</span>
		                	<span class="ttr-arrow-icon"><i class="fa fa-caret-down"></i></span>
		                </a>
		                <ul>
							<li><a href="all-projects.php" class="ttr-material-button"><span class="ttr-label">View All Projects</span></a></li>
							<li><a href="add-dept.php" class="ttr-material-button"><span class="ttr-label">Department</span></a></li>
		                </ul>
		            </li>
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
		                </ul>
		            </li>
					<li>
						<a href="#" class="ttr-material-button">
							<span class="ttr-icon"><img src="assets/images/icon/account.png"></span>
		                	<span class="ttr-label">Statement Of Accounts</span>
		                	<span class="ttr-arrow-icon"><i class="fa fa-caret-down"></i></span>
		                </a>
		                <ul>
							<li>
		                		<a href="statement.php?id=1" class="ttr-material-button"><span class="ttr-label">Sustainability</span></a>
		                	</li>
							<li>
		                		<a href="statement.php?id=2" class="ttr-material-button"><span class="ttr-label">Engineering Services</span></a>
		                	</li>
							<li>
		                		<a href="statement.php?id=3" class="ttr-material-button"><span class="ttr-label">Simulation & analysis Services</span></a>
		                	</li>
							<li>
		                		<a href="statement.php?id=4" class="ttr-material-button"><span class="ttr-label">Deputation</span></a>
		                	</li>
		                </ul>
		            </li>
					<li>
						<a href="#" class="ttr-material-button">
							<span class="ttr-icon"><img src="assets/images/icon/report.png"></span>
		                	<span class="ttr-label">Reports</span>
		                	<span class="ttr-arrow-icon"><i class="fa fa-caret-down"></i></span>
		                </a>
		                <ul>
							<li>
		                		<a href="enquiry-reports.php" class="ttr-material-button"><span class="ttr-label">Enquiry Report</span></a>
		                	</li>
							<li>
		                		<a href="followup-reports.php" class="ttr-material-button"><span class="ttr-label">Followup Report</span></a>
		                	</li>
							<li>
		                		<a href="project-reports.php" class="ttr-material-button"><span class="ttr-label">Project Report</span></a>
		                	</li>
							<li>
		                		<a href="invoice-reports.php" class="ttr-material-button"><span class="ttr-label">Invoice Report</span></a>
		                	</li>
							<li>
		                		<a href="pending.php" class="ttr-material-button"><span class="ttr-label">Project Alerts</span></a>
		                	</li>
							<li>
		                		<a href="invoice-due1.php" class="ttr-material-button"><span class="ttr-label">Invoice Due Reports</span></a>
		                	</li>
							<li>
		                		<a href="invoice-tracker.php" class="ttr-material-button"><span class="ttr-label">Invoice Tracker</span></a>
		                	</li>
							<li>
		                		<a href="client-dept-outstanding.php" class="ttr-material-button"><span class="ttr-label">Client Outstanding Reports</span></a>
		                	</li>
							<li>
		                		<a href="consolidate-report.php" class="ttr-material-button"><span class="ttr-label">Consolidate Report</span></a>
		                	</li>
		                </ul>
		            </li>
				</ul>
			</nav>
		</div>
	</div>