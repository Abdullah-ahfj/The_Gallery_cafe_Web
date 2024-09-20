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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $cuisine = $_POST['cuisine'];
    $food_type = $_POST['food_type'];
    $price = $_POST['price'];

    $image = $_FILES['image']['tmp_name'];
    $imgContent = addslashes(file_get_contents($image));

    $sql = "INSERT INTO menu_items (name, cuisine, food_type, price, image) VALUES ('$name', '$cuisine', '$food_type', '$price', '$imgContent')";


    if (mysqli_query($connection, $sql)) {
        echo "<script>alert('food added successfully!'); window.location.href = 'add_food.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($connection) . "'); window.location.href = 'add_food.php';</script>";
    }
}

// Close the database connection
mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Café | Admin</title>
    <link rel="stylesheet" href="registration.css">
    <script>

        function formValidation() {
            var name = document.getElementById('name').value;
            var cuisine = document.getElementById('cuisine').value;
            var food_type = document.getElementById('food_Type').value;
            var price = document.getElementById('price').value;
            var image = document.getElementById('image').value;

            if (name == "") {
                alert("Food name must be filled out");
                return false;
            }
            if (price == "" || isNaN(price) || price <= 0) {
                alert("Valid food price must be filled out");
                return false;
            }

            if (image == "") {
                alert("Product image must be selected");
                return false;
            }
            return true;
        }
    </script>
    <style>
        .logout {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .logout a {
            text-decoration: none;
            color: white;
            background-color: #ff4b4b;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .logout a:hover {
            background-color: #ff0000;
        }

        label{
            padding-top : 15px;
        }
    </style>
</head>
<body>
    
    <div class=formBox>
    <h2>Add New Meal</h2>

    <form action="add_food.php" method="post" enctype="multipart/form-data" onsubmit="return formValidation()">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="cuisine">Cuisine Type:</label>
        <select id="cuisine" name="cuisine">
            <option >Select Cuisine Type</option>
            <option value="Sri Lankan">Sri Lankan</option>
            <option value="Chinese">Chinese</option>
            <option value="Italian">Italian</option>
            <option value="Arabian">Arabian</option>
            <option value="Indian">Indian</option>
            <option value="none">none</option>
        </select>

        <label for="food_type">Menu Type:</label>
        <select id="food_Type" name="food_type" >
            <option >Select Menu Type</option>
            <option value="meal">Meal</option>
            <option value="dessert">Dessert</option>
            <option value="beverage">Beverage</option>
        </select>

        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" required>

        <label for="image">Food Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>

        <button type="submit">Add To Menu</button>
        <br>
        <a href="view_products.php">Go To Menu</a>
    </form>

    </div>
   
</body>
</html>