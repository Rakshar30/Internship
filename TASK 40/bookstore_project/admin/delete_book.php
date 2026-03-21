<?php
session_start();
include("../config/db.php");

/*--------------ALLOW ADMIN-----------------*/
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

/*--------------DELETE IF ONLY ID -----------------*/
if(!isset($_GET['id'])){
    header("Location: books.php?error=Invalid request");
    exit();
}

$book_id = $_GET['id'];

/*--------------BOOK IMAGE-----------------*/
$query = mysqli_query($conn, "SELECT image FROM products WHERE id = $book_id");
$book = mysqli_fetch_assoc($query);

/*--------------BOOK NOT FOUND-----------------*/
if(!$book){
    header("Location: books.php?error=Book not found");
    exit();
}

/*--------------DELETE IMAGE-----------------*/
$image_path = "../uploads/" . $book['image'];

if(file_exists($image_path)){
    unlink($image_path); 
}

/*--------------DELETE BOOK FROM DATABASE-----------------*/
$deleteBook = mysqli_query($conn, "DELETE FROM products WHERE id = $book_id");

if($deleteBook){
    header("Location: books.php?success=Book deleted successfully");
} else {
    header("Location: books.php?error=Failed to delete book");
}

exit();
?>
<?php include '../includes/admin_header.php'; ?>
<?php include '../includes/admin_footer.php'; ?>