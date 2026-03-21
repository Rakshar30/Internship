<?php 
session_start();
include '../includes/header.php';
include("../config/db.php");

/*-----------USER LOGIN------------*/
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/*-----------FETCH USER ORDER------------*/
$query = "
SELECT 
    orders.id AS order_id,
    products.title AS product_title,
    orders.total_amount,
    orders.order_status,
    orders.created_at
FROM orders
JOIN order_items ON orders.id = order_items.order_id
JOIN products ON order_items.product_id = products.id
WHERE orders.user_id = $user_id
ORDER BY orders.id DESC
";

$result = mysqli_query($conn, $query);
?>

<style>
.dashboard-welcome {
    background: linear-gradient(135deg, #007bff, #6610f2);
    padding: 30px;
    border-radius: 15px;
    color: white;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.dashboard-welcome h2 {
    font-weight: bold;
}

.info-cards .card {
    border-radius: 15px;
    transition: 0.3s;
}

.info-cards .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.orders-table {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.empty-orders-box {
    text-align: center;
    padding: 40px;
    border-radius: 15px;
    background: #f8f9fa;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}
</style>

<div class="container mt-5 mb-5">

<!-----------WELCOME------------>
    <div class="dashboard-welcome">
        <h2>Welcome Back! 👋</h2>
        <p class="mt-2">Explore new books, check your orders, and continue your reading journey.</p>

        <a href="all_books.php" class="btn btn-light px-4 mt-2">
            <i class="bi bi-book-half me-1"></i> Browse Books
        </a>
    </div>

    <div class="row mt-4 info-cards">

        <!--  TOTAL ORDERS -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm p-3">
                <h5 class="text-secondary">Total Orders</h5>
                <h3 class="fw-bold">
                    <?php echo mysqli_num_rows($result); ?>
                </h3>
            </div>
        </div>

        <!--PENDING ORDERS -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm p-3">
                <h5 class="text-secondary">Pending Orders</h5>
                <h3 class="fw-bold text-warning">
                    <?php
                        $pending = mysqli_query($conn, "SELECT * FROM orders WHERE user_id=$user_id AND order_status='Pending'");
                        echo mysqli_num_rows($pending);
                    ?>
                </h3>
            </div>
        </div>

        <!-- DELIVERED ORDERS -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm p-3">
                <h5 class="text-secondary">Delivered Orders</h5>
                <h3 class="fw-bold text-success">
                    <?php
                        $delivered = mysqli_query($conn, "SELECT * FROM orders WHERE user_id=$user_id AND order_status='Delivered'");
                        echo mysqli_num_rows($delivered);
                    ?>
                </h3>
            </div>
        </div>

    </div>

    <!-- RECENT ORDERS -->
    <div class="orders-table mt-4">

        <h3 class="mb-3">Your Recent Orders</h3>

        <?php if(mysqli_num_rows($result) > 0): ?>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Book Name</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['order_id']; ?></td>
                    <td><?= $row['product_title']; ?></td>
                    <td>₹<?= $row['total_amount']; ?></td>

                   <td>
    <?php 
    $status = $row['order_status']; 

    if ($status == "Pending") {
        echo '<span class="badge bg-warning text-dark">Pending</span>';
    } 
    elseif ($status == "Processing") {
        echo '<span class="badge bg-primary">Processing</span>';
    } 
    elseif ($status == "Shipped") {
        echo '<span class="badge bg-info text-dark">Shipped</span>';
    } 
    elseif ($status == "Delivered") {
        echo '<span class="badge bg-success">Delivered</span>';
    } 
    elseif ($status == "Cancelled") {
        echo '<span class="badge bg-danger">Cancelled</span>';
    } 
    else {
        echo '<span class="badge bg-secondary">Pending</span>';
    }
    ?>
</td>
                    <td><?= $row['created_at']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <?php else: ?>

        <!-- EMPTY STATE -->
        <div class="empty-orders-box">
            <i class="bi bi-emoji-frown" style="font-size: 40px; color: #6c757d;"></i>
            <h4 class="mt-3 text-secondary">No orders yet</h4>
            <p class="text-muted">Start purchasing your favorite books now.</p>
            <a href="all_books.php" class="btn btn-primary px-4 mt-2">
                <i class="bi bi-book"></i> Browse Books
            </a>
        </div>

        <?php endif; ?>

    </div>

</div>

<?php include '../includes/footer.php'; ?>