<?php
include('../includes/db.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selected_products'])) {
    $selected_products = $_POST['selected_products'];
    $success = true;

    foreach ($selected_products as $product_id) {
        // Получение данных о продукте из таблицы deleted_products
        $sql = "SELECT name, description, price, quantity, category_id FROM deleted_products WHERE id=$product_id";
        $result = $conn->query($sql);

        if (!$result) {
            $success = false;
            break;
        }

        $row = $result->fetch_assoc();

        if ($row) {
            // Вставка продукта обратно в таблицу products
            $sql_restore = "INSERT INTO products (name, description, price, quantity, category_id) 
                            VALUES ('" . $row['name'] . "', '" . $row['description'] . "', '" . $row['price'] . "', '" . $row['quantity'] . "', '" . $row['category_id'] . "')";
            if ($conn->query($sql_restore) === TRUE) {
                $restored_product_id = $conn->insert_id; // Получаем новый идентификатор восстановленного продукта

                // Восстановление отзывов из таблицы deleted_reviews
                $sql_reviews = "SELECT user_id, review, rating, created_at FROM deleted_reviews WHERE product_id=$product_id";
                $result_reviews = $conn->query($sql_reviews);

                if ($result_reviews) {
                    while ($review = $result_reviews->fetch_assoc()) {
                        $sql_restore_reviews = "INSERT INTO reviews (product_id, user_id, review, rating, created_at) 
                                                VALUES ('" . $restored_product_id . "', '" . $review['user_id'] . "', '" . $review['review'] . "', '" . $review['rating'] . "', '" . $review['created_at'] . "')";
                        if ($conn->query($sql_restore_reviews) !== TRUE) {
                            $success = false;
                        }
                    }
                } else {
                    $success = false;
                }

                // Удаление отзывов из таблицы deleted_reviews
                $sql_delete_reviews = "DELETE FROM deleted_reviews WHERE product_id=$product_id";
                if ($conn->query($sql_delete_reviews) !== TRUE) {
                    $success = false;
                }

                // Удаление продукта из таблицы deleted_products только после успешного восстановления
                $sql_delete = "DELETE FROM deleted_products WHERE id=$product_id";
                if ($conn->query($sql_delete) !== TRUE) {
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
        header("Location: product_restore_select.php?message=" . urlencode("Selected products restored successfully."));
        exit();
    } else {
        header("Location: product_restore_select.php?message=" . urlencode("Error restoring selected products."));
        exit();
    }
} else {
    header("Location: product_restore_select.php?message=" . urlencode("No products selected."));
    exit();
}

$conn->close();
?>
