<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $contact_info = $_POST['contact_info'];
    $lease_start = $_POST['lease_start'];
    $lease_end = $_POST['lease_end'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO Tenant (Name, Contact_Info, Lease_Start_Date, Lease_End_Date, Login_Username, Login_Password)
            VALUES ('$name', '$contact_info', '$lease_start', '$lease_end', '$username', '$password')";
    
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
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #8E44AD, #3498DB); /* Purple to Blue Gradient */
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Form Wrapper */
        .form-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 350px;
            text-align: center;
            animation: fadeIn 0.8s ease-in-out;
        }

        h2 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #8E44AD;
            font-weight: 700;
        }

        label {
            font-size: 14px;
            font-weight: 600;
            display: block;
            text-align: left;
            margin-bottom: 6px;
            color: #333;
        }

        input[type="text"], input[type="date"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            background-color: #f9f9f9;
            color: #333;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus, input[type="date"]:focus, input[type="password"]:focus {
            border-color: #8E44AD;
            box-shadow: 0 0 6px rgba(142, 68, 173, 0.5);
        }

        button[type="submit"] {
            background: linear-gradient(135deg, #8E44AD, #3498DB);
            color: #fff;
            padding: 10px 16px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            font-weight: bold;
            width: 100%;
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(142, 68, 173, 0.3);
        }

        .home-button {
            background: #8E44AD;
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.2s ease;
            display: inline-block;
            margin-bottom: 15px;
        }

        .home-button:hover {
            background-color: #6C3483;
        }

        .login-link {
            margin-top: 15px;
            font-size: 14px;
            color: #8E44AD;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        .success-message, .error-message {
            font-size: 14px;
            margin-top: 10px;
        }

        .success-message {
            color: #27AE60; /* Green */
        }

        .error-message {
            color: #E74C3C; /* Red */
        }

        /* Animations */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .form-container {
                padding: 15px;
            }

            h2 {
                font-size: 20px;
            }

            button[type="submit"], .home-button {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

    <!-- Home Button -->
    <a href="index.php" class="home-button">Back to Home</a>

    <!-- Registration Form -->
    <div class="form-container">
        <h2>Tenant Registration</h2>
        <form method="POST" action="register.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            
            <label for="contact_info">Contact Info:</label>
            <input type="text" id="contact_info" name="contact_info" placeholder="Enter your contact details" required>
            
            <label for="lease_start">Lease Start Date:</label>
            <input type="date" id="lease_start" name="lease_start" required>
            
            <label for="lease_end">Lease End Date:</label>
            <input type="date" id="lease_end" name="lease_end" required>
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Create a username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Create a password" required>
            
            <button type="submit">Register</button>
        </form>
        <!-- Login Link -->
        <a href="login.php" class="login-link">Already have an account? Login here</a>
    </div>

</body>
</html>
