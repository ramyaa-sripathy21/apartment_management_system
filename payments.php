<?php
include("db.php");

// ✅ FETCH PAYMENTS + TENANT NAME
$result = mysqli_query($conn, "
SELECT 
    p.id,
    p.amount,
    p.date,
    p.status,
    t.name AS tenant_name
FROM payments p
LEFT JOIN tenants t 
ON p.tenant_id = t.id
ORDER BY p.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Payments</title>

<style>
body {
    display: flex;
    margin: 0;
    font-family: Segoe UI;
    background: #f4f6f9;
}

/* Sidebar */
.sidebar {
    width: 230px;
    background: #1e1e2f;
    color: #fff;
    padding: 20px;
    height: 100vh;
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
    color: white;
}

/* Logout button */
.logout-btn {
    margin-top: 30px;
    background: #e74c3c;
    text-align: center;
    color: white !important;
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
    border-radius: 10px;
    box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #eee;
    padding: 12px;
}

td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

/* Status */
.status {
    padding: 6px 12px;
    border-radius: 6px;
    color: white;
    font-size: 13px;
}

.paid { background: #2ecc71; }
.pending { background: #f39c12; }
</style>
</head>

<body>

<div class="sidebar">
<h2>Admin Panel</h2>
<a href="adminDashboard.php">Dashboard</a>
<a href="apartments.php">Apartments</a>
<a href="tenants.php">Tenants</a>
<a href="payments.php">Payments</a>
<a href="maintenance.php">Maintenance</a>

<a href="logout.php" class="logout-btn">Logout</a>
</div>

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
<td><?= $row['id'] ?></td>

<td>
<?= !empty($row['tenant_name']) ? $row['tenant_name'] : 'Unknown' ?>
</td>

<td>₹<?= number_format($row['amount'] ?? 0, 2) ?></td>

<td><?= $row['date'] ?></td>

<td>
<?php
$status = $row['status'] ?? 'Pending';

if (stripos($status, 'paid') !== false) {
    echo "<span class='status paid'>$status</span>";
} else {
    echo "<span class='status pending'>$status</span>";
}
?>
</td>

</tr>

<?php } ?>

</table>

</div>
</div>

</body>
</html>