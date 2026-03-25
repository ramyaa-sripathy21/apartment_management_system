<?php
session_start();
include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$tenant_id = $_SESSION['tenant_id'];
$name = $_SESSION['tenant_name'] ?? 'Tenant';

// ✅ Check tenant exists (fix FK error)
$check = $conn->prepare("SELECT Tenant_ID FROM tenant WHERE Tenant_ID=?");
$check->bind_param("i", $tenant_id);
$check->execute();
$resCheck = $check->get_result();

if ($resCheck->num_rows == 0) {
    die("Tenant not found!");
}

// ✅ Get latest booked apartment
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

$amount = $apt['Rent_Amount'] ?? 0;

// ✅ UPI QR GENERATION
$upi_id = "ramya@oksbi"; // 🔴 CHANGE THIS
$name_upi = "ApartmentRent";

$upi_link = "upi://pay?pa=$upi_id&pn=$name_upi&am=$amount&cu=INR";
$qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($upi_link);

// ✅ Handle payment
if (isset($_POST['pay'])) {

    $amount = $_POST['amount'];
    $method = $_POST['method'];

    $status = "Paid via " . $method;

    $stmt2 = $conn->prepare("
        INSERT INTO Payments (Tenant_ID, Amount, Payment_Date, Payment_Status)
        VALUES (?, ?, CURDATE(), ?)
    ");

    $stmt2->bind_param("ids", $tenant_id, $amount, $status);
    $stmt2->execute();

    header("Location: tenantDashboard.php?paid=1");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Make Payment</title>

<style>
body {
    font-family: 'Segoe UI';
    background:#f4f7fc;
    display:flex;
    justify-content:center;
}

.box {
    margin-top:60px;
    background:white;
    padding:25px;
    width:420px;
    border-radius:12px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
    text-align:center;
}

h2 { margin-bottom:10px; }

.info {
    background:#f1f1f1;
    padding:10px;
    border-radius:8px;
    margin:10px 0;
}

.qr {
    margin:15px 0;
}

input {
    width:100%;
    padding:10px;
    margin:10px 0;
    border-radius:6px;
    border:1px solid #ccc;
}

button {
    width:100%;
    padding:12px;
    margin-top:10px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-size:15px;
}

.upi { background:#2ecc71; color:white; }
.card { background:#3498db; color:white; }
.cash { background:#e67e22; color:white; }

a {
    display:block;
    margin-top:15px;
    text-decoration:none;
}
</style>

</head>

<body>

<div class="box">

<h2>💳 Make Payment</h2>

<p>Welcome, <b><?= $name ?></b></p>

<div class="info">
<p><b>Apartment:</b> <?= $apt['Apartment_No'] ?? 'N/A' ?></p>
<p><b>Rent:</b> ₹<?= $amount ?></p>
</div>

<!-- ✅ REAL QR CODE -->
<div class="qr">
<img src="<?= $qr_url ?>" alt="UPI QR">
<p>Scan using GPay / PhonePe / Paytm</p>
</div>

<form method="POST">

<input type="number" name="amount" value="<?= $amount ?>" required>

<button class="upi" name="method" value="UPI">✅ Paid via UPI</button>
<button class="card" name="method" value="Card">💳 Paid via Card</button>
<button class="cash" name="method" value="Cash">💵 Paid via Cash</button>

<input type="hidden" name="pay" value="1">

</form>

<a href="tenantDashboard.php">⬅ Back</a>

</div>

</body>
</html>