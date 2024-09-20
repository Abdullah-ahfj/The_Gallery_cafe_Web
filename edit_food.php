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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM menu_items WHERE id='$id'";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        $food = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Meal not found.'); window.location.href = 'manage_foods.php';</script>";
        exit();
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $cuisine = $_POST['cuisine'];
    $food_type = $_POST['food_type'];
    $price = $_POST['price'];


    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $sql = "UPDATE menu_items SET name='$name', cuisine='$cuisine', food_type='$food_type', price='$price', image='$image' WHERE id='$id'";
    } else {
        $sql = "UPDATE menu_items SET name='$name', cuisine='$cuisine', food_type='$food_type', price='$price' WHERE id='$id'";
    }

    if (mysqli_query($connection, $sql)) {
        echo "<script>alert('Product updated successfully!'); window.location.href = 'manage_foods.php';</script>";
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
        <h2>Edit Menu</h2>
        <form method="post" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?php echo $food['id']; ?>">

            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo $food['name']; ?>" required>
            
            <label for="cuisine">Cuisine</label>
            <select id="cuisine" name="cuisine" value="<?php echo $food['cuisine']; ?>" required>
            <option value="<?php echo $food['cuisine']; ?>">Select Cuisine Type</option>
            <option value="Sri Lankan">Sri Lankan</option>
            <option value="Chinese">Chinese</option>
            <option value="Italian">Italian</option>
            <option value="Arabian">Arabian</option>
            <option value="Indian">Indian</option>
            <option value="none">none</option>
            </select>
            
            <label for="food_type">Menu Type:</label>
            <select id="food_Type" name="food_type" value="<?php echo $food['food_type'] ?>" required>
            <option value="<?php echo $food['food_type'] ?>">Select Menu Type</option>
            <option value="meal">Meal</option>
            <option value="dessert">Dessert</option>
            <option value="beverage">Beverage</option>
            </select>

            <label for="price">Price</label>
            <input type="number" id="price" name="price" value="<?php echo $food['price']; ?>" required>
            
            <label for="image">Image</label>
            <input type="file" id="image" name="image">
            
            <button type="submit">Update Food</button>
        </form>
        <a href="manage_foods.php">Cancel</a>
    </div>
</body>
</html>
