<?php
include('../includes/template.php');
include('../includes/db.php');

renderHeader('Product Details');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id']) && $_SESSION['account_type'] === 'customer') {
    $review = $_POST['review'];
    $rating = $_POST['rating'];
    $user_id = $_SESSION['user_id'];
    $id = $_GET['id'];

    $sql = "INSERT INTO reviews (product_id, user_id, review, rating) VALUES ('$id', '$user_id', '$review', '$rating')";

    if ($conn->query($sql) === TRUE) {
        $message = "Review submitted successfully.";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<h2>Product Details</h2>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT products.*, categories.name as category_name FROM products 
            LEFT JOIN categories ON products.category_id = categories.id 
            WHERE products.id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <div>
            <h3><?php echo $row['name']; ?></h3>
            <p><strong>Description:</strong> <?php echo $row['description']; ?></p>
            <p><strong>Price:</strong> $<?php echo $row['price']; ?></p>
            <p><strong>Quantity:</strong> <?php echo $row['quantity']; ?></p>
            <p><strong>Category:</strong> <?php echo $row['category_name']; ?></p>
        </div>

        <?php if (isset($_SESSION['user_id']) && $_SESSION['account_type'] === 'customer'): ?>
        <!-- Add to Cart Section for Customers -->
        <h3>Add to Cart</h3>
        <form action="../functions/cart_add.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $id; ?>">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $row['quantity']; ?>">
            <input type="submit" value="Add to Cart">
        </form>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']); // Удаляем сообщение об ошибке из сессии после его отображения
        }
        ?>
        <!-- Add Review Section for Customers -->
        <h3>Reviews</h3>
        <form action="product_details.php?id=<?php echo $id; ?>" method="post">
            <textarea name="review" placeholder="Write your review here..." required></textarea><br>
            <label for="rating">Rating:</label>
            <select name="rating" id="rating" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select><br>
            <input type="submit" value="Submit Review">
        </form>
        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <?php endif; ?>

        <!-- Display Reviews -->
        <h3>Customer Reviews</h3>
        <?php
        $sql_reviews = "SELECT * FROM reviews WHERE product_id = $id";
        $result_reviews = $conn->query($sql_reviews);

        if ($result_reviews->num_rows > 0) {
            while($review = $result_reviews->fetch_assoc()) {
                echo "<div>";
                echo "<p><strong>Rating:</strong> " . $review['rating'] . "</p>";
                echo "<p>" . $review['review'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No reviews yet.</p>";
        }

    } else {
        echo "<p>Product not found.</p>";
    }
} else {
    echo "<p>No product ID provided.</p>";
}

$conn->close();

renderFooter();
?>
