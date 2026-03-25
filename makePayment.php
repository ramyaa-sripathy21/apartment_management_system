<?php
session_start();
include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$tenant_id = $_SESSION['tenant_id'];
$name = $_SESSION['tenant_name'] ?? 'Tenant';

// ✅ TOTAL RENT of all booked apartments
$sql = "
SELECT SUM(a.Rent_Amount) AS Total_Rent
FROM tenant_apartment_booking t
JOIN apartment a ON t.Apartment_No = a.Apartment_No
WHERE t.Tenant_ID = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tenant_id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

$amount = $row['Total_Rent'] ?? 0;

// UPI QR
$upi_id = "yourupi@upi"; // change
$upi_link = "upi://pay?pa=$upi_id&pn=Apartment&am=$amount&cu=INR";
$qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($upi_link);

// payment
if (isset($_POST['pay'])) {

    $method = $_POST['method'];

    $stmt2 = $conn->prepare("
        INSERT INTO Payments (Tenant_ID, Amount, Payment_Date, Payment_Status)
        VALUES (?, ?, CURDATE(), ?)
    ");

    $status = "Paid via " . $method;
    $stmt2->bind_param("ids", $tenant_id, $amount, $status);
    $stmt2->execute();

    header("Location: makePayment.php?paid=1");
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
    margin-top:60px;
    background:white;
    padding:25px;
    width:420px;
    border-radius:12px;
    text-align:center;
}

button {
    width:100%;
    padding:12px;
    margin-top:10px;
    border:none;
    color:white;
}

.upi { background:#2ecc71; }
.card { background:#3498db; }
.cash { background:#e67e22; }
</style>
</head>

<body>
<?php if (isset($_GET['paid'])): ?>
<script>
alert("✅ Payment successful!");
</script>
<?php endif; ?>
<div class="box">

<h2>💳 Total Payment</h2>

<p>Welcome, <b><?= $name ?></b></p>
<p><b>Total Rent:</b> ₹<?= $amount ?></p>

<img src="<?= $qr_url ?>" alt="QR">

<form method="POST">
<button class="upi" name="method" value="UPI">UPI</button>
<button class="card" name="method" value="Card">Card</button>
<button class="cash" name="method" value="Cash">Cash</button>
<input type="hidden" name="pay" value="1">
</form>

</div>

</body>
</html>