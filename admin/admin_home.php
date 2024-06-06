<?php
include('../includes/template.php');
include('../includes/db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit();
}

renderHeader('Admin Home');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['title']) && isset($_POST['subtitle'])) {
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];

        $sql = "UPDATE home_content SET title='$title', subtitle='$subtitle' WHERE id=1";
        if ($conn->query($sql) === TRUE) {
            echo "Home content updated successfully.";
        } else {
            echo "Error updating home content: " . $conn->error;
        }
    } elseif (isset($_POST['post_title']) && isset($_POST['post_content'])) {
        $post_title = $_POST['post_title'];
        $post_content = $_POST['post_content'];
        $post_image_url = $_POST['post_image_url'];

        $sql = "INSERT INTO posts (title, content, image_url) VALUES ('$post_title', '$post_content', '$post_image_url')";
        if ($conn->query($sql) === TRUE) {
            echo "Post added successfully.";
        } else {
            echo "Error adding post: " . $conn->error;
        }
    }
}

$sql = "SELECT * FROM home_content WHERE id=1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<h2>Edit Home Content</h2>
<form method="post" action="admin_home.php">
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" value="<?php echo $row['title']; ?>" required><br>
    <label for="subtitle">Subtitle:</label><br>
    <textarea id="subtitle" name="subtitle" required><?php echo $row['subtitle']; ?></textarea><br><br>
    <input type="submit" value="Update">
</form>

<h2>Add New Post</h2>
<form method="post" action="admin_home.php">
    <label for="post_title">Post Title:</label><br>
    <input type="text" id="post_title" name="post_title" required><br>
    <label for="post_content">Post Content:</label><br>
    <textarea id="post_content" name="post_content" required></textarea><br>
    <label for="post_image_url">Post Image URL:</label><br>
    <input type="text" id="post_image_url" name="post_image_url"><br><br>
    <input type="submit" value="Add Post">
</form>

<?php
$conn->close();
renderFooter();
?>
