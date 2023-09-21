<?php
	include("inc/dbconn.php");

	$user = $_SESSION["username"];

	$sqlhead = "SELECT * FROM expence_main WHERE id='1'";
	$resulthead = $conn->query($sqlhead);
	$rowhead = $resulthead->fetch_assoc();
	
	$cash = $rowhead["balance"];

	$sqlhead1 = "SELECT * FROM expence_main WHERE id='2'";
	$resulthead1 = $conn->query($sqlhead1);
	$rowhead1 = $resulthead1->fetch_assoc();
	
	$bank1 = $rowhead1["balance"];

	$sqlhead2 = "SELECT * FROM expence_main WHERE id='3'";
	$resulthead2 = $conn->query($sqlhead2);
	$rowhead2 = $resulthead2->fetch_assoc();
	
	$bank2 = $rowhead2["balance"];

	$sqlhead3 = "SELECT * FROM expence_main WHERE id='4'";
	$resulthead3 = $conn->query($sqlhead3);
	$rowhead3 = $resulthead3->fetch_assoc();
	
	$bank3 = $rowhead3["balance"];
?>
<!-- header start -->
<header class="ttr-header">
	<div class="ttr-header-wrapper">
        <div class="ttr-toggle-sidebar ttr-material-button">
			<i class="ti-close ttr-close-icon"></i>
			<i class="ti-menu ttr-open-icon"></i>
		</div>
		<!--logo start -->
		<div class="ttr-logo-box">
			<div>
				<a href="dashboard.php" class="ttr-logo">
					<img class="ttr-logo-mobile" alt="" src="assets/images/logo.svg" width="160" height="27">
					<img class="ttr-logo-desktop" alt="" src="assets/images/logo.svg" width="160" height="27">
				</a>
			</div>
		</div>
			<!--logo end -->
		<div id="h1" class="ttr-header-menu">
			<!-- header left menu start -->
			<ul class="ttr-header-navigation">
				<li>
					<a href="expence_dashboard.php" class="ttr-material-button ttr-submenu-toggle">Dashboard</a>
				</li>
					<li>
					<a href="#" class="ttr-material-button ttr-submenu-toggle">Account <i class="fa fa-angle-down"></i></a>
					<div class="ttr-header-submenu">
						<ul>
							<li><a href="new-account.php">New Account</a></li>
							<li><a href="sub-account.php">New Sub Account</a></li>
							<!-- <li><a href="new-division.php">New Division</a></li> -->
							<li><a href="all-accounts.php">All Accounts</a></li>
							
						</ul>
					</div>
				</li>
				<li>
					<a href="#" class="ttr-material-button ttr-submenu-toggle">Day Book <i class="fa fa-angle-down"></i></a>
					<div class="ttr-header-submenu">
						<ul>
							<li><a href="income.php">Income</a></li>
							<li><a href="expence.php">Expense</a></li>
							<li><a href="transfer.php">Transfer</a></li>
							 <li><a href="inhouse.php">Inhouse</a></li>
							<!--<li><a href="transfer.php">Transfer</a></li>-->
							<!--<li><a href="credits.php">Credits</a></li> -->
						</ul>
					</div>
				</li>
				<li>
					<a href="#" class="ttr-material-button ttr-submenu-toggle">Reports <i class="fa fa-angle-down"></i></a>
					<div class="ttr-header-submenu">
						<ul>
							 <li><a href="inhouse-account.php">Inhouse Accounts</a></li>
							<li><a href="income-account.php">Income Accounts</a></li> 
							<li><a href="expence-account.php">Expense Accounts</a></li>
							<!-- <li><a href="division-report1.php">Division</a></li> -->
							<!-- <li><a href="transfer-report.php">Transfer</a></li>
							<li><a href="advance-cash.php">Advance Cash</a></li>-->
							<!-- <li><a href="credit-report.php">Credits Report</a></li>
							<li><a href="income-outstanding.php">Outstanding Report</a></li> -->
							<li><a href="expense1.php">Expense Report</a></li>
						</ul>
					</div>
				</li>
				
			</ul>
				<!-- header left menu end -->
		</div>
		<div id="h2" class="ttr-header-right ttr-with-seperator">
				<!-- header right menu start -->
			<ul class="ttr-header-navigation">
				<li>
					<a href="#" class="ttr-material-button ttr-search-toggle">Total: SAR <?php echo number_format($bank1+$bank2+$bank3+$cash,2) ?> <span style="font-size: 12px"></span></a>
				</li>
				<?php
					// if($user == "bazeeth@123")
					// {
						?>
							<li>
								<a href="#" class="ttr-material-button ttr-search-toggle">In Bank: SAR <?php echo number_format($bank1+$bank2+$bank3,2) ?> <span style="font-size: 12px"></span> <i class="fa fa-angle-down"></i></a>
								<div class="ttr-header-submenu">
									<ul>
										<li><a>In Alinma : SAR <?php echo number_format($bank1,2) ?> <span style="font-size: 12px"></span></a></li>
										<!-- <li><a>In QNB : SAR <?php echo number_format($bank2,2) ?> <span style="font-size: 12px"></span></a></li>
										<li><a>In DOHA : SAR <?php echo number_format($bank3,2) ?> <span style="font-size: 12px"></span></a></li> -->
									</ul>
								</div>
							</li>
						<?php
					//}
				?>
				<li>
					<a href="#" class="ttr-material-button">In Hand: SAR <?php echo number_format($cash,2) ?> <span style="font-size: 12px"></span></a>
				</li>
				<li>
					<a href="#" class="ttr-material-button ttr-submenu-toggle"><span class="ttr-user-avatar"><img alt="" src="assets/images/user.png" width="32" height="32"></span></a>
					<div class="ttr-header-submenu">
						<ul>
							<li><a href="change-password.php">Change Password</a></li>
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
	</div>
</header>
