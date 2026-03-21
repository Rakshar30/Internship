<?php
session_start();
include("../config/db.php");

/*--------------ALLOW ADMIN-----------------*/
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

/*--------------USER ID EXIST-----------------*/
if(!isset($_GET['id'])){
    header("Location: users.php");
    exit();
}

$user_id = $_GET['id'];
$message = "";

/*--------------USER DETAILS FROM DATABASE-----------------*/
$userQuery = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($userQuery);

if(!$user){
    header("Location: users.php");
    exit();
}

/*--------------UPDATE USER-----------------*/
if(isset($_POST['update_user'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $update = mysqli_query($conn, "
        UPDATE users SET 
            name = '$name',
            email = '$email',
            phone = '$phone',
            address = '$address'
        WHERE id = $user_id
    ");

    if($update){
        $message = "<div class='alert alert-success text-center'>User updated successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger text-center'>Failed to update user!</div>";
    }
}

include '../includes/admin_header.php';
?>

<h2 class="page-title">Edit User</h2>

<div class="admin-table-box mt-3 p-4">

    <?php echo $message; ?>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" 
                   value="<?php echo $user['name']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" 
                   value="<?php echo $user['email']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" 
                   value="<?php echo $user['phone']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" rows="3" required><?php echo $user['address']; ?></textarea>
        </div>

        <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
        <a href="users.php" class="btn btn-secondary ms-2">Cancel</a>

    </form>

</div>

<?php include '../includes/admin_footer.php'; ?>