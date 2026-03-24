```php
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Check admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Fetch maintenance data
$sql = "SELECT * FROM Maintenance";
$result = $conn->query($sql);

if (!$result) {
    die("Query Error: " . $conn->error);
}

// Add new request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_request'])) {

    $tenant_id = $_POST['tenant_id'];
    $apartment_no = $_POST['apartment_no'];
    $issue_description = $_POST['issue_description'];
    $request_date = $_POST['request_date'];
    $status = $_POST['status'];

    $sql_insert = "INSERT INTO Maintenance 
    (Tenant_ID, Apartment_No, Request_Date, Issue_Description, Status)
    VALUES ('$tenant_id','$apartment_no','$request_date','$issue_description','$status')";

    if ($conn->query($sql_insert) === TRUE) {
        header("Location: maintenance.php");
        exit();
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Maintenance Requests</title>

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

/* Content */
.content {
    margin-left: 260px;
    padding: 40px;
}

/* Card */
.container {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

/* Button */
.btn {
    background: linear-gradient(to right, #43cea2, #185a9d);
    color: white;
    padding: 10px 18px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    margin-bottom: 15px;
}

.btn:hover {
    opacity: 0.9;
}

/* Form */
.form-box {
    display: none;
    margin-bottom: 20px;
}

.form-box input, .form-box textarea, .form-box select {
    width: 100%;
    padding: 10px;
    margin: 6px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #007bff;
    color: white;
    padding: 12px;
}

td {
    padding: 10px;
    text-align: center;
}

tr:nth-child(even) {
    background: #f2f6fc;
}

tr:hover {
    background: #e6f0ff;
}

/* Status */
.status {
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 12px;
}

.pending {
    background: #fff3cd;
}

.resolved {
    background: #d4edda;
}

.progress {
    background: #cce5ff;
}
</style>

<script>
function toggleForm() {
    var form = document.getElementById("formBox");
    form.style.display = (form.style.display === "none") ? "block" : "none";
}
</script>

</head>
<body>

<div class="sidebar">
    <h2>Admin</h2>
    <a href="adminDashboard.php">Dashboard</a>
    <a href="apartments.php">Apartments</a>
    <a href="tenants.php">Tenants</a>
    <a href="payments.php">Payments</a>
    <a href="maintenance.php">Maintenance</a>
    <a href="logout.php">Logout</a>
</div>

<div class="content">
<div class="container">

<h2>Maintenance Requests</h2>

<?php if(isset($message)) echo "<p style='color:red'>$message</p>"; ?>

<button class="btn" onclick="toggleForm()">+ Add Request</button>

<div class="form-box" id="formBox">
<form method="POST">
<input type="number" name="tenant_id" placeholder="Tenant ID" required>
<input type="number" name="apartment_no" placeholder="Apartment No" required>
<input type="date" name="request_date" required>
<textarea name="issue_description" placeholder="Issue Description" required></textarea>

<select name="status">
<option value="Pending">Pending</option>
<option value="In Progress">In Progress</option>
<option value="Resolved">Resolved</option>
</select>

<button class="btn" name="add_request">Submit</button>
</form>
</div>

<table>
<tr>
<th>ID</th>
<th>Tenant</th>
<th>Apartment</th>
<th>Date</th>
<th>Issue</th>
<th>Status</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?php echo $row['Request_ID']; ?></td>
<td><?php echo $row['Tenant_ID']; ?></td>
<td><?php echo $row['Apartment_No']; ?></td>
<td><?php echo $row['Request_Date']; ?></td>
<td><?php echo $row['Issue_Description']; ?></td>
<td>
<span class="status <?php echo strtolower($row['Status']); ?>">
<?php echo $row['Status']; ?>
</span>
</td>
</tr>
<?php endwhile; ?>

</table>

</div>
</div>

</body>
</html>
```


