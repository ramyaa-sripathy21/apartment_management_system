<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data safely
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if fields are empty
    if (empty($username) || empty($password)) {
        $error_message = "Please fill all fields!";
    } else {

        // Prepared statement (SECURE)
        $stmt = $conn->prepare("SELECT * FROM tenant WHERE Username = ? AND Password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $tenant = $result->fetch_assoc();

            // Store session
            $_SESSION['tenant_id'] = $tenant['Tenant_ID'];
            $_SESSION['tenant_name'] = $tenant['Name'];

            // Redirect to dashboard
            header("Location: tenantDashboard.php");
            exit();

        } else {
            $error_message = "Invalid username or password!";
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Login</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

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

    <!-- Error Message -->
    <?php if (!empty($error_message)) { ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php } ?>

    <!-- Login Form -->
    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" placeholder="Enter username" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter password" required>

        <button type="submit">Login</button>
    </form>

    <div class="links">
        <a href="index.php">⬅ Back</a>
        <a href="register.php">Register</a>
    </div>
</div>

</body>
</html>