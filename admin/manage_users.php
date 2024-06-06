<?php
include('../includes/template.php');
include('../includes/db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit();
}

renderHeader('Manage Users');
?>

<h2>Manage Users</h2>
<table>
    <tr>
        <th>Username</th>
        <th>Account Type</th>
        <th>Actions</th>
    </tr>
    <?php
    $sql = "SELECT id, username, account_type FROM users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['account_type'] . "</td>";
            echo "<td>";
            echo "<form action='manage_users.php' method='post' style='display:inline;'>";
            echo "<input type='hidden' name='user_id' value='" . $row['id'] . "'>";
            echo "<select name='account_type'>";
            echo "<option value='customer'" . ($row['account_type'] == 'customer' ? ' selected' : '') . ">Customer</option>";
            echo "<option value='employee'" . ($row['account_type'] == 'employee' ? ' selected' : '') . ">Employee</option>";
            echo "<option value='admin'" . ($row['account_type'] == 'admin' ? ' selected' : '') . ">Admin</option>";
            echo "</select>";
            echo "<input type='submit' value='Update'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No users found.</td></tr>";
    }
    ?>
</table>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_id']) && isset($_POST['account_type'])) {
        $user_id = $_POST['user_id'];
        $account_type = $_POST['account_type'];

        $sql = "UPDATE users SET account_type='$account_type' WHERE id=$user_id";

        if ($conn->query($sql) === TRUE) {
            echo "User account type updated successfully.";
        } else {
            echo "Error updating user account type: " . $conn->error;
        }

        // Перезагрузка страницы для обновления данных
        header("Location: manage_users.php");
        exit();
    }
}

$conn->close();
renderFooter();
?>
