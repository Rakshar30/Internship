<?php
session_start();
include("../config/db.php");

/*--------------ALLOW ADMIN-----------------*/
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

/*--------------CATEGORY ID-----------------*/
$id = $_GET['id'];

/*--------------EXISTING CATEGORY-----------------*/
$result = mysqli_query($conn, "SELECT * FROM categories WHERE id=$id");
$category = mysqli_fetch_assoc($result);

$success = "";
$error = "";

/*--------------WHEN UPDATE BUTTON IS CLICKED-----------------*/
if(isset($_POST['update_category'])){
    $name = trim($_POST['name']);

/*--------------CHECK IF ALREADY EXISTS-----------------*/
    $check = mysqli_query($conn, "SELECT * FROM categories WHERE category_name='$name' AND id!=$id");
    if(mysqli_num_rows($check) > 0){
        $error = "Category name already exists!";
    } else {
        $query = "UPDATE categories SET category_name='$name' WHERE id=$id";
        if(mysqli_query($conn, $query)){
            $success = "Category updated successfully!";
        } else {
            $error = "Failed to update category!";
        }
    }
}
?>

<?php include '../includes/admin_header.php'; ?>

<h2 class="page-title">Edit Category</h2>

<div class="admin-table-box mt-3 p-4">
    <?php if($success != "") { ?>
        <div class="alert alert-success text-center"><?php echo $success; ?></div>
    <?php } ?>

    <?php if($error != "") { ?>
        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php } ?>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control"
                   value="<?php echo $category['category_name']; ?>" required>
        </div>

        <button class="btn btn-primary" name="update_category">Update Category</button>
        <a href="categories.php" class="btn btn-secondary ms-2">Cancel</a>

    </form>

</div>

<?php include '../includes/admin_footer.php'; ?>