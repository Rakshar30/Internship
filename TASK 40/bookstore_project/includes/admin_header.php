<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>

    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="admin-body">

    <!-- FIXED TOP NAVBAR -->
    <nav class="admin-topbar navbar navbar-dark bg-dark px-4">
        <span class="navbar-brand mb-0 h1">Admin Panel</span>
    </nav>

    <!-- FIXED SIDEBAR (below navbar) -->
    <div class="admin-sidebar">
        <a href="../admin/dashboard.php">Dashboard</a>
        <a href="../admin/categories.php">Categories</a>
        <a href="../admin/books.php">Books</a>
        <a href="../admin/orders.php">Orders</a>
        <a href="../admin/users.php">Users</a>
        <a href="../logout.php">Logout</a>
    </div>

    <!-- SCROLLABLE CONTENT -->
    <div class="admin-content fade-in ">