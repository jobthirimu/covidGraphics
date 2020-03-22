<?php
define('DB_SERVER' , 'localhost');
define('DB_USERNAME' , 'root');
define('DB_PASSWORD' , '');
define('DB_DATABASE', "covid");

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$sqll = "CREATE DATABASE covid";
if ($conn->query($sqll) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();

$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

?>