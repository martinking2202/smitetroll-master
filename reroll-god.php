<?php
	include('functions.php');
	include('db-details.php');
	
	$connection = new Connection($u, $p, $db);
	$con = $connection->connect();

	$god = new God($con);

	$excluded_gods = array($_POST['god_id']);

	$ret_god = $god->get_random_god($excluded_gods, $_POST['god_type']);

	echo json_encode($ret_god);