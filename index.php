<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apartment Management System</title>
    <link rel="stylesheet" href="styless.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f5f5f5;
            color: #333;
            scroll-behavior: smooth;
        }

        header {
            background: linear-gradient(45deg, #4CAF50, #2F80ED);
            color: white;
            padding: 10px 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: flex-end;
        }

        nav ul li {
            margin: 0 10px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #FFD700;
        }

        /* Hero Section */
        .hero {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: 90vh;
            background: url('1.jpg') no-repeat center center/cover; /* Replace with your image path */
            color: white;
            padding: 0 20px;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            text-transform: uppercase;
            animation: fadeIn 2s ease-in-out;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .hero .btn {
            background: #FFD700;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            text-transform: uppercase;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .hero .btn:hover {
            background: #FFA500;
            color: white;
        }

        /* Features Section */
        .features {
            background: white;
            padding: 50px 20px;
            text-align: center;
        }

        .features h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
        }

        .feature-item {
            margin: 20px 0;
            animation: slideIn 1s ease-in-out;
        }

        .feature-item h3 {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        /* About Section */
        .about {
            background: #f0f0f0;
            padding: 50px 20px;
            text-align: center;
        }

        .about h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        /* Footer */
        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 20px 10px;
        }

        .footer-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .social-media {
            margin: 10px 0;
        }

        .social-media a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }

        .social-media a:hover {
            transform: scale(1.2);
        }

        /* Animations */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateX(-30px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                align-items: flex-start;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .features h2, .about h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Tenant Login</a></li>
                <li><a href="adminLogin.php">Admin Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Section -->
    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>Welcome to the Apartment Management System</h1>
                <p>Your one-stop platform for booking apartments, making payments, and submitting maintenance requests.</p>
                <a href="register.php" class="btn">Get Started</a>
            </div>
        </section>

        <section class="features">
            <h2>Our Key Features</h2>
            <div class="feature-item">
                <h3>Find & Book Apartments</h3>
                <p>Browse through available apartments and book your dream home in no time.</p>
            </div>
            <div class="feature-item">
                <h3>Secure Payments</h3>
                <p>Pay your rent securely and on time using our integrated payment system.</p>
            </div>
            <div class="feature-item">
                <h3>Maintenance Requests</h3>
                <p>Easily submit maintenance requests and track their progress.</p>
            </div>
        </section>

        <section class="about">
            <h2>About Us</h2>
            <p>We provide a seamless experience for both tenants and property managers, making renting and managing properties easier for everyone. Whether you’re looking for an apartment or managing tenants, we’re here to help.</p>
        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <div class="footer-container">
            <p>&copy; 2025 Apartment Management System | All Rights Reserved</p>
            <p>Contact us: <a href="mailto:praveenhallur2003@gmail.com">praveenhallur2003@gmail.com</a></p>
        </div>
    </footer>

</body>
</html>
