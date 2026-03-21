<?php 
include 'includes/header.php'; 
include 'config/db.php';
?>

<!-----------ANNOUNCEMENT------------>
<div class="announcement-bar bg-warning text-dark py-2 overflow-hidden">
    <div class="scroll-text">
        New Books Added | Latest Arrivals Available Now | Special Discounts on Bestsellers!
    </div>
</div>

<style>
.scroll-text {
    white-space: nowrap;
    display: inline-block;
    animation: scroll-left 12s linear infinite;
    font-weight: bold;
    font-size: 16px;
}

@keyframes scroll-left {
    from { transform: translateX(100%); }
    to { transform: translateX(-100%); }

}
.card {
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-7px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.card img {
    transition: 0.4s ease;
}

.card:hover img {
    transform: scale(1.07);  
}
</style>

<div class="container mt-5">
<!------HERO--->
    <div class="hero-container d-flex justify-content-center align-items-center">
        <div class="hero-box text-center">
            <h1 class="hero-title">
                <i class="bi bi-stars text-warning me-2"></i>
                Welcome to Online BookStore
            </h1>
            <p class="hero-subtitle">
                Discover thousands of books at the best prices.
            </p>

            <a href="user/all_books.php" class="btn btn-primary px-4 py-2 mt-2 hero-btn">
                <i class="bi bi-book-half me-1"></i> Browse Books
            </a>
        </div>
    </div>

<!-----------FEATURED BOOKS------------>
    <div class="section-title-wrapper mb-3">
        <div class="section-title">
            <i class="bi bi-bookmark-star-fill me-2 section-icon"></i>
            Featured Books
        </div>
    </div>

    <div class="row">

        <?php
        // FETCH ANY 4 BOOKS
        $query = "SELECT * FROM products ORDER BY RAND() LIMIT 4";
        $books = mysqli_query($conn, $query);

        if(mysqli_num_rows($books) > 0){
            while($b = mysqli_fetch_assoc($books)){
        ?>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">

                <img src="uploads/<?php echo $b['image']; ?>" 
                     class="card-img-top" 
                     style="height: 250px; object-fit: cover;">

                <div class="card-body">
                    <h5 class="card-title"><?php echo $b['title']; ?></h5>

                    <p class="text-muted">
                        <i class="bi bi-person me-1"></i> 
                        <?php echo $b['author']; ?>
                    </p>

                    <p class="text-primary fw-bold">
                        <i class="bi bi-tags-fill me-1"></i>
                        ₹<?php echo $b['price']; ?>
                    </p>

                    <a href="user/book_details.php?id=<?php echo $b['id']; ?>" 
                       class="btn btn-outline-primary w-100 mb-2">
                        <i class="bi bi-eye me-1"></i> View Details
                    </a>

                    <a href="user/add_to_cart.php?id=<?= $b['id']; ?>" 
   class="btn btn-success w-100">
    <i class="bi bi-cart-plus me-1"></i> Add to Cart
</a>
                </div>

            </div>
        </div>

        <?php 
            } 
        } else {
            echo '
<div class="col-12">
    <div class="text-center p-4 bg-light rounded shadow-sm border" 
         style="max-width: 400px; margin: 40px auto;">
        <i class="bi bi-emoji-frown text-secondary" style="font-size: 45px;"></i>
        <h5 class="mt-3 text-secondary">No Books Available</h5>
        <p class="text-muted">Please check back soon for new arrivals.</p>
    </div>
</div>';
        }
        ?>

    </div>

</div>


<?php include 'includes/footer.php'; ?>