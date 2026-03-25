<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Check login
if (!isset($_SESSION['tenant_id'])) {
    die("Tenant not logged in!");
}

$tenant_id = $_SESSION['tenant_id'];

// ✅ Get tenant details (FIXED lowercase table)
$stmt = $conn->prepare("SELECT * FROM tenant WHERE Tenant_ID = ?");
$stmt->bind_param("i", $tenant_id);
$stmt->execute();
$result = $stmt->get_result();
$tenant = $result->fetch_assoc();

if (!$tenant) {
    die("Tenant not found!");
}

// ✅ Get latest booked apartment
$sql = "
SELECT a.Apartment_No, a.Rent_Amount
FROM tenant_apartment_booking tab
JOIN apartment a ON tab.Apartment_No = a.Apartment_No
WHERE tab.Tenant_ID = ?
ORDER BY tab.Booking_Date DESC
LIMIT 1
";

$stmt2 = $conn->prepare($sql);
$stmt2->bind_param("i", $tenant_id);
$stmt2->execute();
$res = $stmt2->get_result();

$apartment = null;

if ($res && $res->num_rows > 0) {
    $apartment = $res->fetch_assoc();
}

// ✅ Handle payment
if (isset($_POST['submit'])) {

    $amount = $_POST['amount'];

    if (empty($amount)) {
        $error = "Enter amount!";
    } else {

        $stmt3 = $conn->prepare("
            INSERT INTO Payments (Tenant_ID, Amount, Payment_Date, Payment_Status)
            VALUES (?, ?, CURDATE(), 'Pending')
        ");

        $stmt3->bind_param("id", $tenant_id, $amount);
        $stmt3->execute();

        header("Location: tenantDashboard.php");
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
    font-family: Arial;
    background: #f4f7fc;
}
.container {
    width: 400px;
    margin: 50px auto;
    background: white;
    padding: 20px;
    border-radius: 10px;
}
button {
    width: 100%;
    padding: 10px;
    background: blue;
    color: white;
    border: none;
}
input {
    width: 100%;
    padding: 10px;
}
.error {
    color: red;
}
</style>
</head>

<body>

<div class="container">
    <h2>Make Payment</h2>

    <p>Welcome, <strong><?php echo htmlspecialchars($tenant['Name']); ?></strong></p>

    <h3>Apartment Details</h3>

    <table border="1" width="100%">
        <tr>
            <th>Apartment No</th>
            <td><?php echo $apartment ? $apartment['Apartment_No'] : 'N/A'; ?></td>
        </tr>
        <tr>
            <th>Rent</th>
            <td><?php echo $apartment ? $apartment['Rent_Amount'] : 'N/A'; ?></td>
        </tr>
    </table>

    <br>

    <?php if (!empty($error)) { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST">
        <label>Amount:</label>
        <input type="number" name="amount"
        value="<?php echo $apartment ? $apartment['Rent_Amount'] : ''; ?>" required>

        <br><br>
        <button type="submit" name="submit">Pay</button>
    </form>

    <br>
    <a href="tenantDashboard.php">Back</a>
</div>

</body>
</html>