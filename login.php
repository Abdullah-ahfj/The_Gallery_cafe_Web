<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$dbname = "114_a";

$connection = mysqli_connect($host, $username, $password, $dbname);

if (!$connection) {
    die("failed to connect to MYSQL: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = $_POST['usernameOrEmail'];
    $password = $_POST['password'];

    if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT * FROM users WHERE email = ?";
    } else {
        $sql = "SELECT * FROM users WHERE username = ?";
    }

    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 's', $usernameOrEmail);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['userType'] = $user['userType'];
            $_SESSION['user_id'] = $user['id'];

            if ($user['userType'] === 'admin') {
                header("Location: admin_dashboard.php");
            }
            elseif($user['userType'] === 'staff'){
                header("Location: staff_dashboard.php");
            } 
            else {
                header("Location: customer_dashboard.php");
            }
            exit(); 
        } else {
            echo "<script>alert('Invalid password.'); window.location.href = 'login.html';</script>";
        }
    } else {
        echo "<script>alert('No user found with that username or email.'); window.location.href = 'login.html';</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($connection);
?>
