<?php
session_start();
include("db.php");

/* ✅ FETCH PAYMENTS WITH TENANT NAME (FIXED JOIN) */
$result = mysqli_query($conn, "
SELECT 
    p.*, 
    t.Name AS tenant_name
FROM Payment p
LEFT JOIN Tenant t 
ON p.Tenant_ID = t.Tenant_ID
ORDER BY p.Payment_Date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Payments</title>

<style>
body {
    margin: 0;
    display: flex;
    background: #f4f6f9;
    font-family: 'Segoe UI', sans-serif;
}

/* Sidebar */
.sidebar {
    width: 230px;
    background: #1e1e2f;
    color: #fff;
    padding: 20px;
    height: 100vh;
}

.sidebar h2 {
    margin-bottom: 20px;
}

.sidebar a {
    display: block;
    color: #ccc;
    margin: 10px 0;
    text-decoration: none;
    padding: 8px;
    border-radius: 5px;
}

.sidebar a:hover {
    background: #333;
    color: #fff;
}

/* Main */
.main {
    flex: 1;
    padding: 30px;
}

/* Card */
.card {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0px 4px 12px rgba(0,0,0,0.08);
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

th, td {
    padding: 12px;
    text-align: center;
}

th {
    background: #f1f1f1;
    font-weight: 600;
}

tr:hover {
    background: #f9f9f9;
}

/* Status Styles */
.status {
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 13px;
}

.paid {
    background: #d4edda;
    color: #155724;
}

.upi {
    background: #cce5ff;
    color: #004085;
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
<div class="card">
<h2>💰 Payments</h2>

<table>
<tr>
<th>ID</th>
<th>Tenant</th>
<th>Amount</th>
<th>Date</th>
<th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>

<td><?= $row['Payment_ID'] ?></td>

<td>
<?= !empty($row['tenant_name']) ? $row['tenant_name'] : 'Unknown' ?>
</td>

<td>₹<?= number_format($row['Payment_Amount'], 2) ?></td>

<td><?= $row['Payment_Date'] ?></td>

<td>
<?php if (strpos($row['Payment_Status'], 'UPI') !== false) { ?>
    <span class="status upi"><?= $row['Payment_Status'] ?></span>
<?php } else { ?>
    <span class="status paid"><?= $row['Payment_Status'] ?></span>
<?php } ?>
</td>

</tr>
<?php } ?>

</table>
</div>
</div>

</body>
</html>