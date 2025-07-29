<?php
session_start();
include 'db.php';
include 'navbar.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header('Location: dashboard.php');
    exit();
}

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Check if username already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Username already exists.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$hash', '$role')";
        if (mysqli_query($conn, $query)) {
            $success = "User registered successfully.";
        } else {
            $error = "Failed to register user.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register User - Cash Book System</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2>Register New User</h2>

        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="User">User</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <button type="submit" name="register" class="btn btn-primary">Register User</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <footer class="bg-dark text-white text-center py-2 mt-5">
  &copy; <?php echo date('Y'); ?> CashBook System. All rights reserved.
</footer>
</body>
</html>
