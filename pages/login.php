<?php
include('../includes/template.php');
include('../includes/db.php');

renderHeader('Login');
?>

<h2>Login</h2>
<form action="login.php" method="post">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" placeholder="Enter username" required><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" placeholder="Enter password" required><br><br>
    <input type="submit" value="Login">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['account_type'] = $row['account_type']; // Сохраняем тип аккаунта
            header("Location: ../index.php");
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username.";
    }

    $conn->close();
}

renderFooter();
?>
