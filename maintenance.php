<?php
include("db.php");

// MARK DONE
if(isset($_GET['done'])){
    $id = $_GET['done'];
    mysqli_query($conn, "UPDATE maintenance SET status='Completed' WHERE id=$id");
}

// FETCH WITH TENANT NAME
$result = mysqli_query($conn, "
    SELECT maintenance.*, tenants.name 
    FROM maintenance
    LEFT JOIN tenants ON maintenance.tenant_id = tenants.id
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
th,td { padding:12px; border-bottom:1px solid #ddd; }
.status { padding:5px 10px; border-radius:6px; }
.pending { background:#fff3cd; }
.done { background:#d4edda; }
.btn { padding:6px 10px; background:#28a745; color:#fff; text-decoration:none; border-radius:5px; }
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

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['issue']; ?></td>

<td>
<?php if($row['status']=='Pending'){ ?>
<span class="status pending">Pending</span>
<?php } else { ?>
<span class="status done">Completed</span>
<?php } ?>
</td>

<td>
<?php if($row['status']=='Pending'){ ?>
<a href="?done=<?php echo $row['id']; ?>" class="btn">Mark Done</a>
<?php } else { echo "✔"; } ?>
</td>
</tr>
<?php } ?>

</table>
</div>
</div>
</body>
</html>