<?php
session_start();
include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    die("Session error: tenant not logged in");
}

$tenant_id = $_SESSION['tenant_id'];

if (!isset($_POST['apartment_no'])) {
    die("Error: apartment not selected");
}

$apartment_no = $_POST['apartment_no'];

// DEBUG (REMOVE AFTER TEST)
echo "Tenant: $tenant_id | Apartment: $apartment_no <br>";

// INSERT BOOKING
$stmt = $conn->prepare("
    INSERT INTO tenant_apartment_booking (Tenant_ID, Apartment_No, Booking_Date)
    VALUES (?, ?, CURDATE())
");

if(!$stmt){
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("is", $tenant_id, $apartment_no);

if(!$stmt->execute()){
    die("Insert failed: " . $stmt->error);
}

// UPDATE STATUS
$stmt2 = $conn->prepare("
    UPDATE apartment 
    SET Availability_Status='Occupied' 
    WHERE Apartment_No=?
");

$stmt2->bind_param("s", $apartment_no);
$stmt2->execute();

echo "Booking successful!";
exit();
?>