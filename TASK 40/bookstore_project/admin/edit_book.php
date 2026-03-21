<?php
session_start();
include("../config/db.php");

/*--------------ALLOW ADMIN-----------------*/
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

/*--------------BOOK ID EXISTS-----------------*/
if(!isset($_GET['id'])){
    header("Location: books.php");
    exit();
}

$book_id = $_GET['id'];
$success = "";
$error = "";

/*--------------FETCH DATA-----------------*/
$query = "SELECT * FROM products WHERE id = $book_id";
$result = mysqli_query($conn, $query);
$book = mysqli_fetch_assoc($result);

/*--------------BOOK NOT FOUND----------------*/
if(!$book){
    header("Location: books.php");
    exit();
}

/*--------------UPDATE----------------*/
if(isset($_POST['update_book'])){

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $new_image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

/*--------------NEW IMAGE-----------------*/
    if($new_image != ""){
        $ext = strtolower(pathinfo($new_image, PATHINFO_EXTENSION));
        $allowed = ["jpg","jpeg","png","gif","webp"];

        if(in_array($ext, $allowed)){

            $image_name = time() . "_" . rand(1000,9999) . "." . $ext;

            $upload_path = "../uploads/" . $image_name;

            if(move_uploaded_file($tmp_name, $upload_path)){

/*--------------DELETE OLD IMAGE-----------------*/
                if($book['image'] != "" && file_exists("../uploads/" . $book['image'])){
                    unlink("../uploads/" . $book['image']);
                }

/*--------------UPDATE NEW IMAGE-----------------*/
                $update = "UPDATE products SET 
                    title='$title',
                    author='$author',
                    price='$price',
                    stock='$stock',
                    category_id='$category_id',
                    description='$description',
                    image='$image_name'
                WHERE id=$book_id";

                if(mysqli_query($conn, $update)){
                    $success = "Book updated successfully!";
                } else {
                    $error = "Failed to update book.";
                }

            } else {
                $error = "Failed to upload new image.";
            }

        } else {
            $error = "Invalid image format!";
        }

    } else {

/*--------------UPDATE WITHOUT IMAGE----------------*/
        $update = "UPDATE products SET 
            title='$title',
            author='$author',
            price='$price',
            stock='$stock',
            category_id='$category_id',
            description='$description'
        WHERE id=$book_id";

        if(mysqli_query($conn, $update)){
            $success = "Book updated successfully!";
        } else {
            $error = "Failed to update book.";
        }
    }
}
?>

<?php include '../includes/admin_header.php'; ?>

<h2 class="page-title">Edit Book</h2>

<div class="admin-table-box mt-3 p-4">

<?php if($success != ""){ ?>
    <div class="alert alert-success text-center"><?php echo $success; ?></div>
<?php } ?>

<?php if($error != ""){ ?>
    <div class="alert alert-danger text-center"><?php echo $error; ?></div>
<?php } ?>

<form method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <label class="form-label">Book Title</label>
        <input type="text" name="title" class="form-control" value="<?php echo $book['title']; ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Author</label>
        <input type="text" name="author" class="form-control" value="<?php echo $book['author']; ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" name="price" class="form-control" value="<?php echo $book['price']; ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Stock</label>
        <input type="number" name="stock" class="form-control" value="<?php echo $book['stock']; ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select" required>
            <?php
            $category_query = mysqli_query($conn, "SELECT * FROM categories");
            while($c = mysqli_fetch_assoc($category_query)){
            ?>
                <option value="<?php echo $c['id']; ?>" 
                    <?php if($c['id'] == $book['category_id']) echo "selected"; ?>>
                    <?php echo $c['category_name']; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Current Image</label><br>
        <img src="../uploads/<?php echo $book['image']; ?>" width="90" height="100" style="object-fit:cover;">
    </div>

    <div class="mb-3">
        <label class="form-label">Upload New Image (optional)</label>
        <input type="file" name="image" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4"><?php echo $book['description']; ?></textarea>
    </div>

    <button type="submit" name="update_book" class="btn btn-primary">Update Book</button>
    <a href="books.php" class="btn btn-secondary ms-2">Cancel</a>

</form>

</div>

<?php include '../includes/admin_footer.php'; ?>