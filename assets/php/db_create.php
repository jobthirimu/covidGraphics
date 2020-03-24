<?php
define('DB_SERVER' , 'localhost');
define('DB_USERNAME' , 'id13002461_progettocovid');
define('DB_PASSWORD' , 'progettocovid');
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$sqll = "CREATE DATABASE IF NOT EXISTS id13002461_covid";
if ($conn->query($sqll) === TRUE) {
   // echo "Database created successfully";
} else {
    //echo "Error creating database: " . $conn->error;
}

$conn->close();
?>