<?php
// includes/template.php

session_start();

function renderHeader($title) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title><?php echo $title; ?> - Computer Parts Store</title>
        <link rel="stylesheet" type="text/css" href="../includes/styles.css">
    </head>
    <body>

    <header>
        <h1>Computer Parts Store</h1>
    </header>

    <nav>
        <a href="../index.php">Home</a>
        <a href="../pages/products.php">Products</a>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['account_type'] === 'admin'): ?>
            <a href="../admin/manage_users.php">Manage Users</a>
            <a href="../pages/view_carts.php">View User Carts</a>
            <a href="../admin/manage_content.php">Manage Content</a>
            <a href="../functions/logout.php">Logout</a>
        <?php elseif (isset($_SESSION['user_id']) && $_SESSION['account_type'] === 'employee'): ?>
            <a href="../pages/view_carts.php">View User Carts</a>
            <a href="../functions/logout.php">Logout</a>
        <?php elseif (isset($_SESSION['user_id']) && $_SESSION['account_type'] === 'customer'): ?>
            <a href="../pages/cart.php">Shopping Cart</a>
            <a href="../functions/logout.php">Logout</a>
        <?php else: ?>
            <a href="../pages/register.php">Register</a>
            <a href="../pages/login.php">Login</a>
        <?php endif; ?>
    </nav>

    <div class="container">
    <?php
}

function renderFooter() {
    ?>
    </div>
    </body>
    </html>
    <?php
}
?>
