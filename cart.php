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

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('The cart empty.'); window.location.href = 'pre_order.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove'])) {
        $id = $_POST['id'];
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
            if (empty($_SESSION['cart'])) {
                unset($_SESSION['cart']);
            }
            echo "<script>alert('Menu item removed from cart!'); window.location.href = 'cart.php';</script>";
        }
    } elseif (isset($_POST['confirm_order'])) {
        
        $cstmr_id = $_SESSION['user_id'];
        $food_ids = implode(',', array_keys($_SESSION['cart']));
        $pcs = implode(',', $_SESSION['cart']);
        $total = $_POST['total'];
        
        $sql = "INSERT INTO pre_orders (customer_id, meal_id, quantities, total) VALUES ('$cstmr_id', '$food_ids', '$pcs', '$total')";

        if (mysqli_query($connection, $sql)) {
            $order_id = mysqli_insert_id($connection);
            $order_info = "Order ID: " . $order_id . "\\n";
            foreach ($_SESSION['cart'] as $id => $pcs) {
                $sql = "SELECT name FROM menu_items WHERE id='$id'";
                $result = mysqli_query($connection, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $order_info .= $row['name'] . " (PCS: $pcs)\\n";
                }
            }
            $order_info .= "Total: $$total";
            unset($_SESSION['cart']);
            echo "<script>alert('Pre-order confirmed!\\n$order_info'); window.location.href = 'pre_order.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($connection) . "'); window.location.href = 'cart.php';</script>";
        }
    }
}


$cart = $_SESSION['cart'];
$food_ids = implode(',', array_keys($cart));

$sql = "SELECT id, name, price FROM menu_items WHERE id IN ($food_ids)";
$result = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    <link rel="stylesheet" href="menu.css">

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
        .cart_link{
            display : flex;
            flex-direction : block;
            justify-content: space-between;
        }
        .cart_link a{
            height: 20px;
            margin: 20px auto;
            margin-right: 20px;
            padding: 10px 20px;
        }
        .cart_link button{
            margin-left: 380px;
            margin-top: 0;
            width: 200px;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <h1>Your Cart</h1>
 
    <table>
        <tr>
            <th>Name</th>   
            <th>Price</th>
            <th>PCS</th>
            <th>Subtotal</th>
            <th class="action-column">Action</th>
        </tr>
        <?php
        $total = 0;
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $pcs = $cart[$row['id']];
                $subtotal = $row['price'] * $pcs;
                $total += $subtotal;
                echo '<tr>';
                echo '<td>' . $row['name'] . '</td>';
                echo '<td>Rs. ' . $row['price'] . '</td>';
                echo '<td>' . $pcs . '</td>';
                echo '<td>Rs. ' . $subtotal . '</td>';
                echo '<td class="action-column">';
                echo '<form method="post" action="cart.php" style="margin: 0;">';
                echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                echo '<button type="submit" name="remove" class="remove-button">Remove</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        }

        mysqli_close($connection);
        ?>
    </table>
    <div class="total">
        <strong>Total: RS.<?php echo ' ' .$total.''; ?></strong>
    </div>
    <div class="cart_link">
    <a href="pre_order.php" class="back-link">Continue Shopping</a>
    <a href="customer_dashboard.php" class="back-link">Back to Customer Dashboard</a> 
    <form method="post" action="cart.php">
        <input type="hidden" name="total" value="<?php echo $total; ?>">
        <button type="submit" name="confirm_order" class="confirm-button">Confirm Order</button>
    </form>
  
    </div>
     
     
    
</body>
</html>
