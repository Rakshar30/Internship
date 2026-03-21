<?php 
session_start();
include("../config/db.php");
include '../includes/header.php';

$error = "";

if(isset($_POST['admin_login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

/*--------------CHECK ADMIN-----------------*/
    $query = "SELECT * FROM users WHERE email='$email' AND role='admin'";
    $result = mysqli_query($conn, $query);

    $admin = mysqli_fetch_assoc($result);

    if($admin && password_verify($password, $admin['password'])){
        
/*--------------SESSION -----------------*/
        $_SESSION['user_id']  = $admin['id'];
        $_SESSION['role']     = $admin['role'];

        echo "<script>
            alert('Admin Login Successful!');
            window.location.href='dashboard.php';
        </script>";

    } else {
        $error = "Invalid admin login! Check email or password.";
    }
}
?>

<style>
    .admin-login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
    }

    .admin-login-box {
        background: #ffffff;
        padding: 35px;
        width: 380px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
</style>

<div class="admin-login-container">

    <div class="admin-login-box">

        <h3 class="text-center mb-4">Admin Login</h3>

        <?php if($error != ""){ ?>
            <div class="alert alert-danger text-center"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Admin Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter admin email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>

            <button type="submit" name="admin_login" class="btn btn-dark w-100 mt-2">
                Login
            </button>

        </form>

    </div>

</div>

<?php include '../includes/footer.php'; ?>