<?php

session_start();




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
    $sql = "DELETE FROM reservation WHERE id='$id'";

    if (mysqli_query($connection, $sql)) {
        echo "<script>alert('Reservation deleted successfully!');</script>";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
} else {
    echo "<script>alert('Invalid User ID.'); ";
}

mysqli_close($connection);
?>
