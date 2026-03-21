<?php
session_start();
include("../config/db.php");

/*-----------USER LOGIN------------*/
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/*-----------NOT SUBMITTED------------*/
if(!isset($_POST['total_amount'])){
    header("Location: cart.php");
    exit();
}

/*-----------BILLING DETAILS------------*/
$name       = mysqli_real_escape_string($conn, $_POST['name']);
$phone      = mysqli_real_escape_string($conn, $_POST['phone']);
$address    = mysqli_real_escape_string($conn, $_POST['address']);
$payment    = $_POST['payment_method'];
$total      = $_POST['total_amount'];

$status = "pending";


/*-----------INSERT INTO ORDERS TABLE------------*/
$orderQuery = "
    INSERT INTO orders (user_id, total_amount, order_status)
    VALUES ('$user_id', '$total', '$order_status')
";

if(mysqli_query($conn, $orderQuery)){
    
/*-----------LAST INSERTED ORDER ID------------*/
    $order_id = mysqli_insert_id($conn);

    // CART ITEM OF PARTICULAR USER
    $cartQuery = "
        SELECT cart.*, products.title, products.price 
        FROM cart
        LEFT JOIN products ON products.id = cart.product_id
        WHERE cart.user_id = $user_id
    ";
    $cartItems = mysqli_query($conn, $cartQuery);

    // INSERT CART ITEM IN ORDER ITEM
    while($item = mysqli_fetch_assoc($cartItems)){
        $product_id = $item['product_id'];
        $quantity   = $item['quantity'];
        $price      = $item['price'];

        mysqli_query($conn, "
            INSERT INTO order_items (order_id, product_id, quantity, price)
            VALUES ('$order_id', '$product_id', '$quantity', '$price')
        ");
    }

    // CLEAR CART
    mysqli_query($conn, "DELETE FROM cart WHERE user_id = $user_id");

    // SUCCESS PAGE
    header("Location: order_success.php?order_id=".$order_id);
    exit();

} else {
    echo "<h3>Error placing order. Please try again.</h3>";
}
?>