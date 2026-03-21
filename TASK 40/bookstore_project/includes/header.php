<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Book Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/bookstore_project/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
.admin-wrapper {
    display: flex;
}

.admin-sidebar {
    width: 230px;
    min-height: 100vh;
    background: #1e1e1e;
    padding: 20px 0;
    position: fixed;
    top: 0;
    left: 0;
}

.admin-sidebar a {
    display: block;
    padding: 12px 20px;
    color: #ffffffcc;
    text-decoration: none;
    font-size: 16px;
    transition: 0.3s;
}

.admin-sidebar a:hover {
    background: #333;
    color: white;
}


.admin-content {
    margin-left: 230px;
    width: calc(100% - 230px);
    padding: 30px;
}
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/bookstore_project/index.php">
            <i class="bi bi-book-half me-2"></i> BookStore
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a href="/bookstore_project/index.php" class="nav-link">
                        <i class="bi bi-house-door me-1"></i> Home
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/bookstore_project/user/categories.php" class="nav-link">
                        <i class="bi bi-list-ul me-1"></i> Categories
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/bookstore_project/user/cart.php" class="nav-link">
                        <i class="bi bi-cart3 me-1"></i> Cart
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="/bookstore_project/logout.php" class="nav-link">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>