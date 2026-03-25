<?php
session_start();
include 'db.php';

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error_message = "Please fill all fields!";
    } else {

        // ✅ GET USER BY USERNAME ONLY
        $stmt = $conn->prepare("SELECT * FROM tenants WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $user = $result->fetch_assoc();

            // ✅ CHECK PASSWORD MANUALLY
            if ($password == $user['password']) {

                $_SESSION['tenant_id'] = $user['id'];
                $_SESSION['tenant_name'] = $user['name'];

                header("Location: tenantDashboard.php");
                exit();

            } else {
                $error_message = "Incorrect password!";
            }

        } else {
            $error_message = "User not found!";
        }

        $stmt->close();
    }

    $conn->close();
}
?>