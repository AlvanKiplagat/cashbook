<?php
session_start();
include 'db.php';
include 'navbar.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: view_transactions.php');
    exit();
}

// Check if transaction ID is provided
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Delete the transaction
    $query = "DELETE FROM transactions WHERE trans_id = '$id'";
    if (mysqli_query($conn, $query)) {
        header('Location: view_transactions.php');
        exit();
    } else {
        echo "Failed to delete transaction.";
    }
} else {
    echo "No transaction ID provided.";
}
?>
