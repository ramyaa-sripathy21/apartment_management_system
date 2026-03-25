<?php
include("db.php");

// ADD APARTMENT
if(isset($_POST['addApartment'])){
    $no = $_POST['no'];
    $floor = $_POST['floor'];
    $rent = $_POST['rent'];
    $status = $_POST['status'];

    mysqli_query($conn, "INSERT INTO apartments (apartment_no, floor, rent, status)
    VALUES ('$no','$floor','$rent','$status')");
}

// FETCH
$result = mysqli_query($conn, "SELECT * FROM apartments");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Apartments</title>

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

/* Status badge */
.status {
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 13px;
}

.available {
    background: #d4edda;
    color: #155724;
}

.occupied {
    background: #f8d7da;
    color: #721c24;
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

    <!-- Add Apartment -->
    <div class="card">
        <div class="title">Add Apartment</div>

        <form method="POST">
            <div class="form-group">
                <input type="text" name="no" placeholder="Apartment No (e.g. A101)" required>
            </div>

            <div class="form-group">
                <input type="number" name="floor" placeholder="Floor" required>
            </div>

            <div class="form-group">
                <input type="number" name="rent" placeholder="Rent Amount" required>
            </div>

            <div class="form-group">
                <select name="status">
                    <option value="Available">Available</option>
                    <option value="Occupied">Occupied</option>
                </select>
            </div>

            <button type="submit" name="addApartment">Add Apartment</button>
        </form>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="title">All Apartments</div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Floor</th>
                    <th>Rent</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['apartment_no']; ?></td>
                    <td><?php echo $row['floor']; ?></td>
                    <td>₹<?php echo $row['rent']; ?></td>

                    <td>
                        <?php if($row['status'] == 'Available'){ ?>
                            <span class="status available">Available</span>
                        <?php } else { ?>
                            <span class="status occupied">Occupied</span>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>