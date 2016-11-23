<!DOCTYPE html>
<html lang="en">
<head>
	<title>Wonkasoft: Admin Panel</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/> 
	<meta charset="UTF-8">
	<meta name="description" content="Admin Panel for internal use only">
	<meta name="keywords" content="Admin Panel">
	<meta name="author" content="Wonkasoft">
	
	<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
	<script src="js/admin.js"></script>

	<link rel="stylesheet" type="text/css" href="css/admin.css">
</head>
<body>
	<div id="header">
		<div class="logo">
			<a href="#"><img src="img/wonkasoft-logo-wide.png" alt="logo"></a>
		</div>
		<div class="user-info">
			<img src="img/users.svg" class="user-info-icon"><strong>Admin</strong>
		</div>
	</div>

	<a href="#" class="mobile"><img src="img/menu.svg" class="menu-icons">MENU</a>

	<div id="container">	
		<div class="sidebar">
			<ul id="nav">
				<li><a href="#" class="selected"><img src="img/dashboard.svg" class="icons">Dashboard</a></li>
				<li><a href="#"><img src="img/users.svg" class="icons">Users</a></li>
				<li><a href="#"><img src="img/reports.svg" class="icons">Reports</a></li>
				<li><a href="#"><img src="img/database-configuration.svg" class="icons">Database Config</a></li>
				<li><a href="#"><img src="img/settings.svg" class="icons">Settings</a></li>
				<li><a href="#"><img src="img/support.svg" class="icons">Support</a></li>
			</ul>
		</div>
		
		<div class="content">
			<h1>Dashboard</h1>
			<p>This is your new Dashboard</p>

			<div class="box">
				<div class="box-title">
					Reports
				</div>
				<div class="box-panel">
					This is your reports

				</div>
			</div>

			<div class="box">
				<div class="box-title">
					Users
				</div>
				<div class="box-panel">
					User activities 


				</div>
			</div>

			<div class="box">
				<div class="box-title">
					Database Info
				</div>
				<div class="box-panel">
					Database activities

				</div>
			</div>

		<div class="box">
			<div class="box-title">
				Click Information
			</div>
			<div class="box-panel">
				Clicks
			</div>
		</div>

		<div class="box">
			<div class="box-title">
				Active plugin installs
			</div>
			<div class="box-panel">
				Server Information
			</div>
		</div>

	</div>
	<div id="footer">
		<a href="http://wonkasoft.com">Wonkasoft</a> &copy; 2016, All rights reserved.
	</div>


</body>
</html>