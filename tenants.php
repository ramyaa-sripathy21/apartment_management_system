<?php
include("db.php");

/* -------- FETCH AVAILABLE APARTMENTS -------- */
$apartments = mysqli_query($conn, "
SELECT * FROM apartments 
WHERE status = 'available'
");

/* -------- ADD TENANT -------- */
if(isset($_POST['addTenant'])){

    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $apartment_id = $_POST['apartment_id'];

    if(empty($apartment_id)){
        echo "<script>alert('Please select an apartment');</script>";
    } else {

        mysqli_query($conn, "INSERT INTO tenants (name, contact, start_date, end_date, apartment_id)
        VALUES ('$name','$contact','$start','$end','$apartment_id')");

        mysqli_query($conn, "UPDATE apartments 
                             SET status='occupied' 
                             WHERE id='$apartment_id'");

        echo "<script>alert('Tenant Added Successfully'); window.location='tenants.php';</script>";
    }
}

/* -------- DROP TENANT -------- */
if (isset($_GET['drop'])) {

    $tenant_id = $_GET['drop'];

    // Get apartment_id
    $get = mysqli_query($conn, "SELECT apartment_id FROM tenants WHERE id='$tenant_id'");
    $row = mysqli_fetch_assoc($get);

    // If assigned → free apartment
    if ($row && !empty($row['apartment_id'])) {

        $apartment_id = $row['apartment_id'];

        mysqli_query($conn, "UPDATE apartments 
                             SET status='available' 
                             WHERE id='$apartment_id'");
    }

    // Delete tenant
    mysqli_query($conn, "DELETE FROM tenants WHERE id='$tenant_id'");

    header("Location: tenants.php?success=1");
    exit();
}

/* -------- FETCH TENANTS -------- */
$result = mysqli_query($conn, "
SELECT tenants.*, apartments.apartment_no 
FROM tenants 
LEFT JOIN apartments ON tenants.apartment_id = apartments.id
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Tenants</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI';
    background: #f4f6f9;
    display: flex;
}

/* Sidebar */
.sidebar {
    width: 230px;
    background: #1e1e2f;
    color: white;
    padding: 20px;
    height: 100vh;
}

.sidebar h2 {
    margin-bottom: 20px;
}

.sidebar a {
    display: block;
    color: #ccc;
    padding: 10px;
    text-decoration: none;
    border-radius: 6px;
}

.sidebar a:hover {
    background: #333;
    color: white;
}

/* Main */
.main {
    flex: 1;
    padding: 30px;
}

/* Card */
.card {
    background: white;
    padding: 25px;
    margin-bottom: 25px;
    border-radius: 12px;
    box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
}

/* Form */
form {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

input, select {
    padding: 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

/* Button */
button {
    padding: 12px;
    background: #3498db;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

button:hover {
    background: #2980b9;
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #eee;
    padding: 12px;
}

td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

/* Drop Button */
.drop-btn {
    background: #e74c3c;
    padding: 6px 12px;
    border-radius: 5px;
    color: white;
    text-decoration: none;
}

.drop-btn:hover {
    background: #c0392b;
}
</style>
</head>

<body>

<!-- ✅ SUCCESS POPUP -->
<?php if (isset($_GET['success'])) { ?>
<script>
    alert("✅ Tenant dropped successfully!");
</script>
<?php } ?>

<div class="sidebar">
<h2>Admin Panel</h2>
<a href="adminDashboard.php">Dashboard</a>
<a href="apartments.php">Apartments</a>
<a href="tenants.php">Tenants</a>
<a href="payments.php">Payments</a>
<a href="maintenance.php">Maintenance</a>
</div>

<div class="main">

<!-- ✅ ADD TENANT (RESTORED) -->
<div class="card">
<h2>Add Tenant</h2>

<form method="POST">
    <input type="text" name="name" placeholder="Tenant Name" required>
    <input type="text" name="contact" placeholder="Phone Number" required>
    <input type="date" name="start_date" required>
    <input type="date" name="end_date" required>

    <select name="apartment_id" required>
        <option value="">Select Apartment</option>

        <?php while($apt = mysqli_fetch_assoc($apartments)) { ?>
            <option value="<?php echo $apt['id']; ?>">
                <?php echo $apt['apartment_no']; ?>
            </option>
        <?php } ?>

    </select>

    <button type="submit" name="addTenant">Add Tenant</button>
</form>
</div>

<!-- ✅ TENANTS TABLE -->
<div class="card">
<h2>All Tenants</h2>

<table>
<tr>
<th>Name</th>
<th>Contact</th>
<th>Apartment</th>
<th>Start</th>
<th>End</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['contact']; ?></td>

<td>
<?php echo $row['apartment_no'] ?? 'Not Assigned'; ?>
</td>

<td><?php echo $row['start_date']; ?></td>
<td><?php echo $row['end_date']; ?></td>

<td>
<a href="?drop=<?php echo $row['id']; ?>" 
onclick="return confirm('Vacate this apartment?')" 
class="drop-btn">Drop</a>
</td>
</tr>
<?php } ?>

</table>
</div>

</div>

</body>
</html>