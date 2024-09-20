<?php

session_start();


$host = "localhost";
$username = "root";
$password = "";
$dbname = "114_a";

$connection = mysqli_connect($host, $username, $password, $dbname);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "SELECT name, email, subject, message, submitted_at FROM contact_us";
$result = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
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
        td{
            flex-wrap: wrap;
            height: 100px;
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
        <h1>View Messaged and Feedback</h1>
        <input type="text" id="searchInput" onkeyup="searchMeals()" placeholder="Search User..">
        <a href="admin_dashboard.php" style="background-color: green;green; margin-right:20px"">Back to admin dashboard</a><a href="staff_dashboard.php" style="background-color: green;">Back to staff dashboard</a>
        <table id="menuTable">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Sent Date</th>
            </tr>
            <?php
    
            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['subject'] . "</td>";
                    echo "<td>" . $row['message'] . "</td>";
                    echo "<td>" . $row['submitted_at'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No Messages</td></tr>";
            }
   
            mysqli_close($connection);
            ?>
        </table>
        
    </div>
</body>
</html>