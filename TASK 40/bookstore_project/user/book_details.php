<?php 
session_start();
include '../config/db.php';
include '../includes/header.php';

/*--------------CHECK IF ID IS PRESENT-----------------*/
if(!isset($_GET['id'])){
    header("Location: all_books.php");
    exit();
}

$book_id = $_GET['id'];

/*--------------CHECK BOOKS DETAILS-----------------*/
$query = "
    SELECT products.*, categories.category_name 
    FROM products
    LEFT JOIN categories ON categories.id = products.category_id
    WHERE products.id = $book_id
";

$result = mysqli_query($conn, $query);
$book = mysqli_fetch_assoc($result);

/*--------------BOOK NOT FOUND-----------------*/
if(!$book){
    echo "<div class='container mt-5 text-center'>
            <h3 class='text-danger'>Book not found!</h3>
            <a href='all_books.php' class='btn btn-primary mt-3'>Back</a>
          </div>";
    include '../includes/footer.php';
    exit();
}
?>

<div class="container mt-5 mb-5">

    <div class="admin-table-box p-4">

        <div class="row">

            <!-- BOOK IMAGE -->
            <div class="col-md-4 text-center">
                <img src="../uploads/<?php echo $book['image']; ?>" 
                     class="img-fluid rounded shadow-sm book-detail-img" 
                     style="max-height: 380px; object-fit: cover;">
            </div>

            <!-- BOOK DETAILS -->
            <div class="col-md-8">

                <h2 class="fw-bold"><?php echo $book['title']; ?></h2>

                <p class="mt-3">
                    <span class="fw-bold text-secondary">Author:</span> 
                    <?php echo $book['author']; ?>
                </p>

                <p class="mt-3">
                    <span class="fw-bold text-secondary">Category:</span> 
                    <?php echo $book['category_name']; ?>
                </p>

                <p class="fw-bold text-success fs-4">
                    ₹<?php echo number_format($book['price'], 2); ?>
                </p>

                <p class="mt-3 text-muted">
                    <strong>Description:</strong><br>
                    <?php echo nl2br($book['description']); ?>
                </p>

                <a href="add_to_cart.php?id=<?php echo $book['id']; ?>" 
                   class="btn btn-success px-4 py-2 mt-3">
                    <i class="bi bi-cart-plus me-2"></i>Add to Cart
                </a>

                <a href="all_books.php" 
                   class="btn btn-secondary px-4 py-2 mt-3 ms-2">
                    <i class="bi bi-arrow-left me-1"></i>Back to Books
                </a>

            </div>

        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>