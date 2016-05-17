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

            $god_info = array(
                'id' => $row['god_id'],
                'name' => $row['god_name'],
                'type' => $row['god_type']
            );

            
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
  	}
?>