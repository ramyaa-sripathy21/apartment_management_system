<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

/* ✅ FETCH MAINTENANCE WITH TENANT NAME */
$result = mysqli_query($conn, "
SELECT m.*, t.Name AS tenant_name
FROM Maintenance m
LEFT JOIN Tenant t ON m.Tenant_ID = t.Tenant_ID
ORDER BY m.Request_ID DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Maintenance</title>

<style>
body {
    margin: 0;
    display: flex;
    font-family: 'Segoe UI', sans-serif;
    background: #f4f6f9;
}

/* Sidebar */
.sidebar {
    width: 230px;
    background: #1e1e2f;
    color: #fff;
    height: 100vh;
    padding: 20px;
}

.sidebar h2 {
    margin-bottom: 20px;
}

.sidebar a {
    display: block;
    color: #ccc;
    padding: 10px;
    margin-bottom: 5px;
    text-decoration: none;
    border-radius: 5px;
}

.sidebar a:hover {
    background: #333;
    color: #fff;
}

.logout-btn {
    display: block;
    margin-top: 30px;
    padding: 10px;
    background: #e74c3c;
    color: white;
    text-align: center;
    border-radius: 6px;
    text-decoration: none;
}

.logout-btn:hover {
    background: #c0392b;
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
}

tr:hover {
    background: #f9f9f9;
}

/* Status */
.pending {
    color: orange;
    font-weight: bold;
}

.done {
    color: green;
    font-weight: bold;
}

/* Button */
.btn {
    padding: 6px 12px;
    background: green;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn:hover {
    opacity: 0.9;
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
    <a href="logout.php" class="logout">Logout</a>
</div>

<!-- Main -->
<div class="main">
<div class="card">
<h2>🛠 Maintenance Requests</h2>

<table>
<tr>
<th>ID</th>
<th>Tenant</th>
<th>Issue</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>

<td><?= $row['Request_ID'] ?></td>

<td>
<?= !empty($row['tenant_name']) ? $row['tenant_name'] : 'Unknown' ?>
</td>

<td><?= $row['Issue_Description'] ?></td>

<td>
<?php if ($row['Status'] == 'Pending') { ?>
    <span class="pending">Pending</span>
<?php } else { ?>
    <span class="done">Completed</span>
<?php } ?>
</td>

<td>
<?php if ($row['Status'] == 'Pending') { ?>
    <form method="POST" action="updateMaintenance.php">
        <input type="hidden" name="id" value="<?= $row['Request_ID'] ?>">
        <button class="btn">Done</button>
    </form>
<?php } else { ?>
    ✔
<?php } ?>
</td>

</tr>
<?php } ?>

</table>

</div>
</div>

</body>
</html>