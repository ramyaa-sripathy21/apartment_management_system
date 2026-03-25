<?php
include("db.php");

// MARK AS COMPLETED
if(isset($_GET['done'])){
    $id = $_GET['done'];
    mysqli_query($conn, "UPDATE maintenance SET status='Completed' WHERE id=$id");
}

// FETCH WITH TENANT NAME (JOIN)
$result = mysqli_query($conn, "
    SELECT maintenance.*, tenants.name 
    FROM maintenance
    JOIN tenants ON maintenance.tenant_id = tenants.id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Maintenance</title>

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
}

/* Title */
.title {
    font-size: 22px;
    margin-bottom: 20px;
    color: #333;
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

/* Status */
.status {
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
}

.pending {
    background: #fff3cd;
    color: #856404;
}

.completed {
    background: #d4edda;
    color: #155724;
}

/* Button */
.btn {
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
}

.btn-done {
    background: #28a745;
    color: #fff;
}

.btn-done:hover {
    background: #218838;
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

    <div class="card">
        <div class="title">Maintenance Requests</div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tenant</th>
                    <th>Issue</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['issue']; ?></td>

                    <td>
                        <?php if($row['status'] == 'Pending'){ ?>
                            <span class="status pending">Pending</span>
                        <?php } else { ?>
                            <span class="status completed">Completed</span>
                        <?php } ?>
                    </td>

                    <td>
                        <?php if($row['status'] == 'Pending'){ ?>
                            <a href="?done=<?php echo $row['id']; ?>" class="btn btn-done">
                                Mark Done
                            </a>
                        <?php } else { ?>
                            ✔
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>

        </table>
    </div>

</div>

</body>
</html>