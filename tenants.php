<?php
include("db.php");

// FETCH AVAILABLE APARTMENTS (FIXED)
$apartments = mysqli_query($conn, "
SELECT * FROM apartments 
WHERE LOWER(status) = 'available'
");

// ADD TENANT
if(isset($_POST['addTenant'])){
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $apartment_id = $_POST['apartment_id'];

    mysqli_query($conn, "INSERT INTO tenants (name, contact, start_date, end_date, apartment_id)
    VALUES ('$name','$contact','$start','$end','$apartment_id')");

    mysqli_query($conn, "UPDATE apartments SET status='Occupied' WHERE id=$apartment_id");

    header("Location: tenants.php");
}

// DROP TENANT
if(isset($_GET['drop'])){
    $tenant_id = $_GET['drop'];

    $get = mysqli_query($conn, "SELECT apartment_id FROM tenants WHERE id=$tenant_id");
    $row = mysqli_fetch_assoc($get);
    $apartment_id = $row['apartment_id'];

    mysqli_query($conn, "UPDATE apartments SET status='Available' WHERE id=$apartment_id");
    mysqli_query($conn, "DELETE FROM tenants WHERE id=$tenant_id");

    header("Location: tenants.php");
}

// FETCH TENANTS
$result = mysqli_query($conn, "
SELECT tenants.*, apartments.apartment_no 
FROM tenants 
LEFT JOIN apartments ON tenants.apartment_id = apartments.id
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Tenants</title>

<style>
body { display:flex; background:#f4f6f9; font-family:Segoe UI; }
.sidebar { width:230px; background:#1e1e2f; color:#fff; padding:20px; height:100vh; }
.sidebar a { display:block; color:#ccc; margin:10px 0; text-decoration:none; }
.main { flex:1; padding:30px; }
.card { background:#fff; padding:25px; border-radius:10px; margin-bottom:20px; }
input,select { width:100%; padding:10px; margin:8px 0; }
button { width:100%; padding:10px; background:#2196F3; color:#fff; border:none; }
table { width:100%; border-collapse:collapse; }
th,td { padding:10px; border-bottom:1px solid #ddd; }
.drop-btn { background:red; color:#fff; padding:5px 8px; text-decoration:none; }
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
<h2>Add Tenant</h2>

<form method="POST">
<input type="text" name="name" placeholder="Name" required>
<input type="text" name="contact" placeholder="Contact" required>
<input type="date" name="start" required>
<input type="date" name="end" required>

<select name="apartment_id" required>
<option value="">Select Apartment</option>

<?php while($apt = mysqli_fetch_assoc($apartments)) { ?>
<option value="<?php echo $apt['id']; ?>">
<?php echo $apt['apartment_no']; ?>
</option>
<?php } ?>

</select>

<button name="addTenant">Add Tenant</button>
</form>
</div>

<div class="card">
<h2>All Tenants</h2>

<table>
<tr>
<th>Name</th>
<th>Contact</th>
<th>Apartment</th>
<th>Start</th>
<th>End</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['contact']; ?></td>
<td><?php echo $row['apartment_no']; ?></td>
<td><?php echo $row['start_date']; ?></td>
<td><?php echo $row['end_date']; ?></td>

<td>
<a href="?drop=<?php echo $row['id']; ?>" 
onclick="return confirm('Vacate this apartment?')" 
class="drop-btn">Drop</a>
</td>
</tr>
<?php } ?>

</table>
</div>

</div>

</body>
</html>