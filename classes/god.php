<?php
	class God {
        // Creating some properties (variables tied to an object)
        
        public $connection;
        
        // Assigning the values
        public function __construct($connection) {
	          $this->connection = $connection;
        }
        
        // Creating a method (function tied to an object)
        public function get_random_god($excluded_gods = '', $god_type = '') {
            $exclusions = '';
            if($excluded_gods){
                if($god_type){
                    $exclusions = "WHERE god_type = '$god_type' AND god_id != $excluded_gods[0]";
                }
                else {
                    $exclusions = "WHERE god_id != $excluded_gods[0]";
                }
            }
            else {
                if($god_type){
                    $exclusions = "WHERE god_type = '$god_type'";
                }
                else {
                    $exclusions = "";
                }
            }

		    $getGod = mysqli_query($this->connection, "SELECT * FROM gods $exclusions ORDER BY RAND() LIMIT 1");
            
            $row = mysqli_fetch_assoc($getGod);

            if($row['god_image']) {
                $god_image = $row['god_image'];
            }
            else {
                $god_image = 'images/god-hi.jpg';
            }

            $god_info = array(
                'id' => $row['god_id'],
                'name' => $row['god_name'],
                'type' => $row['god_type'],
                'image' => $god_image
            );

            $retGod = $row['god_name'];
            $itemCount = mysqli_query($this->connection, "SELECT * FROM counts WHERE count_name = '$retGod'");
            
            $row = mysqli_fetch_assoc($itemCount);
            if($row['count']) {
                $count = intval($row['count']) + 1;

                mysqli_query($this->connection, "UPDATE counts SET
                    count = $count
                    WHERE count_name = '$retGod'
                ");
            }
            else {
                $addPing = mysqli_query(
                    $this->connection,"INSERT INTO counts (
                        count_id,
                        count_name,
                        count_type,
                        count
                    )
                    VALUES (
                        NULL,
                        '$retGod',
                        'god',
                        1
                    )"
                );
            }
            
            return $god_info;
        }

        public function insert_god($god_name) {
           $addGod = mysqli_query(
                $this->connection,"INSERT INTO gods (
                    god_id,
                    god_name
                )
                VALUES (
                    NULL,
                    '$god_name'
                )"
            );

            $god_id = $this->connection->insert_id;
            return "$god_name inserted as god ID: $god_id";
        }

        public function reroll_god_type($god_type) {

            $getGod = mysqli_query($this->connection, "SELECT * FROM gods WHERE god_type != '$god_type' ORDER BY RAND() LIMIT 1");
            
            $row = mysqli_fetch_assoc($getGod);

            if($row['god_image']) {
                $god_image = $row['god_image'];
            }
            else {
                $god_image = 'images/god-hi.jpg';
            }

            $god_info = array(
                'id' => $row['god_id'],
                'name' => $row['god_name'],
                'type' => $row['god_type'],
                'image' => $god_image
            );

            $retGod = $row['god_name'];
            $itemCount = mysqli_query($this->connection, "SELECT * FROM counts WHERE count_name = '$retGod'");
            
            $row = mysqli_fetch_assoc($itemCount);
            if($row['count']) {
                $count = intval($row['count']) + 1;

                mysqli_query($this->connection, "UPDATE counts SET
                    count = $count
                    WHERE count_name = '$retGod'
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
                        '$retGod',
                        'god',
                        1,
                        0
                    )"
                );
            }

            return $god_info;
        }

        public function reroll_log($god_name) {
            $godCount = mysqli_query($this->connection, "SELECT * FROM counts WHERE count_name = '$god_name'");
            
            $row = mysqli_fetch_assoc($godCount);

            $rerollCount = intval($row['rerolls']) + 1;

            mysqli_query($this->connection, "UPDATE counts SET
                rerolls = $rerollCount
                WHERE count_name = '$god_name'
            ");
        }

        public function god_rerolls($order){
            $gods = array();
            $godCounts = mysqli_query($this->connection, "SELECT * FROM counts WHERE count_type = 'god' ORDER BY $order DESC");   
            while ($god = $godCounts->fetch_assoc()) {
                $godName = $god['count_name'];
                $godCount = $god['count'];
                $godRerolls = $god['rerolls'];
                
                $getGodImage = mysqli_query($this->connection, "SELECT god_image FROM gods WHERE god_name = '$godName'");
                $godImage = mysqli_fetch_assoc($getGodImage);
                $gods[$godName] = array(
                    'count' => $godCount,
                    'rerolls' => $godRerolls,
                    'image' => $godImage['god_image']
                );
            }

            return $gods;
        }
  	}
?>