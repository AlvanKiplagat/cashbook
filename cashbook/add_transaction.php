<?php
session_start();
include 'db.php';
include 'navbar.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['add'])) {
    $date = $_POST['date'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $type = $_POST['type'];
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $amount = $_POST['amount'];
    $account = $_POST['account'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO transactions (date, description, type, category, amount, account, user_id)
              VALUES ('$date', '$description', '$type', '$category', '$amount', '$account', '$user_id')";
    
    if (mysqli_query($conn, $query)) {
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Failed to add transaction. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Transaction - Cash Book System</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2>Add Transaction</h2>

        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required/>
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="text" name="description" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Type</label>
                <select name="type" class="form-control" required>
                    <option value="">-- Select Type --</option>
                    <option value="Receipt">Receipt</option>
                    <option value="Payment">Payment</option>
                </select>
            </div>
            <div class="form-group">
                <label>Category</label>
                <input type="text" name="category" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input type="number" step="0.01" name="amount" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Account</label>
                <select name="account" class="form-control" required>
                    <option value="">-- Select Account --</option>
                    <option value="Cash">Cash</option>
                    <option value="Bank">Bank</option>
                    <option value="M-Pesa">M-Pesa</option>
                </select>
            </div>
            <button type="submit" name="add" class="btn btn-success">Add Transaction</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <footer class="bg-dark text-white text-center py-2 mt-5">
  &copy; <?php echo date('Y'); ?> CashBook System. All rights reserved.
</footer>
</body>
</html>
