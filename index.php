<?php
	include('functions.php');
	include('db-details.php');
	$connection = new Connection($u, $p, $db);
	$con = $connection->connect();

	$god = new God($con);
	$rand_god = $god->get_random_god();
	$item = new Item($con);

	$excluded_items = array();
	$excluded_relics = array();
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
				<h1 class="god_name"><?php echo $rand_god['name']; ?></h1>
				<input type="hidden" name="god_id" value="<?php echo $rand_god['id']; ?>"/>
				<input type="hidden" name="god_type" value="<?php echo $rand_god['type']; ?>"/>
				<div class="button god-reroll">Re-roll</div>

				<div class="items">
					<div class="item">
<?php
						$item1 = $item->get_random_item('', 'boots-'.$rand_god['type']);
?>
						<h2 class="item_name"><?php echo $item1['name']; ?></h2>
						<input type="hidden" name="item_id" value="<?php echo $item1['id']; ?>"/>
						<input type="hidden" name="item_type" value="<?php echo 'boots-'.$rand_god['type']; ?>"/>
						<div class="button reroll">Re-roll</div>
<?php
						$excluded_items[] = $item1['id'];
?>
					</div>
					<div class="item">
<?php
						$item2 = $item->get_random_item($excluded_items, $rand_god['type']);
?>
						<h2 class="item_name"><?php echo $item2['name']; ?></h2>
						<input type="hidden" name="item_id" value="<?php echo $item2['id']; ?>"/>
						<input type="hidden" name="item_type" value="<?php echo $rand_god['type']; ?>"/>
						<div class="button reroll">Re-roll</div>
<?php						
						$excluded_items[] = $item2['id'];
?>
					</div>
					<div class="item">
<?php
						$item3 = $item->get_random_item($excluded_items, $rand_god['type']);
?>
						<h2 class="item_name"><?php echo $item3['name']; ?></h2>
						<input type="hidden" name="item_id" value="<?php echo $item3['id']; ?>"/>
						<input type="hidden" name="item_type" value="<?php echo $rand_god['type']; ?>"/>
						<div class="button reroll">Re-roll</div>
<?php	
						$excluded_items[] = $item3['id'];
?>
					</div>
					<div class="item">
<?php
						$item4 = $item->get_random_item($excluded_items, $rand_god['type']);
?>
						<h2 class="item_name"><?php echo $item4['name']; ?></h2>
						<input type="hidden" name="item_id" value="<?php echo $item4['id']; ?>"/>
						<input type="hidden" name="item_type" value="<?php echo $rand_god['type']; ?>"/>
						<div class="button reroll">Re-roll</div>
<?php	
						$excluded_items[] = $item4['id'];
?>
					</div>
					<div class="item">
<?php
						$item5 = $item->get_random_item($excluded_items, $rand_god['type']);
?>
						<h2 class="item_name"><?php echo $item5['name']; ?></h2>
						<input type="hidden" name="item_id" value="<?php echo $item5['id']; ?>"/>
						<input type="hidden" name="item_type" value="<?php echo $rand_god['type']; ?>"/>
						<div class="button reroll">Re-roll</div>
<?php	
						$excluded_items[] = $item5['id'];
?>
					</div>
					<div class="item">
<?php
						$item6 = $item->get_random_item($excluded_items, $rand_god['type']);
?>
						<h2 class="item_name"><?php echo $item6['name']; ?></h2>
						<input type="hidden" name="item_id" value="<?php echo $item6['id']; ?>"/>
						<input type="hidden" name="item_type" value="<?php echo $rand_god['type']; ?>"/>
						<div class="button reroll">Re-roll</div>
<?php	
						$excluded_items[] = $item6['id'];
?>
					</div>
				</div>
				<div class="relics">
					<div class="item relic">
<?php
						$relic1 = $item->get_random_item('', 'relic');
?>
						<h2 class="item_name"><?php echo $relic1['name']; ?></h2>
						<input type="hidden" name="item_id" value="<?php echo $relic1['id']; ?>"/>
						<input type="hidden" name="item_type" value="relic"/>
						<div class="button reroll">Re-roll</div>
<?php	
						$excluded_relics[] = $relic1['id'];
?>
					</div>
					<div class="item relic">
<?php
						$relic2 = $item->get_random_item($excluded_relics, 'relic');
?>
						<h2 class="item_name"><?php echo $relic2['name']; ?></h2>
						<input type="hidden" name="item_id" value="<?php echo $relic2['id']; ?>"/>
						<input type="hidden" name="item_type" value="relic"/>
						<div class="button reroll">Re-roll</div>
<?php	
						$excluded_relics[] = $relic2['id'];
?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>