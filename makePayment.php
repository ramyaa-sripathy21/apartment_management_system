<?php
session_start();
include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$tenant_id = $_SESSION['tenant_id'];
$name = $_SESSION['tenant_name'];

// get latest booked apartment
$sql = "
SELECT a.Apartment_No, a.Rent_Amount
FROM tenant_apartment_booking t
JOIN apartment a ON t.Apartment_No = a.Apartment_No
WHERE t.Tenant_ID = ?
ORDER BY t.Booking_Date DESC
LIMIT 1
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tenant_id);
$stmt->execute();
$res = $stmt->get_result();

$apt = $res->fetch_assoc();

// payment
if (isset($_POST['pay'])) {
    $amount = $_POST['amount'];

    $stmt2 = $conn->prepare("
        INSERT INTO Payments (Tenant_ID, Amount, Payment_Date, Payment_Status)
        VALUES (?, ?, CURDATE(), 'Paid')
    ");
    $stmt2->bind_param("id", $tenant_id, $amount);
    $stmt2->execute();

    header("Location: tenantDashboard.php");
    exit();
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