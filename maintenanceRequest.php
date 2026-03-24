<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Check login
if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$tenant_id = $_SESSION['tenant_id'];

// Get tenant
$result = $conn->query("SELECT * FROM Tenant WHERE Tenant_ID='$tenant_id'");
$tenant = $result->fetch_assoc();

$tenant_name = $tenant['Name'] ?? 'Guest';

// Submit request
if (isset($_POST['submit'])) {
    $desc = $_POST['description'];

    $conn->query("INSERT INTO Maintenance (Tenant_ID, Apartment_No, Request_Date, Issue_Description, Status)
                  VALUES ('$tenant_id', '0', CURDATE(), '$desc', 'Pending')");

    header("Location: tenantDashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Maintenance</title>
<style>
body {
    font-family: Arial;
    background: #f2f2f2;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.box {
    background: white;
    padding: 30px;
    width: 400px;
    border-radius: 10px;
}
button {
    width: 100%;
    padding: 10px;
    background: blue;
    color: white;
    border: none;
}
textarea {
    width: 100%;
    height: 120px;
    margin-bottom: 10px;
}
</style>
</head>

<body>

<div class="box">
    <h2>Submit Maintenance Request</h2>
    <p>Welcome, <?php echo $tenant_name; ?></p>

    <form method="POST">
        <textarea name="description" placeholder="Describe issue..." required></textarea>
        <button name="submit">Submit</button>
    </form>

    <br>
    <a href="tenantDashboard.php">Back</a>
</div>

</body>
</html>