<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Fetch tenants
$result = $conn->query("SELECT * FROM tenant");

// Add tenant
if (isset($_POST['add_tenant'])) {
    $name = $_POST['name'];
    $contact = $_POST['contact_info'];
    $start = $_POST['lease_start'];
    $end = $_POST['lease_end'];

    $conn->query("INSERT INTO tenant (Name, Contact_Info, Lease_Start_Date, Lease_End_Date)
                  VALUES ('$name','$contact','$start','$end')");

    header("Location: tenants.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tenants</title>
</head>
<body>

<h2>Manage Tenants</h2>

<form method="POST">
    Name: <input type="text" name="name"><br><br>
    Contact: <input type="text" name="contact_info"><br><br>
    Start: <input type="date" name="lease_start"><br><br>
    End: <input type="date" name="lease_end"><br><br>
    <button name="add_tenant">Add</button>
</form>

<br><br>

<table border="1">
<tr>
    <th>Name</th>
    <th>Contact</th>
    <th>Start</th>
    <th>End</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['Name']; ?></td>
    <td><?php echo $row['Contact_Info']; ?></td>
    <td><?php echo $row['Lease_Start_Date']; ?></td>
    <td><?php echo $row['Lease_End_Date']; ?></td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>