<?php
include("db.php");

// FETCH AVAILABLE APARTMENTS
$apartments = mysqli_query($conn, "SELECT * FROM apartments WHERE status='Available'");

// ADD TENANT
if(isset($_POST['addTenant'])){
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $apartment_id = $_POST['apartment_id'];

    // INSERT TENANT
    mysqli_query($conn, "INSERT INTO tenants (name, contact, start_date, end_date, apartment_id)
    VALUES ('$name','$contact','$start','$end','$apartment_id')");

    // UPDATE APARTMENT STATUS → Occupied
    mysqli_query($conn, "UPDATE apartments SET status='Occupied' WHERE id=$apartment_id");

    header("Location: tenants.php");
}

// DROP TENANT (FREE APARTMENT)
if(isset($_GET['drop'])){
    $tenant_id = $_GET['drop'];

    // Get apartment_id
    $get = mysqli_query($conn, "SELECT apartment_id FROM tenants WHERE id=$tenant_id");
    $row = mysqli_fetch_assoc($get);
    $apartment_id = $row['apartment_id'];

    // Make apartment Available again
    mysqli_query($conn, "UPDATE apartments SET status='Available' WHERE id=$apartment_id");

    // Delete tenant (or keep if you want history)
    mysqli_query($conn, "DELETE FROM tenants WHERE id=$tenant_id");

    header("Location: tenants.php");
}

// FETCH TENANTS WITH APARTMENT
$result = mysqli_query($conn, "
    SELECT tenants.*, apartments.apartment_no 
    FROM tenants 
    LEFT JOIN apartments ON tenants.apartment_id = apartments.id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Tenants</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    display: flex;
    background: #f4f6f9;
}

/* Sidebar */
.sidebar {
    width: 230px;
    height: 100vh;
    background: #1e1e2f;
    color: #fff;
    padding: 20px;
    position: fixed;
}

.sidebar h2 {
    margin-bottom: 30px;
}

.sidebar a {
    display: block;
    color: #ccc;
    text-decoration: none;
    padding: 12px;
    margin: 10px 0;
    border-radius: 8px;
}

.sidebar a:hover {
    background: #2f2f45;
    color: #fff;
}

/* Main */
.main {
    margin-left: 230px;
    padding: 30px;
    width: 100%;
}

/* Card */
.card {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    margin-bottom: 25px;
}

/* Title */
.title {
    font-size: 22px;
    margin-bottom: 20px;
    color: #333;
}

/* Form */
.form-group {
    margin-bottom: 15px;
}

input, select {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

input:focus, select:focus {
    border-color: #2196F3;
}

/* Button */
button {
    width: 100%;
    padding: 12px;
    background: #2196F3;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background: #1976D2;
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
}

table thead {
    background: #f1f1f1;
}

table th, table td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

table tr:hover {
    background: #f9f9f9;
}

/* Drop Button */
.drop-btn {
    color: #fff;
    background: #e53935;
    padding: 6px 10px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
}

.drop-btn:hover {
    background: #c62828;
}

/* Responsive */
@media(max-width: 768px){
    .sidebar { display: none; }
    .main { margin-left: 0; }
}
</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="adminDashboard.php">Dashboard</a>
    <a href="apartments.php">Apartments</a>
    <a href="tenants.php">Tenants</a>
    <a href="payments.php">Payments</a>
    <a href="maintenance.php">Maintenance</a>
    <a href="logout.php">Logout</a>
</div>

<!-- Main -->
<div class="main">

    <!-- Add Tenant -->
    <div class="card">
        <div class="title">Add Tenant</div>

        <form method="POST">

            <div class="form-group">
                <input type="text" name="name" placeholder="Tenant Name" required>
            </div>

            <div class="form-group">
                <input type="text" name="contact" placeholder="Contact Number" required>
            </div>

            <div class="form-group">
                <input type="date" name="start" required>
            </div>

            <div class="form-group">
                <input type="date" name="end" required>
            </div>

            <!-- Apartment Dropdown -->
            <div class="form-group">
                <select name="apartment_id" required>
                    <option value="">Select Apartment</option>

                    <?php while($row = mysqli_fetch_assoc($apartments)) { ?>
                        <option value="<?php echo $row['id']; ?>">
                            <?php echo $row['apartment_no']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" name="addTenant">Add Tenant</button>
        </form>
    </div>

    <!-- Tenant List -->
    <div class="card">
        <div class="title">All Tenants</div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Apartment</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['contact']; ?></td>
                    <td><?php echo $row['apartment_no']; ?></td>
                    <td><?php echo $row['start_date']; ?></td>
                    <td><?php echo $row['end_date']; ?></td>

                    <td>
                        <a href="?drop=<?php echo $row['id']; ?>" 
                           onclick="return confirm('Vacate this apartment?')" 
                           class="drop-btn">
                           Drop
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>