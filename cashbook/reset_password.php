<?php
session_start();
include 'db.php';
include 'navbar.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header('Location: dashboard.php');
    exit();
}

$id = $_GET['id'];

if (isset($_POST['reset'])) {
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($conn, "UPDATE users SET password='$hash' WHERE user_id=$id");
    header('Location: manage_users.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password - Cash Book System</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2>Reset User Password</h2>
        <form method="POST">
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" class="form-control" required/>
            </div>
            <button type="submit" name="reset" class="btn btn-warning">Reset Password</button>
            <a href="manage_users.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <footer class="bg-dark text-white text-center py-2 mt-5">
  &copy; <?php echo date('Y'); ?> CashBook System. All rights reserved.
</footer>
</body>
</html>
