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
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "SELECT id, name, cuisine, food_type, price, image FROM menu_items";
$result = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage foods</title>
    <link rel="stylesheet" href="registration.css">
    <style>
        a {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 20px;
            background-color: rgb(170, 22, 22);
            color: white;
            text-decoration: none;
        }
        a:hover{
            background-color: rgb(255, 109, 109);
        }
    </style>
    <script>
        function searchMeals() {
            var input = document.getElementById('searchInput');
            var filter = input.value.toLowerCase();
            var table = document.getElementById('menuTable');
            var tr = table.getElementsByTagName('tr');

            for (var i = 1; i < tr.length; i++) {
                tr[i].style.display = 'none';
                var td = tr[i].getElementsByTagName('td');
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        if (td[j].innerHTML.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = '';
                            break;
                        }
                    }
                }
            }
        }
    </script>
</head>
<body>
    <div class="view-products-container">
        <h1>Manage Meals</h1>
        <input type="text" id="searchInput" onkeyup="searchMeals()" placeholder="Search for meals..">
        <a href="admin_dashboard.php" style="background-color: green;">Back to Admin Dashboard</a>
        <table id="menuTable">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>cuisine</th>
                <th>Price</th>
                <th>food_type</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php
    
            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['cuisine'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>" . $row['food_type'] . "</td>";
                    echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="food Image"/></td>';
                    echo '<td>';
                    echo '<a href="edit_food.php?id=' . $row['id'] . '">Edit</a> | ';
                    echo '<a href="delete_food.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this from menu?\')">Delete</a>';
                    echo '</td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No foods found</td></tr>";
            }
   
            mysqli_close($connection);
            ?>
        </table>
        
    </div>
</body>
</html>
