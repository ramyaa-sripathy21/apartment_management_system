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

// ✅ Must come from POST (not GET)
if (!isset($_POST['apartment_no'])) {
    header("Location: tenantDashboard.php");
    exit();
}

$apartment_no = $_POST['apartment_no'];

// ✅ Check if already booked
$stmt = $conn->prepare("SELECT * FROM tenant_apartment_booking WHERE Tenant_ID = ?");
$stmt->bind_param("i", $tenant_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: tenantDashboard.php?already=1");
    exit();
}

// ✅ Insert booking
$stmt2 = $conn->prepare("
    INSERT INTO tenant_apartment_booking (Tenant_ID, Apartment_No, Booking_Date)
    VALUES (?, ?, CURDATE())
");
$stmt2->bind_param("is", $tenant_id, $apartment_no);
$stmt2->execute();

// ✅ Update apartment status
$stmt3 = $conn->prepare("UPDATE apartment SET Availability_Status='Occupied' WHERE Apartment_No=?");
$stmt3->bind_param("s", $apartment_no);
$stmt3->execute();

// ✅ Redirect with success
header("Location: tenantDashboard.php?booked=1");
exit();
?>