<?php
include("db.php");

// FETCH PAYMENTS WITH TENANT NAME
$result = mysqli_query($conn, "
SELECT 
    payments.*, 
    tenants.name AS tenant_name
FROM payments
LEFT JOIN tenants 
ON payments.tenant_id = tenants.id
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Payments</title>

<style>
body { display:flex; background:#f4f6f9; font-family:Segoe UI; }
.sidebar { width:230px; background:#1e1e2f; color:#fff; padding:20px; height:100vh; }
.sidebar a { display:block; color:#ccc; margin:10px 0; text-decoration:none; }
.main { flex:1; padding:30px; }
.card { background:#fff; padding:25px; border-radius:10px; }
table { width:100%; border-collapse:collapse; }
th,td { padding:10px; border-bottom:1px solid #ddd; }
.status { background:#c8e6c9; padding:5px 10px; border-radius:5px; }
</style>
</head>

<body>

<div class="sidebar">
<h2>Admin Panel</h2>
<a href="adminDashboard.php">Dashboard</a>
<a href="apartments.php">Apartments</a>
<a href="tenants.php">Tenants</a>
<a href="payments.php">Payments</a>
<a href="maintenance.php">Maintenance</a>
</div>

<div class="main">
<div class="card">
<h2>Payments</h2>

<table>
<tr>
<th>ID</th>
<th>Tenant</th>
<th>Amount</th>
<th>Date</th>
<th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?php echo $row['id']; ?></td>

<td>
<?php echo !empty($row['tenant_name']) ? $row['tenant_name'] : 'Unknown'; ?>
</td>

<td>₹<?php echo $row['amount']; ?></td>
<td><?php echo $row['date']; ?></td>

<td>
<span class="status"><?php echo $row['status']; ?></span>
</td>

</tr>
<?php } ?>

</table>
</div>
</div>

</body>
</html>