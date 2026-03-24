<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Tenant WHERE Login_Username = '$username' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $tenant = $result->fetch_assoc();
        if ($password == $tenant['Login_Password']) {
            $_SESSION['tenant_id'] = $tenant['Tenant_ID'];
            $_SESSION['tenant_name'] = $tenant['Name'];
            header("Location: tenantDashboard.php");
            exit();
        } else {
            $error_message = "Invalid password!";
        }
    } else {
        $error_message = "Tenant not found!";
    }

    $conn->close();
}
?>