<!---1) Login--->
<?php
session_start();
include("db.php");
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
        $_SESSION['user'] = $email;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or Password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="styles/styles.css" rel="stylesheet">
</head>
<body class="bg-dark">
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-4">
            <div class="card p-4 shadow">
                <h3 class="text-center">Login</h3>
                <form method="POST">
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button name="login" class="btn btn-primary w-100">Login</button>
</form>
<?php if(isset($error)){ ?>
    <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
<?php } ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<!--2) Dashboard-->
<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
include("db.php");
$studentCount = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM students"));
?>
<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="styles/styles.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar col-md-2">
        <h4 class="text-white text-center">Student Panel</h4>
        <a href="dashboard.php">Dashboard</a>
        <a href="add_student.php">Add Student</a>
        <a href="view_students.php">View Students</a>
        <a href="logout.php">Logout</a>
    </div>
    <!-- Content -->
    <div class="container-fluid p-4">
        <h2>Dashboard</h2>
        <div class="row mt-4">
        <div class="col-md-3">
                <div class="card dashboard-card shadow p-3">
                    <h5>Total Students</h5>
                    <h3><?php echo $studentCount; ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<!--3) Add Student-->
<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
include("db.php");
$message = "";
if(isset($_POST['add_student'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $query = "INSERT INTO students (name,email,course)
              VALUES ('$name', '$email', '$course')";
    if(mysqli_query($conn, $query)){
        $message = "<div class='alert alert-success'>Student Added Successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error adding Student</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Student</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="styles/styles.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
<!-- Sidebar -->
<div class="sidebar col-md-2">
    <a href="dashboard.php">Dashboard</a>
    <a href="add_student.php" class="bg-primary text-white">Add Student</a>
    <a href="view_students.php">View Students</a>
    <a href="logout.php">Logout</a>
</div>
<!-- Content -->
<div class="container-fluid p-4">
    <h2>Add New Student</h2>
    <?php echo $message; ?>
    <div class="card shadow p-4 mt-3">
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Course</label>
                <textarea name="course" class="form-control" required></textarea>
            </div>
            <button type="submit" name="add_student" class="btn btn-primary">
               Add Student
            </button>
        </form>
    </div>
</div>
</div>
</body>
</html>

<!--4) Edit Student-->
<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
include("db.php");
/* GET STUDENT DATA */
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM students WHERE id=$id");
    $student = mysqli_fetch_assoc($result);
    
    if(!$student){
    header("Location: view_students.php");
    exit();
    }
}else{
    header("Location: view_students.php");
    exit();
}
/* UPDATE STUDENT DATA */
if(isset($_POST['update_student'])){
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $course = mysqli_real_escape_string($conn,$_POST['course']);
    $query="UPDATE students SET
            name='$name',
            email='$email',
            course='$course'
            WHERE id=$id";
    if(mysqli_query($conn,$query)){
        header("Location:view_students.php");
        exit();
    } else {
        $message="<div class='alert alert-danger'>Error updating student!</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/styles.css" rel=stylesheet>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
<div class="sidebar col-md-2">
    <a href="dashboard.php">Dashboard</a>
    <a href="add_student.php">Add Student</a>
    <a href="view_students.php">View Students</a>
    <a href="logout.php">Logout</a>
</div>
<!-- Content -->
<div class="container p-4">
    <h2>Edit Student</h2>
    <?php if(isset($message)) echo $message; ?>
    <div class="card p-4 shadow mt-3">
        <form method="POST">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control"
                       value="<?= $student['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="<?= $student['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Course</label>
                <textarea name="course" class="form-control" required><?= $student['course']; ?></textarea>
            </div>
            <button type="submit" name="update_student" class="btn btn-success">Update Student</button>
            <a href="view_students.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
</div>
</body>
</html>

<!--5) View Student-->
<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
include("db.php");
// Fetch all students
$students = mysqli_query($conn, "SELECT * FROM students");
?>
<!DOCTYPE html>
<html>
<head>
<title>View Students</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="styles/styles.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar col-md-2">
        <a href="dashboard.php">Dashboard</a>
        <a href="add_student.php">Add Student</a>
        <a href="view_students.php" class="bg-primary text-white">View Students</a>
        <a href="logout.php">Logout</a>
    </div>
    <!-- Content -->
    <div class="container-fluid p-4">
        <h2>All Students</h2>
        <div class="card p-3 shadow mt-3">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($students)){ ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['course']; ?></td>
                        <td>
                            <a href="edit_students.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete_students.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure you want to delete this student?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
          
<!--6) Delete-->
<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
include("db.php");
// Check if ID is passed
if(isset($_GET['id'])){
    $id = $_GET['id'];
    // Delete the student
    mysqli_query($conn, "DELETE FROM students WHERE id=$id");
    // Redirect back
    header("Location: view_students.php");
    exit();
} else {
    // If no ID, go back
    header("Location: view_students.php");
    exit();
}
?>

<!--7) Logout-->
<?php
session_start();
session_destroy();
header("Location: login.php");
exit();
?>

<!--8) Database-->
<?php
$conn=mysqli_connect("localhost","root","","student_system");
if(!$conn){
    die("Connection Failed" . mysqli_connect_error());
}
?>

<!--9) CSS Styling-->
body {
    font-family: Arial, sans-serif;
    background-color: #f0f2f5;
    margin: 0;
}
.sidebar {
    height: 100vh;
    width: 200px;
    background-color: #222;
    padding-top: 20px;
}
.sidebar a {
    display: block;
    padding: 12px 20px;
    color: #ddd;
    text-decoration: none;
    font-size: 15px;
}
.sidebar a:hover {
    background-color: #333;
    color: #fff;
}
.dashboard-card {
    border-left: 5px solid #0d6efd;
    background: #fff;
    padding: 20px;
    border-radius: 5px;
}
.dashboard-card:hover {
    background: #f2f6ff;
    transition: 0.3s;
}
.card {
    border: none;
    border-radius: 6px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
input, textarea, select {
    border-radius: 4px;
    border: 1px solid #ccc;
}
table {
    background-color: #fff;
}
table th {
    background-color: #0d6efd;
    color: white;
}
.btn-primary, .btn-success, .btn-danger, .btn-secondary {
    border-radius: 4px;
}
