<?php
	include('functions.php');
	include('db-details.php');
	$connection = new Connection($u, $p, $db);
	$con = $connection->connect();

	$ping = $connection->ping($con, $_SERVER['REMOTE_ADDR']);

	$god = new God($con);
	$rand_god = $god->get_random_god();
	$item = new Item($con);

	$excluded_items = array();
	$excluded_relics = array();

	$initial_items = $item->initial_get_items($rand_god['type']);

	$exceptions = new item_god_Exception($con);
	$god_exceptions = $exceptions->get_exceptions($rand_god['name']);
/*
		echo serialize(array(
			'css_file' => array(
				'placement' => 'head',
				'url' => 'exceptions/css/neith.css'
			)
		));
*/		
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
<?php
		foreach($god_exceptions as $god_exception){
			$type = $god_exception['type'];
			$placement = $god_exception['placement'];
			$url = $god_exception['url'];
			if(isset($god_exception['element'])) $element = $god_exception['element'];

			if($type === 'css_file' && $placement === 'head'){
				echo '<link rel="stylesheet" type="text/css" href="'.$url.'" />';
			}
			else if($type === 'js_file' && $placement === 'head'){
				echo '<script type="text/javascript" src="'.$url.'"></script>';
			}
		}
?>
	</head>
	<body>
		<header>
			
		</header>
		<div id="main">
			<div id="outer_exception">
<?php
				foreach($god_exceptions as $god_exception){
					$type = $god_exception['type'];
					$placement = $god_exception['placement'];
					$url = $god_exception['url'];
					if(isset($god_exception['element'])) $element = $god_exception['element'];
					if($type === 'element' && $placement === 'outer'){
						if($god_exception['element'] === 'audio'){
							echo '<audio autoplay><source src="'.$god_exception['src'].'.ogg" type="audio/ogg"><source src="'.$god_exception['src'].'.mp3" type="audio/mpeg"></audio>';
						} 
					}
				}
?>
			</div>
			<div id="god">
				<div id="inner_exception">
<?php
					foreach($god_exceptions as $god_exception){
						$type = $god_exception['type'];
						$placement = $god_exception['placement'];
						$url = $god_exception['url'];
						if(isset($god_exception['element'])) $element = $god_exception['element'];
						if($type === 'element' && $placement === 'inner'){
							if($god_exception['element'] === 'audio'){
								echo '<audio autoplay><source src="'.$god_exception['src'].'.ogg" type="audio/ogg"><source src="'.$god_exception['src'].'.mp3" type="audio/mpeg"></audio>';
							} 
						}
					}
?>
				</div>
				<div class="god">
					<div id="god_exception">
<?php
						foreach($god_exceptions as $god_exception){
							$type = $god_exception['type'];
							$placement = $god_exception['placement'];
							$url = $god_exception['url'];
							if(isset($god_exception['element'])) $element = $god_exception['element'];
							if($type === 'element' && $placement === 'god'){
								if($god_exception['element'] === 'audio'){
									echo '<audio autoplay><source src="'.$god_exception['src'].'.ogg" type="audio/ogg"><source src="'.$god_exception['src'].'.mp3" type="audio/mpeg"></audio>';
								} 
							}
						}
?>
					</div>
					<h1 class="god_name"><?php echo $rand_god['name']; ?></h1>
					<!--<img class="god_image" src="<?php echo $rand_god['image']; ?>"/>-->
					<input type="hidden" name="god_id" value="<?php echo $rand_god['id']; ?>"/>
					<input type="hidden" name="god_type" value="<?php echo $rand_god['type']; ?>"/>
					<div class="button god-reroll"><i class="icon-arrows-rotate"></i></div>
				</div>
				<div class="items">
					<div id="items_exception">
<?php
						foreach($god_exceptions as $god_exception){
							$type = $god_exception['type'];
							$placement = $god_exception['placement'];
							$url = $god_exception['url'];
							if(isset($god_exception['element'])) $element = $god_exception['element'];
							if($type === 'element' && $placement === 'items'){
								if($god_exception['element'] === 'audio'){
									echo '<audio autoplay><source src="'.$god_exception['src'].'.ogg" type="audio/ogg"><source src="'.$god_exception['src'].'.mp3" type="audio/mpeg"></audio>';
								}
	 						}
						}
?>
					</div>
					<div class="item">
						<h2 class="item_name"><?php echo $initial_items['boots']['name']; ?></h2>
						<!--<img class="item_image" src="<?php echo $initial_items['boots']['image']; ?>"/>-->
						<input type="hidden" name="item_id" value="<?php echo $initial_items['boots']['id']; ?>"/>
						<input type="hidden" name="item_type" value="<?php echo 'boots-'.$rand_god['type']; ?>"/>
						<div class="button reroll"><i class="icon-arrows-rotate"></i></div>
					</div>
					<div class="item">
						<h2 class="item_name"><?php echo $initial_items['item2']['name']; ?></h2>
						<!--<img class="item_image" src="<?php echo $initial_items['item2']['image']; ?>"/>-->
						<input type="hidden" name="item_id" value="<?php echo $initial_items['item2']['id']; ?>"/>
						<input type="hidden" name="item_type" value="<?php echo $rand_god['type']; ?>"/>
						<div class="button reroll"><i class="icon-arrows-rotate"></i></div>
					</div>
					<div class="item">
						<h2 class="item_name"><?php echo $initial_items['item3']['name']; ?></h2>
						<!--<img class="item_image" src="<?php echo $initial_items['item3']['image']; ?>"/>-->
						<input type="hidden" name="item_id" value="<?php echo $initial_items['item3']['id']; ?>"/>
						<input type="hidden" name="item_type" value="<?php echo $rand_god['type']; ?>"/>
						<div class="button reroll"><i class="icon-arrows-rotate"></i></div>
					</div>
					<div class="item">
						<h2 class="item_name"><?php echo $initial_items['item4']['name']; ?></h2>
						<!--<img class="item_image" src="<?php echo $initial_items['item4']['image']; ?>"/>-->
						<input type="hidden" name="item_id" value="<?php echo $initial_items['item4']['id']; ?>"/>
						<input type="hidden" name="item_type" value="<?php echo $rand_god['type']; ?>"/>
						<div class="button reroll"><i class="icon-arrows-rotate"></i></div>
					</div>
					<div class="item">
						<h2 class="item_name"><?php echo $initial_items['item5']['name']; ?></h2>
						<!--<img class="item_image" src="<?php echo $initial_items['item5']['image']; ?>"/>-->
						<input type="hidden" name="item_id" value="<?php echo $initial_items['item5']['id']; ?>"/>
						<input type="hidden" name="item_type" value="<?php echo $rand_god['type']; ?>"/>
						<div class="button reroll"><i class="icon-arrows-rotate"></i></div>
					</div>
					<div class="item">
						<h2 class="item_name"><?php echo $initial_items['item6']['name']; ?></h2>
						<!--<img class="item_image" src="<?php echo $initial_items['item6']['image']; ?>"/>-->
						<input type="hidden" name="item_id" value="<?php echo $initial_items['item6']['id']; ?>"/>
						<input type="hidden" name="item_type" value="<?php echo $rand_god['type']; ?>"/>
						<div class="button reroll"><i class="icon-arrows-rotate"></i></div>
					</div>
				</div>
				<div class="relics">
					<div id="relics_exception">
<?php
						foreach($god_exceptions as $god_exception){
							$type = $god_exception['type'];
							$placement = $god_exception['placement'];
							$url = $god_exception['url'];
							if(isset($god_exception['element'])) $element = $god_exception['element'];
							if($type === 'element' && $placement === 'relics'){
								if($god_exception['element'] === 'audio'){
									echo '<audio autoplay><source src="'.$god_exception['src'].'.ogg" type="audio/ogg"><source src="'.$god_exception['src'].'.mp3" type="audio/mpeg"></audio>';
								}
							}
						}
?>
					</div>
					<div class="item relic">
						<h2 class="item_name"><?php echo $initial_items['relic1']['name']; ?></h2>
						<!--<img class="relic_image" src="<?php echo $initial_items['relic1']['image']; ?>"/>-->
						<input type="hidden" name="item_id" value="<?php echo $initial_items['relic1']['id']; ?>"/>
						<input type="hidden" name="item_type" value="relic"/>
						<div class="button reroll"><i class="icon-arrows-rotate"></i></div>
					</div>
					<div class="item relic">
						<h2 class="item_name"><?php echo $initial_items['relic2']['name']; ?></h2>
						<!--<img class="relic_image" src="<?php echo $initial_items['relic2']['image']; ?>"/>-->
						<input type="hidden" name="item_id" value="<?php echo $initial_items['relic2']['id']; ?>"/>
						<input type="hidden" name="item_type" value="relic"/>
						<div class="button reroll"><i class="icon-arrows-rotate"></i></div>
					</div>
				</div>

				<div id="empty-space">
					<div id="count">3</div>
					<div id="reroll-all">
						Reroll God Type
					</div>
				</div>
			</div>
		</div>
		<footer>

		</footer>
	</body>
</html>