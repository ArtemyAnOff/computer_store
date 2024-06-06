<?php
include('../includes/db.php');

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] !== 'customer') {
    header("Location: ../pages/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $sql = "DELETE FROM cart WHERE id=$id AND user_id=$user_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../pages/cart.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
