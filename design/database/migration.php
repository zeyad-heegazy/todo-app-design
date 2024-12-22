<?php

$conn = mysqli_connect("localhost", "root", "");

// $sql = "DROP DATABASE todoapp";
$sql = "CREATE DATABASE IF NOT EXISTS todoapp";
mysqli_query($conn, $sql);


mysqli_close($conn);


$conn = mysqli_connect("localhost", "root", "", "todoapp");

$sql = "CREATE TABLE IF NOT EXISTS tasks (
   id INT PRIMARY KEY AUTO_INCREMENT, 
   title VARCHAR(200) NOT NULL
)";

mysqli_query($conn, $sql);
