<?php
session_start();
include 'db.php';

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "
    SELECT * FROM Tenant 
    WHERE Login_Username='$name' 
    AND Login_Password='$password'
");

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        // ✅ CLEAR OLD SESSION SAFELY
        $_SESSION = [];

        // ✅ SET NEW SESSION
        $_SESSION['tenant_id'] = $row['Tenant_ID'];

        session_regenerate_id(true);

        header("Location: tenantDashboard.php");
        exit();

    } else {
        $error_message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tenant Login</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #4CAF50, #2F80ED);
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.login-container {
    background: white;
    padding: 30px;
    border-radius: 10px;
    width: 100%;
    max-width: 400px;
    text-align: center;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

h2 {
    color: #007BFF;
    margin-bottom: 20px;
}

label {
    display: block;
    text-align: left;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

button {
    width: 100%;
    padding: 12px;
    background: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background: #0056b3;
}

.error {
    color: red;
    margin-bottom: 10px;
}

.links {
    margin-top: 15px;
}

.links a {
    text-decoration: none;
    color: #007BFF;
    margin: 0 10px;
}
</style>
</head>

<body>

<div class="login-container">
    <h2>Tenant Login</h2>

    <?php if (!empty($error_message)) { ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php } ?>

    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" placeholder="Enter username" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter password" required>

        <!-- ✅ FIXED BUTTON -->
        <button type="submit">Login</button>
    </form>

    <div class="links">
        <a href="index.php">⬅ Back</a>
        <a href="register.php">Register</a>
    </div>
</div>

</body>
</html>