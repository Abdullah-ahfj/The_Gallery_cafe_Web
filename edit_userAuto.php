<?php

session_start();


if (!isset($_SESSION['username'])) {
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
    $sql = "SELECT * FROM users WHERE id='$id'";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        $food = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Meal not found.'); window.location.href = 'user.php';</script>";
        exit();
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


    $sql = "UPDATE users SET username='$username', password ='$password' WHERE id='$id'";
    

    if (mysqli_query($connection, $sql)) {
        echo "<script>alert('Updated successfully!'); window.location.href = 'user.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }
}


mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit </title>
    <link rel="stylesheet" href="registration.css">
</head>
<body>
    <div class="formBox">
        <h2>Update Username or Password</h2>
        <form method="post" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?php echo $food['id']; ?>">

            <label for="name">Name</label>
            <input type="text" id="name" name="username" value="<?php echo $food['username']; ?>" required>
            
            <label for="password">Password</label>
            <input type="password" id="price" name="password"  required>
            
            <button type="submit">Update</button>
        </form>
        <a href="user.php">Cancel</a>
    </div>
</body>
</html>
