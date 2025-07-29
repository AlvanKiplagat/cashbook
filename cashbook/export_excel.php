<?php
session_start();
include 'db.php';
include 'navbar.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Set headers to download as Excel file
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=transactions_report.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Fetch transactions
$query = "SELECT * FROM transactions ORDER BY date DESC";
$result = mysqli_query($conn, $query);

// Output table
echo "<table border='1'>";
echo "<tr>
        <th>Date</th>
        <th>Description</th>
        <th>Type</th>
        <th>Category</th>
        <th>Amount</th>
        <th>Account</th>
      </tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>".$row['date']."</td>";
    echo "<td>".htmlspecialchars($row['description'])."</td>";
    echo "<td>".$row['type']."</td>";
    echo "<td>".htmlspecialchars($row['category'])."</td>";
    echo "<td>".$row['amount']."</td>";
    echo "<td>".$row['account']."</td>";
    echo "</tr>";
}
echo "</table>";
exit();
?>
