<?php
if (!isset($_SESSION)) session_start();
?>

<style>
.navbar {
    font-family: 'Roboto Slab', serif;
    text-align: center;
}

.navbar-nav .nav-link {
    font-weight: bold;
    font-size: 18px;
}

.navbar-brand {
    font-weight: bold;
    font-size: 20px;
}

.navbar-text {
    font-weight: bold;
    font-size: 18px;
}
</style>

<nav class="navbar navbar-dark bg-dark fixed-top w-100">
  <div class="container">
    <a class="navbar-brand mx-auto" href="dashboard.php">
      <img src="logo.png" width="50" height="50" class="d-inline-block align-top mr-2" alt="">
      CASHBOOK SYSTEM
    </a>
    
    <!-- Toggler button visible always -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible links -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="add_transaction.php">Add Transaction</a></li>
        <li class="nav-item"><a class="nav-link" href="view_transactions.php">Transactions</a></li>
        <li class="nav-item"><a class="nav-link" href="reports.php">Reports</a></li>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'): ?>
          <li class="nav-item"><a class="nav-link" href="manage_users.php">Manage Users</a></li>
          <li class="nav-item"><a class="nav-link" href="register.php">Register User</a></li>
        <?php endif; ?>
      </ul>
      <!-- User text and logout inside collapsible as well -->
      <ul class="navbar-nav">
        
        <li class="nav-item">
          <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
