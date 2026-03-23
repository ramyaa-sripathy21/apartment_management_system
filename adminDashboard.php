<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$admin_name = "Admin User"; // Ideally, you fetch the admin name from the DB

// Count apartments
$sql_apartments = "SELECT COUNT(*) AS total_apartments FROM Apartment";
$result_apartments = $conn->query($sql_apartments);
$apartments_count = $result_apartments->fetch_assoc()['total_apartments'];

// Count tenants
$sql_tenants = "SELECT COUNT(*) AS total_tenants FROM Tenant";
$result_tenants = $conn->query($sql_tenants);
$tenants_count = $result_tenants->fetch_assoc()['total_tenants'];

// Count payments
$sql_payments = "SELECT COUNT(*) AS total_payments FROM Payment";
$result_payments = $conn->query($sql_payments);
$payments_count = $result_payments->fetch_assoc()['total_payments'];

// Count maintenance requests
$sql_maintenance = "SELECT COUNT(*) AS total_requests FROM Maintenance";
$result_maintenance = $conn->query($sql_maintenance);
$maintenance_count = $result_maintenance->fetch_assoc()['total_requests'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Apartment Management</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #1e3c72, #2a5298);
            color: #fff;
            overflow-x: hidden;
        }

        h1, h2 {
            margin: 0;
        }

        h1 {
            font-size: 28px;
        }

        h2 {
            font-size: 24px;
        }

        p {
            font-size: 16px;
        }

        /* Header Styling */
        header {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            font-size: 32px;
            color: #fff;
            animation: slideIn 1s ease;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background: #333;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
        }

        .sidebar h3 {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: #aaa;
            text-decoration: none;
            font-size: 16px;
            margin: 10px 0;
            display: block;
            padding: 10px;
            border-radius: 4px;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .sidebar a:hover {
            background: #444;
            color: #fff;
        }

        .btn {
            display: block;
            background: linear-gradient(to right, #ff416c, #ff4b2b);
            color: white;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
            text-decoration: none;
            margin-top: 20px;
            transition: transform 0.3s;
        }

        .btn:hover {
            transform: translateY(-3px);
        }

        /* Content Styling */
        .content {
            margin-left: 270px;
            padding: 20px;
        }

        .dashboard-boxes {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .dashboard-box {
            flex: 1 1 calc(25% - 20px);
            background: linear-gradient(to bottom, #43cea2, #185a9d);
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .dashboard-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .dashboard-box h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .dashboard-box p {
            font-size: 36px;
            margin: 0;
            font-weight: bold;
        }

        .dashboard-box a {
            margin-top: 10px;
            display: inline-block;
            padding: 8px 15px;
            background: #fff;
            color: #185a9d;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            transition: background 0.3s, color 0.3s;
        }

        .dashboard-box a:hover {
            background: #185a9d;
            color: #fff;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-box {
                flex: 1 1 calc(50% - 20px);
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .content {
                margin-left: 0;
            }

            .dashboard-box {
                flex: 1 1 100%;
            }
        }

        /* Animations */
        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome, Admin</h1>
</header>

<div class="sidebar">
    <h3>Admin Dashboard</h3>
    <a href="apartments.php">Manage Apartments</a>
    <a href="tenants.php">Manage Tenants</a>
    <a href="payments.php">Manage Payments</a>
    <a href="maintenance.php">Manage Maintenance Requests</a>
    <a href="logout.php" class="btn">Logout</a>
</div>

<div class="content">
    <h2>Admin Dashboard</h2>
    <p>Welcome to the Admin Dashboard. Here you can see a quick overview of the management sections.</p>

    <!-- Dashboard Boxes -->
    <div class="dashboard-boxes">
        <div class="dashboard-box">
            <h3>Total Apartments</h3>
            <p><?php echo $apartments_count; ?></p>
            <a href="apartments.php">Manage Apartments</a>
        </div>

        <div class="dashboard-box">
            <h3>Total Tenants</h3>
            <p><?php echo $tenants_count; ?></p>
            <a href="tenants.php">Manage Tenants</a>
        </div>

        <div class="dashboard-box">
            <h3>Total Payments</h3>
            <p><?php echo $payments_count; ?></p>
            <a href="payments.php">Manage Payments</a>
        </div>

        <div class="dashboard-box">
            <h3>Total Maintenance Requests</h3>
            <p><?php echo $maintenance_count; ?></p>
            <a href="maintenance.php">Manage Maintenance</a>
        </div>
    </div>
</div>

</body>
</html>
