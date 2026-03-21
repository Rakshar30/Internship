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

/*--------------INSERTING BOOK-----------------*/
if(isset($_POST['add_book'])){

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $stock = $_POST['stock'];

/*--------------INSERTING IMAGE -----------------*/
    $image = $_FILES['image'];

    if($image['error'] === 0){
    $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    $allowed_ext = ["jpg", "jpeg", "png", "gif", "webp"];

        if(!in_array($ext, $allowed_ext)){
            $error = "Invalid image format! Only JPG, JPEG, PNG, GIF, WEBP allowed.";
        } else {
            $image_name = time() . "_" . rand(1000,9999) . "." . $ext;
            $tmp_name = $image['tmp_name'];
            $upload_path = realpath(__DIR__ . "/../uploads") . "/" . $image_name;
            if(move_uploaded_file($tmp_name, $upload_path)){

/*--------------INSERT INTO DATABASE-----------------*/
                $query = "INSERT INTO products(title, author, price, description, image, category_id, stock)
                          VALUES('$title', '$author', '$price', '$description', '$image_name', '$category_id', '$stock')";

                if(mysqli_query($conn, $query)){
                    $success = "Book added successfully!";
                } else {
                    $error = "Database error: Failed to add book.";
                }

            } else {
                $error = "Failed to move uploaded file! Check folder permissions.";
            }
        }

    } else {
        $error = "Please upload a valid image!";
    }
}
?>

<?php include '../includes/admin_header.php'; ?>

<h2 class="mb-4">Add New Book</h2>
<hr>

<div style="max-width:700px;">

<?php if($success != ""){ ?>
    <div class="alert alert-success text-center"><?php echo $success; ?></div>
<?php } ?>

<?php if($error != ""){ ?>
    <div class="alert alert-danger text-center"><?php echo $error; ?></div>
<?php } ?>

<form method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <label class="form-label">Book Title</label>
        <input type="text" name="title" class="form-control" placeholder="Enter book title" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Author Name</label>
        <input type="text" name="author" class="form-control" placeholder="Enter author name" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" name="price" class="form-control" placeholder="Enter book price" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Stock</label>
        <input type="number" name="stock" class="form-control" placeholder="Available stock" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select" required>
            <option disabled selected>Select Category</option>

            <?php
            $cat = mysqli_query($conn, "SELECT * FROM categories");
            while($c = mysqli_fetch_assoc($cat)){
            ?>
                <option value="<?php echo $c['id']; ?>">
                    <?php echo $c['category_name']; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Upload Book Image</label>
        <input type="file" name="image" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Book Description</label>
        <textarea name="description" class="form-control" rows="4" placeholder="Enter book description" required></textarea>
    </div>

    <button type="submit" name="add_book" class="btn btn-primary">Add Book</button>
    <a href="books.php" class="btn btn-secondary ms-2">Back</a>

</form>
</div>

<?php include '../includes/admin_footer.php'; ?>