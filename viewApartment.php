<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Check if apartment number is provided in the URL
if (!isset($_GET['apartment_no'])) {
    echo "Invalid request.";
    exit();
}

$apartment_no = $_GET['apartment_no'];

// Fetch apartment details from the database
$sql_apartment = "SELECT * FROM Apartment WHERE Apartment_No = '$apartment_no'";
$result = $conn->query($sql_apartment);

if ($result->num_rows == 0) {
    echo "Apartment not found.";
    exit();
}

$apartment = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apartment Details</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #e0eafc, #cfdef3);
            color: #333;
            padding: 20px;
        }

        .details-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            margin: 5px 0;
        }

        .btn {
            background: linear-gradient(to right, #43cea2, #185a9d);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            transform: translateY(-3px);
            background: linear-gradient(to right, #185a9d, #43cea2);
        }
    </style>
</head>
<body>

<div class="details-container">
    <h2>Apartment Details</h2>
    <p><strong>Apartment Number:</strong> <?php echo $apartment['Apartment_No']; ?></p>
    <p><strong>Floor Number:</strong> <?php echo $apartment['Floor_No']; ?></p>
    <p><strong>Rent Amount:</strong> <?php echo $apartment['Rent_Amount']; ?></p>
    <p><strong>Availability Status:</strong> <?php echo $apartment['Availability_Status']; ?></p>

    <a href="tenants.php" class="btn">Back to Apartments</a>
</div>

</body>
</html>
