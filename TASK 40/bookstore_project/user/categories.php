<?php 
include '../includes/header.php';
include '../config/db.php';
?>
<?php
function getCategoryIcon($name) {
    $name = strtolower($name);

    if (strpos($name, "history") !== false || strpos($name, "historic") !== false)
        return "bi-book-half";

    if (strpos($name, "programming") !== false || strpos($name, "coding") !== false)
        return "bi-laptop";

    if (strpos($name, "fiction") !== false || strpos($name, "novel") !== false)
        return "bi-stars";

    if (strpos($name, "Science") !== false || strpos($name, "sci") !== false)
        return "bi-book-half";

    if (strpos($name, "technology") !== false || strpos($name, "technology") !== false)
        return "bi-cpu";

    return "bi-folder2-open"; 
}
?>

<div class="container mt-5">

    <!-- FILTER SECTION -->
    <div class="card shadow-sm p-4 mb-4">
        <form action="" method="GET">
            <div class="row g-3">

                <!-- SEARCH  BAR -->
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search categories..."
                           value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                </div>

                <!-- DROPDOWN CATEGORY -->
                <div class="col-md-4">
                    <select name="category" class="form-control">
                        <option value="">Select Category</option>

                        <?php 
                        $cats = mysqli_query($conn, "SELECT * FROM categories ORDER BY category_name ASC");
                        while($c = mysqli_fetch_assoc($cats)) { 
                        ?>
                            <option value="<?= $c['id']; ?>"
                                <?= (isset($_GET['category']) && $_GET['category'] == $c['id']) ? "selected" : "" ?>>
                                <?= $c['category_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- DROPDOWN PRICE -->
                <div class="col-md-4">
                    <select name="sort" class="form-control">
                        <option value="">Sort by Price</option>
                        <option value="low" <?= (isset($_GET['sort']) && $_GET['sort'] == 'low') ? "selected" : "" ?>>
                            Price: Low to High
                        </option>
                        <option value="high" <?= (isset($_GET['sort']) && $_GET['sort'] == 'high') ? "selected" : "" ?>>
                            Price: High to Low
                        </option>
                    </select>
                </div>

                <div class="col-md-12 text-end mt-3">
                    <button class="btn btn-primary px-4" type="submit">Apply Filters</button>
                </div>

            </div>
        </form>

    </div>

    <h2 class="mb-4">
        <i class="bi bi-list-ul me-2"></i> Categories
    </h2>

    <div class="row">

        <?php 
        $query = "SELECT * FROM categories WHERE 1=1";

        // SEARCH FILTER
        if(!empty($_GET['search'])){
            $search = $_GET['search'];
            $query .= " AND category_name LIKE '%$search%'";
        }

        if(!empty($_GET['category'])){
            $cat_id = $_GET['category'];
            $query .= " AND id = $cat_id";
        }

        $query .= " ORDER BY category_name ASC";

        $categories = mysqli_query($conn, $query);

        if(mysqli_num_rows($categories) > 0) {
            while($cat = mysqli_fetch_assoc($categories)) {
        ?>

        <!-- CATEGORY CARD -->
        <div class="col-md-3 mb-4">
            <a href="category_books.php?id=<?= $cat['id']; ?>" class="text-decoration-none">
                <div class="card shadow-sm p-3 text-center category-card">
                    <i class="bi <?= getCategoryIcon($cat['category_name']); ?>" style="font-size:40px;"></i>
                    <h5 class="mt-2 text-dark"><?= $cat['category_name']; ?></h5>
                </div>
            </a>
        </div>

        <?php 
            }
        } else {
            echo "<p class='text-muted'>No categories found.</p>";
        }
        ?>

    </div>

</div>

<style>
.category-card {
    transition: 0.3s;
    border-radius: 15px;
}
.category-card:hover {
    transform: translateY(-5px);
    background: #f8f9fa;
}
</style>

<?php include '../includes/footer.php'; ?>