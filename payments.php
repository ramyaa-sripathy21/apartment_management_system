<?php
session_start();
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
<style>
body { font-family: Arial; background:#f4f7fc; }
.container { margin-left:260px; padding:20px; }
.card { background:white; padding:20px; border-radius:10px; }
table { width:100%; border-collapse:collapse; }
th,td { padding:10px; border:1px solid #ddd; }
</style>
</head>

<body>
<div class="container">
<div class="card">
<h2>Payments</h2>
<table>
<tr><th>ID</th><th>Tenant</th><th>Amount</th><th>Date</th><th>Status</th></tr>
<?php while($p=$result->fetch_assoc()): ?>
<tr>
<td><?= $p['Payment_ID'] ?></td>
<td><?= $p['Tenant_ID'] ?></td>
<td><?= $p['Amount'] ?></td>
<td><?= $p['Payment_Date'] ?></td>
<td><?= $p['Payment_Status'] ?></td>
</tr>
<?php endwhile; ?>
</table>
</div>
</div>
</body>
</html>