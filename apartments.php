<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

$result = $conn->query("SELECT * FROM apartment");

if (isset($_POST['add_apartment'])) {
    $stmt = $conn->prepare("INSERT INTO apartment (Apartment_No, Floor_No, Rent_Amount, Availability_Status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sids", $_POST['apartment_no'], $_POST['floor_no'], $_POST['rent_amount'], $_POST['availability_status']);
    $stmt->execute();
    header("Location: apartments.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Apartments</title>
<style>
body { font-family: Arial; background:#f4f7fc; }
.container { margin-left:260px; padding:20px; }
.sidebar {
    width:250px; position:fixed; height:100%;
    background:#333; color:white; padding:20px;
}
.sidebar a { color:white; display:block; margin:10px 0; text-decoration:none; }
.card { background:white; padding:20px; border-radius:10px; margin-bottom:20px; }
input, select { width:100%; padding:10px; margin:8px 0; }
button { padding:10px; background:blue; color:white; border:none; width:100%; }
table { width:100%; border-collapse:collapse; }
th,td { padding:10px; border:1px solid #ddd; }
</style>
</head>

<body>

<div class="sidebar">
<h3>Admin</h3>
<a href="adminDashboard.php">Dashboard</a>
<a href="apartments.php">Apartments</a>
<a href="tenants.php">Tenants</a>
<a href="payments.php">Payments</a>
<a href="maintenance.php">Maintenance</a>
<a href="logout.php">Logout</a>
</div>

<div class="container">

<div class="card">
<h2>Add Apartment</h2>
<form method="POST">
<input name="apartment_no" placeholder="Apartment No" required>
<input name="floor_no" type="number" placeholder="Floor" required>
<input name="rent_amount" type="number" placeholder="Rent" required>
<select name="availability_status">
<option>Available</option>
<option>Occupied</option>
</select>
<button name="add_apartment">Add Apartment</button>
</form>
</div>

<div class="card">
<h2>All Apartments</h2>
<table>
<tr><th>No</th><th>Floor</th><th>Rent</th><th>Status</th></tr>
<?php while($row=$result->fetch_assoc()): ?>
<tr>
<td><?= $row['Apartment_No'] ?></td>
<td><?= $row['Floor_No'] ?></td>
<td><?= $row['Rent_Amount'] ?></td>
<td><?= $row['Availability_Status'] ?></td>
</tr>
<?php endwhile; ?>
</table>
</div>

</div>
</body>
</html>