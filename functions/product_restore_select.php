<?php
include('../includes/template.php');
include('../includes/db.php');

renderHeader('Select Products to Restore');

?>

<h2>Select Products to Restore</h2>

<?php include('../includes/product_actions.php'); ?>

<form method="GET" action="product_restore_select.php">
    <input type="text" name="search" placeholder="Search deleted products" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
    <select name="category">
        <option value="">All Categories</option>
        <?php
        $sql = "SELECT id, name FROM categories";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($category = $result->fetch_assoc()) {
                $selected = isset($_GET['category']) && $_GET['category'] == $category['id'] ? "selected" : "";
                echo "<option value='" . $category['id'] . "' $selected>" . $category['name'] . "</option>";
            }
        } else {
            echo "<option value=''>No categories available</option>";
        }
        ?>
    </select>
    <input type="submit" value="Search">
</form>

<form method="POST" action="../functions/product_restore_multiple.php">
    <div id="product-list">
        <?php
        $sql = "SELECT id, name, description, price, quantity, category_id FROM deleted_products";

        $conditions = [];
        if (isset($_GET['search']) && $_GET['search'] !== '') {
            $search = $conn->real_escape_string($_GET['search']);
            $conditions[] = "(name LIKE '%$search%' OR description LIKE '%$search%')";
        }

        if (isset($_GET['category']) && $_GET['category'] !== '') {
            $category = $conn->real_escape_string($_GET['category']);
            $conditions[] = "category_id = '$category'";
        }

        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table><tr><th>Select</th><th>Name</th><th>Description</th><th>Price</th><th>Quantity</th><th>Category</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td><input type='checkbox' name='selected_products[]' value='" . $row["id"] . "'></td><td>" . $row["name"]. "</td><td>" . $row["description"]. "</td><td>" . $row["price"]. "</td><td>" . $row["quantity"]. "</td><td>" . $row["category_id"] . "</td></tr>";
            }
            echo "</table>";
            echo "<input type='submit' value='Restore Selected'>";
        } else {
            echo "No results found";
        }

        $conn->close();
        ?>
    </div>
</form>

<?php
renderFooter();
?>
