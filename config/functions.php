<?php 
/**
 * print readable data
*/
function show($stuff, $exit = true) {
    echo "<pre>";
    print_r($stuff);
    echo "</pre>";
    if ($exit) {
        exit;
    }
    
}
/**
 * database Connection
*/
define('DB_USER','root');
define('DB_HOST','localhost');
define('DB_PASS','');
define('DB_NAME','nabta_db');
$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if(!$conn){
    echo "Could not connect something went wrong";
}
