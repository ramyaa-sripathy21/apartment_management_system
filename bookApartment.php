<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$tenant_id = $_SESSION['tenant_id'];
$tenant_name = $_SESSION['tenant_name'];

// Get apartment details
if (isset($_GET['apartment_no'])) {
    $apartment_no = $_GET['apartment_no'];

    $sql = "SELECT * FROM Apartment 
            WHERE Apartment_No = '$apartment_no' 
            AND Availability_Status = 'Available'";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $apartment = $result->fetch_assoc();
    } else {
        header("Location: tenantDashboard.php");
        exit();
    }
} else {
    header("Location: tenantDashboard.php");
    exit();
}

// Handle booking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $lease_start_date = $_POST['Lease_Start_Date'];
    $lease_end_date = $_POST['Lease_End_Date'];

    // Update apartment
    $update_sql = "UPDATE Apartment 
                   SET Availability_Status = 'Occupied' 
                   WHERE Apartment_No = '$apartment_no'";

    if ($conn->query($update_sql)) {

        // Insert booking
        $booking_sql = "INSERT INTO Tenant_Apartment_Booking 
        (Tenant_ID, Apartment_No, Lease_Start_Date, Lease_End_Date)
        VALUES ('$tenant_id', '$apartment_no', '$lease_start_date', '$lease_end_date')";

        if ($conn->query($booking_sql)) {
            echo "<script>alert('Apartment booked successfully!');
                  window.location.href='tenantDashboard.php';</script>";
        } else {
            echo "Booking Error: " . $conn->error;
        }

    } else {
        echo "Update Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Book Apartment</title>
</head>

<body>

<h2>Book Apartment</h2>

<p>Welcome, <?php echo $tenant_name; ?></p>

<table border="1">
<tr>
    <th>Apartment Number</th>
    <td><?php echo $apartment['Apartment_No']; ?></td>
</tr>
<tr>
    <th>Floor</th>
    <td><?php echo $apartment['Floor_No']; ?></td>
</tr>
<tr>
    <th>Rent</th>
    <td><?php echo $apartment['Rent_Amount']; ?></td>
</tr>
</table>

<form method="POST">
    <label>Start Date:</label>
    <input type="date" name="Lease_Start_Date" required><br><br>

    <label>End Date:</label>
    <input type="date" name="Lease_End_Date" required><br><br>

    <button type="submit">Confirm Booking</button>
</form>

<br>
<a href="tenantDashboard.php">Back</a>

</body>
</html>