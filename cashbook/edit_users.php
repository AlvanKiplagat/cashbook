<?php
session_start();
include 'db.php';
include 'navbar.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header('Location: dashboard.php');
    exit();
}

$id = $_GET['id'];

if (isset($_POST['update'])) {
    $role = $_POST['role'];
    mysqli_query($conn, "UPDATE users SET role='$role' WHERE user_id=$id");
    header('Location: manage_users.php');
    exit();
}

// Fetch user details
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE user_id=$id"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User - Cash Book System</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2>Edit User Role</h2>
        <form method="POST">
            <div class="form-group">
                <label>Username: <?php echo $user['username']; ?></label>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="User" <?php if($user['role']=='User') echo 'selected'; ?>>User</option>
                    <option value="Admin" <?php if($user['role']=='Admin') echo 'selected'; ?>>Admin</option>
                </select>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update Role</button>
            <a href="manage_users.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <footer class="bg-dark text-white text-center py-2 mt-5">
  &copy; <?php echo date('Y'); ?> CashBook System. All rights reserved.
</footer>
</body>
</html>
