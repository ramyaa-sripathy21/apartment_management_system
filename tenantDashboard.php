<?php
session_start();
include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['tenant_name'] ?? 'Tenant';

// available apartments
$result = $conn->query("SELECT * FROM apartment WHERE Availability_Status='Available'");

// booked apartments
$tenant_id = $_SESSION['tenant_id'];
$booked = $conn->query("
    SELECT a.* 
    FROM tenant_apartment_booking t
    JOIN apartment a ON t.Apartment_No = a.Apartment_No
    WHERE t.Tenant_ID = '$tenant_id'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Tenant Dashboard</title>

<style>
body { margin:0; font-family:Segoe UI; background:#f4f7fc; }

.sidebar {
    width:230px; height:100vh; position:fixed;
    background:#2c3e50; color:white; padding:20px;
}
.sidebar a {
    display:block; padding:10px; margin:8px 0;
    color:white; text-decoration:none;
}
.sidebar a:hover { background:#34495e; }

.main { margin-left:250px; padding:20px; }

.card {
    background:white; padding:20px; border-radius:10px;
    margin-bottom:20px;
}

table { width:100%; border-collapse:collapse; }
th,td { padding:12px; border-bottom:1px solid #ddd; }
th { background:#3498db; color:white; }

button {
    background:#2ecc71; color:white;
    border:none; padding:8px 12px;
}
</style>

</head>
<body>

<div class="sidebar">
<h2><?= $name ?></h2>
<a href="tenantDashboard.php">Apartments</a>
<a href="makePayment.php">Payment</a>
<a href="maintenanceRequest.php">Maintenance</a>
<a href="logout.php">Logout</a>
</div>

<div class="main">

<?php if (isset($_GET['booked'])): ?>
<script>alert("✅ Apartment booked successfully!");</script>
<?php endif; ?>

<h1>Welcome, <?= $name ?></h1>

<!-- AVAILABLE -->
<div class="card">
<h3>Available Apartments</h3>

<table>
<tr><th>No</th><th>Floor</th><th>Rent</th><th>Action</th></tr>

<?php while($row=$result->fetch_assoc()): ?>
<tr>
<td><?= $row['Apartment_No'] ?></td>
<td><?= $row['Floor_No'] ?></td>
<td>₹<?= $row['Rent_Amount'] ?></td>
<td>
<form method="POST" action="bookApartment.php">
<input type="hidden" name="apartment_no" value="<?= $row['Apartment_No'] ?>">
<button type="submit">Book</button>
</form>
</td>
</tr>
<?php endwhile; ?>

</table>
</div>

<!-- BOOKED -->
<div class="card">
<h3>My Booked Apartments</h3>

<table>
<tr><th>No</th><th>Floor</th><th>Rent</th></tr>

<?php while($b=$booked->fetch_assoc()): ?>
<tr>
<td><?= $b['Apartment_No'] ?></td>
<td><?= $b['Floor_No'] ?></td>
<td>₹<?= $b['Rent_Amount'] ?></td>
</tr>
<?php endwhile; ?>

</table>
</div>

</div>
</body>
</html>