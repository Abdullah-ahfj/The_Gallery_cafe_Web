<?php

session_start();


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

        $id = $_SESSION['order_id'];
        $cstmr_id = $_SESSION['user_id'];
        $food_ids = implode(',', array_keys($_SESSION['cart']));
        $pcs = implode(',', $_SESSION['cart']);
        $total = $_POST['total'];
        
        $sql = "UPDATE pre_orders SET customer_id='$cstmr_id', meal_id='$food_ids', quantities='$pcs', total='$total' WHERE id='$id'";


        if (mysqli_query($connection, $sql)) {
            $order_id = mysqli_insert_id($connection);
            $order_info = "Order ID: " . $id . "\\n";
            foreach ($_SESSION['cart'] as $id => $pcs) {
                $sql = "SELECT name FROM menu_items WHERE id='$food_ids'";
                $result = mysqli_query($connection, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $order_info .= $row['name'] . " (PCS: $pcs)\\n";
                }
            }
            $order_info .= "Total: $$total";
            unset($_SESSION['cart']);
            echo "<script>alert('Pre-order confirmed!\\n$order_info'); window.location.href = 'edit_order.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($connection) . "'); window.location.href = 'adminCart.php';</script>";
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
    <link rel="stylesheet" href="registration.css">
    <link rel="stylesheet" href="menu.css">
</head>
<body>
    <h2>Your Cart</h2>
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
                echo '<td>$' . $row['price'] . '</td>';
                echo '<td>' . $pcs . '</td>';
                echo '<td>$' . $subtotal . '</td>';
                echo '<td class="action-column">';
                echo '<form method="post" action="adminCart.php" style="margin: 0;">';
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
    <form method="post" action="adminCart.php">
        <input type="hidden" name="total" value="<?php echo $total; ?>">
        <button type="submit" name="confirm_order" class="confirm-button">Confirm Order</button>
    </form>
    <a href="mng_orders.php" class="back-link">Manage Orders</a>
</body>
</html>
