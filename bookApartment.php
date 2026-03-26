<?php
session_start();
include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$tenant_id = $_SESSION['tenant_id'];

/* -------- CHECK INPUT -------- */
if (!isset($_POST['apartment_no']) || empty($_POST['apartment_no'])) {
    echo "<script>alert('Error: Apartment not selected'); window.location='tenantDashboard.php';</script>";
    exit();
}

$apartment_no = $_POST['apartment_no'];

/* -------- CHECK IF APARTMENT ALREADY BOOKED -------- */
$check = mysqli_query($conn, "
    SELECT * FROM apartments 
    WHERE apartment_no='$apartment_no' AND status='occupied'
");

if (mysqli_num_rows($check) > 0) {
    echo "<script>
        alert('Apartment already booked!');
        window.location='tenantDashboard.php';
    </script>";
    exit();
}

/* -------- BOOK APARTMENT (ALLOW MULTIPLE) -------- */
$update = "
UPDATE apartments 
SET tenant_id='$tenant_id', status='occupied' 
WHERE apartment_no='$apartment_no'
";

if (mysqli_query($conn, $update)) {
    echo "<script>
        alert('Apartment booked successfully!');
        window.location='tenantDashboard.php';
    </script>";
} else {
    echo "<script>
        alert('Booking failed!');
        window.location='tenantDashboard.php';
    </script>";
}
?>