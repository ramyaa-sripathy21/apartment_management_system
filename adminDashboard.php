<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// counts
$a = $conn->query("SELECT COUNT(*) as c FROM apartment")->fetch_assoc()['c'];
$t = $conn->query("SELECT COUNT(*) as c FROM tenant")->fetch_assoc()['c'];
$p = $conn->query("SELECT COUNT(*) as c FROM Payments")->fetch_assoc()['c'];
$m = $conn->query("SELECT COUNT(*) as c FROM maintenance")->fetch_assoc()['c'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<style>
body { font-family: Arial; margin:0; background:#1e3c72; color:white; }
.sidebar {
    width:250px; position:fixed; height:100%;
    background:#222; padding:20px;
}
.sidebar a { color:white; display:block; margin:15px 0; text-decoration:none; }
.container { margin-left:260px; padding:20px; }
.card {
    background:linear-gradient(135deg,#43cea2,#185a9d);
    padding:20px; border-radius:10px; margin:10px;
    display:inline-block; width:250px; text-align:center;
}
</style>
</head>

<body>

<div class="sidebar">
<h3>Admin</h3>
<a href="apartments.php">Apartments</a>
<a href="tenants.php">Tenants</a>
<a href="payments.php">Payments</a>
<a href="maintenance.php">Maintenance</a>
<a href="logout.php">Logout</a>
</div>

<div class="container">
<h1>Welcome Admin</h1>

<div class="card">Apartments<br><h2><?= $a ?></h2></div>
<div class="card">Tenants<br><h2><?= $t ?></h2></div>
<div class="card">Payments<br><h2><?= $p ?></h2></div>
<div class="card">Maintenance<br><h2><?= $m ?></h2></div>

</div>

</body>
</html>