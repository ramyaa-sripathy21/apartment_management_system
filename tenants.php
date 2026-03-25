<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

$result = $conn->query("SELECT * FROM tenant");

if (isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO tenant (Name, Contact, Lease_Start_Date, Lease_End_Date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $_POST['name'], $_POST['contact'], $_POST['start'], $_POST['end']);
    $stmt->execute();
    header("Location: tenants.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tenants</title>
<style>
body { font-family: Arial; background:#f4f7fc; }
.container { margin-left:260px; padding:20px; }
.card { background:white; padding:20px; border-radius:10px; margin-bottom:20px; }
input { width:100%; padding:10px; margin:8px 0; }
button { padding:10px; background:green; color:white; border:none; width:100%; }
table { width:100%; border-collapse:collapse; }
th,td { padding:10px; border:1px solid #ddd; }
</style>
</head>

<body>

<div class="container">

<div class="card">
<h2>Add Tenant</h2>
<form method="POST">
<input name="name" placeholder="Name" required>
<input name="contact" placeholder="Contact" required>
<input name="start" type="date" required>
<input name="end" type="date" required>
<button name="add">Add Tenant</button>
</form>
</div>

<div class="card">
<h2>All Tenants</h2>
<table>
<tr><th>Name</th><th>Contact</th><th>Start</th><th>End</th></tr>
<?php while($t=$result->fetch_assoc()): ?>
<tr>
<td><?= $t['Name'] ?></td>
<td><?= $t['Contact'] ?></td>
<td><?= $t['Lease_Start_Date'] ?></td>
<td><?= $t['Lease_End_Date'] ?></td>
</tr>
<?php endwhile; ?>
</table>
</div>

</div>
</body>
</html>