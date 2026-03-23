<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Fetch Payments
$sql_payments = "SELECT * FROM Payment";
$payments = $conn->query($sql_payments);

// Handle form submission for adding a new payment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_payment'])) {
    // Collect form data and sanitize it
    $tenant_id = mysqli_real_escape_string($conn, $_POST['tenant_id']);
    $payment_amount = mysqli_real_escape_string($conn, $_POST['payment_amount']);
    $payment_date = mysqli_real_escape_string($conn, $_POST['payment_date']);
    $payment_status = mysqli_real_escape_string($conn, $_POST['payment_status']);

    // Check for required fields
    if (empty($tenant_id) || empty($payment_amount) || empty($payment_date) || empty($payment_status)) {
        $message = "All fields are required!";
    } else {
        // Insert new payment into the database
        $sql_insert = "INSERT INTO Payment (Tenant_ID, Payment_Amount, Payment_Date, Payment_Status) 
                       VALUES ('$tenant_id', '$payment_amount', '$payment_date', '$payment_status')";

        if ($conn->query($sql_insert) === TRUE) {
            $message = "Payment added successfully!";
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
    <title>Manage Payments - Admin</title>
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

        /* New Payment Form */
        .new-payment-form {
            display: none;
            margin-top: 20px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease;
        }

        .new-payment-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .new-payment-form button {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .new-payment-form button:hover {
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
    <h2>Admin Dashboard</h2>
    <a href="adminDashboard.php">Dashboard</a>
    <a href="apartments.php">Manage Apartments</a>
    <a href="tenants.php">Manage Tenants</a>
    <a href="paymentManagement.php">Manage Payments</a>
    <a href="maintenance.php">Manage Maintenance Requests</a>
    <a href="logout.php" class="btn">Logout</a>
</div>

<div class="content">
    <h2>Manage Payments</h2>

    <!-- Display success or error message -->
    <?php if (isset($message)) { echo "<p style='color:red;'>$message</p>"; } ?>

    <!-- Button to show the form for adding a new payment -->
    <button class="btn" onclick="document.getElementById('newPaymentForm').style.display='block'">Add New Payment</button>

    <!-- New Payment Form -->
    <div id="newPaymentForm" class="new-payment-form" style="display:none;">
        <h3>Add New Payment</h3>
        <form method="POST" action="">
            <label for="tenant_id">Tenant ID:</label>
            <input type="number" id="tenant_id" name="tenant_id" required>

            <label for="payment_amount">Payment Amount:</label>
            <input type="number" id="payment_amount" name="payment_amount" required>

            <label for="payment_date">Payment Date:</label>
            <input type="date" id="payment_date" name="payment_date" required>

            <label for="payment_status">Payment Status:</label>
            <select id="payment_status" name="payment_status" required>
                <option value="Paid">Paid</option>
                <option value="Pending">Pending</option>
                <option value="Overdue">Overdue</option>
            </select>

            <button type="submit" name="add_payment">Add Payment</button>
        </form>
    </div>

    <!-- Payments Table -->
    <table>
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Tenant ID</th>
                <th>Payment Amount</th>
                <th>Payment Date</th>
                <th>Status</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($payment = $payments->fetch_assoc()): ?>
            <tr>
                <td><?php echo $payment['Payment_ID']; ?></td>
                <td><?php echo $payment['Tenant_ID']; ?></td>
                <td><?php echo $payment['Payment_Amount']; ?></td>
                <td><?php echo $payment['Payment_Date']; ?></td>
                <td><?php echo $payment['Payment_Status']; ?></td>
                <td><a href="viewPayment.php?payment_id=<?php echo $payment['Payment_ID']; ?>" class="details-link">View Details</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
