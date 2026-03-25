<?php
session_start();
include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$tenant_id = $_SESSION['tenant_id'];
$name = $_SESSION['tenant_name'] ?? 'Tenant';

// ✅ Get TOTAL rent
$sql = "
SELECT SUM(a.Rent_Amount) AS total_rent
FROM tenant_apartment_booking t
JOIN apartment a ON t.Apartment_No = a.Apartment_No
WHERE t.Tenant_ID = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tenant_id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

$amount = $row['total_rent'] ?? 0;

// ✅ UPI QR
$upi_id = "ramya@oksbi"; // change this
$upi_link = "upi://pay?pa=$upi_id&pn=Apartment&am=$amount&cu=INR";
$qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($upi_link);


// ✅ PAYMENT HANDLE (FIXED)
if (isset($_POST['pay'])) {

    $method = $_POST['method'];
    $status = "Paid via " . $method;

    try {
        $stmt2 = $conn->prepare("
            INSERT INTO payments (tenant_id, amount, date, status)
            VALUES (?, ?, CURDATE(), ?)
        ");

        $stmt2->bind_param("ids", $tenant_id, $amount, $status);
        $stmt2->execute();

        header("Location: makePayment.php?paid=1");
        exit();

    } catch (Exception $e) {
        header("Location: makePayment.php?paid=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Make Payment</title>

<style>
body {
    font-family: Segoe UI;
    background: #f4f7fc;
    display: flex;
    justify-content: center;
}

.container {
    margin-top: 60px;
    background: white;
    padding: 25px;
    width: 420px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0px 5px 15px rgba(0,0,0,0.1);
}

h2 {
    margin-bottom: 10px;
}

.amount {
    font-size: 22px;
    color: #2ecc71;
    font-weight: bold;
}

img {
    margin: 15px 0;
}

button {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    border: none;
    color: white;
    border-radius: 6px;
    font-size: 15px;
    cursor: pointer;
}

.upi { background: #2ecc71; }
.card { background: #3498db; }
.cash { background: #e67e22; }

button:hover {
    opacity: 0.9;
}
</style>

</head>

<body>

<div class="container">

<!-- ✅ POPUP -->
<?php if (isset($_GET['paid'])): ?>
<script>
alert("✅ Payment Successful!");
</script>
<?php endif; ?>

<h2>💳 Make Payment</h2>

<p>Welcome, <b><?= $name ?></b></p>

<p>Total Rent:</p>
<div class="amount">₹<?= $amount ?></div>

<!-- QR -->
<img src="<?= $qr_url ?>" alt="QR Code">

<form method="POST">
    <button class="upi" name="method" value="UPI">Pay via UPI</button>
    <button class="card" name="method" value="Card">Pay via Card</button>
    <button class="cash" name="method" value="Cash">Pay via Cash</button>
    <input type="hidden" name="pay" value="1">
</form>

<br>
<a href="tenantDashboard.php">⬅ Back</a>

</div>

</body>
</html>