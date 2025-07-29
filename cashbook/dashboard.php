<?php
session_start();
include 'db.php';
include 'navbar.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$username = $_SESSION['username'];

$accounts = ['Cash', 'Bank', 'M-Pesa'];
$balances = [];

foreach ($accounts as $account) {
    $query = "SELECT 
                SUM(CASE WHEN type='Receipt' THEN amount ELSE -amount END) as balance 
              FROM transactions 
              WHERE account='$account'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $balances[$account] = $row['balance'] ?? 0.00;
}

$today = date('Y-m-d');
$query = "SELECT * FROM transactions WHERE date='$today'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Cash Book System</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2>Welcome, <?php echo htmlspecialchars($username); ?></h2>

        <div class="row mt-4">
            <?php foreach ($balances as $account => $balance): ?>
                <div class="col-md-4">
                    <div class="card text-center mb-3">
                        <div class="card-header"><?php echo $account; ?> Balance</div>
                        <div class="card-body">
                            <h5 class="card-title">Ksh <?php echo number_format($balance, 2); ?></h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-4">
            <h4>Today's Transactions (<?php echo date('d M Y'); ?>)</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Account</th>
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
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </div>
    <footer class="bg-dark text-white text-center py-2 mt-5">
  &copy; <?php echo date('Y'); ?> CashBook System. All rights reserved.
</footer>
</body>
</html>
