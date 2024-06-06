<?php
include('../includes/template.php');
include('../includes/db.php');

renderHeader('Select Product to Edit');

?>

<h2>Select Product to Edit</h2>

<?php include('../includes/product_actions.php'); ?>

<form method="GET" action="product_edit_select.php">
    <input type="text" name="search" placeholder="Search products" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
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

<div id="product-list">
    <?php
    $sql = "SELECT products.id, products.name, products.description, products.price, products.quantity, categories.name as category_name 
            FROM products 
            LEFT JOIN categories ON products.category_id = categories.id";

    $conditions = [];
    if (isset($_GET['search']) && $_GET['search'] !== '') {
        $search = $conn->real_escape_string($_GET['search']);
        $conditions[] = "(products.name LIKE '%$search%' OR products.description LIKE '%$search%')";
    }

    if (isset($_GET['category']) && $_GET['category'] !== '') {
        $category = $conn->real_escape_string($_GET['category']);
        $conditions[] = "products.category_id = '$category'";
    }

    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr><th>Name</th><th>Description</th><th>Price</th><th>Quantity</th><th>Category</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td><a href='../functions/product_edit.php?id=" . $row["id"] . "'>" . $row["name"]. "</a></td><td>" . $row["description"]. "</td><td>" . $row["price"]. "</td><td>" . $row["quantity"]. "</td><td>" . $row["category_name"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No results found";
    }

    $conn->close();
    ?>
</div>

<?php
renderFooter();
?>
