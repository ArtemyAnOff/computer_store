<?php
include('../includes/db.php');

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] !== 'customer') {
    header("Location: ../pages/login.php");
    exit();
}

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['user_id'];

    // Проверка количества товара на складе и в корзине пользователя
    $sql_product = "SELECT quantity FROM products WHERE id='$product_id'";
    $result_product = $conn->query($sql_product);
    if ($result_product->num_rows > 0) {
        $row_product = $result_product->fetch_assoc();
        $available_quantity = $row_product['quantity'];

        $sql_cart = "SELECT SUM(quantity) as total_quantity FROM cart WHERE user_id='$user_id' AND product_id='$product_id'";
        $result_cart = $conn->query($sql_cart);
        $row_cart = $result_cart->fetch_assoc();
        $cart_quantity = $row_cart['total_quantity'] ?? 0;

        if (($cart_quantity + $quantity) <= $available_quantity) {
            // Добавление товара в корзину
            $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')
                    ON DUPLICATE KEY UPDATE quantity=quantity + VALUES(quantity)";

            if ($conn->query($sql) === TRUE) {
                header("Location: ../pages/cart.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $_SESSION['error'] = 'Not enough product quantity available.';
            header("Location: ../functions/product_details.php?id=$product_id");
            exit();
        }
    } else {
        echo "Error: Product not found.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
