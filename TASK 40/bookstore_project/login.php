<?php 
session_start();
include 'includes/header.php'; 
include("config/db.php");

$error = "";

if(isset($_POST['login'])){

    $email    = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn,$query);
    $user = mysqli_fetch_assoc($result);

    if($user && password_verify($password, $user['password'])){

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role'];

        echo "<script>alert('Login Successful!');</script>";

        if($user['role'] == "admin"){
            echo "<script>window.location.href='admin/dashboard.php';</script>";
        } else {
            echo "<script>window.location.href='user/home.php';</script>";
        }

    } else {
        $error = "Invalid email or password!";
    }
}
?>

<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow">
        <div class="card-header bg-dark text-white text-center">
            <h4><i class="bi bi-box-arrow-in-right me-2"></i>Login</h4>
        </div>

        <div class="card-body">
            <?php if($error!=""){ ?>
                <div class="alert alert-danger text-center"><?php echo $error; ?></div>
            <?php } ?>

            <form method="POST">

                <label>Email</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                </div>

                <label>Password</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                </div>

                <button type="submit" name="login" class="btn btn-primary w-100">
                    Login
                </button>

                <p class="text-center mt-3">
                    Don't have an account? <a href="register.php">Register</a>
                </p>

            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>