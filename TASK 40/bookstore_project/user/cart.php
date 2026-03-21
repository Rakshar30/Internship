<?php 
session_start();
include '../config/db.php';
include '../includes/header.php';

/*--------------IF NOT LOGGED IN USER THEN LOGIN-----------------*/
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<div class="container mt-5 cart-container">

    <h2 class="fade-in">Your Cart</h2>
    <hr>

<?php
/*--------------FETCH CART ITEMS-----------------*/
$query = "
    SELECT cart.*, products.title, products.price, products.image
    FROM cart
    LEFT JOIN products ON products.id = cart.product_id
    WHERE cart.user_id = $user_id
";

$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0){
    echo "
        <div class='text-center p-5'>
            <img src='../assets/images/empty_cart.png' width='180' class='mb-3'>
            <h4 class='text-muted'>Your cart is empty</h4>
            <a href='all_books.php' class='btn btn-primary mt-3'>Browse Books</a>
        </div>
    ";
    include '../includes/footer.php';
    exit();
}
?>

    <!-- CART TABLE -->
    <table class="table table-bordered fade-in">

        <thead class="table-light">
            <tr>
                <th>Book</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

        <?php while($item = mysqli_fetch_assoc($result)){ 
            $total = $item['price'] * $item['quantity'];
        ?>

            <tr class="cart-row" data-id="<?php echo $item['id']; ?>">

                <td>
                    <img src="../uploads/<?php echo $item['image']; ?>" width="60" class="me-2 rounded">
                    <?php echo $item['title']; ?>
                </td>

                <td>₹<?php echo number_format($item['price'], 2); ?></td>

                <td>
                    <input type="number" 
                           class="form-control qty-box" 
                           value="<?php echo $item['quantity']; ?>" 
                           min="1">
                </td>

                <td class="item-total">
                    ₹<?php echo number_format($total, 2); ?>
                </td>

                <td>
                    <a href="remove_cart.php?id=<?php echo $item['id']; ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Remove item from cart?');">
                        Remove
                    </a>
                </td>

            </tr>

        <?php } ?>

        </tbody>
    </table>

    <a href="checkout.php" class="btn btn-success mt-3 proceed-btn fade-in">
        Proceed to Checkout
    </a>

</div>

<!-- AJAX UPDATE SCRIPT -->
<script>
document.querySelectorAll(".qty-box").forEach((box) => {
    box.addEventListener("change", function() {

        let row = this.closest("tr");
        let cart_id = row.getAttribute("data-id");
        let qty = this.value;

        // AJAX Update
        fetch("update_cart.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `cart_id=${cart_id}&qty=${qty}`
        })
        .then(res => res.text())
        .then(data => {
            if(data.trim() === "success"){
                location.reload();  // refresh totals
            }
        });
    });
});
</script>

<?php include '../includes/footer.php'; ?>