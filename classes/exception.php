<?php
	class item_god_Exception {
        // Creating some properties (variables tied to an object)
        
        public $connection;
        
        // Assigning the values
        public function __construct($connection) {
	          $this->connection = $connection;
        }
        
        // Creating a method (function tied to an object)
        public function get_exceptions($exception_name = '', $exception_id = '') {
            $exceptions = '';
            if($exception_name){

                $exceptions .= 'WHERE exception_name = "'.$exception_name.'"';
                if($exception_id) {
                    $exceptions .= 'AND exception_id = $exception_id';
                }
            }
            elseif($exception_id){
                $exceptions .= 'WHERE exception_id = "$exception_id"';
            }
		    $getExceptions = mysqli_query($this->connection, "SELECT * FROM exceptions $exceptions");
            
            $returnExceptions = array();
            while ($exception = $getExceptions->fetch_assoc()) {

                $functions = unserialize($exception['exception_function_files']);

                foreach($functions as $exception_function_type => $exception_function_dets){
                    $exceptionPlacement = '';
                    $exceptionURL = '';
                    $exceptionElement = '';
                    $exceptionSource = '';
                    if(isset($exception_function_dets['placement'])) $exceptionPlacement = $exception_function_dets['placement'];
                    if(isset($exception_function_dets['url'])) $exceptionURL = $exception_function_dets['url'];
                    if(isset($exception_function_dets['element'])) $exceptionElement = $exception_function_dets['element'];
                    if(isset($exception_function_dets['src'])) $exceptionSource = $exception_function_dets['src'];

                    $singleException = array(
                        'type' => $exception_function_type,
                        'placement' => $exceptionPlacement,
                        'url' => $exceptionURL,
                        'element' => $exceptionElement,
                        'src' => $exceptionSource
                    );

                    array_push($returnExceptions, $singleException);
                }
            }
            
            return $returnExceptions;
        }

  	}
?>