<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    echo "Tenant not logged in!";
    exit();
}

$tenant_id = $_SESSION['tenant_id'];

// Get tenant
$result = $conn->query("SELECT * FROM Tenant WHERE Tenant_ID='$tenant_id'");
$tenant = $result->fetch_assoc();

// Get apartment booking
$sql = "
SELECT a.Apartment_No, a.Rent_Amount
FROM tenant_apartment_booking tab
JOIN apartment a ON tab.Apartment_No = a.Apartment_No
WHERE tab.Tenant_ID = '$tenant_id'
ORDER BY tab.Booking_Date DESC
LIMIT 1
";

$res = $conn->query($sql);

if ($res && $res->num_rows > 0) {
    $apartment = $res->fetch_assoc();
} else {
    $apartment = null;
}

// Payment submit
if (isset($_POST['submit'])) {
    $amount = $_POST['amount'];

    $conn->query("INSERT INTO Payments (Tenant_ID, Amount, Payment_Status)
                  VALUES ('$tenant_id', '$amount', 'Pending')");

    header("Location: tenantDashboard.php");
    exit();
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
</style>
</head>

<body>

<div class="container">
    <h2>Make Payment</h2>

    <p>Welcome, <?php echo $tenant['Name']; ?></p>

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

    <form method="POST">
        <label>Amount:</label>
        <input type="number" name="amount"
        value="<?php echo $apartment ? $apartment['Rent_Amount'] : ''; ?>" required>

        <br><br>
        <button name="submit">Pay</button>
    </form>

    <br>
    <a href="tenantDashboard.php">Back</a>
</div>

</body>
</html>