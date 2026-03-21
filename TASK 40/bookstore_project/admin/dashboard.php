<?php 
session_start();
include("../config/db.php");

/*--------------ALLOW ADMIN-----------------*/
if(!isset($_SESSION['role']) || $_SESSION['role']!="admin"){
    header("Location: ../login.php");
    exit();
}

/*--------------FETCH STATISTICS-----------------*/
$books = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM products"));
$categories = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM categories"));
$orders = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM orders"));
$users = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users"));

/*--------------ORDER STATUS COUNTS-----------------*/
$statusData = mysqli_query($conn, "
    SELECT order_status, COUNT(*) as count 
    FROM orders 
    GROUP BY order_status
");

$statuses = [];
$statusCounts = [];

while($row = mysqli_fetch_assoc($statusData)){
    $statuses[] = $row['order_status'];
    $statusCounts[] = $row['count'];
}

/*--------------MONTHLY REVENUE-----------------*/
$monthlyData = mysqli_query($conn, "
    SELECT DATE_FORMAT(created_at,'%b') as month, SUM(total_amount) as total 
    FROM orders 
    GROUP BY MONTH(created_at)
");

$months = [];
$totals = [];

while($row = mysqli_fetch_assoc($monthlyData)){
    $months[] = $row['month'];
    $totals[] = $row['total'];
}

/*--------------DAILY ORDERS COUNT-----------------*/
$dailyData = mysqli_query($conn, "
    SELECT DATE(created_at) as day, COUNT(*) as count 
    FROM orders 
    GROUP BY DATE(created_at)
");

$days = [];
$dayOrders = [];

while($row = mysqli_fetch_assoc($dailyData)){
    $days[] = $row['day'];
    $dayOrders[] = $row['count'];
}

/*--------------CATEGORY-WISE BOOKS-----------------*/
$catData = mysqli_query($conn, "
    SELECT categories.category_name, COUNT(products.id) as total 
    FROM categories 
    LEFT JOIN products ON categories.id = products.category_id 
    GROUP BY categories.id
");

$catNames = [];
$catCounts = [];

while($row = mysqli_fetch_assoc($catData)){
    $catNames[] = $row['category_name'];
    $catCounts[] = $row['total'];
}

?>

<?php include '../includes/admin_header.php'; ?>

<div class="container mt-4 mb-5">

    <h2 class="mb-4 fw-bold">Admin Dashboard</h2>
    <hr>

    <!-- STAT CARDS -->
    <div class="row text-white">

        <div class="col-md-3 mb-3">
            <div class="dashboard-card text-center p-3 text-white rounded">
                <h3><?= $books ?></h3>
                <p>Total Books</p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="dashboard-card text-center p-3 text-white rounded">
                <h3><?= $categories ?></h3>
                <p>Categories</p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="dashboard-card text-center p-3 text-white rounded">
                <h3><?= $orders ?></h3>
                <p>Total Orders</p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="dashboard-card text-center p-3 text-white rounded">
                <h3><?= $users ?></h3>
                <p>Registered Users</p>
            </div>
        </div>

    </div>

    <!-- CHARTS SECTION -->
    <div class="row mt-4">

        <!-- ORDER STATUS PIE -->
        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow">
                <h5 class="text-center">Order Status Overview</h5>
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- MONTHLY REVENUE BAR -->
        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow">
                <h5 class="text-center">Monthly Revenue</h5>
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- DAILY ORDERS LINE -->
        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow">
                <h5 class="text-center">Daily Orders</h5>
                <canvas id="dailyChart"></canvas>
            </div>
        </div>

        <!-- CATEGORY-WISE BOOKS -->
        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow">
                <h5 class="text-center">Books per Category</h5>
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* ORDER STATUS PIE */
new Chart(document.getElementById('statusChart'), {
    type: 'pie',
    data: {
        labels: <?= json_encode($statuses) ?>,
        datasets: [{
            data: <?= json_encode($statusCounts) ?>
        }]
    }
});

/* MONTHLY REVENUE BAR */
new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($months) ?>,
        datasets: [{
            data: <?= json_encode($totals) ?>
        }]
    }
});

/* DAILY ORDERS LINE */
new Chart(document.getElementById('dailyChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode($days) ?>,
        datasets: [{
            data: <?= json_encode($dayOrders) ?>
        }]
    }
});

/* CATEGORY-WISE BOOKS */
new Chart(document.getElementById('categoryChart'), {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($catNames) ?>,
        datasets: [{
            data: <?= json_encode($catCounts) ?>
        }]
    }
});
</script>

<?php include '../includes/admin_footer.php'; ?>