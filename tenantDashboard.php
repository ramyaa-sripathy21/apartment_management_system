<?php
session_start();
include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['tenant_name'];
$tenant_id = $_SESSION['tenant_id'];

// AVAILABLE APARTMENTS
$apartments = mysqli_query($conn, "
SELECT * FROM apartments WHERE status='available'
");

// BOOKED APARTMENT
$booked = mysqli_query($conn, "
SELECT a.*
FROM tenants t
JOIN apartments a ON t.apartment_id = a.id
WHERE t.id = $tenant_id
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Tenant Dashboard</title>

<style>
body { display:flex; margin:0; font-family:Segoe UI; background:#f4f6f9; }

/* SIDEBAR */
.sidebar {
    width:230px;
    background:#1e1e2f;
    color:#fff;
    padding:20px;
    height:100vh;
}

.sidebar h2 { margin-bottom:20px; }

.sidebar a {
    display:block;
    color:#ccc;
    margin:12px 0;
    text-decoration:none;
}

.sidebar a:hover { color:#fff; }

/* MAIN */
.main {
    flex:1;
    padding:30px;
}

.card {
    background:#fff;
    padding:20px;
    border-radius:10px;
    margin-bottom:25px;
}

/* TABLE */
table { width:100%; border-collapse:collapse; }

th,td {
    padding:10px;
    border-bottom:1px solid #ddd;
}

th { background:#f1f1f1; }

/* BUTTON */
button {
    background:#28a745;
    color:white;
    border:none;
    padding:6px 10px;
    border-radius:5px;
}

/* LOGOUT */
.logout {
    color:red !important;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
<h2>Tenant Panel</h2>
<a href="tenantDashboard.php">Dashboard</a>
<a href="makePayment.php">Payments</a>
<a href="maintenanceRequest.php">Maintenance</a>
<a href="logout.php" class="logout">Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<h2>Welcome, <?php echo $name; ?></h2>

<!-- AVAILABLE -->
<div class="card">
<h3>Available Apartments</h3>

<table>
<tr>
<th>Apartment No</th>
<th>Floor</th>
<th>Rent</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($apartments)) { ?>
<tr>
<td><?php echo $row['apartment_no']; ?></td>
<td><?php echo $row['floor']; ?></td>
<td>₹<?php echo $row['rent']; ?></td>

<td>
<form method="POST" action="bookApartment.php">
<input type="hidden" name="apartment_id" value="<?php echo $row['id']; ?>">
<button>Book</button>
</form>
</td>
</tr>
<?php } ?>

</table>
</div>

<!-- BOOKED -->
<div class="card">
<h3>Your Apartment</h3>

<table>
<tr>
<th>Apartment No</th>
<th>Floor</th>
<th>Rent</th>
</tr>

<?php while($row = mysqli_fetch_assoc($booked)) { ?>
<tr>
<td><?php echo $row['apartment_no']; ?></td>
<td><?php echo $row['floor']; ?></td>
<td>₹<?php echo $row['rent']; ?></td>
</tr>
<?php } ?>

</table>
</div>

</div>
</body>
</html>