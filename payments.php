<?php
ob_start(); // MUST be first line, no space before this

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Check admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Fetch payments
$sql = "SELECT * FROM Payments";
$result = $conn->query($sql);

if (!$result) {
    die("Query Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Payments</title>
</head>

<body>

<h2>Manage Payments</h2>

<table border="1">
<tr>
    <th>ID</th>
    <th>Tenant</th>
    <th>Amount</th>
    <th>Date</th>
    <th>Status</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['Payment_ID']; ?></td>
    <td><?php echo $row['Tenant_ID']; ?></td>
    <td><?php echo $row['Amount']; ?></td>
    <td><?php echo $row['Payment_Date']; ?></td>
    <td><?php echo $row['Payment_Status']; ?></td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>