<?php
session_start();
include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['tenant_name'] ?? 'Tenant';
$tenant_id = $_SESSION['tenant_id'];

// AVAILABLE APARTMENTS
$apartments = mysqli_query($conn, "
SELECT * FROM apartments 
WHERE status = 'available'
");

// BOOKED APARTMENT
$booked = mysqli_query($conn, "
SELECT a.*
FROM tenants t
JOIN apartments a ON t.apartment_id = a.id
WHERE t.id = $tenant_id
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

.card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

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

/* Normal links */
.top-links a {
    margin-right: 15px;
    text-decoration: none;
    color: #2196F3;
    font-weight: bold;
}

/* 🔴 LOGOUT BUTTON RED */
.logout-btn {
    background: red;
    color: white !important;
    padding: 6px 10px;
    border-radius: 5px;
}

.logout-btn:hover {
    background: darkred;
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
    <a href="logout.php" class="logout-btn">🚪 Logout</a>
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

        <?php 
        if(mysqli_num_rows($apartments) > 0){
            while($row = mysqli_fetch_assoc($apartments)) { 
        ?>
        <tr>
            <td><?php echo $row['apartment_no']; ?></td>
            <td><?php echo $row['floor']; ?></td>
            <td>₹<?php echo $row['rent']; ?></td>

            <td>
                <form method="POST" action="bookApartment.php">
                    <input type="hidden" name="apartment_id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Book</button>
                </form>
            </td>
        </tr>
        <?php 
            } 
        } else { 
        ?>
        <tr>
            <td colspan="4" style="text-align:center;">No Available Apartments</td>
        </tr>
        <?php } ?>

    </table>
</div>

<!-- BOOKED APARTMENT -->
<div class="card">
    <h3>Your Booked Apartment</h3>

    <table>
        <tr>
            <th>Apartment No</th>
            <th>Floor</th>
            <th>Rent</th>
        </tr>

        <?php 
        if(mysqli_num_rows($booked) > 0){
            while($row = mysqli_fetch_assoc($booked)) { 
        ?>
        <tr>
            <td><?php echo $row['apartment_no']; ?></td>
            <td><?php echo $row['floor']; ?></td>
            <td>₹<?php echo $row['rent']; ?></td>
        </tr>
        <?php 
            } 
        } else { 
        ?>
        <tr>
            <td colspan="3" style="text-align:center;">No Apartment Booked</td>
        </tr>
        <?php } ?>

    </table>
</div>

</div>

</body>
</html>