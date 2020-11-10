<?php 
// two to ways to connect 
// MySQLi i stands for improved or PDO which stands for PHP Data Objects 
// PDO is better but need to know objects 
// connect to database takes four parameters 1) host 2) user 3) test 4) database name 
// this is connecting to whole database 
$conn = mysqli_connect('localhost', 'musaa', '1234' , 'ninja_pizza');

// check connection 
if(!$conn) {
   echo 'connection error' . mysqli_connect_error(); 
}


?>