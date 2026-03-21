<?php 
session_start();
include("../config/db.php");

/*--------------ALLOW ADMIN-----------------*/
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

include '../includes/admin_header.php';
?>

<h2 class="mb-4">Manage Users</h2>
<hr>

<div class="admin-table-box">
    <div class="table-responsive">

        <table class="table admin-table table-hover">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Joined On</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

            <?php
            
/*--------------FETCH NON ADMIN USERS I.E CUSTOMERS-----------------*/
            $query = "SELECT * FROM users WHERE role='customer' ORDER BY id DESC";
            $users = mysqli_query($conn, $query);

            if(mysqli_num_rows($users) > 0){
                while($u = mysqli_fetch_assoc($users)){
            ?>

                <tr>
                    <td><?php echo $u['id']; ?></td>
                    <td><?php echo $u['name']; ?></td>
                    <td><?php echo $u['email']; ?></td>
                    <td><?php echo $u['phone']; ?></td>
                    <td><?php echo $u['address']; ?></td>
                    <td><?php echo $u['created_at']; ?></td>

                    <td>

                        <a href="delete_user.php?id=<?php echo $u['id']; ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Are you sure you want to delete this user?');">
                           Delete
                        </a>
                    </td>
                </tr>

            <?php 
                } 
            } else { 
            ?>

                <tr>
                    <td colspan="7" class="text-center">No users found</td>
                </tr>

            <?php } ?>

            </tbody>

        </table>

        <nav class="mt-3">
            <ul class="pagination justify-content-end">
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
            </ul>
        </nav>

    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>