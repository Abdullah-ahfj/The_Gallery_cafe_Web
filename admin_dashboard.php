<?php

session_start();

if (!isset($_SESSION['username']) || $_SESSION['userType'] !== 'admin') {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "114_a";

$connection = mysqli_connect($servername, $username, $password, $dbname);


if (!$connection) {
    die("Failed to connect to MYSQL: " . mysqli_connect_error());
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Café | Admin</title>
    <link rel="stylesheet" href="menu.css">
    <link rel="shortcut icon" href="images\Screenshot (4).png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        #menu1{
            width: 100%;
            display: flex;
            flex-wrap:wrap;
            justify-content: center;
            align-items: center;
            margin: 50px 50px 50px 50px;
            background-color: white;


        }
        #menu1 a{
            color:white;
            background-color: rgb(23, 105, 153);
            width: 150px;
            height: 90px;
            text-align:center;
            padding:78px 50px 78px 50px;
            margin-bottom:20px;
            border-radius:10px;
            margin-right:21px;
            text-decoration: none;
            font-size:20px;
               
        }
        #menu1 a:hover{
            color:white;
            font-size:24px;
            border-bottom: none;
            background-color: rgb(100, 167, 206);
        }

        
    </style>
</head>
<body>

<div id="navigation" >
        <div class ="logo_container">
            <a href="#" id="logo">The Gallery Café<br></a>
            Beyond a Meal
        </div>
        <center><h1 id="menu1">Admin Dashboard</h1></center>
        
        <a class="LogoutL" href="logout.php" >Logout</a>
</div>   
<hr>

<div class= "container" style="margin-top:30px; margin-bottom:210px;">
<div id="menu1" >
        <a href="mng_user.php">Manage Users</a>
        <a href="AdminAddUser.html">Add New Admin or Staff</a>
        <a href="add_food.php">Add Items To Menu</a>
        <a href="manage_foods.php">manage Menu</a>
        <a href="mng_reservation.php">Manage reservations</a>
        <a href="mng_orders.php">Manage Orders</a>
        <a href="fromContactUs.php">Feedback & Messages</a>
     
</div>
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

