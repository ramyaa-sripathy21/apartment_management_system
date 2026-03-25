<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Check admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Fetch apartments (FIXED lowercase)
$sql = "SELECT * FROM apartment";
$apartments = $conn->query($sql);

// Handle add apartment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_apartment'])) {

    $apartment_no = $_POST['apartment_no'];
    $floor_no = $_POST['floor_no'];
    $rent_amount = $_POST['rent_amount'];
    $availability_status = $_POST['availability_status'];

    $stmt = $conn->prepare("INSERT INTO apartment (Apartment_No, Floor_No, Rent_Amount, Availability_Status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sids", $apartment_no, $floor_no, $rent_amount, $availability_status);

    if ($stmt->execute()) {
        $message = "Apartment added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Apartments</title>

<style>
body { font-family: Arial; background: #f4f7fc; }
.container { margin-left: 260px; padding: 20px; }
.sidebar {
    width: 250px;
    position: fixed;
    height: 100%;
    background: #333;
    color: white;
    padding: 20px;
}
.sidebar a { color: white; display: block; margin: 10px 0; text-decoration: none; }
table { width: 100%; border-collapse: collapse; }
th, td { padding: 10px; border: 1px solid #ddd; }
button { padding: 10px; background: blue; color: white; border: none; }
.form-box { display: none; margin-top: 20px; }
</style>

</head>
<body>

<div class="sidebar">
    <h3>Admin Panel</h3>
    <a href="adminDashboard.php">Dashboard</a>
    <a href="apartments.php">Apartments</a>
    <a href="tenants.php">Tenants</a>
    <a href="payments.php">Payments</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container">

<h2>Manage Apartments</h2>

<?php if (isset($message)) echo "<p>$message</p>"; ?>

<button onclick="toggleForm()">Add Apartment</button>

<div class="form-box" id="formBox">
<form method="POST">
    <input type="text" name="apartment_no" placeholder="Apartment No" required><br><br>
    <input type="number" name="floor_no" placeholder="Floor No" required><br><br>
    <input type="number" name="rent_amount" placeholder="Rent" required><br><br>

    <select name="availability_status">
        <option value="Available">Available</option>
        <option value="Occupied">Occupied</option>
    </select><br><br>

    <button type="submit" name="add_apartment">Add</button>
</form>
</div>

<br>

<table>
<tr>
    <th>Apartment No</th>
    <th>Floor</th>
    <th>Rent</th>
    <th>Status</th>
</tr>

<?php while($row = $apartments->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['Apartment_No']; ?></td>
    <td><?php echo $row['Floor_No']; ?></td>
    <td><?php echo $row['Rent_Amount']; ?></td>
    <td><?php echo $row['Availability_Status']; ?></td>
</tr>
<?php endwhile; ?>

</table>

</div>

<script>
function toggleForm() {
    var f = document.getElementById("formBox");
    f.style.display = (f.style.display === "block") ? "none" : "block";
}
</script>

</body>
</html>