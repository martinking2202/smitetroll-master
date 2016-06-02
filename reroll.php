<?php
	include('functions.php');
	include('db-details.php');
	
	$connection = new Connection($u, $p, $db);
	$con = $connection->connect();
	$excluded_items = array();
	
	$item = new Item($con);
	$excl_items_json = json_decode($_POST['item_exclusions']);
	foreach($excl_items_json as $excl_item){
		array_push($excluded_items, $excl_item);
	}

	$ret_item = $item->get_random_item($excluded_items, $_POST['item_type']);

	$rerolled = $item->reroll_log($_POST['rerolled']);
	echo json_encode($ret_item);