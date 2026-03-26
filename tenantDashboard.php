<?php
session_start();
include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$tenant_id = $_SESSION['tenant_id'];

/* -------- FETCH TENANT DETAILS -------- */
$tenant_query = "SELECT * FROM tenants WHERE id='$tenant_id'";
$tenant_result = mysqli_query($conn, $tenant_query);
$tenant = mysqli_fetch_assoc($tenant_result);

/* -------- AVAILABLE APARTMENTS -------- */
$available_query = "SELECT * FROM apartments WHERE status='available'";
$available_result = mysqli_query($conn, $available_query);

/* -------- TENANT APARTMENT -------- */
$my_apartment_query = "SELECT * FROM apartments WHERE tenant_id='$tenant_id'";
$my_apartment_result = mysqli_query($conn, $my_apartment_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tenant Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Tenant Panel</h2>
        <a href="#">Home</a>
        <a href="makePayments.php">Payments</a>
        <a href="maintenanceRequest.php">Maintenance</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- 🔥 WELCOME -->
        <div class="card welcome">
            <h2>Welcome back, <?php echo $tenant['name']; ?> 👋</h2>
            <p>Your smart living dashboard is ready 🚀</p>

            <div class="info">
                <p><strong>Email:</strong> <?php echo $tenant['email']; ?></p>
                <p><strong>Phone:</strong> <?php echo $tenant['phone']; ?></p>
                <p><strong>Tenant ID:</strong> <?php echo $tenant['id']; ?></p>
            </div>
        </div>

        <!-- 🏢 AVAILABLE APARTMENTS -->
        <div class="card">
            <h3>Available Apartments</h3>

            <table>
                <tr>
                    <th>Apartment No</th>
                    <th>Floor</th>
                    <th>Rent</th>
                    <th>Action</th>
                </tr>

                <?php while($row = mysqli_fetch_assoc($available_result)) { ?>
                <tr>
                    <td><?php echo $row['apartment_no']; ?></td>
                    <td><?php echo $row['floor']; ?></td>
                    <td>₹<?php echo $row['rent']; ?></td>
                    <td>
                        <form method="POST" action="bookApartment.php">
                            <input type="hidden" name="apartment_no" value="<?php echo $row['apartment_no']; ?>">
                            <button class="btn">Book</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>

            </table>
        </div>

        <!-- 🏠 YOUR APARTMENT -->
        <div class="card">
            <h3>Your Apartment</h3>

            <table>
                <tr>
                    <th>Apartment No</th>
                    <th>Floor</th>
                    <th>Rent</th>
                </tr>

                <?php
                if (mysqli_num_rows($my_apartment_result) > 0) {
                    while($row = mysqli_fetch_assoc($my_apartment_result)) {
                ?>
                <tr>
                    <td><?php echo $row['apartment_no']; ?></td>
                    <td><?php echo $row['floor']; ?></td>
                    <td>₹<?php echo $row['rent']; ?></td>
                </tr>
                <?php } } else { ?>
                <tr>
                    <td colspan="3">No apartment booked yet</td>
                </tr>
                <?php } ?>

            </table>
        </div>

    </div>
</div>

</body>
</html>