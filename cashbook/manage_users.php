<?php
session_start();
include 'db.php';
include 'navbar.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header('Location: dashboard.php');
    exit();
}

// Fetch all users
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users - Cash Book System</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2>Manage Users</h2>
        <table class="table table-bordered">
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $row['user_id']; ?>" class="btn btn-info btn-sm">Edit</a>
                        <a href="reset_password.php?id=<?php echo $row['user_id']; ?>" class="btn btn-warning btn-sm">Reset Password</a>
                        <!-- Optional delete
                        <a href="delete_user.php?id=<?php echo $row['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this user?');">Delete</a>
                        -->
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
    <footer class="bg-dark text-white text-center py-2 mt-5">
  &copy; <?php echo date('Y'); ?> CashBook System. All rights reserved.
</footer>
</body>
</html>
