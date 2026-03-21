<?php 
session_start();
include '../config/db.php';
include '../includes/header.php';

/*-----------USER LOGIN------------*/
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/*-----------FETCH USER DETAILS------------*/
$userQuery = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($userQuery);

/*-----------FETCH CART ITEMS------------*/
$cartQuery = "
    SELECT cart.*, products.title, products.price, products.image
    FROM cart
    LEFT JOIN products ON products.id = cart.product_id
    WHERE cart.user_id = $user_id
";
$cartItems = mysqli_query($conn, $cartQuery);

if(mysqli_num_rows($cartItems) == 0){
    echo "
        <div class='container mt-5 text-center'>
            <h3>Your cart is empty</h3>
            <a href='all_books.php' class='btn btn-primary mt-3'>Browse Books</a>
        </div>
    ";
    include '../includes/footer.php';
    exit();
}

$totalAmount = 0;
?>

<div class="container mt-5 checkout-container">

    <h2>Checkout</h2>
    <hr>

    <div class="row">

        <!-- LEFT:USER DETAILS -->
        <div class="col-md-6">

            <h4>Billing Details</h4>

            <form action="place_order.php" method="POST">

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" 
                           value="<?php echo $user['name']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" 
                           value="<?php echo $user['phone']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="4" required><?php echo $user['address']; ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Payment Method</label>
                    <select class="form-select" name="payment_method" required>
                        <option value="COD">Cash on Delivery</option>
                    </select>
                </div>

                <input type="hidden" name="total_amount" value="<?php // set below ?>">

        </div>

        <!-- RIGHT:ORDER SUMMARY-->
        <div class="col-md-6">

            <h4>Order Summary</h4>

            <table class="table table-bordered">

                <?php while($item = mysqli_fetch_assoc($cartItems)){ 
                    $itemTotal = $item['price'] * $item['quantity'];
                    $totalAmount += $itemTotal;
                ?>

                <tr>
                    <th>Book</th>
                    <td><?php echo $item['title']; ?></td>
                </tr>

                <tr>
                    <th>Price</th>
                    <td>₹<?php echo number_format($item['price'], 2); ?></td>
                </tr>

                <tr>
                    <th>Quantity</th>
                    <td><?php echo $item['quantity']; ?></td>
                </tr>

                <tr>
                    <th>Total</th>
                    <td>₹<?php echo number_format($itemTotal, 2); ?></td>
                </tr>

                <?php } ?>

                <tr class="table-success">
                    <th>Grand Total</th>
                    <td><strong>₹<?php echo number_format($totalAmount, 2); ?></strong></td>
                </tr>

            </table>
>
            <input type="hidden" name="total_amount" value="<?php echo $totalAmount; ?>">

            <button type="submit" class="btn btn-success btn-lg w-100 mt-3">Place Order</button>

            </form>

        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>