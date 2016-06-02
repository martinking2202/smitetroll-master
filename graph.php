<?php	
	include('functions.php');
	include('db-details.php');
	$connection = new Connection($u, $p, $db);
	$con = $connection->connect();

	$god = new God($con);
	$item = new Item($con);
	$relic = new Item($con);
	
	if(isset($_GET['type'])){
		$type = $_GET['type'];
	}
	else {
		$type = 'god';
	}

	$countFunction = $type.'_rerolls';

	$allCount = $$type->$countFunction('count');
	$allReroll = $$type->$countFunction('rerolls');

	$firstCount = reset($allCount);
	$firstReroll = reset($allReroll);

	if($firstCount['count'] > $firstReroll['rerolls']) {
		$maxAmount = $firstCount['count'];
	}
	else {
		$maxAmount = $firstReroll['rerolls'];
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width" />
		<title></title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="fonts/iconfont/arrows/styles.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="js/js.js"></script>
	</head>
	<body>
		<header>

		</header>
		<div id="graphContainer">
			<div id="navControls">
				<ul>
					<li>
						<span><a href="?type=god">Gods</a></span>
					</li>
					<li>
						<span><a href="?type=item">Items</a></span>
					</li>
					<li>
						<span><a href="?type=relic">Relics</a></span>
					</li>
				</ul>
			</div>
			<div id="graph">								
				<div id="graphData">
					<div id="highestAmount"><?php echo $maxAmount;?></div>
<?php
					foreach($allCount as $count=>$info){
?>
						<div class="count">
							<div class="bar roll" data-bar-value="<?php echo $info['count'];?>"></div>
							<div class="bar reroll" data-bar-value="<?php echo $info['rerolls'];?>"></div>
							<div class="info">
								<img src="<?php echo $info['image']; ?>"/>
								<div class="text">
									<h5><?php echo $count;?></h6>
									<h6>Count: <?php echo $info['count'];?></h6>
									<h6>Rerolls: <?php echo $info['rerolls'];?></h6>
								</div>
							</div>
							<img src="portrait-<?php echo $info['image']; ?>"/>
						</div>
<?php
					}
?>
				</div>
			</div>
			<canvas id="linegraph" class="hide"></canvas>
		</div>
	</body>
</html>