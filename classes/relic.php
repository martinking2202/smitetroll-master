<?php
	class User {
        // Creating some properties (variables tied to an object)
        
        public $connection;
        
        // Assigning the values
        public function __construct($connection) {
	          $this->connection = $connection;
        }
        
        // Creating a method (function tied to an object)
        public function login($con, $user, $pw) {
		    $getUser = mysqli_query($con, "SELECT * FROM users WHERE user_username = '$user'");
            
            $row = mysqli_fetch_assoc($getUser);
            $returned_pw = $row['user_password'];

            $pw_verify = password_verify($pw, $returned_pw);

            if($pw_verify){
                $user_id = $row['user_id'];

                return $user_id;
            }
            else {
                return 0;
            }
        }

         public function create_user($con, $user, $pw) {
            $options = [
                'cost' => 12,
            ];
            $hash_pw = password_hash($pw, PASSWORD_BCRYPT, $options);

            $createUser = mysqli_query(
                $con,"INSERT INTO users (
                    user_id,
                    user_username,
                    user_password
                )
                VALUES (
                    NULL,
                    '$user',
                    '$hash_pw'
                )"
            );
        }

        public function get_customers($con, $user) {
            $sql = "SELECT * FROM user_customers WHERE user_id = $user";
            $customerSetup = new Customer($con);
            $return = array();
            if ($result = mysqli_query($con, $sql)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $customerID = $row['customer_id'];
                    $thisCust = $customerSetup->get_customer($customerID);
                    array_push($return, $thisCust);
                }
            }
            return $return;
        }

        public function login_customer($con, $user, $customer) {
            $checkLink = mysqli_query($con, "SELECT * FROM user_customers WHERE user_id = $user AND customer_id = $customer");
            
            $row = mysqli_fetch_assoc($checkLink);
            $customer_id = $row['customer_id'];

            if($customer_id){
                return $customer_id;
            }
            else {
                return 0;
            }
        }
  	}
?>