<?php
	include('functions.php');
	include('db-details.php');
	$connection = new Connection($u, $p, $db);
	$con = $connection->connect();

	$item = new Item($con);

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width" />
		<title></title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="js/js.js"></script>
	</head>
	<body>
		<header>
			
		</header>
		<div id="main">
			<div id="god">
				<?php
					if(isset($_POST['item_name']) && $_POST['item_name']){
						if(isset($_POST['item_type'])){
							echo $item->insert_item($_POST['item_name'], $_POST['item_type']);
						}
						else {
							echo $item->insert_item($_POST['item_name']);
						}
					}
				?>
				<form id="item_insert" method="post" action="">
					<input type="text" name="item_name"/>
					<select name="item_type">
						<option value=""></option>
						<option value="boots-physical">Physical Boots</option>
						<option value="boots-magical">Magical Boots</option>
						<option value="physical">Physical</option>
						<option value="magical">Magical</option>
						<option value="relic">Relic</option>
					</select>
					<input type="submit"/>
				</form>
			</div>
		</div>
	</body>
</html>