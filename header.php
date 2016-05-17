<?php
	include('../functions.php');
	include('../db-details.php');
	$connection = new Connection($u, $p, $db);
	$con = $connection->connect();	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width" />
		<title></title>
		<link rel="stylesheet" type="text/css" href="../css/style.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="../js/js.js"></script>
	</head>
	<body>
		<header>
			<nav id="account_menu">
				<ul>
<?php
					if(!isset($_SESSION['user_id'])){
?>
						<li>
							<a href="register.php"a>Register</a>
						</li>
<?php
					}
?>
					<li>
<?php
						if(isset($_SESSION['user_id'])){
							echo 'User ID: '.$_SESSION['user_id'].' <a href="logout.php">Logout</a>';
						}
						else {
?>
							<a href="login.php">Login</a>
<?php
						}
?>
					</li>
					<li>
<?php
						if(isset($_SESSION['customer_id'])){
							echo 'Customer ID: '.$_SESSION['customer_id'].' <a href="customers.php">Choose Customer</a>';
						}
						else {
?>
							<a href="customers.php">Choose Customer</a>
<?php
						}
?>
					</li>
				</ul>
			</nav>
			<nav id="main_menu">
				<ul>
<?php
					if(isset($_SESSION['customer_id'])){
?>
						<li>
							<a href="events.php">Events</a>
						</li>
<?php
					}
?>
				</ul>
			</nav>
		</header>