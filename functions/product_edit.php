<?php
include('../includes/template.php');
include('../includes/db.php');

renderHeader('Edit Product');

?>

<h2>Edit Product</h2>

<?php include('../includes/product_actions.php'); ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category_id = $_POST['category'];

    $sql = "UPDATE products SET name='$name', description='$description', price='$price', quantity='$quantity', category_id='$category_id' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        $message = "Product updated successfully";
        header("Location: product_edit.php?id=$id&message=" . urlencode($message));
        exit();
    } else {
        echo "Error updating product: " . $conn->error;
    }
}
?>

<?php if (isset($_GET['message'])): ?>
    <div class="message success"><?php echo urldecode($_GET['message']); ?></div>
<?php endif; ?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>

        <div class="product-edit-form">
            <form method="post" action="product_edit.php" class="product-edit-form">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
                </div>
                <div>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required><?php echo $row['description']; ?></textarea>
                </div>
                <div>
                    <label for="price">Price:</label>
                    <input type="text" id="price" name="price" value="<?php echo $row['price']; ?>" required>
                </div>
                <div>
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="<?php echo $row['quantity']; ?>" required>
                </div>
                <div>
                    <label for="category">Category:</label>
                    <select id="category" name="category">
                        <?php
                        $sql = "SELECT id, name FROM categories";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($category = $result->fetch_assoc()) {
                                $selected = $row['category_id'] == $category['id'] ? "selected" : "";
                                echo "<option value='" . $category['id'] . "' $selected>" . $category['name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <input type="submit" value="Update Product">
                </div>
            </form>
        </div>
        <?php
    } else {
        echo "Product not found";
    }
} else {
    echo "No product id provided.";
}

$conn->close();
renderFooter();
?>
