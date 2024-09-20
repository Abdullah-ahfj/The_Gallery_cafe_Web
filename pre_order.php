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

$sql = "SELECT id, name, cuisine, price, food_type, image FROM menu_items";
$result = mysqli_query($connection, $sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $id = $_POST['id'];
    $pcs = $_POST['pcs'];

    if (!isset($_SESSION['cart'])) {
         $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $pcs;
    } else {
        $_SESSION['cart'][$id] = $pcs;
    }

    echo "<script>alert('menu item added to cart!'); window.location.href = 'pre_order.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Café | Pre-Order</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="menu.css">

    <script>
        function searchMeals() {
            // Declare variables
            var input, filter, cards, cardContainer, h3, name, cuisine, i;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            cardContainer = document.getElementsByClassName("card_container")[0];
            cards = cardContainer.getElementsByClassName("card");
            
            // Loop through all cards and hide those that don't match the search query
            for (i = 0; i < cards.length; i++) {
                name = cards[i].getElementsByTagName("h3")[0];
                cuisine = cards[i].getElementsByTagName("h3")[1];
                if (name || cuisine) {
                    if (name.innerHTML.toUpperCase().indexOf(filter) > -1 || cuisine.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        cards[i].style.display = "";
                    } else {
                        cards[i].style.display = "none";
                    }
                }       
            }
        }
    </script>
    
</head>
<body>
<div id="navigation">
        <div class ="logo_container">
            <a href="#" id="logo">The Gallery Café<br></a>
            Beyond a Meal
        </div>

        <div id="menu">
            <a href="customer_dashboard.php"> Home</a>
            <a href="menu.php">Menu</a>
            <a href="pre_order.php " style="color: black; border-bottom: 1px solid black; font-size: 18px; background-color: white;">Pre-Order</a>
            <a href="reservation.html">Reservations</a>
            <a href="promotion.html">Promotions</a>
            <a href="user.php">User Account</a>
            
            <a href="contactus.html">Contact Us</a>
            <a href="aboutus.html">About Us</a>
            
        </div>
        <a class="LogoutL" href="logout.php">Logout</a>
        
    </div>
    <div class="container" style="margin-top:42px; margin-bottom:240px">
    <div id="srchBar">
        <input type="text" id="searchInput" onkeyup="searchMeals()" placeholder="Search for meals..">
        <a href="cart.php" id="link">View Cart</a>
        <a href="customer_dashboard.php" id="link">Back</a>
    </div>
    <div class="card_container">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="card">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="food Image"/>';
                echo '<h3>' . $row['name'] . '</h3>';
                echo '<h3> ID:'. $row['id'] .'</h3>';
                echo '<h3 style = "color:grey">' . $row['cuisine'] . '<br><p style="font-size:15px;">('. $row['food_type'] . ')</p></h3>';
                echo '<p class="price">Rs. ' . $row['price'] . '</p>';
                echo '<form method="post" action="pre_order.php">';
                echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                echo '<input type="number" name="pcs" value="1" min="1" max="6" required>';
                echo '<button type="submit" name="add_to_cart">Add to Cart</button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo '<p>No menu-items available.</p>';
        }

        mysqli_close($connection);
        ?>
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
