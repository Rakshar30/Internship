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

<h2 class="mb-4">Manage Books</h2>
<hr>

<a href="add_book.php" class="btn btn-primary mb-3">Add New Book</a>

<div class="admin-table-box">
    <div class="table-responsive">

        <table class="table admin-table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Book</th>
                    <th>Author</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $query = "SELECT products.*, categories.category_name 
                          FROM products 
                          LEFT JOIN categories 
                          ON products.category_id = categories.id
                          ORDER BY products.id DESC";
                
                $result = mysqli_query($conn, $query);

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>

                    <td><?php echo $row['title']; ?></td>

                    <td><?php echo $row['author']; ?></td>

                    <td>₹<?php echo $row['price']; ?></td>

                    <td><?php echo $row['category_name']; ?></td>

                    <td>
                        <img src="../uploads/<?php echo $row['image']; ?>" 
                             width="50" 
                             height="60"
                             style="object-fit: cover; border-radius: 4px;">
                    </td>

                    <td><?php echo $row['stock']; ?></td>

                    <td>
                        <a href="edit_book.php?id=<?php echo $row['id']; ?>" 
                           class="btn btn-sm btn-warning">Edit</a>

                        <a href="delete_book.php?id=<?php echo $row['id']; ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Are you sure you want to delete this book?');">
                           Delete
                        </a>
                    </td>
                </tr>

                <?php 
                    }
                } else { 
                ?>

                <tr>
                    <td colspan="8" class="text-center">No books found</td>
                </tr>

                <?php } ?>
            </tbody>

        </table>

        <nav class="mt-3">
            <ul class="pagination justify-content-end">
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
            </ul>
        </nav>

    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>