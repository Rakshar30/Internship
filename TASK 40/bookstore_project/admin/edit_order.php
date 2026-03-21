<?php
session_start();
include("../config/db.php");

/*--------------ALLOW ADMIN-----------------*/
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

/*--------------ORDER IS EXISTS-----------------*/
if(!isset($_GET['id'])){
    header("Location: orders.php");
    exit();
}

$order_id = $_GET['id'];
$message = "";

/*--------------FETCH ORDER DETAILS-----------------*/
$orderQuery = mysqli_query($conn, "SELECT * FROM orders WHERE id = $order_id");
$order = mysqli_fetch_assoc($orderQuery);

if(!$order){
    header("Location: orders.php");
    exit();
}

/*--------------UPDATE-----------------*/
if(isset($_POST['update_status'])){
    $new_status = $_POST['status'];

    $update = mysqli_query($conn, 
        "UPDATE orders SET order_status='$new_status' WHERE id=$order_id"
    );

    if($update){
        $message = "<div class='alert alert-success text-center'>Order status updated successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger text-center'>Failed to update order status!</div>";
    }
}

include '../includes/admin_header.php';
?>

<h2 class="page-title">Update Order Status</h2>

<div class="admin-table-box mt-3 p-4">

    <?php echo $message; ?>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Order ID</label>
            <input type="text" class="form-control" value="<?php echo $order['id']; ?>" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-select" name="status" required>

                <option value="Pending" <?php echo ($order['order_status']=="Pending")?"selected":""; ?>>Pending</option>
                <option value="Processing" <?php echo ($order['order_status']=="Processing")?"selected":""; ?>>Processing</option>
                <option value="Shipped" <?php echo ($order['order_status']=="Shipped")?"selected":""; ?>>Shipped</option>
                <option value="Delivered" <?php echo ($order['order_status']=="Delivered")?"selected":""; ?>>Delivered</option>
                <option value="Cancelled" <?php echo ($order['order_status']=="Cancelled")?"selected":""; ?>>Cancelled</option>

            </select>
        </div>

        <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
        <a href="orders.php" class="btn btn-secondary ms-2">Cancel</a>

    </form>

</div>

<?php include '../includes/admin_footer.php'; ?>