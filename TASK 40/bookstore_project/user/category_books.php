<?php 
include '../includes/header.php';
include '../config/db.php';

if(!isset($_GET['id'])){
    echo "<div class='container mt-5'><h4 class='text-danger'>Category not found!</h4></div>";
    exit();
}

$cat_id = $_GET['id'];

/*--------------FETCH CATEGORY NAME-----------------*/
$cat = mysqli_query($conn, "SELECT category_name FROM categories WHERE id=$cat_id");
$category = mysqli_fetch_assoc($cat);
if(!$category){
    echo "<div class='container mt-5'><h4 class='text-danger'>Invalid Category!</h4></div>";
    include '../includes/footer.php';
    exit();
}
?>

<style>
body {
    font-family: 'Poppins', sans-serif !important;
}

.filter-box {
    border-radius: 15px;
    background: white;
    border: none;
}

.filter-box input,
.filter-box select {
    height: 48px;
    font-size: 15px;
    border-radius: 10px;
}

.book-card {
    border-radius: 18px;
    overflow: hidden;
    transition: 0.35s ease;
    background: white;
    border: none !important;
}

.book-card:hover {
    transform: translateY(-7px);
    box-shadow: 0 12px 20px rgba(0,0,0,0.15);
}

.book-img {
    height: 260px;
    object-fit: cover;
    border-bottom: 1px solid #eee;
}

.book-title {
    font-size: 17px;
    font-weight: 600;
    height: 45px;
    overflow: hidden;
}

.book-author {
    font-size: 14px;
    color: #6c757d;
}

.book-price {
    font-size: 18px;
    font-weight: 700;
    color: #3b82f6;
}

.no-books {
    font-size: 18px;
    padding: 40px;
    text-align: center;
    color: #6c757d;
}
</style>

<div class="container mt-5">

    <h2 class="mb-4 fw-bold">
        <i class="bi bi-tags-fill text-primary me-2"></i>
        <?= $category['category_name']; ?> Books
    </h2>

    <div class="card p-4 mb-4 shadow-sm filter-box">
        <form method="GET">
            <input type="hidden" name="id" value="<?= $cat_id; ?>">

            <div class="row g-3">

            <!-- SEARCH -->
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control"
                        placeholder="Search books..."
                        value="<?= $_GET['search'] ?? '' ?>">
                </div>

                <!-- SORT -->
                <div class="col-md-4">
                    <select name="sort" class="form-control">
                        <option value="">Sort by Price</option>
                        <option value="low" <?= ($_GET['sort'] ?? '') == 'low' ? 'selected' : '' ?>>Low → High</option>
                        <option value="high" <?= ($_GET['sort'] ?? '') == 'high' ? 'selected' : '' ?>>High → Low</option>
                    </select>
                </div>

                <div class="col-md-4 text-end">
                    <button class="btn btn-primary px-4 py-2" type="submit">
                        <i class="bi bi-funnel"></i> Apply
                    </button>
                </div>

            </div>
        </form>
    </div>

    <div class="row">

        <?php 
        $query = "SELECT * FROM products WHERE category_id=$cat_id";

        if(!empty($_GET['search'])){
            $search = $_GET['search'];
            $query .= " AND title LIKE '%$search%'";
        }

        if(!empty($_GET['sort'])){
            if($_GET['sort'] == 'low'){
                $query .= " ORDER BY price ASC";
            } else if($_GET['sort'] == 'high'){
                $query .= " ORDER BY price DESC";
            }
        }

        $books = mysqli_query($conn, $query);

        if(mysqli_num_rows($books) > 0){
            while($b = mysqli_fetch_assoc($books)){
        ?>

        <!-- CARD -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm book-card">

                <img src="../uploads/<?= $b['image']; ?>" 
                     class="book-img">

                <div class="card-body">

                    <h5 class="book-title"><?= $b['title']; ?></h5>

                    <p class="book-author">
                        <i class="bi bi-person"></i>
                        <?= $b['author']; ?>
                    </p>

                    <p class="book-price">₹<?= $b['price']; ?></p>

                    <a href="book_details.php?id=<?= $b['id']; ?>"
                       class="btn btn-outline-primary w-100 mb-2">
                        <i class="bi bi-eye"></i> View Details
                    </a>

                    <a href="add_to_cart.php?id=<?= $b['id']; ?>"
                       class="btn btn-success w-100">
                        <i class="bi bi-cart-plus"></i> Add to Cart
                    </a>

                </div>
            </div>
        </div>

        <?php 
            }
        } else {
            echo "<div class='no-books'>No books found in this category.</div>";
        }
        ?>

    </div>

</div>

<?php include '../includes/footer.php'; ?>