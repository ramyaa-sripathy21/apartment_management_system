<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

$result = $conn->query("SELECT * FROM maintenance_requests");
?>

<!DOCTYPE html>
<html>
<head>
<title>Maintenance</title>
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
<h2>Maintenance Requests</h2>

<table>
<tr><th>ID</th><th>Tenant</th><th>Issue</th><th>Status</th></tr>

<?php if($result): ?>
<?php while($m=$result->fetch_assoc()): ?>
<tr>
<td><?= $m['Request_ID'] ?></td>
<td><?= $m['Tenant_ID'] ?></td>
<td><?= $m['Issue_Description'] ?></td>
<td><?= $m['Status'] ?></td>
</tr>
<?php endwhile; ?>
<?php endif; ?>

</table>

</div>
</div>

</body>
</html>