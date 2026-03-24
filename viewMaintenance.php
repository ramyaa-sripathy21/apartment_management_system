<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Fetch the Request_ID from the URL
if (isset($_GET['request_id'])) {
    $request_id = mysqli_real_escape_string($conn, $_GET['request_id']);

    // Query to get the maintenance request details
    $sql_request = "SELECT * FROM Maintenance WHERE Request_ID = '$request_id'";
    $result = $conn->query($sql_request);

    if ($result && $result->num_rows > 0) {
        $request = $result->fetch_assoc();
    } else {
        $error_message = "Maintenance request not found.";
    }
} else {
    header("Location: maintenance.php"); // Redirect if no Request_ID is provided
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Maintenance Request</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #e0eafc, #cfdef3);
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #2575fc;
        }
        p {
            font-size: 16px;
            margin: 10px 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: linear-gradient(to right, #43cea2, #185a9d);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: transform 0.3s, background 0.3s;
        }
        .btn:hover {
            transform: translateY(-3px);
            background: linear-gradient(to right, #185a9d, #43cea2);
        }
    </style>
</head>
<body>

<div class="container">
    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php else: ?>
        <h1>Maintenance Request Details</h1>
        <p><strong>Request ID:</strong> <?php echo $request['Request_ID']; ?></p>
        <p><strong>Tenant ID:</strong> <?php echo $request['Tenant_ID']; ?></p>
        <p><strong>Apartment Number:</strong> <?php echo $request['Apartment_No']; ?></p>
        <p><strong>Request Date:</strong> <?php echo $request['Request_Date']; ?></p>
        <p><strong>Issue Description:</strong> <?php echo $request['Issue_Description']; ?></p>
        <p><strong>Status:</strong> <?php echo $request['Status']; ?></p>
        <a href="maintenance.php" class="btn">Back to Maintenance</a>
    <?php endif; ?>
</div>

</body>
</html>
