<?php
include('../includes/template.php');
include('../includes/db.php');

renderHeader('Add Product');

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category_id = $_POST['category'];

    $sql = "INSERT INTO products (name, description, price, quantity, category_id) 
            VALUES ('$name', '$description', '$price', '$quantity', '$category_id')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Product added successfully";
        header("Location: product_add.php?message=" . urlencode($message));
        exit();
    } else {
        $message = "Error adding product: " . $conn->error;
    }
}
?>

<h2>Add Product</h2>

<?php include('../includes/product_actions.php'); ?>

<?php if (isset($_GET['message'])): ?>
    <div class="message success"><?php echo urldecode($_GET['message']); ?></div>
<?php endif; ?>

<div class="product-add-form">
    <form method="post" action="product_add.php">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" required>
        </div>
        <div>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>
        </div>
        <div>
            <label for="category">Category:</label>
            <select id="category" name="category">
                <?php
                $sql = "SELECT id, name FROM categories";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div>
            <input type="submit" value="Add Product">
        </div>
    </form>
</div>

<?php
$conn->close();
renderFooter();
?>
