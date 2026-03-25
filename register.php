<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $contact = $_POST['contact'];        // ✅ fixed name
    $start = $_POST['start'];            // ✅ fixed name
    $end = $_POST['end'];                // ✅ fixed name
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ✅ FIXED TABLE + COLUMN NAMES
    $sql = "INSERT INTO tenants (name, contact, start_date, end_date, username, password)
            VALUES ('$name', '$contact', '$start', '$end', '$username', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='success-message'>Registration successful!</div>";
    } else {
        echo "<div class='error-message'>Error: " . $conn->error . "</div>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family:'Poppins', sans-serif;
            background: linear-gradient(135deg, #8E44AD, #3498DB);
            color:#fff;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }

        .form-container {
            background: rgba(255,255,255,0.9);
            padding:20px;
            border-radius:10px;
            box-shadow:0 4px 15px rgba(0,0,0,0.2);
            width:100%;
            max-width:350px;
            text-align:center;
        }

        h2 {
            font-size:22px;
            margin-bottom:15px;
            color:#8E44AD;
        }

        label {
            font-size:14px;
            display:block;
            text-align:left;
            margin-bottom:6px;
            color:#333;
        }

        input {
            width:100%;
            padding:10px;
            margin-bottom:15px;
            border:1px solid #ddd;
            border-radius:6px;
            background:#f9f9f9;
        }

        button {
            background: linear-gradient(135deg, #8E44AD, #3498DB);
            color:#fff;
            padding:10px;
            border:none;
            border-radius:6px;
            width:100%;
            cursor:pointer;
        }

        .home-button {
            background:#8E44AD;
            color:#fff;
            padding:8px 16px;
            border-radius:6px;
            text-decoration:none;
            display:inline-block;
            margin-bottom:15px;
        }

        .login-link {
            margin-top:15px;
            color:#8E44AD;
            text-decoration:none;
            display:inline-block;
            font-weight:bold;
        }

        .success-message { color:green; }
        .error-message { color:red; }
    </style>
</head>

<body>

<a href="index.php" class="home-button">Back to Home</a>

<div class="form-container">
    <h2>Tenant Registration</h2>

    <form method="POST">

        <label>Name:</label>
        <input type="text" name="name" required>

        <!-- ✅ FIXED NAME -->
        <label>Contact Info:</label>
        <input type="text" name="contact" required>

        <!-- ✅ FIXED NAME -->
        <label>Lease Start Date:</label>
        <input type="date" name="start" required>

        <!-- ✅ FIXED NAME -->
        <label>Lease End Date:</label>
        <input type="date" name="end" required>

        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Register</button>

    </form>

    <a href="login.php" class="login-link">Already have an account? Login here</a>
</div>

</body>
</html>