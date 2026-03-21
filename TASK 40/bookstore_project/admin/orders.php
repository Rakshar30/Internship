<?php 
session_start();
include("../config/db.php");

/*--------------ALLOW ADMIN-----------------*/
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

include '../includes/admin_header.php';
?>

<h2 class="mb-4">Manage Orders</h2>
<hr>

<div class="admin-table-box">
    <div class="table-responsive">

        <table class="table admin-table table-hover">
            <thead class="admin-thead">
                <tr>
                    <th>Order ID</th>
                    <th>User Name</th>
                    <th>Book</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

            <?php
/*--------------FECTCH ORDERS WITH USERS-----------------*/
            $orderQuery = "
                SELECT orders.*, users.name AS user_name 
                FROM orders 
                LEFT JOIN users ON users.id = orders.user_id
                ORDER BY orders.id DESC
            ";
            $orders = mysqli_query($conn, $orderQuery);

            if(mysqli_num_rows($orders) > 0){
                while($o = mysqli_fetch_assoc($orders)){

/*------------------Fetch booked items for this order--------------*/
                    $itemsQuery = "
                        SELECT order_items.*, products.title 
                        FROM order_items
                        LEFT JOIN products ON products.id = order_items.product_id
                        WHERE order_items.order_id = {$o['id']}
                    ";
                    $items = mysqli_query($conn, $itemsQuery);

                    while($item = mysqli_fetch_assoc($items)){
            ?>

                <tr>
                    <td><?php echo $o['id']; ?></td>
                    <td><?php echo $o['user_name']; ?></td>
                    <td><?php echo $item['title']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₹<?php echo number_format($o['total_amount'], 2); ?></td>

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
        echo '<span class="badge bg-warning text-dark">Pending</span>';
    }
?>
</td>

                    <td>
                        <a href="edit_order.php?id=<?php echo $o['id']; ?>" 
                           class="btn btn-sm btn-warning">Edit</a>
                    </td>
                </tr>

            <?php 
                    } 
                } 
            } else {
            ?>
                <tr>
                    <td colspan="7" class="text-center">No orders found</td>
                </tr>
            <?php } ?>

            </tbody>
        </table>

        <nav class="mt-3">
            <ul class="pagination justify-content-end">
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
            </ul>
        </nav>

    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>