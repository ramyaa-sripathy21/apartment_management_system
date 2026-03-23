<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Fetch Tenants
$sql_tenants = "SELECT * FROM Tenant";
$tenants = $conn->query($sql_tenants);

// Handle form submission for adding a new tenant
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_tenant'])) {
    $name = $_POST['name'];
    $contact_info = $_POST['contact_info'];
    $lease_start = $_POST['lease_start'];
    $lease_end = $_POST['lease_end'];

    // Insert new tenant into the database
    $sql_insert = "INSERT INTO Tenant (Name, Contact_Info, Lease_Start_Date, Lease_End_Date) 
                   VALUES ('$name', '$contact_info', '$lease_start', '$lease_end')";
    if ($conn->query($sql_insert) === TRUE) {
        $message = "Tenant added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tenants - Admin</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #e0eafc, #cfdef3);
            color: #333;
            overflow-x: hidden;
        }

        h1, h2 {
            margin: 0;
        }

        h1 {
            font-size: 32px;
        }

        h2 {
            font-size: 28px;
        }

        p {
            font-size: 16px;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(to bottom, #6a11cb, #2575fc);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
        }

        .sidebar h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            margin: 15px 0;
            display: block;
            padding: 10px;
            border-radius: 4px;
            transition: background 0.3s ease, padding-left 0.3s;
        }

        .sidebar a:hover {
            background: #3b8cfc;
            padding-left: 15px;
        }

        /* Content Area */
        .content {
            margin-left: 270px;
            padding: 20px;
        }

        .content h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            animation: fadeIn 1s ease;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background: #f8f8f8;
            color: #2575fc;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        tr:hover {
            background: #d9e9ff;
            transition: background 0.3s;
        }

        /* Buttons and Links */
        .details-link {
            color: #2575fc;
            text-decoration: none;
            font-size: 14px;
        }

        .details-link:hover {
            text-decoration: underline;
        }

        .btn {
            background: linear-gradient(to right, #43cea2, #185a9d);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin: 10px 0;
            transition: transform 0.3s, background 0.3s;
        }

        .btn:hover {
            transform: translateY(-3px);
            background: linear-gradient(to right, #185a9d, #43cea2);
        }

        /* New Tenant Form */
        .new-tenant-form {
            display: none;
            margin-top: 20px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease;
        }

        .new-tenant-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .new-tenant-form button {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .new-tenant-form button:hover {
            background: linear-gradient(to right, #2575fc, #6a11cb);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .content {
                margin-left: 0;
            }

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                box-shadow: none;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Dashboard</h2>
    <a href="adminDashboard.php">Dashboard</a>
    <a href="apartments.php">Manage Apartments</a>
    <a href="tenants.php">Manage Tenants</a>
    <a href="payments.php">Manage Payments</a>
    <a href="maintenance.php">Manage Maintenance Requests</a>
    <a href="logout.php" class="btn">Logout</a>
</div>

<div class="content">
    <h2>Manage Tenants</h2>

    <?php if (isset($message)) { echo "<p style='color:green;'>$message</p>"; } ?>

    <button class="btn" onclick="document.getElementById('newTenantForm').style.display='block'">Add New Tenant</button>

    <div id="newTenantForm" class="new-tenant-form">
        <h3>Add New Tenant</h3>
        <form method="POST" action="">
            <label for="name">Tenant Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="contact_info">Contact Info:</label>
            <input type="text" id="contact_info" name="contact_info" required>

            <label for="lease_start">Lease Start Date:</label>
            <input type="date" id="lease_start" name="lease_start" required>

            <label for="lease_end">Lease End Date:</label>
            <input type="date" id="lease_end" name="lease_end" required>

            <button type="submit" name="add_tenant">Add Tenant</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tenant Name</th>
                <th>Contact Info</th>
                <th>Lease Start</th>
                <th>Lease End</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($tenant = $tenants->fetch_assoc()): ?>
            <tr>
                <td><?php echo $tenant['Name']; ?></td>
                <td><?php echo $tenant['Contact_Info']; ?></td>
                <td><?php echo $tenant['Lease_Start_Date']; ?></td>
                <td><?php echo $tenant['Lease_End_Date']; ?></td>
                <td><a href="viewTenant.php?tenant_id=<?php echo $tenant['Tenant_ID']; ?>" class="details-link">View Details</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
