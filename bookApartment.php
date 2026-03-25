<?php
session_start();
include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$tenant_id = $_SESSION['tenant_id'];

if (!isset($_POST['apartment_no'])) {
    header("Location: tenantDashboard.php");
    exit();
}

$apartment_no = $_POST['apartment_no'];

// ✅ Allow multiple bookings (NO restriction)

$stmt = $conn->prepare("
    INSERT INTO tenant_apartment_booking (Tenant_ID, Apartment_No, Booking_Date)
    VALUES (?, ?, CURDATE())
");
$stmt->bind_param("is", $tenant_id, $apartment_no);
$stmt->execute();

// mark apartment occupied
$stmt2 = $conn->prepare("
    UPDATE apartment 
    SET Availability_Status='Occupied' 
    WHERE Apartment_No=?
");
$stmt2->bind_param("s", $apartment_no);
$stmt2->execute();

header("Location: tenantDashboard.php?booked=1");
exit();
?>