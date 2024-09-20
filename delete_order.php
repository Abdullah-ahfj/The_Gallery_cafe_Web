<?php

session_start();

if (!isset($_SESSION['username']) || $_SESSION['userType'] !== 'admin') {
    header("Location: login.html");
    exit();
}


$host = "localhost";
$username = "root";
$password = "";
$dbname = "114_a";

$connection = mysqli_connect($host, $username, $password, $dbname);

if (!$connection) {
    die("Failed to connect to MYSQL: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM pre_orders WHERE id='$id'";

    if (mysqli_query($connection, $sql)) {
        echo "<script>alert('Order deleted successfully!'); window.location.href = 'mng_orders.php'; </script>";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
} else {
    echo "<script>alert('Invalid User ID.');</script>";
}

mysqli_close($connection);
?>
