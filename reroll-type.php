<?php
	include('functions.php');
	include('db-details.php');
	
	$connection = new Connection($u, $p, $db);
	$con = $connection->connect();

	$god = new God($con);

	$ret_god = $god->reroll_god_type($_POST['god_type']);

	echo json_encode($ret_god);