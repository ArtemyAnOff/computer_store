<?php
include('../includes/template.php');
include('../includes/db.php');

renderHeader('Register');
?>

<h2>Register</h2>
<form action="register.php" method="post">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" placeholder="Enter username" required><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" placeholder="Enter password" required><br><br>
    <input type="submit" value="Register">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $account_type = 'customer'; // Устанавливаем тип аккаунта по умолчанию

    $sql = "INSERT INTO users (username, password, account_type) VALUES ('$username', '$password', '$account_type')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

renderFooter();
?>
