<?php
session_start();
include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$tenant_id = $_SESSION['tenant_id'];
$name = $_SESSION['tenant_name'];

if(isset($_POST['submit'])){
    $issue = $_POST['issue'];
    $conn->query("INSERT INTO maintenance (tenant_id, issue, status)
    VALUES ('$tenant_id','$issue','Pending')");
    header("Location: tenantDashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Maintenance</title>
<style>
body { font-family:Segoe UI; background:#f4f7fc; display:flex; justify-content:center; }
.box {
    margin-top:80px; background:white; padding:25px;
    width:400px; border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}
textarea { width:100%; height:120px; margin:10px 0; }
button { width:100%; padding:10px; background:#e67e22; color:white; border:none; }
</style>
</head>

<body>

<div class="box">
<h2>Maintenance Request</h2>
<p>Welcome, <b><?= $name ?></b></p>

<form method="POST">
<textarea name="issue" placeholder="Describe issue..." required></textarea>
<button name="submit">Submit</button>
</form>

<a href="tenantDashboard.php">Back</a>
</div>

</body>
</html>