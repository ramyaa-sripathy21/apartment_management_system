<?php
session_start();
include 'db.php';

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Check if tenant_id is passed in the URL
if (isset($_GET['tenant_id'])) {
    $tenant_id = intval($_GET['tenant_id']);

    // Fetch tenant details from the database
    $sql = "SELECT * FROM Tenant WHERE Tenant_ID = $tenant_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $tenant = $result->fetch_assoc();
    } else {
        echo "Tenant not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Details</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(to bottom, #e0eafc, #cfdef3);
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
            font-size: 24px;
        }
        p {
            font-size: 16px;
            margin: 10px 0;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #2575fc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .back-link:hover {
            background: #185a9d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tenant Details</h2>
        <p><strong>Name:</strong> <?php echo $tenant['Name']; ?></p>
        <p><strong>Contact Info:</strong> <?php echo $tenant['Contact_Info']; ?></p>
        <p><strong>Lease Start Date:</strong> <?php echo $tenant['Lease_Start_Date']; ?></p>
        <p><strong>Lease End Date:</strong> <?php echo $tenant['Lease_End_Date']; ?></p>
        <a href="tenants.php" class="back-link">Back to Manage Tenants</a>
    </div>
</body>
</html>
