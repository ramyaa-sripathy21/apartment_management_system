<?php
session_start();
include 'db.php';

// Check if the tenant is logged in
if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$tenant_id = $_SESSION['tenant_id'];

// Fetch tenant details
$sql = "SELECT * FROM Tenant WHERE Tenant_ID = '$tenant_id'";
$result = $conn->query($sql);

// Check for query failure
if (!$result) {
    die("Query Failed: " . $conn->error);
}

// Fetch tenant data
$tenant = $result->fetch_assoc();

// Check if tenant data exists
if (!$tenant) {
    die("Tenant not found or query returned no results!");
}

// Safely access tenant name
$tenant_name = isset($tenant['Tenant_Name']) ? $tenant['Tenant_Name'] : 'Guest';

// Handle maintenance request submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['Description'];

    // Insert maintenance request details into the database
    $sql_request = "INSERT INTO Maintenance_Request (Tenant_ID, Description, Status) VALUES ('$tenant_id', '$description', 'Pending')";
    if ($conn->query($sql_request) === TRUE) {
        echo "<script>alert('Maintenance request submitted successfully!'); window.location.href='tenantDashboard.php';</script>";
    } else {
        echo "<script>alert('Error submitting request: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Request - Tenant Dashboard</title>
    <style>
        /* Resetting some basic styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .container {
            background-color: #ffffff;
            width: 90%;
            max-width: 600px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
        }

        textarea {
            resize: vertical;
            height: 150px;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        textarea:focus {
            border-color: #007bff;
        }

        button {
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .btn-back {
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            background-color: #f44336;
            color: white;
            padding: 10px 15px;
            text-align: center;
            border-radius: 4px;
            width: 100%;
            font-size: 16px;
        }

        .btn-back:hover {
            background-color: #d32f2f;
        }

        /* Responsive design for mobile */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 20px;
            }

            button {
                font-size: 14px;
                padding: 10px;
            }

            textarea {
                font-size: 13px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Submit Maintenance Request</h1>
    <p>Welcome, <?php echo $tenant_name; ?>! Please describe the maintenance issue below:</p>

    <form method="POST">
        <label for="Description">Issue Description:</label>
        <textarea name="Description" required></textarea>

        <button type="submit">Submit Request</button>
    </form>

    <a href="tenantDashboard.php" class="btn-back">Back to Dashboard</a>
</div>

</body>
</html>
