<?php
session_start();
include 'db.php';

// Check admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Add tenant
if (isset($_POST['add_tenant'])) {

    $name = $_POST['name'];
    $contact = $_POST['contact_info'];
    $start = $_POST['lease_start'];
    $end = $_POST['lease_end'];

    // Validation
    if (empty($name) || empty($contact) || empty($start) || empty($end)) {
        die("All fields are required!");
    }

    $sql = "INSERT INTO tenant 
    (Name, Contact_Info, Lease_Start_Date, Lease_End_Date)
    VALUES ('$name','$contact','$start','$end')";

    if (!$conn->query($sql)) {
        die("Error: " . $conn->error);
    }

    header("Location: tenants.php");
    exit();
}

// Fetch tenants
$result = $conn->query("SELECT * FROM tenant");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Tenants</title>

    <style>
    body {
        font-family: Arial;
        background: #f4f6f9;
        margin: 0;
    }

    .container {
        width: 80%;
        margin: 40px auto;
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h2 {
        text-align: center;
        color: #333;
    }

    form {
        margin-bottom: 20px;
    }

    input {
        padding: 10px;
        margin: 5px;
        width: 200px;
    }

    button {
        padding: 10px 15px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background: #0056b3;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }

    th {
        background: #007bff;
        color: white;
    }

    tr:nth-child(even) {
        background: #f2f2f2;
    }
    </style>
</head>

<body>

<div class="container">

    <h2>Manage Tenants</h2>

    <form method="POST">
        <input type="text" name="name" placeholder="Tenant Name" required>
        <input type="text" name="contact_info" placeholder="Contact Info" required>
        <input type="date" name="lease_start" required>
        <input type="date" name="lease_end" required>
        <button type="submit" name="add_tenant">Add Tenant</button>
    </form>

    <table>
        <tr>
            <th>Name</th>
            <th>Contact</th>
            <th>Lease Start</th>
            <th>Lease End</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['Name']; ?></td>
            <td><?php echo $row['Contact_Info']; ?></td>
            <td><?php echo $row['Lease_Start_Date']; ?></td>
            <td><?php echo $row['Lease_End_Date']; ?></td>
        </tr>
        <?php endwhile; ?>

    </table>

</div>

</body>
</html>