<?php
session_start();
include 'db.php';
include 'navbar.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Daily Summary
$today = date('Y-m-d');
$query_daily = "
    SELECT 
        SUM(CASE WHEN type='Receipt' THEN amount ELSE 0 END) AS total_receipts,
        SUM(CASE WHEN type='Payment' THEN amount ELSE 0 END) AS total_payments
    FROM transactions
    WHERE date='$today'
";
$result_daily = mysqli_query($conn, $query_daily);
$daily = mysqli_fetch_assoc($result_daily);
$daily_balance = ($daily['total_receipts'] ?? 0) - ($daily['total_payments'] ?? 0);

// Monthly Summary
$month = date('Y-m');
$query_monthly = "
    SELECT 
        SUM(CASE WHEN type='Receipt' THEN amount ELSE 0 END) AS total_receipts,
        SUM(CASE WHEN type='Payment' THEN amount ELSE 0 END) AS total_payments
    FROM transactions
    WHERE DATE_FORMAT(date, '%Y-%m') = '$month'
";
$result_monthly = mysqli_query($conn, $query_monthly);
$monthly = mysqli_fetch_assoc($result_monthly);
$monthly_balance = ($monthly['total_receipts'] ?? 0) - ($monthly['total_payments'] ?? 0);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Financial Reports - Cash Book System</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2>Financial Reports</h2>

        <div class="mt-4">
            <h4>Daily Summary (<?php echo date('d M Y'); ?>)</h4>
            <table class="table table-bordered">
                <tr>
                    <th>Total Receipts</th>
                    <td>Ksh <?php echo number_format($daily['total_receipts'] ?? 0, 2); ?></td>
                </tr>
                <tr>
                    <th>Total Payments</th>
                    <td>Ksh <?php echo number_format($daily['total_payments'] ?? 0, 2); ?></td>
                </tr>
                <tr>
                    <th>Net Balance</th>
                    <td>Ksh <?php echo number_format($daily_balance, 2); ?></td>
                </tr>
            </table>
        </div>

        <div class="mt-4">
            <h4>Monthly Summary (<?php echo date('F Y'); ?>)</h4>
            <table class="table table-bordered">
                <tr>
                    <th>Total Receipts</th>
                    <td>Ksh <?php echo number_format($monthly['total_receipts'] ?? 0, 2); ?></td>
                </tr>
                <tr>
                    <th>Total Payments</th>
                    <td>Ksh <?php echo number_format($monthly['total_payments'] ?? 0, 2); ?></td>
                </tr>
                <tr>
                    <th>Net Balance</th>
                    <td>Ksh <?php echo number_format($monthly_balance, 2); ?></td>
                </tr>
            </table>
        </div>

        <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>
    <footer class="bg-dark text-white text-center py-2 mt-5">
  &copy; <?php echo date('Y'); ?> CashBook System. All rights reserved.
</footer>
</body>
</html>
