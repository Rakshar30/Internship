<?php
session_start();
include("../config/db.php");

/*--------------ALLOW ADMIN-----------------*/
if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../login.php");
    exit();
}

/*--------------USER ID PRESENT-----------------*/
if (!isset($_GET['id'])) {
    header("Location: users.php");
    exit();
}

$user_id = $_GET['id'];

/*--------------ADMIN CANNOT DELETE ACCOUNT-----------------*/
if ($user_id == $_SESSION['user_id']) {
    echo "<script>alert('You cannot delete your own admin account!'); 
          window.location.href='users.php';</script>";
    exit();
}

/*--------------DELETE USER-----------------*/
$delete = mysqli_query($conn, "DELETE FROM users WHERE id = $user_id");

if ($delete) {
    echo "<script>alert('User deleted successfully!'); 
          window.location.href='users.php';</script>";
} else {
    echo "<script>alert('Failed to delete user!'); 
          window.location.href='users.php';</script>";
}
?>