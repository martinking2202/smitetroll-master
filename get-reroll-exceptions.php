<?php
	include('functions.php');
	include('db-details.php');
	
	$exception_name = $_POST['exception_name'];
	$connection = new Connection($u, $p, $db);
	$con = $connection->connect();

	$exceptions = new item_god_Exception($con);
	$god_exceptions = $exceptions->get_exceptions(
		$exception_name
		//'neith'
	);

	echo json_encode($god_exceptions);