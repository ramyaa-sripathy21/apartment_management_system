<?php
include("db.php");

/* ===== FETCH COUNTS (CORRECT WAY) ===== */
$apartments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM apartments"))['total'];

$tenants = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tenants"))['total'];

$payments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM payments"))['total'];

$maintenance = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM maintenance"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    display: flex;
    background: #f4f6f9;
}

/* Sidebar */
.sidebar {
    width: 230px;
    height: 100vh;
    background: #1e1e2f;
    color: #fff;
    padding: 20px;
    position: fixed;
}

.sidebar h2 {
    margin-bottom: 30px;
}

.sidebar a {
    display: block;
    color: #ccc;
    text-decoration: none;
    padding: 12px;
    margin: 10px 0;
    border-radius: 8px;
    transition: 0.3s;
}

.sidebar a:hover {
    background: #2f2f45;
    color: #fff;
}

/* Main */
.main {
    margin-left: 230px;
    padding: 30px;
    width: 100%;
}

/* Header */
.header {
    font-size: 26px;
    font-weight: bold;
    margin-bottom: 25px;
    color: #333;
}

/* Cards */
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: 20px;
}

.card {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
}

.card h3 {
    font-size: 16px;
    color: #777;
    margin-bottom: 10px;
}

.card p {
    font-size: 30px;
    font-weight: bold;
    color: #333;
}

/* Colors */
.apartments { border-left: 6px solid #4CAF50; }
.tenants { border-left: 6px solid #2196F3; }
.payments { border-left: 6px solid #FF9800; }
.maintenance { border-left: 6px solid #E91E63; }

/* Responsive */
@media(max-width: 768px) {
    .sidebar { display: none; }
    .main { margin-left: 0; }
}
</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="adminDashboard.php">Dashboard</a>
    <a href="apartments.php">Apartments</a>
    <a href="tenants.php">Tenants</a>
    <a href="payments.php">Payments</a>
    <a href="maintenance.php">Maintenance</a>
    <a href="logout.php">Logout</a>
</div>

<!-- Main -->
<div class="main">

    <div class="header">Welcome Admin 👋</div>

    <div class="cards">

        <div class="card apartments">
            <h3>Total Apartments</h3>
            <p><?php echo $apartments; ?></p>
        </div>

        <div class="card tenants">
            <h3>Total Tenants</h3>
            <p><?php echo $tenants; ?></p>
        </div>

        <div class="card payments">
            <h3>Total Payments</h3>
            <p><?php echo $payments; ?></p>
        </div>

        <div class="card maintenance">
            <h3>Maintenance Requests</h3>
            <p><?php echo $maintenance; ?></p>
        </div>

    </div>

</div>

</body>
</html>