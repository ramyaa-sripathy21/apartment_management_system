<?php
include("db.php");

// MARK AS PAID
if(isset($_GET['pay'])){
    $id = $_GET['pay'];
    mysqli_query($conn, "UPDATE payments SET status='Paid' WHERE id=$id");
}

// FETCH PAYMENTS WITH TENANT NAME
$result = mysqli_query($conn, "
    SELECT payments.*, tenants.name 
    FROM payments
    LEFT JOIN tenants ON payments.tenant_id = tenants.id
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
th,td { padding:12px; border-bottom:1px solid #ddd; }
.status { padding:5px 10px; border-radius:6px; }
.pending { background:#fff3cd; }
.paid { background:#d4edda; }
.btn { padding:6px 10px; background:#2196F3; color:#fff; text-decoration:none; border-radius:5px; }
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
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td>₹<?php echo $row['amount']; ?></td>
<td><?php echo $row['date']; ?></td>

<td>
<?php if($row['status']=='Pending'){ ?>
<span class="status pending">Pending</span>
<?php } else { ?>
<span class="status paid">Paid</span>
<?php } ?>
</td>

<td>
<?php if($row['status']=='Pending'){ ?>
<a href="?pay=<?php echo $row['id']; ?>" class="btn">Mark Paid</a>
<?php } else { echo "✔"; } ?>
</td>
</tr>
<?php } ?>

</table>
</div>
</div>
</body>
</html>