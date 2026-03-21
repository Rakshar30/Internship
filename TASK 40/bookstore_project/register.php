<?php 
session_start();
include 'includes/header.php'; 
include("config/db.php");

// Block admin from accessing register page
if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"){
    echo "<script>alert('Admin cannot access registration page');
    window.location.href='login.php';</script>";
    exit();
}

$success = "";
$error = "";

if(isset($_POST['register'])){

    $name       = $_POST['name'];
    $email      = $_POST['email'];
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone      = $_POST['phone'];
    $address    = $_POST['address'];

    // ❗ Block admin email from registering
    if($email === "admin@gmail.com"){
        $error = "This email belongs to admin. Users cannot register using admin email.";
    } 
    else {
        // Insert only CUSTOMER
        $query = "INSERT INTO users(name,email,password,phone,address,role)
                  VALUES('$name','$email','$password','$phone','$address','customer')";
        
        if(mysqli_query($conn,$query)){
            $success = "Registration successful! You can now login.";
        }
    }
}
?>

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h4><i class="bi bi-person-plus me-2"></i>User Registration</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="">

                <?php if($error != "") { ?>
                <div class="alert alert-danger text-center">
                    <?php echo $error; ?>
                </div>
                <?php } ?>

                <?php if($success != "") { ?>
                <div class="alert alert-success text-center">
                    <?php echo $success; ?>
                    <a href="login.php" class="btn btn-success btn-sm w-100 mt-2">Login Now</a>
                </div>
                <?php } ?>

                <label>Name</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
                </div>

                <label>Email</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                </div>

                <label>Phone</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                    <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number" required>
                </div>

                <label>Address</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                    <input type="text" name="address" class="form-control" placeholder="Enter your Address" required>
                </div>

                <label>Password</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Create Password" required>
                </div>

                <button type="submit" name="register" class="btn btn-success w-100 mb-2">
                    <i class="bi bi-person-check me-1"></i> Register
                </button>

            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>