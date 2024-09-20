<?php

session_start();

if (!isset($_SESSION['username']) || $_SESSION['userType'] !== 'customer')  {
    header("Location: login.html");
    exit();
}

$host = "localhost";
$username = "root";
$password = "";
$dbname = "114_a";

$connection = mysqli_connect($host, $username, $password, $dbname);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$usernamesession = $_SESSION['username'];
$sql = "SELECT id, username, email, userType, created_at FROM users WHERE username = '$usernamesession'";
$result = mysqli_query($connection, $sql);
$sql2 = "SELECT id, customer_name, r_date, duration, slot FROM reservation WHERE customer_name = '$usernamesession'";
$result2 = mysqli_query($connection, $sql2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ay Account</title>
    
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th{
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        td {
            height: 60px;
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: rgb(5, 71, 133);
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
        #link{
            height: 60px;
        }
        #link a {
            height: 60px;
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 20px;
            background-color: rgb(170, 22, 22);
            color: white;
            text-decoration: none;
        }
        #link a:hover{
            background-color: rgb(255, 109, 109);
        }
        body{
            display : flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        h1 {
            color: rgb(5, 71, 133);
            text-align: center;
        }
        .user_container{
            margin-top: 20px;
            margin-bottom:150px;
            display : flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
    </style>
  

</head>
<body>
<div id="navigation">
        <div class ="logo_container">
            <a href="#" id="logo">The Gallery Café<br></a>
            Beyond a Meal
        </div>

        <div id="menu">
            <a href="home.html"> Home</a>
            <a href="menu.php">Menu</a>
            <a href="pre_order.php">Pre-Order</a>
            <a href="reservation.html">Reservations</a>
            <a href="promotion.html">Promotions</a>
            <a href="user.php"  style="color: black; border-bottom: 1px solid black; font-size: 18px; background-color: white;">User Account</a>
            <a href="contactus.html">Contact Us</a>
            <a href="aboutus.html">About Us</a>
            
        </div>
        <a class="AdminLogin" href="registration.html">Register | Login</a>
</div>
    <div class="user_container">
        <h1>My Account</h1>
        <h3>Welcome <?php echo $_SESSION['username'] ?></h3>
        <table id="menuTable">
            <tr>
                <th>User Name</th>
                <th>Email</th>
   
                <th>Joined Date</th>
                <th>Action</th>
            </tr>
            <?php
    
            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
  
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
  
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo '<td>';
                    echo '<a href="edit_userAuto.php?id=' . $row['id'] . '" id="link">Change Username or Password</a> 
                     ';
                    echo '</td>';
                    echo "</tr>";
                }

            } else {
                echo "<tr><td colspan='7'>Not Registered</td></tr>";
            }
   
            ?>
        </table>
        <table id="menuTable">
        <h3>Reservations</h3>
            <tr>

                <th>User Name</th>
                <th>Reserved Date</th>
                <th>Duration</th>
                <th>Table No</th>
                <th>Action</th>
            </tr>
            <?php
    
            if (mysqli_num_rows($result2) > 0) {

                while ($row2 = mysqli_fetch_assoc($result2)) {
                    echo "<tr>";
                    echo "<td>" . $row2['customer_name'] . "</td>";
                    echo "<td>" . $row2['r_date'] . "</td>";
                    echo "<td>" . $row2['duration'] . "</td>";
                    echo "<td>" . $row2['slot'] . "</td>";
                    echo '<td>';

                    echo '<a href="delete_reservation.php?id=' . $row2['id'] . '" onclick="return confirm(\'Are you sure you want to delete this Reservation?\' )">Delete</a>';
                    echo '</td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No Reservation found</td></tr>";
            }
   
            ?>
            
        </table>

    </div>
    <footer id="picassoFooter">
        <div class="footer-navigation">
            <h3>Quick Links</h3>
            <ul class="quicklink">
                <li><a href="home.html">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">contact us</a></li>
            </ul>
        </div>
        <div class="footer-navigation">
            <h3>Contact Us</h3>
            <p>Email: info@thegallerycafe.com</p>
            <p>Phone: 0771148418</p>
            
        </div>
        <div class="footer-navigation">
            <h3>Policy</h3>
            <ul class="quicklink">
                <li><a href="Terms&Conditions.html">Terms & Conditions</a></li>
                <li><a href="privacy-policy.html">Privacy Policy</a></li>
            </ul>
        </div>
        
        <div class="footer-navigation">
            <h3>Follow Us</h3>
            <div class="social-icons">
                <a href="https://facebook.com" class="fa fa-facebook"></a>
                <a href="https://twitter.com" class="fa fa-twitter"></a>
                <a href="https://instagram.com" class="fa fa-instagram"></a>
            </div>
        </div>
        <div class ="logo_container" style="position: relative;">
            <a href="home.html" id="logo">The Gallery Café<br></a>
            Beyond a Meal
        </div>
        <p style="color: black; margin-top: 50px; padding-bottom: 0%;">&copy; 2024 The Gallery Café. All rights reserved.</p>
    </footer>
</body>
</html>