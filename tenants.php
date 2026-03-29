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

        // INSERT TENANT
        mysqli_query($conn, "INSERT INTO tenants (name, contact, start_date, end_date, apartment_id)
        VALUES ('$name','$contact','$start','$end','$apartment_id')");

        // UPDATE APARTMENT STATUS
        mysqli_query($conn, "UPDATE apartments SET status='occupied' WHERE id='$apartment_id'");

        echo "<script>alert('Tenant Added Successfully'); window.location='tenants.php';</script>";
    }
}

/* -------- DROP TENANT (FIXED) -------- */
if (isset($_GET['drop'])) {

    $tenant_id = $_GET['drop'];

    // 🔥 STEP 1: Get apartment_id of tenant
    $get = mysqli_query($conn, "SELECT apartment_id FROM tenants WHERE id='$tenant_id'");
    $row = mysqli_fetch_assoc($get);

    if ($row && !empty($row['apartment_id'])) {

        $apartment_id = $row['apartment_id'];

        // 🔥 STEP 2: Make apartment available
        mysqli_query($conn, "UPDATE apartments 
                             SET status='available' 
                             WHERE id='$apartment_id'");

        // 🔥 STEP 3: Delete tenant
        mysqli_query($conn, "DELETE FROM tenants WHERE id='$tenant_id'");

        header("Location: tenants.php?success=1");
        exit();

    } else {
        header("Location: tenants.php?error=1");
        exit();
    }
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

.sidebar {
    width: 230px;
    background: #1e1e2f;
    color: white;
    padding: 20px;
    height: 100vh;
}

.sidebar a {
    display: block;
    color: #ccc;
    padding: 10px;
    text-decoration: none;
}

.sidebar a:hover {
    background: #333;
    color: white;
}

.main {
    flex: 1;
    padding: 30px;
}

.card {
    background: white;
    padding: 25px;
    margin-bottom: 25px;
    border-radius: 12px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

.drop-btn {
    background: #e74c3c;
    padding: 6px 12px;
    border-radius: 5px;
    color: white;
    text-decoration: none;
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

<!-- ❌ ERROR POPUP -->
<?php if (isset($_GET['error'])) { ?>
<script>
    alert("❌ Something went wrong!");
</script>
<?php } ?>

<div class="sidebar">
<h2>Admin Panel</h2>
<a href="adminDashboard.php">Dashboard</a>
<a href="apartments.php">Apartments</a>
<a href="tenants.php">Tenants</a>
</div>

<div class="main">

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