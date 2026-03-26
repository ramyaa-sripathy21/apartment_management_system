<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    mysqli_query($conn, "
        UPDATE maintenance 
        SET status = 'Completed' 
        WHERE id = $id
    ");

    header("Location: maintenance.php");
    exit();
}
?>