<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "computer_parts_store";

// Создаем соединение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
