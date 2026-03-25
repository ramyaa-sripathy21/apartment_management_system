<?php
include("db.php");

// ADD TENANT
if(isset($_POST['addTenant'])){
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    mysqli_query($conn, "INSERT INTO tenants (name, contact, start_date, end_date) 
    VALUES ('$name','$contact','$start','$end')");
}

// FETCH TENANTS
$result = mysqli_query($conn, "SELECT * FROM tenants");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Tenants</title>

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

/* Card */
.card {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    margin-bottom: 25px;
}

/* Title */
.title {
    font-size: 22px;
    margin-bottom: 20px;
    color: #333;
}

/* Form */
.form-group {
    margin-bottom: 15px;
}

input {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    outline: none;
}

input:focus {
    border-color: #2196F3;
}

/* Button */
button {
    width: 100%;
    padding: 12px;
    background: #2196F3;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #1976D2;
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
}

table thead {
    background: #f1f1f1;
}

table th, table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table tr:hover {
    background: #f9f9f9;
}

/* Responsive */
@media(max-width: 768px){
    .sidebar {
        display: none;
    }
    .main {
        margin-left: 0;
    }
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

    <!-- Add Tenant -->
    <div class="card">
        <div class="title">Add Tenant</div>

        <form method="POST">
            <div class="form-group">
                <input type="text" name="name" placeholder="Tenant Name" required>
            </div>

            <div class="form-group">
                <input type="text" name="contact" placeholder="Contact Number" required>
            </div>

            <div class="form-group">
                <input type="date" name="start" required>
            </div>

            <div class="form-group">
                <input type="date" name="end" required>
            </div>

            <button type="submit" name="addTenant">Add Tenant</button>
        </form>
    </div>

    <!-- Tenant List -->
    <div class="card">
        <div class="title">All Tenants</div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
            </thead>

            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['contact']; ?></td>
                    <td><?php echo $row['start_date']; ?></td>
                    <td><?php echo $row['end_date']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>