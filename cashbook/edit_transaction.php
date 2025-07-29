<?php
session_start();
include 'db.php';
include 'navbar.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: view_transactions.php');
    exit();
}

$id = $_GET['id'];

// Fetch existing transaction
$query = "SELECT * FROM transactions WHERE trans_id='$id'";
$result = mysqli_query($conn, $query);
$trans = mysqli_fetch_assoc($result);

if (!$trans) {
    header('Location: view_transactions.php');
    exit();
}

// Handle update form submission
if (isset($_POST['update'])) {
    $date = $_POST['date'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $type = $_POST['type'];
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $amount = $_POST['amount'];
    $account = $_POST['account'];

    $update = "UPDATE transactions SET 
                date='$date',
                description='$description',
                type='$type',
                category='$category',
                amount='$amount',
                account='$account'
               WHERE trans_id='$id'";

    if (mysqli_query($conn, $update)) {
        header('Location: view_transactions.php');
        exit();
    } else {
        $error = "Failed to update transaction. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Transaction - Cash Book System</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2>Edit Transaction</h2>

        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" class="form-control" value="<?php echo $trans['date']; ?>" required/>
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="text" name="description" class="form-control" value="<?php echo htmlspecialchars($trans['description']); ?>" required/>
            </div>
            <div class="form-group">
                <label>Type</label>
                <select name="type" class="form-control" required>
                    <option value="Receipt" <?php if ($trans['type'] == 'Receipt') echo 'selected'; ?>>Receipt</option>
                    <option value="Payment" <?php if ($trans['type'] == 'Payment') echo 'selected'; ?>>Payment</option>
                </select>
            </div>
            <div class="form-group">
                <label>Category</label>
                <input type="text" name="category" class="form-control" value="<?php echo htmlspecialchars($trans['category']); ?>" required/>
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input type="number" step="0.01" name="amount" class="form-control" value="<?php echo $trans['amount']; ?>" required/>
            </div>
            <div class="form-group">
                <label>Account</label>
                <select name="account" class="form-control" required>
                    <option value="Cash" <?php if ($trans['account'] == 'Cash') echo 'selected'; ?>>Cash</option>
                    <option value="Bank" <?php if ($trans['account'] == 'Bank') echo 'selected'; ?>>Bank</option>
                    <option value="M-Pesa" <?php if ($trans['account'] == 'M-Pesa') echo 'selected'; ?>>M-Pesa</option>
                </select>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update Transaction</button>
            <a href="view_transactions.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <footer class="bg-dark text-white text-center py-2 mt-5">
  &copy; <?php echo date('Y'); ?> CashBook System. All rights reserved.
</footer>
</body>
</html>
