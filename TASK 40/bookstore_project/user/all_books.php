<?php 
session_start();
include '../config/db.php';
include '../includes/header.php'; 
?>

<div class="container mt-5">

    <div class="section-title-wrapper mb-4">
        <div class="section-title">
            <i class="bi bi-book-half me-2 section-icon"></i>
            All Books
        </div>
    </div>

    <div class="row">

        <?php
/*--------------CHECK ALL PRODUCTS-----------------*/
        $query = "
            SELECT products.*, categories.category_name 
            FROM products
            LEFT JOIN categories ON categories.id = products.category_id
            ORDER BY products.id DESC
        ";
        $books = mysqli_query($conn, $query);

        if(mysqli_num_rows($books) > 0){
            while($b = mysqli_fetch_assoc($books)){
        ?>

        <!--CARD STRUCTURE -->
        <div class="col-md-3 mb-4">
            <div class="book-card shadow-sm">

                <div class="book-img-wrapper">
                    <img src="../uploads/<?php echo $b['image']; ?>" class="card-img-top book-img">
                </div>

                <div class="card-body text-center">
                    <h5 class="book-title"><?php echo $b['title']; ?></h5>

                    <p class="text-muted">
                        <i class="bi bi-person"></i> <?php echo $b['author']; ?>
                    </p>

                    <p class="book-price text-primary fw-bold">
                        ₹<?php echo number_format($b['price'], 2); ?>
                    </p>

                    <a href="add_to_cart.php?id=<?= $b['id']; ?>" 
   class="btn btn-success w-100">
   <i class="bi bi-cart-plus me-1"></i> Add to Cart
</a>

                    <a href="book_details.php?id=<?php echo $b['id']; ?>" 
                       class="btn btn-outline-primary w-100">
                        <i class="bi bi-eye"></i> Quick View
                    </a>

                </div>
            </div>
        </div>

        <?php 
            } 
        } else { 
        ?>

        <!-- BOOKS NOT AVALIABLE -->
        <div class="col-12 text-center mt-5 mb-5">
            <div style="padding:40px; border-radius:15px; 
                        background:#f8f9fa; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                <img src="../assets/images/empty.png" width="120" class="mb-3">
                <h4 class="text-muted">No Books Available Yet</h4>
                <p class="text-secondary">Please check again later. New books will be added soon!</p>
            </div>
        </div>

        <?php } ?>

    </div>

</div>

<?php include '../includes/footer.php'; ?>