<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['userType'] !== 'customer') {
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


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["user"];
    $date = $_POST["date"];
    $duration = $_POST["duration"];
    $selectedSlot = $_POST["slot"];



    // Check if any required field is empty
    if (empty($date) || empty($duration) || empty($selectedSlot) || empty($user)) {
        echo "<script>alert('Error: Please fill in all the required fields.');</script>";
    } else {
        // Check the availability of the selected slot (you may need to adjust this part)
        $query = "SELECT * FROM reservation WHERE slot = $selectedSlot AND r_date = '$date'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) == 0) {
            // Slot is available, insert into the database
            $sql = "INSERT INTO reservation (customer_name, r_date, duration, slot) VALUES ('$user', '$date', '$duration', '$selectedSlot')";

            if (mysqli_query($connection, $sql)) {
                echo "<script>alert('Booking successful! Table booked for $duration hours on $date.');</script>";
            } else {
                echo "<script>alert('Error: " . $sql . "\\n" . mysqli_error($connection) . "');</script>";
               
            }
        } else {
            // Slot is not available
            echo "<script>alert('Error: Slot $selectedSlot is  already booked for $duration hours on $date. try another slot');</script>";
            
        }
    }

    // Close the database connection
    mysqli_close($connection);
} 

?>
