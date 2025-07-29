<?php
session_start();
include 'db.php';
include 'navbar.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Fetch all transactions
$query = "SELECT t.*, u.username FROM transactions t
          JOIN users u ON t.user_id = u.user_id
          ORDER BY t.date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Transactions - Cash Book System</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2>All Transactions</h2>

        <table class="table table-striped">
    <thead>
        <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Type</th>
            <th>Category</th>
            <th>Amount</th>
            <th>Account</th>
            <th>Recorded By</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($trans = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $trans['date']; ?></td>
                <td><?php echo htmlspecialchars($trans['description']); ?></td>
                <td><?php echo $trans['type']; ?></td>
                <td><?php echo htmlspecialchars($trans['category']); ?></td>
                <td>Ksh <?php echo number_format($trans['amount'], 2); ?></td>
                <td><?php echo $trans['account']; ?></td>
                <td><?php echo $trans['username']; ?></td>
                <td>
                    <a href="edit_transaction.php?id=<?php echo $trans['trans_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <?php if ($_SESSION['role'] == 'Admin') { ?>
                    <a href="delete_transaction.php?id=<?php echo $trans['trans_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this transaction?');">Delete</a>
                    <?php } ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<div class="text-center mt-3">
  <a href="export_excel.php" class="btn btn-success">
    Download Excel
  </a>
</div>
   <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
    <footer class="bg-dark text-white text-center py-2 mt-5">
  &copy; <?php echo date('Y'); ?> CashBook System. All rights reserved.
</footer>
</body>
</html>
