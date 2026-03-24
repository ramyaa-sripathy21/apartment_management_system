<?php
ob_start(); // Fix header errors

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Check admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Fetch payments
$sql = "SELECT * FROM Payments";
$result = $conn->query($sql);

if (!$result) {
    die("Query Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Payments</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, #eef2f3, #dfe9f3);
}

/* Sidebar */
.sidebar {
    width: 240px;
    height: 100vh;
    position: fixed;
    background: linear-gradient(to bottom, #6a11cb, #2575fc);
    padding: 20px;
    color: white;
}

.sidebar h2 {
    margin-bottom: 20px;
}

.sidebar a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
}

.sidebar a:hover {
    background: rgba(255,255,255,0.2);
}

/* Main content */
.content {
    margin-left: 260px;
    padding: 40px;
}

/* Card */
.container {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

/* Heading */
h2 {
    margin-bottom: 20px;
    color: #333;
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 10px;
    overflow: hidden;
}

th {
    background: linear-gradient(to right, #007bff, #0056b3);
    color: white;
    padding: 14px;
}

td {
    padding: 12px;
    text-align: center;
}

/* Row styles */
tr:nth-child(even) {
    background: #f2f6fc;
}

tr:hover {
    background: #e6f0ff;
}

/* Status badge */
.status {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: bold;
}

.pending {
    background: #fff3cd;
    color: #856404;
}

.paid {
    background: #d4edda;
    color: #155724;
}
</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Admin Dashboard</h2>
    <a href="adminDashboard.php">Dashboard</a>
    <a href="apartments.php">Manage Apartments</a>
    <a href="tenants.php">Manage Tenants</a>
    <a href="payments.php">Manage Payments</a>
    <a href="maintenance.php">Maintenance Requests</a>
    <a href="logout.php">Logout</a>
</div>

<!-- Content -->
<div class="content">
<div class="container">

<h2>Manage Payments</h2>

<table>
<tr>
    <th>ID</th>
    <th>Tenant</th>
    <th>Amount</th>
    <th>Date</th>
    <th>Status</th>
</tr>

<?php if ($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['Payment_ID'] ?? '-'; ?></td>
        <td><?php echo $row['Tenant_ID'] ?? '-'; ?></td>
        <td>₹ <?php echo $row['Amount'] ?? '0'; ?></td>
        <td><?php echo $row['Payment_Date'] ?? '-'; ?></td>
        <td>
            <span class="status <?php echo strtolower($row['Payment_Status'] ?? 'pending'); ?>">
                <?php echo $row['Payment_Status'] ?? 'Pending'; ?>
            </span>
        </td>
    </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="5">No payments found</td>
    </tr>
<?php endif; ?>

</table>

</div>
</div>

</body>
</html>