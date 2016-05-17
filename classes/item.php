<?php
	class Item {
        // Creating some properties (variables tied to an object)
        
        public $connection;
        
        // Assigning the values
        public function __construct($connection) {
	          $this->connection = $connection;
        }
        
        public function get_random_item($excluded_items = '', $item_type = '') {
            $exclusions = '';
            $sql = "SELECT * FROM items ";
            if($excluded_items){
                if($item_type){
                    if($item_type === 'relic'){
                        $exclusions = "WHERE item_type = '$item_type' AND item_id != $excluded_items[0]";
                    }
                    else {
                        if(strpos($item_type, 'boots') !== FALSE){
                            $exclusions = "WHERE item_type = '$item_type' AND item_id != $excluded_items[0]";
                        }
                        else {
                            $exclusions = "WHERE item_type = '' OR item_type = '$item_type' AND item_id != $excluded_items[0]";
                        }
                    }
                }
                else {
                    $exclusions = "WHERE item_id != $excluded_items[0]";
                }
                if(sizeof($excluded_items) > 1){
                    for($i = 1; $i < sizeof($excluded_items); $i++){
                        $exclusions .= ' AND item_id != '.$excluded_items[$i];
                    }
                }
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

            $item_info = array(
                'id' => $row['item_id'],
                'name' => $row['item_name']
            );

            return $item_info;
        }

        public function insert_item($item_name, $item_type = '') {
           $addItem = mysqli_query(
                $this->connection,"INSERT INTO items (
                    item_id,
                    item_name,
                    item_type
                )
                VALUES (
                    NULL,
                    '$item_name',
                    '$item_type'
                )"
            );

            $item_id = $this->connection->insert_id;
            return "$item_name inserted as item ID: $item_id";
        }
  	}
?>