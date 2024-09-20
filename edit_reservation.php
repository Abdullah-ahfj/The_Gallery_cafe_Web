<?php

session_start();


if (!isset($_SESSION['username']) ) {
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
    $sql = "SELECT * FROM reservation WHERE id='$id'";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        $food = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Reservation not found.'); window.location.href = 'mng_reservation.php';</script>";
        exit();
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST["user"];
    $date = $_POST["date"];
    $duration = $_POST["duration"];
    $selectedSlot = $_POST["slot"];

    $sql = "UPDATE reservation SET customer_name='$user', r_date='$date', duration='$duration', slot='$selectedSlot' WHERE id='$id'";


    if (mysqli_query($connection, $sql)) {
        echo "<script>alert('Reservation updated successfully!'); window.location.href = 'mng_reservation.php';</script>";
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
    <title>Edit Product</title>
    <link rel="stylesheet" href="registration.css">
</head>
<body>
    <div class="formBox">
        <h1>Edit Reservation</h1>
        <form   method="post">
        
        <label for="user">Name</label>
        <input type="text" id="customer_id" name="user" value="<?php echo $food['customer_name']; ?>">

        <label for="date">Reservation Date:</label>
        <input type="date" id="date" name="date" value="<?php echo $food['r_date']; ?>">

        <label for="duration">Select Hours:</label>
        <select id="duration" name="duration" value="<?php echo $food['duration']; ?>">

            <option value="1">1 Hour</option>
            <option value="2">2 Hours</option>
            <option value="3">3 Hours</option>
            <option value="4">4 Hours</option>
            <option value="5">5 Hours</option>
            <option value="6">6 Hours</option>
            <option value="7">7 Hours</option>
            <!-- Add more options as needed -->
        </select>

        <label for="slot">Select Table:</label>
        <select id="slot" name="slot" value="<?php echo $food['slot']; ?>">
            <!-- Add more options as needed -->
            <!-- Added 30 slots -->
            <option value="1">Table 1</option>
            <option value="2">Table 2</option>
            <option value="3">Table 3</option>
            <option value="4">Table 4</option>
            <option value="5">Table 5</option>
            <option value="6">Table 6</option>
            <option value="7">Table 7</option>
            <option value="8">Table 8</option>
            <option value="9">Table 9</option>
            <option value="10">Table 10</option>
            <option value="11">Table 11</option>
            <option value="12">Table 12</option>
            <option value="13">Table 13</option>
            <option value="14">Table 14</option>
            <option value="15">Table 15</option>
            <option value="16">Table 16</option>
            <option value="17">Table 17</option>
            <option value="18">Table 18</option>
            <option value="19">Table 19</option>
            <option value="20">Table 20</option>
            <option value="21">Table 21</option>
            <option value="22">Table 22</option>
            <option value="23">Table 23</option>
            <option value="24">Table 24</option>
            <option value="25">Table 25</option>
            <option value="26">Table 26</option>
            <option value="27">Table 27</option>
            <option value="28">Table 28</option>
            <option value="29">Table 29</option>
            <option value="30">Table 30</option>
        </select>

        <button type="submit">Edit Reservation</button>


        
    </form>

        <a href="mng_reservation.php">Back</a>
    </div>
</body>
</html>

