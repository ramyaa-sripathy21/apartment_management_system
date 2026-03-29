<?php
session_start();
include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['tenant_name'] ?? 'Tenant';
$tenant_id = $_SESSION['tenant_id'];

//echo "Maintenance Tenant ID = " . $tenant_id;
//exit();

// ✅ HANDLE SUBMIT (FIXED)
if (isset($_POST['submit'])) {

    $issue = $_POST['issue'];

    try {
        $stmt = $conn->prepare("
            INSERT INTO maintenance (tenant_id, issue, status)
            VALUES (?, ?, 'Pending')
        ");

        $stmt->bind_param("is", $tenant_id, $issue);
        $stmt->execute();

        header("Location: maintenanceRequest.php?success=1");
        exit();

    } catch (Exception $e) {
        header("Location: maintenanceRequest.php?success=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Maintenance Request</title>

<style>
body {
    font-family: Segoe UI;
    background: #f4f7fc;
    display: flex;
    justify-content: center;
}

.container {
    margin-top: 60px;
    background: white;
    padding: 25px;
    width: 420px;
    border-radius: 12px;
    box-shadow: 0px 5px 15px rgba(0,0,0,0.1);
}

textarea {
    width: 100%;
    height: 120px;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

button {
    width: 100%;
    padding: 12px;
    background: #3498db;
    color: white;
    border: none;
    margin-top: 10px;
    border-radius: 6px;
    cursor: pointer;
}

button:hover {
    opacity: 0.9;
}
</style>

</head>

<body>

<div class="container">

<!-- ✅ POPUP -->
<?php if (isset($_GET['success'])): ?>
<script>
alert("✅ Maintenance Request Submitted!");
</script>
<?php endif; ?>

<h2>🛠 Maintenance Request</h2>

<p>Welcome, <b><?= $name ?></b></p>

<form method="POST">
<textarea name="issue" placeholder="Describe your issue..." required></textarea>

<button name="submit">Submit Request</button>
</form>

<br>
<a href="tenantDashboard.php">⬅ Back</a>

</div>

</body>
</html>