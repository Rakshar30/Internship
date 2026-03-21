<?php
session_start();
include("../config/db.php");

/*-------------- LOGIN-----------------*/
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/*--------------CHECK IF PRODUCT IS PRESENT-----------------*/
if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: all_books.php");
    exit();
}

$product_id = intval($_GET['id']); 

/*--------------CHECK IF PRODUCT IS PRESENT IN DATABASE-----------------*/
$product_check = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
if(mysqli_num_rows($product_check) == 0){
    header("Location: all_books.php");
    exit();
}

/*--------------CHECK IF PRODUCT IS PRESENT IN CART-----------------*/
$check = mysqli_query($conn,
    "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id"
);

if(mysqli_num_rows($check) > 0){
    mysqli_query($conn,
        "UPDATE cart SET quantity = quantity + 1 
         WHERE user_id = $user_id AND product_id = $product_id"
    );
} else {
    mysqli_query($conn,
        "INSERT INTO cart(user_id, product_id, quantity)
         VALUES($user_id, $product_id, 1)"
    );
}

header("Location: cart.php");
exit();
?>