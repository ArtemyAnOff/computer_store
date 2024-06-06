<?php
include('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selected_products'])) {
    $selected_products = $_POST['selected_products'];
    $success = true;

    foreach ($selected_products as $product_id) {
        // Получение связанных отзывов
        $sql_reviews = "SELECT * FROM reviews WHERE product_id=$product_id";
        $result_reviews = $conn->query($sql_reviews);

        // Перенос продукта в таблицу deleted_products без копирования id
        $sql = "INSERT INTO deleted_products (name, description, price, quantity, category_id) 
                SELECT name, description, price, quantity, category_id
                FROM products WHERE id=$product_id";
        if ($conn->query($sql) === TRUE) {
            $deleted_product_id = $conn->insert_id; // Получаем id добавленного продукта

            // Перенос связанных отзывов в таблицу deleted_reviews
            while ($row_review = $result_reviews->fetch_assoc()) {
                $sql_insert_review = "INSERT INTO deleted_reviews (product_id, user_id, review, rating, created_at) 
                                      VALUES ($deleted_product_id, " . $row_review['user_id'] . ", '" . $row_review['review'] . "', " . $row_review['rating'] . ", '" . $row_review['created_at'] . "')";
                if ($conn->query($sql_insert_review) !== TRUE) {
                    $success = false;
                }
            }

            // Удаление связанных записей в таблице reviews
            $sql_delete_reviews = "DELETE FROM reviews WHERE product_id=$product_id";
            if ($conn->query($sql_delete_reviews) === TRUE) {
                // Удаление связанных записей в таблице cart
                $sql_delete_cart = "DELETE FROM cart WHERE product_id=$product_id";
                if ($conn->query($sql_delete_cart) === TRUE) {
                    // Удаление продукта из таблицы products
                    $sql_delete = "DELETE FROM products WHERE id=$product_id";
                    if ($conn->query($sql_delete) !== TRUE) {
                        $success = false;
                    }
                } else {
                    $success = false;
                }
            } else {
                $success = false;
            }
        } else {
            $success = false;
        }
    }

    if ($success) {
        header("Location: product_delete_select.php?message=" . urlencode("Selected products deleted successfully."));
        exit();
    } else {
        header("Location: product_delete_select.php?message=" . urlencode("Error deleting selected products."));
        exit();
    }
} else {
    header("Location: product_delete_select.php?message=" . urlencode("No products selected."));
    exit();
}

$conn->close();
?>
