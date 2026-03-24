<?php ob_start(); ?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

$result = $conn->query("SELECT * FROM Payments");
?>

<!DOCTYPE html>
<html>
<head>
<title>Payments</title>
</head>
<body>

<h2>Payments</h2>

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