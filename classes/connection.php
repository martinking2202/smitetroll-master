<?php
	class Connection {
        // Creating some properties (variables tied to an object)
        
        public $username;
        public $password;
        public $database;
        
        // Assigning the values
        public function __construct($username, $password, $database) {
	          $this->username = $username;
	          $this->password = $password;
	          $this->database = $database;
        }
        
        // Creating a method (function tied to an object)
        public function connect() {
		    return mysqli_connect("localhost",$this->username, $this->password, $this->database);
        }

        public function ping($conn, $ip) {
            $date = date('Y-m-d');
            $getIP = mysqli_query($conn, "SELECT * FROM pings WHERE ip_address = '$ip'");
            
            $row = mysqli_fetch_assoc($getIP);
            if($row['count']) {
                $count = intval($row['count']) + 1;

                mysqli_query($conn,"UPDATE pings SET
                    count = $count, last_ping = CAST('$date' as DATE)
                    WHERE ip_address = '$ip'
                ");
            }
            else {
                $addPing = mysqli_query(
                    $conn,"INSERT INTO pings (
                        ping_id,
                        ip_address,
                        count,
                        last_ping
                    )
                    VALUES (
                        NULL,
                        '$ip',
                        1,
                        CAST('$date' as DATE)
                    )"
                );
            }
        }
  	}
?>