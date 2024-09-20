<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "114_a";

$connection = mysqli_connect($host, $username, $password, $dbname);

if (!$connection) {
    die("Failed to connect to MYSQL: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $userType = $_POST['userType'];
 
    $checkEmailUnique = "SELECT * FROM users WHERE email='$email'";
   
    $result = mysqli_query($connection, $checkEmailUnique);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Error: This email is already existed.'); window.location.href = 'registration.html';</script>";
    } else {
        $sql = "INSERT INTO users (username, email, password, userType) VALUES ('$user', '$email', '$password', '$userType')";

        if (mysqli_query($connection, $sql)) {
            // If insertion is successful, show success message and redirect to login page
            echo "<script>alert('Registration successful!'); window.location.href = 'login.html';</script>";
        } else {
            // If insertion fails, show error message and redirect to registration page
            echo "<script>alert('Error: " . mysqli_error($connection) . "'); window.location.href = 'registration.html';</script>";
        }
    }
}

// Close the database connection
mysqli_close($connection);
?>
