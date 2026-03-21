<?php
session_start();
include '../config/db.php';

if(!isset($_GET['id'])){
    header("Location: cart.php");
    exit();
}

$cart_id = $_GET['id'];

mysqli_query($conn, "DELETE FROM cart WHERE id = $cart_id");

header("Location: cart.php");
exit();
?>