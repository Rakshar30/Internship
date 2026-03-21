<?php
session_start();
include '../config/db.php';

if(isset($_POST['cart_id']) && isset($_POST['qty'])){
    
    $cart_id = $_POST['cart_id'];
    $qty = $_POST['qty'];

    mysqli_query($conn, "UPDATE cart SET quantity = $qty WHERE id = $cart_id");

    echo "success";
}
?>