<?php
session_start();
include("../config/db.php");

/*-----------USER LOGIN------------*/
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

/*-----------ORDER ID EXSITS------------*/
if(!isset($_GET['order_id'])){
    header("Location: all_books.php");
    exit();
}

$order_id = $_GET['order_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Successful</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .box {
            background: #fff;
            padding: 40px;
            width: 450px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        h2 {
            color: #28a745;
            font-size: 28px;
        }
        p {
            font-size: 18px;
            color: #333;
        }
        .order-id {
            font-size: 22px;
            font-weight: bold;
            color: #007bff;
            margin-top: 10px;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
        }
        a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>🎉 Order Placed Successfully!</h2>
    <p>Thank you for shopping with us!</p>

    <div class="order-id">Order ID: <?php echo $order_id; ?></div>

    <p>Your order has been submitted and is currently being processed.</p>

    <a href="orders.php">View My Orders</a>
</div>

</body>
</html>