<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Fetch Apartments
$sql_apartments = "SELECT * FROM Apartment";
$apartments = $conn->query($sql_apartments);

// Handle form submission to add a new apartment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_apartment'])) {
    $apartment_no = $_POST['apartment_no'];
    $floor_no = $_POST['floor_no'];
    $rent_amount = $_POST['rent_amount'];
    $availability_status = $_POST['availability_status'];

    // Insert the new apartment into the database
    $sql_insert = "INSERT INTO Apartment (Apartment_No, Floor_No, Rent_Amount, Availability_Status) 
                   VALUES ('$apartment_no', '$floor_no', '$rent_amount', '$availability_status')";
    if ($conn->query($sql_insert) === TRUE) {
        $message = "Apartment added successfully!";
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
    <title>Manage Apartments - Admin</title>
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

        /* New Apartment Form */
        .new-apartment-form {
            display: none;
            margin-top: 20px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease;
        }

        .new-apartment-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .new-apartment-form button {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .new-apartment-form button:hover {
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
    <a href="payments.php">Manage Payments</a>
    <a href="maintenance.php">Manage Maintenance Requests</a>
    <a href="logout.php" class="btn">Logout</a>
</div>

<!-- Main Content -->
<div class="content">
    <h2>Manage Apartments</h2>

    <!-- Display success or error message -->
    <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>

    <!-- Button to show the form for adding a new apartment -->
    <button class="btn" onclick="toggleNewApartmentForm()">Add New Apartment</button>

    <!-- New Apartment Form -->
    <div id="newApartmentForm" class="new-apartment-form">
        <h3>Add New Apartment</h3>
        <form method="POST" action="">
            <label for="apartment_no">Apartment Number:</label>
            <input type="text" id="apartment_no" name="apartment_no" required>

            <label for="floor_no">Floor Number:</label>
            <input type="text" id="floor_no" name="floor_no" required>

            <label for="rent_amount">Rent Amount:</label>
            <input type="text" id="rent_amount" name="rent_amount" required>

            <label for="availability_status">Availability Status:</label>
            <select id="availability_status" name="availability_status" required>
                <option value="Available">Available</option>
                <option value="Occupied">Occupied</option>
            </select>

            <button type="submit" name="add_apartment">Add Apartment</button>
        </form>
    </div>

    <!-- Apartments Table -->
    <table>
        <thead>
            <tr>
                <th>Apartment No</th>
                <th>Floor No</th>
                <th>Rent Amount</th>
                <th>Availability</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($apartment = $apartments->fetch_assoc()): ?>
            <tr>
                <td><?php echo $apartment['Apartment_No']; ?></td>
                <td><?php echo $apartment['Floor_No']; ?></td>
                <td><?php echo $apartment['Rent_Amount']; ?></td>
                <td><?php echo $apartment['Availability_Status']; ?></td>
                <td><a href="viewApartment.php?apartment_no=<?php echo $apartment['Apartment_No']; ?>" class="details-link">View Details</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    // Toggle new apartment form visibility with smooth transition
    function toggleNewApartmentForm() {
        const form = document.getElementById('newApartmentForm');
        form.style.display = form.style.display === 'block' ? 'none' : 'block';
    }
</script>

</body>
</html>
