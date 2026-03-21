<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "online_bookstore";

$conn = mysqli_connect($host,$user,$password,$database);

if(!$conn){
    die("Database connection failed");
}

?>