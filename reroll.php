<?php
	include('functions.php');
	include('db-details.php');
	
	$connection = new Connection($u, $p, $db);
	$con = $connection->connect();

	$item = new Item($con);

	$excluded_items = array($_POST['item_id']);

	$ret_item = $item->get_random_item($excluded_items, $_POST['item_type']);

	echo json_encode($ret_item);