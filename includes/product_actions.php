<?php if (isset($_SESSION['account_type']) && ($_SESSION['account_type'] === 'admin' || $_SESSION['account_type'] === 'employee')): ?>
    <div class="product-actions">
        <a href="../functions/product_add.php">Add</a>
        <a href="../functions/product_edit_select.php">Edit</a>
        <a href="../functions/product_delete_select.php">Delete</a>
        <a href="../functions/product_restore_select.php">Restore</a>
    </div>
<?php endif; ?>
