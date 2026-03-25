<?php
session_start();
include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['tenant_name'] ?? 'Tenant';
$tenant_id = $_SESSION['tenant_id'];

// ✅ FETCH AVAILABLE APARTMENTS
$apartments = mysqli_query($conn, "
SELECT * FROM apartment 
WHERE LOWER(Availability_Status) = 'available'
");

// ✅ FETCH BOOKED APARTMENTS (optional display)
$booked = mysqli_query($conn, "
SELECT a.*
FROM tenant_apartment_booking t
JOIN apartment a ON t.Apartment_No = a.Apartment_No
WHERE t.Tenant_ID = $tenant_id
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Tenant Dashboard</title>

<style>
body {
    font-family: Segoe UI;
    background: #f4f6f9;
    margin: 0;
}

.header {
    background: #1e1e2f;
    color: white;
    padding: 15px;
    text-align: center;
}

.container {
    padding: 30px;
}

/* Card */
.card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

th {
    background: #f1f1f1;
}

/* Buttons */
button {
    padding: 8px 12px;
    border: none;
    background: #28a745;
    color: white;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    opacity: 0.9;
}

.top-links {
    margin-bottom: 20px;
}

.top-links a {
    margin-right: 15px;
    text-decoration: none;
    color: #2196F3;
}
</style>

</head>

<body>

<div class="header">
    <h2>Welcome, <?php echo $name; ?></h2>
</div>

<div class="container">

<!-- LINKS -->
<div class="top-links">
    <a href="makePayment.php">💳 Make Payment</a>
    <a href="maintenanceRequest.php">🛠 Maintenance</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- AVAILABLE APARTMENTS -->
<div class="card">
    <h3>Available Apartments</h3>

    <table>
        <tr>
            <th>Apartment No</th>
            <th>Floor</th>
            <th>Rent</th>
            <th>Action</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($apartments)) { ?>
        <tr>
            <td><?php echo $row['Apartment_No']; ?></td>
            <td><?php echo $row['Floor']; ?></td>
            <td>₹<?php echo $row['Rent_Amount']; ?></td>

            <td>
                <form method="POST" action="bookApartment.php">
                    <input type="hidden" name="apartment_no" value="<?php echo $row['Apartment_No']; ?>">
                    <button type="submit">Book</button>
                </form>
            </td>
        </tr>
        <?php } ?>

    </table>
</div>

<!-- BOOKED APARTMENTS -->
<div class="card">
    <h3>Your Booked Apartments</h3>

    <table>
        <tr>
            <th>Apartment No</th>
            <th>Floor</th>
            <th>Rent</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($booked)) { ?>
        <tr>
            <td><?php echo $row['Apartment_No']; ?></td>
            <td><?php echo $row['Floor']; ?></td>
            <td>₹<?php echo $row['Rent_Amount']; ?></td>
        </tr>
        <?php } ?>

    </table>
</div>

</div>

</body>
</html>