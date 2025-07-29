<?php
session_start();
include 'db.php';

$error = ""; // Initialize error message

// Handle login submission
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $username = mysqli_real_escape_string($conn, $username);

        // Use prepared statement for security
        $stmt = mysqli_prepare($conn, "SELECT user_id, username, password, role FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header('Location: dashboard.php');
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Please enter both username and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Cash Book System</title>
<link rel="stylesheet" href="css/style.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(135deg, #1e3c72, #2a5298);
      height: 100vh;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .logo {
  width: 100px;
  height: 100px;
  margin-bottom: 10px;
  border-radius: 50%;
  object-fit: cover;
  box-shadow: 0 0 10px rgba(0,0,0,0.3);
}

    .login-container {
      background: #fff;
      padding: 10px 20px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
      width: 50%;
      max-width: 400px;
      text-align: center;
    }
    

    .login-container h2 {
      margin-bottom: 30px;
      font-weight: bold;
    }

    .btn-primary {
      background: #0c5deaff;
      border: none;
    }

    .btn-primary:hover {
      background: #3c3f44ff;
    }

    footer {
      position: absolute;
      bottom: 0;
      width: 100%;
    }
    
  </style>
</head>

<body>

  <div class="login-container">
  <img src="logo.png" alt="Logo" class="logo" />
  <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <form method="POST" action="">
    <div class="form-group text-left">
      <label>Username</label>
      <input type="text" name="username" class="form-control" required/>
    </div>
    <div class="form-group text-left">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required/>
    </div>
    <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
    <p class="mt-3">
  <a href="reset_pswd.php" class="text-primary">Forgot Password?</a>
</p>
  </form>
</div>
  <footer class="bg-dark text-white text-center py-2 mt-5">
    &copy; <?php echo date('Y'); ?> CashBook System. All rights reserved.
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
