<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Fetch existing maintenance requests
$sql_maintenance = "SELECT * FROM Maintenance";
$maintenance_requests = $conn->query($sql_maintenance);

// Handle form submission for adding new maintenance request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_request'])) {
    // Collect and sanitize form data
    $tenant_id = mysqli_real_escape_string($conn, $_POST['tenant_id']);
    $apartment_no = mysqli_real_escape_string($conn, $_POST['apartment_no']);
    $issue_description = mysqli_real_escape_string($conn, $_POST['issue_description']);
    $request_date = mysqli_real_escape_string($conn, $_POST['request_date']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Check for required fields
    if (empty($tenant_id) || empty($apartment_no) || empty($issue_description) || empty($request_date) || empty($status)) {
        $message = "All fields are required!";
    } else {
        // Insert new maintenance request into the database
        $sql_insert = "INSERT INTO Maintenance (Tenant_ID, Apartment_No, Request_Date, Issue_Description, Status)
                       VALUES ('$tenant_id', '$apartment_no', '$request_date', '$issue_description', '$status')";

        if ($conn->query($sql_insert) === TRUE) {
            $message = "Maintenance request added successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Maintenance Requests - Admin</title>
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
    .new-request-form {
        display: none;
        margin-top: 20px;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.5s ease;
    }

    .new-request-form input, .new-request-form select, .new-request-form textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .new-request-form button {
        background: linear-gradient(to right, #6a11cb, #2575fc);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .new-request-form button:hover {
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

<!-- Sidebar -->
<div class="sidebar">
    <h3>Admin Dashboard</h3>
    <a href="adminDashboard.php">Dashboard</a>
    <a href="apartments.php">Manage Apartments</a>
    <a href="tenants.php">Manage Tenants</a>
    <a href="payments.php">Manage Payments</a>
    <a href="maintenance.php">Manage Maintenance</a>
    <a href="logout.php">Logout</a>
</div>

<!-- Content Area -->
<div class="content">
    <h2>Manage Maintenance Requests</h2>

    <!-- Display success or error message -->
    <?php if (isset($message)) { echo "<p style='color:red;'>$message</p>"; } ?>

    <!-- Button to show the form for adding a new maintenance request -->
    <button class="btn" onclick="document.getElementById('newRequestForm').style.display='block'">Add New Maintenance Request</button>

    <!-- New Maintenance Request Form -->
    <div id="newRequestForm" class="new-request-form">
        <h3>Add New Maintenance Request</h3>
        <form method="POST" action="">
            <label for="tenant_id">Tenant ID:</label>
            <input type="number" id="tenant_id" name="tenant_id" required>

            <label for="apartment_no">Apartment Number:</label>
            <input type="number" id="apartment_no" name="apartment_no" required>

            <label for="issue_description">Issue Description:</label>
            <textarea id="issue_description" name="issue_description" rows="4" required></textarea>

            <label for="request_date">Request Date:</label>
            <input type="date" id="request_date" name="request_date" required>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Resolved">Resolved</option>
            </select>

            <button type="submit" name="add_request">Add Request</button>
        </form>
    </div>

    <!-- Maintenance Requests Table -->
    <table>
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Tenant ID</th>
                <th>Apartment No</th>
                <th>Request Date</th>
                <th>Issue Description</th>
                <th>Status</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($request = $maintenance_requests->fetch_assoc()): ?>
            <tr>
                <td><?php echo $request['Request_ID']; ?></td>
                <td><?php echo $request['Tenant_ID']; ?></td>
                <td><?php echo $request['Apartment_No']; ?></td>
                <td><?php echo $request['Request_Date']; ?></td>
                <td><?php echo $request['Issue_Description']; ?></td>
                <td><?php echo $request['Status']; ?></td>
                <td><a href="viewMaintenance.php?request_id=<?php echo $request['Request_ID']; ?>" class="details-link">View Details</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
