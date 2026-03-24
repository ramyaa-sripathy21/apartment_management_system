<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Check if Payment_ID is provided
if (!isset($_GET['payment_id'])) {
    die("Payment ID not specified.");
}

// Sanitize and retrieve the Payment ID from the URL
$payment_id = mysqli_real_escape_string($conn, $_GET['payment_id']);

// Fetch payment details from the database
$sql = "SELECT * FROM Payment WHERE Payment_ID = '$payment_id'";
$result = $conn->query($sql);

// Check if the payment exists
if ($result->num_rows == 0) {
    die("Payment not found.");
}

$payment = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom, #e0eafc, #cfdef3);
            color: #333;
            padding: 20px;
        }
        .details-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 10px;
        }
        a {
            display: inline-block;
            text-decoration: none;
            color: white;
            background: #2575fc;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        a:hover {
            background: #6a11cb;
        }
    </style>
</head>
<body>

<div class="details-box">
    <h2>Payment Details</h2>
    <p><strong>Payment ID:</strong> <?php echo $payment['Payment_ID']; ?></p>
    <p><strong>Tenant ID:</strong> <?php echo $payment['Tenant_ID']; ?></p>
    <p><strong>Payment Amount:</strong> $<?php echo number_format($payment['Payment_Amount'], 2); ?></p>
    <p><strong>Payment Date:</strong> <?php echo $payment['Payment_Date']; ?></p>
    <p><strong>Payment Status:</strong> <?php echo $payment['Payment_Status']; ?></p>
    <a href="payments.php">Back to Payments</a>
</div>

</body>
</html>
