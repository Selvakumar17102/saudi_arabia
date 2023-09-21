<header class="ttr-header">
	<div class="ttr-header-wrapper">
		<!--sidebar menu toggler start -->
		<div class="ttr-toggle-sidebar ttr-material-button">
			<i class="ti-close ttr-close-icon"></i>
			<i class="ti-menu ttr-open-icon"></i>
		</div>
		<!--sidebar menu toggler end -->
		<!--logo start -->
		<div class="ttr-logo-box">
			<div>
				<a href="index.php" class="ttr-logo">
					<img class="ttr-logo-mobile" alt="" src="assets/images/logo.svg" width="30" height="30">
					<img class="ttr-logo-desktop" alt="" src="assets/images/logo.svg" width="160" height="27">
				</a>
			</div>
		</div>
		<!--logo end -->
		<div class="ttr-header-menu">
		<!-- header left menu start -->
		<ul class="ttr-header-navigation">
			<li>
				<a class="ttr-material-button ttr-submenu-toggle"><?php echo date('l j, F Y'); ?></a>
			</li>
		</ul>
			<!-- header left menu end -->
	</div>

		<div class="ttr-header-right ttr-with-seperator">
			<!-- header right menu start -->
			<p>Project Management System</p>
			<ul class="ttr-header-navigation">
				
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
			<!-- header right menu end -->
		</div>
		<!--header search panel start -->
		<div class="ttr-search-bar">
			<form class="ttr-search-form">
				<div class="ttr-search-input-wrapper">
					<input type="text" name="qq" placeholder="search something..." class="ttr-search-input">
					<button type="submit" name="search" class="ttr-search-submit"><i class="ti-arrow-right"></i></button>
				</div>
				<span class="ttr-search-close ttr-search-toggle">
					<i class="ti-close"></i>
				</span>
			</form>
		</div>
		<!--header search panel end -->
	</div>
</header>