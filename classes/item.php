<?php
	class Item {
        // Creating some properties (variables tied to an object)
        
        public $connection;
        
        // Assigning the values
        public function __construct($connection) {
	          $this->connection = $connection;
        }
        
        public function initial_get_items($item_type = '') {
            $bootsSQL = "SELECT * FROM items WHERE item_type = 'boots-$item_type' ORDER BY RAND() LIMIT 1";
            $itemsSQL = "SELECT * FROM items WHERE item_type = '$item_type' OR item_type = '' ORDER BY RAND() LIMIT 5";             
            $relicsSQL = "SELECT * FROM items WHERE item_type = 'relic' ORDER BY RAND() LIMIT 2";   

            $get_boots = mysqli_query($this->connection, $bootsSQL);
            $bootsRow = mysqli_fetch_assoc($get_boots);

            
            if($bootsRow['item_image']) {
                $item_image = $bootsRow['item_image'];
            }
            else {
                $item_image = 'images/hi.jpg';
            }
            
            $item_info = array(
                'boots' => array(
                    'id' => $bootsRow['item_id'],
                    'name' => $bootsRow['item_name'],
                    'image' => $item_image
                )
            );

            $retItem = $bootsRow['item_name'];
            $itemCount = mysqli_query($this->connection, "SELECT * FROM counts WHERE count_name = '$retItem'");
            
            $row = mysqli_fetch_assoc($itemCount);
            if($row['count']) {
                $count = intval($row['count']) + 1;

                mysqli_query($this->connection, "UPDATE counts SET
                    count = $count
                    WHERE count_name = '$retItem'
                ");
            }
            else {
                $addPing = mysqli_query(
                    $this->connection,"INSERT INTO counts (
                        count_id,
                        count_name,
                        count_type,
                        count,
                        rerolls
                    )
                    VALUES (
                        NULL,
                        '$retItem',
                        'item',
                        1,
                        0
                    )"
                );
            }

            $get_items = mysqli_query($this->connection, $itemsSQL);

            $i = 2;
            while ($itemRow = $get_items->fetch_assoc()) {
                if($itemRow['item_image']) {
                    $item_image = $itemRow['item_image'];
                }
                else {
                    $item_image = 'images/hi.jpg';
                }
                
                $item_info['item'.$i] = array(
                    'id' => $itemRow['item_id'],
                    'name' => $itemRow['item_name'],
                    'image' => $item_image
                );

                $retItem = $itemRow['item_name'];
                $itemCount = mysqli_query($this->connection, "SELECT * FROM counts WHERE count_name = '".$retItem."'");
                if(isset($itemCount->num_rows) && $itemCount->num_rows || $itemCount){
                    $row = mysqli_fetch_assoc($itemCount);
                    if($row['count']) {
                        $count = intval($row['count']) + 1;

                        mysqli_query($this->connection, "UPDATE counts SET
                            count = $count
                            WHERE count_name = '$retItem'
                        ");
                    }
                }
                else {
                    $addPing = mysqli_query(
                        $this->connection,"INSERT INTO counts (
                            count_id,
                            count_name,
                            count_type,
                            count,
                            rerolls
                        )
                        VALUES (
                            NULL,
                            '$retItem',
                            'item',
                            1,
                            0
                        )"
                    );

                }
                
                $i++;
            }

            $get_relics = mysqli_query($this->connection, $relicsSQL);

            $r = 1;
            while ($relicRow = $get_relics->fetch_assoc()) {
                if($relicRow['item_image']) {
                    $item_image = $relicRow['item_image'];
                }
                else {
                    $item_image = 'images/hi.jpg';
                }
                $item_info['relic'.$r] = array(
                    'id' => $relicRow['item_id'],
                    'name' => $relicRow['item_name'],
                    'image' => $item_image
                );

                $retItem = $relicRow['item_name'];
                $itemCount = mysqli_query($this->connection, "SELECT * FROM counts WHERE count_name = '$retItem'");
                
                $row = mysqli_fetch_assoc($itemCount);
                if($row['count']) {
                    $count = intval($row['count']) + 1;

                    mysqli_query($this->connection, "UPDATE counts SET
                        count = $count
                        WHERE count_name = '$retItem'
                    ");
                }
                else {
                    $addPing = mysqli_query(
                        $this->connection,"INSERT INTO counts (
                            count_id,
                            count_name,
                            count_type,
                            count,
                            rerolls
                        )
                        VALUES (
                            NULL,
                            '$retItem',
                            'relic',
                            1,
                            0
                        )"
                    );
                }
                $r++;
            }

            return $item_info;
            
        }

        public function get_random_item($excluded_items = '', $item_type = '') {
            $exclusions = '';
            $sql = "SELECT * FROM items ";
            $ping_type = $item_type;
            if($excluded_items){
                if($item_type){
                    if($item_type === 'relic'){
                        $exclusions = "WHERE item_type = '$item_type' AND item_id NOT IN ($excluded_items[0]";
                    }
                    else {
                        $ping_type = 'item';
                        if(strpos($item_type, 'boots') !== FALSE){
                            $exclusions = "WHERE item_type = '$item_type' AND item_id NOT IN ($excluded_items[0]";
                        }
                        else {
                            $exclusions = "WHERE item_type IN ('','$item_type') AND item_id NOT IN ($excluded_items[0]";
                        }
                    }
                }
                else {
                    $exclusions = "WHERE item_id NOT IN ($excluded_items[0]";
                }
                if(sizeof($excluded_items) > 1){
                    for($i = 1; $i < sizeof($excluded_items); $i++){
                        $exclusions .= ','.$excluded_items[$i];
                    }
                }
                $exclusions .= ')';
            }
            else {
                if($item_type){
                    if($item_type === 'relic'){
                        $exclusions = "WHERE item_type = '$item_type'";
                    }
                    else {
                        if(strpos($item_type, 'boots') !== FALSE){
                            $exclusions = "WHERE item_type = '$item_type'";
                        }
                        else {
                            $exclusions = "WHERE item_type = '' OR item_type = '$item_type'";
                        }
                    }
                }
            }

            $sql .= $exclusions;
            $sql .= ' ORDER BY RAND() LIMIT 1';

            $get_item = mysqli_query($this->connection, $sql);
            
            $row = mysqli_fetch_assoc($get_item);

            if($row['item_image']) {
                $item_image = $row['item_image'];
            }
            else {
                $item_image = 'images/hi.jpg';
            }
            $item_info = array(
                'itemid' => $row['item_id'],
                'itemname' => $row['item_name'],
                'itemimage' => $item_image
            );

            $retItem = $row['item_name'];
            $itemCount = mysqli_query($this->connection, "SELECT * FROM counts WHERE count_name = '$retItem'");
            
            $row = mysqli_fetch_assoc($itemCount);
            if($row['count']) {
                $count = intval($row['count']) + 1;

                mysqli_query($this->connection, "UPDATE counts SET
                    count = $count
                    WHERE count_name = '$retItem'
                ");
            }
            else {
                $addPing = mysqli_query(
                    $this->connection,"INSERT INTO counts (
                        count_id,
                        count_name,
                        count_type,
                        count,
                        rerolls
                    )
                    VALUES (
                        NULL,
                        '$retItem',
                        '$ping_type',
                        1,
                        0
                    )"
                );
            }

            $itemJSON = json_encode($item_info);
            
            return $itemJSON;
        }

        public function insert_item($item_name, $item_type = '') {
           $addItem = mysqli_query(
                $this->connection,"INSERT INTO items (
                    item_id,
                    item_name,
                    item_type,
                    item_image
                )
                VALUES (
                    NULL,
                    '$item_name',
                    '$item_type',
                    ''
                )"
            );

            $item_id = $this->connection->insert_id;
            return "$item_name inserted as item ID: $item_id";
        }

        public function reroll_log($item_name) {
            $itemCount = mysqli_query($this->connection, "SELECT * FROM counts WHERE count_name = '$item_name'");
            
            $row = mysqli_fetch_assoc($itemCount);

            $count = intval($row['rerolls']) + 1;

            mysqli_query($this->connection, "UPDATE counts SET
                rerolls = $count
                WHERE count_name = '$item_name'
            ");
        }

        public function item_rerolls($order){
            $items = array();
            $itemCounts = mysqli_query($this->connection, "SELECT * FROM counts WHERE count_type = 'item' ORDER BY $order DESC");   
            while ($item = $itemCounts->fetch_assoc()) {
                $itemName = $item['count_name'];
                $itemCount = $item['count'];
                $itemRerolls = $item['rerolls'];
                
                $getItemImage = mysqli_query($this->connection, "SELECT item_image FROM items WHERE item_name = '$itemName'");
                $itemImage = mysqli_fetch_assoc($getItemImage);
                $items[$itemName] = array(
                    'count' => $itemCount,
                    'rerolls' => $itemRerolls,
                    'image' => $itemImage['item_image']
                );
            }

            return $items;
        }

        public function relic_rerolls($order){
            $relics = array();
            $relicCounts = mysqli_query($this->connection, "SELECT * FROM counts WHERE count_type = 'relic' ORDER BY $order DESC");   
            while ($relic = $relicCounts->fetch_assoc()) {
                $relicName = $relic['count_name'];
                $relicCount = $relic['count'];
                $relicRerolls = $relic['rerolls'];
                
                $getRelicImage = mysqli_query($this->connection, "SELECT item_image FROM items WHERE item_name = '$relicName'");
                $relicImage = mysqli_fetch_assoc($getRelicImage);
                $relics[$relicName] = array(
                    'count' => $relicCount,
                    'rerolls' => $relicRerolls,
                    'image' => $relicImage['item_image']
                );
            }

            return $relics;
        }

  	}
?>