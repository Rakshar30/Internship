<?php 
session_start();
include '../config/db.php';
include '../includes/header.php';

/*------------CHECK USER LOGIN------------*/
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/*------------FETCH ORDERS------------*/
$query = "
SELECT 
    id AS order_id,
    total_amount,
    order_status,
    created_at
FROM orders
WHERE user_id = $user_id
ORDER BY id ASC
";

$orders = mysqli_query($conn, $query);
?>

<div class="container mt-5 orders-container">
    <h2>Your Orders</h2>
    <hr>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Order ID</th>
                <th>Books</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>

        <?php if(mysqli_num_rows($orders) > 0): ?>
            <?php while($o = mysqli_fetch_assoc($orders)): ?>

            <tr>
                <td><?= $o['order_id']; ?></td>

                <!-- FETCH BOOKS INSIDE THE ORDER -->
                <td>
                    <?php
                    $oid = $o['order_id'];
                    $itemQuery = "
                        SELECT products.title 
                        FROM order_items
                        JOIN products ON products.id = order_items.product_id
                        WHERE order_items.order_id = $oid
                    ";
                    $items = mysqli_query($conn, $itemQuery);

                    while($item = mysqli_fetch_assoc($items)){
                        echo "<div>{$item['title']}</div>";
                    }
                    ?>
                </td>

                <td>₹<?= number_format($o['total_amount'], 2); ?></td>

                <td>
                    <?php 
                    $status = trim($o['order_status']); 

                    if($status == "Pending"){
                        echo '<span class="badge bg-warning text-dark">Pending</span>';
                    }
                    elseif($status == "Processing"){
                        echo '<span class="badge bg-primary">Processing</span>';
                    }
                    elseif($status == "Shipped"){
                        echo '<span class="badge bg-info text-dark">Shipped</span>';
                    }
                    elseif($status == "Delivered"){
                        echo '<span class="badge bg-success">Delivered</span>';
                    }
                    elseif($status == "Cancelled"){
                        echo '<span class="badge bg-danger">Cancelled</span>';
                    }
                    else {
                        echo '<span class="badge bg-secondary">Pending</span>';
                    }
                    ?>
                </td>

                <td><?= date("d M Y", strtotime($o['created_at'])); ?></td>
            </tr>

            <?php endwhile; ?>
        
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center text-muted">
                    <em>No orders placed yet.</em>
                </td>
            </tr>
        <?php endif; ?>

        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>