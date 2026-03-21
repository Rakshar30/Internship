<?php
session_start();
include("../config/db.php");

/*--------------ALLOW ADMIN-----------------*/
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

/*--------------DELETE CATEGORY-----------------*/
if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM categories WHERE id=$id");
    header("Location: categories.php");
    exit();
}
?>

<?php include '../includes/admin_header.php'; ?>

<h2 class="mb-4">Manage Categories</h2>
<hr>

<a href="add_category.php" class="btn btn-primary mb-3">
    + Add New Category
</a>

<div class="admin-table-box">
    <div class="table-responsive">

        <table class="table admin-table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th style="width:150px;">Action</th>
                </tr>
            </thead>

            <tbody>

                <?php
                $i = 1;
                $result = mysqli_query($conn, "SELECT * FROM categories ORDER BY id DESC");

                while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td>
                        <a href="edit_category.php?id=<?php echo $row['id']; ?>" 
                           class="btn btn-sm btn-warning">Edit</a>

                        <a href="categories.php?delete=<?php echo $row['id']; ?>"
                           onclick="return confirm('Are you sure you want to delete this category?');"
                           class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
                <?php } ?>

            </tbody>

        </table>

    <nav class="mt-3">
    <ul class="pagination justify-content-end">
        <li class="page-item active">
            <a class="page-link" href="#">1</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="#">2</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="#">3</a>
        </li>
    </ul>
</nav>    

    </div>

</div>

<?php include '../includes/admin_footer.php'; ?>