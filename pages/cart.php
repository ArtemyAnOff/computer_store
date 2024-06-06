<?php
include('../includes/template.php');
include('../includes/db.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

renderHeader('Shopping Cart');
?>

<h2>Shopping Cart</h2>

<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT cart.*, products.name, products.price FROM cart LEFT JOIN products ON cart.product_id = products.id WHERE cart.user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>Name</th><th>Price</th><th>Quantity</th><th>Total</th><th>Actions</th></tr>";
    $total = 0;
    while ($row = $result->fetch_assoc()) {
        $item_total = $row['price'] * $row['quantity'];
        $total += $item_total;
        echo "<tr><td>" . $row['name'] . "</td><td>$" . $row['price'] . "</td><td>" . $row['quantity'] . "</td><td>$" . $item_total . "</td>";
        echo "<td><a href='../functions/cart_remove.php?id=" . $row['id'] . "'>Remove</a></td></tr>";
    }
    echo "<tr><td colspan='3'><strong>Total</strong></td><td><strong>$" . $total . "</strong></td><td></td></tr>";
    echo "</table>";
} else {
    echo "<p>Your cart is empty.</p>";
}

$conn->close();
?>

<br><a href="products.php">Continue Shopping</a>

<?php
renderFooter();
?>
