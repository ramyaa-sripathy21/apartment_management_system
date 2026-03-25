<?php
session_start();
include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$tenant_id = $_SESSION['tenant_id'];
$name = $_SESSION['tenant_name'];

// fetch latest booking
$sql = "SELECT a.Apartment_No, a.Rent_Amount
FROM tenant_apartment_booking t
JOIN apartment a ON t.Apartment_No = a.Apartment_No
WHERE t.Tenant_ID = '$tenant_id'
ORDER BY t.Booking_Date DESC LIMIT 1";

$res = $conn->query($sql);
$apt = $res->fetch_assoc();

if(isset($_POST['pay'])){
    $amount = $_POST['amount'];
    $conn->query("INSERT INTO Payments (Tenant_ID, Amount, Payment_Date, Payment_Status)
    VALUES ('$tenant_id','$amount',CURDATE(),'Paid')");
    header("Location: tenantDashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Payment</title>
<style>
body { font-family:Segoe UI; background:#f4f7fc; display:flex; justify-content:center; }
.box {
    margin-top:80px; background:white; padding:25px;
    width:400px; border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}
input { width:100%; padding:10px; margin:10px 0; }
button { width:100%; padding:10px; background:#3498db; color:white; border:none; }
</style>
</head>

<body>

<div class="box">
<h2>Make Payment</h2>
<p>Welcome, <b><?= $name ?></b></p>

<p><b>Apartment:</b> <?= $apt['Apartment_No'] ?? 'N/A' ?></p>
<p><b>Rent:</b> ₹<?= $apt['Rent_Amount'] ?? 'N/A' ?></p>

<form method="POST">
<input type="number" name="amount" value="<?= $apt['Rent_Amount'] ?? '' ?>" required>
<button name="pay">Pay</button>
</form>

<a href="tenantDashboard.php">Back</a>
</div>

</body>
</html>