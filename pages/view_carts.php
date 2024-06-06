<?php
include('../includes/template.php');
include('../includes/db.php');

if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] !== 'admin' && $_SESSION['account_type'] !== 'employee')) {
    header("Location: ../pages/login.php");
    exit();
}

renderHeader('View User Carts');
?>

<h2>User Carts</h2>
<form method="GET" action="view_carts.php">
    <label for="user_id">Select User:</label>
    <select id="user_id" name="user_id">
        <option value="">Select a user</option>
        <?php
        $sql = "SELECT id, username FROM users WHERE account_type='customer'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($user = $result->fetch_assoc()) {
                $selected = isset($_GET['user_id']) && $_GET['user_id'] == $user['id'] ? "selected" : "";
                echo "<option value='" . $user['id'] . "' $selected>" . $user['username'] . "</option>";
            }
        } else {
            echo "<option value=''>No users available</option>";
        }
        ?>
    </select>
    <input type="submit" value="View Cart">
</form>

<div id="cart-list">
    <?php
    if (isset($_GET['user_id']) && $_GET['user_id'] !== '') {
        $user_id = $conn->real_escape_string($_GET['user_id']);
        $sql = "SELECT cart.id, products.name, cart.quantity, products.price
                FROM cart
                JOIN products ON cart.product_id = products.id
                WHERE cart.user_id = $user_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table><tr><th>Product Name</th><th>Quantity</th><th>Price</th><th>Total</th></tr>";
            $total = 0;
            while($row = $result->fetch_assoc()) {
                $subtotal = $row['quantity'] * $row['price'];
                $total += $subtotal;
                echo "<tr><td>" . $row['name'] . "</td><td>" . $row['quantity'] . "</td><td>" . $row['price'] . "</td><td>" . $subtotal . "</td></tr>";
            }
            echo "<tr><td colspan='3'>Total</td><td>" . $total . "</td></tr>";
            echo "</table>";
        } else {
            echo "No products in the cart.";
        }
    }
    $conn->close();
    ?>
</div>

<?php
renderFooter();
?>
