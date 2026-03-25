<?php
include("db.php");

// MARK AS DONE
if(isset($_GET['done'])){
    $id = $_GET['done'];
    mysqli_query($conn, "UPDATE maintenance SET status='Completed' WHERE id=$id");
    header("Location: maintenance.php");
}

// FETCH WITH TENANT NAME
$result = mysqli_query($conn, "
SELECT 
    maintenance.*, 
    tenants.name AS tenant_name
FROM maintenance
LEFT JOIN tenants 
ON maintenance.tenant_id = tenants.id
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Maintenance</title>

<style>
body { display:flex; background:#f4f6f9; font-family:Segoe UI; }
.sidebar { width:230px; background:#1e1e2f; color:#fff; padding:20px; height:100vh; }
.sidebar a { display:block; color:#ccc; margin:10px 0; text-decoration:none; }
.main { flex:1; padding:30px; }
.card { background:#fff; padding:25px; border-radius:10px; }
table { width:100%; border-collapse:collapse; }
th,td { padding:10px; border-bottom:1px solid #ddd; }
.done-btn { background:green; color:#fff; padding:5px 8px; text-decoration:none; }
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
<h2>Maintenance Requests</h2>

<table>
<tr>
<th>ID</th>
<th>Tenant</th>
<th>Issue</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?php echo $row['id']; ?></td>

<td>
<?php echo !empty($row['tenant_name']) ? $row['tenant_name'] : 'Unknown'; ?>
</td>

<td><?php echo $row['issue']; ?></td>
<td><?php echo $row['status']; ?></td>

<td>
<?php if($row['status'] != 'Completed'){ ?>
<a href="?done=<?php echo $row['id']; ?>" class="done-btn">Done</a>
<?php } else { echo "✔"; } ?>
</td>

</tr>
<?php } ?>

</table>
</div>
</div>

</body>
</html>