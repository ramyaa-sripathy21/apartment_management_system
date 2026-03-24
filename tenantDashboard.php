<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['tenant_id'])) { 
    header("Location: login.php"); 
    exit(); 
} 

$tenant_id = $_SESSION['tenant_id']; 
$tenant_name = $_SESSION['tenant_name']; 

// Correct column name
$sql_apartments = "SELECT * FROM Apartment WHERE Availability_Status = 'Available'"; 
$apartments = $conn->query($sql_apartments); 
?> 

<!DOCTYPE html> 
<html lang="en"> 
<head>     
    <meta charset="UTF-8">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">     
    <title>Tenant Dashboard</title>     

    <style>
        body {
            font-family: Arial;
            margin: 0;
            display: flex;
        }

        .sidenav {
            width: 220px;
            background: #2c3e50;
            height: 100vh;
            color: white;
            padding: 20px;
        }

        .sidenav a {
            display: block;
            padding: 10px;
            color: white;
            text-decoration: none;
            margin-top: 10px;
            background: #34495e;
        }

        .main {
            flex: 1;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
        }

        .btn {
            background: blue;
            color: white;
            padding: 8px;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>

<body>

<div class="sidenav">
    <h3><?php echo $tenant_name; ?></h3>
    <a href="#">Apartments</a>
    <a href="makePayment.php">Payment</a>
    <a href="maintenanceRequest.php">Maintenance</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">
    <h1>Welcome, <?php echo $tenant_name; ?></h1>
    <h2>Available Apartments</h2>

    <?php while ($row = $apartments->fetch_assoc()): ?>
        <div class="card">
            <h3><?php echo $row['Apartment_No']; ?></h3>
            <p>Floor: <?php echo $row['Floor_No']; ?></p>
            <p>Rent: ₹<?php echo $row['Rent_Amount']; ?></p>

            <a class="btn" href="bookApartment.php?apartment_no=<?php echo $row['Apartment_No']; ?>">
                Book Now
            </a>
        </div>
    <?php endwhile; ?>

</div>

</body>
</html>

