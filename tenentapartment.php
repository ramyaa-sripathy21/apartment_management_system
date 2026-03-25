<?php
session_start();
include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$tenant_id = $_SESSION['tenant_id'];

// FETCH TENANT APARTMENT
$result = mysqli_query($conn, "
SELECT a.*
FROM tenants t
JOIN apartments a ON t.apartment_id = a.id
WHERE t.id = $tenant_id
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Your Apartment</title>

<style>
body { display:flex; margin:0; font-family:Segoe UI; background:#f4f6f9; }

.sidebar {
    width:230px;
    background:#1e1e2f;
    color:#fff;
    padding:20px;
    height:100vh;
}

.sidebar a {
    display:block;
    color:#ccc;
    margin:12px 0;
    text-decoration:none;
}

.sidebar a:hover { color:#fff; }

.main { flex:1; padding:30px; }

.card {
    background:#fff;
    padding:20px;
    border-radius:10px;
}

table { width:100%; border-collapse:collapse; }

th,td {
    padding:10px;
    border-bottom:1px solid #ddd;
}

th { background:#f1f1f1; }

.logout { color:red !important; }
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
<h2>Tenant Panel</h2>
<a href="tenantDashboard.php">Dashboard</a>
<a href="tenantApartment.php">Apartment</a>
<a href="makePayment.php">Payments</a>
<a href="maintenanceRequest.php">Maintenance</a>
<a href="logout.php" class="logout">Logout</a>
</div>

<!-- MAIN -->
<div class="main">
<h2>Your Apartment</h2>

<div class="card">

<table>
<tr>
<th>Apartment No</th>
<th>Floor</th>
<th>Rent</th>
</tr>

<?php 
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)) { 
?>
<tr>
<td><?php echo $row['apartment_no']; ?></td>
<td><?php echo $row['floor']; ?></td>
<td>₹<?php echo $row['rent']; ?></td>
</tr>
<?php } 
} else { ?>
<tr>
<td colspan="3" style="text-align:center;">No Apartment Assigned</td>
</tr>
<?php } ?>

</table>

</div>
</div>

</body>
</html>