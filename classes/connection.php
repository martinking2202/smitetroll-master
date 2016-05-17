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
  	}
?>