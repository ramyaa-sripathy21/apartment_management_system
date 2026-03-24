<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Fetch tenants
$sql = "SELECT Tenant_ID, Name, Contact_Info, Lease_Start_Date, Lease_End_Date FROM tenant";
$result = $conn->query($sql);

// Add tenant
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_tenant'])) {
    $name = $_POST['name'];
    $contact = $_POST['contact_info'];
    $start = $_POST['lease_start'];
    $end = $_POST['lease_end'];

    $insert = "INSERT INTO tenant (Name, Contact_Info, Lease_Start_Date, Lease_End_Date)
               VALUES ('$name', '$contact', '$start', '$end')";

    if ($conn->query($insert)) {
        header("Location: tenants.php");
        exit();
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Tenants</title>
    <style>
        body { font-family: Arial; margin: 0; }
        .sidebar {
            width: 220px;
            background: #4b00c9;
            color: white;
            height: 100vh;
            position: fixed;
            padding: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            margin: 10px 0;
            text-decoration: none;
        }
        .content {
            margin-left: 240px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        th {
            background: #eee;
        }
        .btn {
            padding: 10px;
            background: green;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
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
    <h2>Manage Tenants</h2>

    <?php if (isset($message)) echo "<p style='color:red;'>$message</p>"; ?>

    <form method="POST">
        <h3>Add Tenant</h3>
        <input type="text" name="name" placeholder="Name" required><br><br>
        <input type="text" name="contact_info" placeholder="Contact Info" required><br><br>
        <input type="date" name="lease_start" required><br><br>
        <input type="date" name="lease_end" required><br><br>
        <button class="btn" name="add_tenant">Add Tenant</button>
    </form>

    <br><br>

    <table>
        <tr>
            <th>Name</th>
            <th>Contact</th>
            <th>Lease Start</th>
            <th>Lease End</th>
            <th>Details</th>
        </tr>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['Name']; ?></td>
                    <td><?php echo $row['Contact_Info']; ?></td>
                    <td><?php echo $row['Lease_Start_Date']; ?></td>
                    <td><?php echo $row['Lease_End_Date']; ?></td>
                    <td>
                        <a href="viewTenant.php?tenant_id=<?php echo $row['Tenant_ID']; ?>">
                            View
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">No tenants found</td></tr>
        <?php endif; ?>
    </table>

</div>

</body>
</html>