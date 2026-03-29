<?php
session_start();
include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$tenant_id = $_SESSION['tenant_id'];

//echo $tenant_id;
//exit();

// ✅ Fetch tenant name
$nameQuery = mysqli_query($conn, "SELECT Name FROM Tenant WHERE Tenant_ID='$tenant_id'");
$data = mysqli_fetch_assoc($nameQuery);
$name = $data['Name'] ?? 'Tenant';

// ✅ Fetch rent
$sql = "SELECT SUM(rent) AS total_rent FROM apartments WHERE tenant_id = '$tenant_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$rent = $row['total_rent'] ?? 0;

// ✅ UPI QR
$upi_id = "ramya@oksbi";
$upi_link = "upi://pay?pa=$upi_id&pn=Apartment&am=$rent&cu=INR";
$qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($upi_link);

// ✅ PAYMENT HANDLE
if (isset($_POST['pay'])) {

    $method = $_POST['method'];
    $status = "Paid via " . $method;

    $amount = $rent; // ✅ FIXED (IMPORTANT)

    if (!$tenant_id || $tenant_id <= 0) {
    die("Invalid tenant ID");
}

    $stmt = $conn->prepare("
        INSERT INTO payments (tenant_id, amount, date, status)
        VALUES (?, ?, CURDATE(), ?)
    ");

    $stmt->bind_param("ids", $tenant_id, $amount, $status);
    $stmt->execute();

    header("Location: makePayment.php?paid=1");
    exit();
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

.amount {
    font-size: 22px;
    color: #2ecc71;
    font-weight: bold;
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
<div class="amount">₹<?= $rent ?></div>

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