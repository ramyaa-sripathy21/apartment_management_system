<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Check if the tenant is logged in
if (!isset($_SESSION['tenant_id'])) {
    echo "Tenant not logged in!";
    exit();
}

$tenant_id = $_SESSION['tenant_id'];

// Fetch tenant details
$sql = "SELECT * FROM Tenant WHERE Tenant_ID = '$tenant_id'";
$result = $conn->query($sql);

if (!$result) {
    die("Query Failed: " . $conn->error);
}

$tenant = $result->fetch_assoc();

// Fetch the latest apartment booking details to show payment info
$sql_apartment = "
SELECT a.Apartment_No, a.Rent_Amount
FROM tenant_apartment_booking tab
JOIN apartment a ON tab.Apartment_No = a.Apartment_No
WHERE tab.Tenant_ID = '$tenant_id'
ORDER BY tab.Booking_Date DESC
LIMIT 1
";

$result_apartment = $conn->query($sql_apartment);

if ($result_apartment && $result_apartment->num_rows > 0) {
    $apartment = $result_apartment->fetch_assoc();
} else {
    $apartment = null;
}

$apartment = $result_apartment->fetch_assoc();
echo "<pre>";
print_r($apartment);
echo "</pre>";
exit();

if (!$apartment) {
    echo "No booking found!";
}

// Handle payment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['Amount'];

    // Insert payment details into the database
    $sql_payment = "INSERT INTO Payments (Tenant_ID, Amount, Payment_Status) VALUES ('$tenant_id', '$amount', 'Pending')";
    if ($conn->query($sql_payment) === TRUE) {
        echo "<script>alert('Payment request submitted successfully!'); window.location.href='tenantDashboard.php';</script>";
    } else {
        echo "<script>alert('Error submitting payment: " . $conn->error . "');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment - Tenant Dashboard</title>
    <style>
        /* General styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        h2, h3 {
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            color: #555;
        }

        td {
            background-color: #fff;
        }

        form {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
        }

        label {
            margin-bottom: 6px;
            font-size: 16px;
            color: #333;
        }

        input[type="number"] {
            padding: 10px;
            font-size: 14px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            outline: none;
        }

        input[type="number"]:focus {
            border-color: #007bff;
        }

        .btn {
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            text-align: center;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-back {
            background-color: #FF5733;
        }

        .btn-back:hover {
            background-color: #ff3f1f;
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }

            table {
                font-size: 14px;
            }

            .btn {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Make Payment</h1>
    <p>Welcome, <?php echo isset($tenant['Name']) ? $tenant['Name'] : 'User'; ?>! Please enter the payment amount for your apartment.</p>

    <h2>Apartment Details</h2>
    <table>
        <tr>
            <th>Apartment Number</th>
            <?php echo ($apartment != null) ? $apartment['Apartment_No'] : 'Not Available'; ?>
        </tr>
        <tr>
            <th>Rent Amount</th>
            <?php echo ($apartment != null) ? $apartment['Rent_Amount'] : 'Not Available'; ?>
    </table>

    <h3>Payment Information</h3>
    <form method="POST">
        <label for="Amount">Amount to Pay:</label>
        <input type="number" name="Amount" required step="0.01"
value="<?php echo ($apartment != null) ? $apartment['Rent_Amount'] : ''; ?>">

        <button type="submit" class="btn">Submit Payment</button>
    </form>

    <a href="tenantDashboard.php" class="btn btn-back">Back to Dashboard</a>
</div>

</body>
</html>

<?php
die("TEST");

session_start();
include 'db.php';

// Check if the tenant is logged in
if (!isset($_SESSION['tenant_id'])) {
    echo "Tenant not logged in!";
    exit();
}

$tenant_id = $_SESSION['tenant_id'];

// Fetch tenant details
$sql = "SELECT * FROM Tenant WHERE Tenant_ID = '$tenant_id'";
$result = $conn->query($sql);

if (!$result) {
    die("Query Failed: " . $conn->error);
}

$tenant = $result->fetch_assoc();

// Fetch the latest apartment booking details to show payment info
$sql_apartment = "
SELECT a.Apartment_No, a.Rent_Amount
FROM tenant_apartment_booking tab
JOIN apartment a ON tab.Apartment_No = a.Apartment_No
WHERE tab.Tenant_ID = '$tenant_id'
ORDER BY tab.Booking_Date DESC
LIMIT 1
";

$result_apartment = $conn->query($sql_apartment);

if ($result_apartment && $result_apartment->num_rows > 0) {
    $apartment = $result_apartment->fetch_assoc();
} else {
    $apartment = null;
}

$apartment = $result_apartment->fetch_assoc();
echo "<pre>";
print_r($apartment);
echo "</pre>";
exit();

if (!$apartment) {
    echo "No booking found!";
}

// Handle payment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['Amount'];

    // Insert payment details into the database
    $sql_payment = "INSERT INTO Payments (Tenant_ID, Amount, Payment_Status) VALUES ('$tenant_id', '$amount', 'Pending')";
    if ($conn->query($sql_payment) === TRUE) {
        echo "<script>alert('Payment request submitted successfully!'); window.location.href='tenantDashboard.php';</script>";
    } else {
        echo "<script>alert('Error submitting payment: " . $conn->error . "');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment - Tenant Dashboard</title>
    <style>
        /* General styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        h2, h3 {
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            color: #555;
        }

        td {
            background-color: #fff;
        }

        form {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
        }

        label {
            margin-bottom: 6px;
            font-size: 16px;
            color: #333;
        }

        input[type="number"] {
            padding: 10px;
            font-size: 14px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            outline: none;
        }

        input[type="number"]:focus {
            border-color: #007bff;
        }

        .btn {
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            text-align: center;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-back {
            background-color: #FF5733;
        }

        .btn-back:hover {
            background-color: #ff3f1f;
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }

            table {
                font-size: 14px;
            }

            .btn {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Make Payment</h1>
    <p>Welcome, <?php echo isset($tenant['Name']) ? $tenant['Name'] : 'User'; ?>! Please enter the payment amount for your apartment.</p>

    <h2>Apartment Details</h2>
    <table>
        <tr>
            <th>Apartment Number</th>
            <?php echo ($apartment != null) ? $apartment['Apartment_No'] : 'Not Available'; ?>
        </tr>
        <tr>
            <th>Rent Amount</th>
            <?php echo ($apartment != null) ? $apartment['Rent_Amount'] : 'Not Available'; ?>
    </table>

    <h3>Payment Information</h3>
    <form method="POST">
        <label for="Amount">Amount to Pay:</label>
        <input type="number" name="Amount" required step="0.01"
value="<?php echo ($apartment != null) ? $apartment['Rent_Amount'] : ''; ?>">

        <button type="submit" class="btn">Submit Payment</button>
    </form>

    <a href="tenantDashboard.php" class="btn btn-back">Back to Dashboard</a>
</div>

</body>
</html>

