<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Fetch payments
$result = $conn->query("SELECT * FROM Payments");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Payments</title>

<style>
body {
    font-family: Arial;
    background: #f4f6f9;
}

.container {
    width: 85%;
    margin: 40px auto;
    background: white;
    padding: 20px;
    border-radius: 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
}

th {
    background: #007bff;
    color: white;
}
</style>

</head>
<body>

<div class="container">

<h2>Manage Payments</h2>

<table>
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

</div>

</body>
</html>