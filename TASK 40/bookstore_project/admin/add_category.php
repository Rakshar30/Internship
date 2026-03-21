<?php
session_start();
include("../config/db.php");
/*--------------ALLOW ADMIN-----------------*/
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

$success = "";
$error = "";

if(isset($_POST['add_category'])){
    
    $name = trim($_POST['name']);

/*--------------IF CATEGORY EXISTS-----------------*/
    $check = mysqli_query($conn, "SELECT * FROM categories WHERE category_name='$name'");
    if(mysqli_num_rows($check) > 0){
        $error = "Category already exists!";
    } else {
/*--------------IF NOT INSERT CATEGORY-----------------*/
        $query = "INSERT INTO categories(category_name) VALUES('$name')";
        if(mysqli_query($conn, $query)){
            $success = "Category added successfully!";
        } else {
            $error = "Failed to add category!";
        }
    }
}
?>

<?php include '../includes/admin_header.php'; ?>

<h2 class="mb-4">Add New Category</h2>
<hr>

<div style="max-width: 600px;">
    <?php if($success != "") { ?>
        <div class="alert alert-success text-center">
            <?php echo $success; ?>
        </div>
    <?php } ?>

    <?php if($error != "") { ?>
        <div class="alert alert-danger text-center">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter category name" required>
        </div>

        <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
        <a href="categories.php" class="btn btn-secondary ms-2">Back</a>

    </form>
</div>

<?php include '../includes/admin_footer.php'; ?>