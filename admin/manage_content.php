<?php
include('../includes/template.php');
include('../includes/db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit();
}

renderHeader('Manage Content');

$message = "";
$message1 = "";
$message2 = "";
$message3 = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action === 'update_home') {
            $title = $_POST['title'];
            $subtitle = $_POST['subtitle'];

            $sql = "UPDATE home_content SET title='$title', subtitle='$subtitle' WHERE id=1";
            if ($conn->query($sql) === TRUE) {
                $message = "<div class='message success'>Home content updated successfully.</div>";
            } else {
                $message = "<div class='message error'>Error updating home content: " . $conn->error . "</div>";
            }
            $post_title = $_POST['post_title'];
            $post_content = $_POST['post_content'];
            $post_image_url = $_POST['post_image_url'];

            // Update positions of existing posts
            $conn->query("UPDATE posts SET position = position + 1");

            $sql = "INSERT INTO posts (title, content, image_url, position) VALUES ('$post_title', '$post_content', '$post_image_url', 1)";
            if ($conn->query($sql) === TRUE) {
                $message1 = "<div class='message success'>Post added successfully.</div>";
            } else {
                $message1 = "<div class='message error'>Error adding post: " . $conn->error . "</div>";
            }
        } elseif ($action === 'edit_post') {
            $post_id = $_POST['post_id'];
            $post_title = $_POST['post_title'];
            $post_content = $_POST['post_content'];
            $post_image_url = $_POST['post_image_url'];

            $sql = "UPDATE posts SET title='$post_title', content='$post_content', image_url='$post_image_url' WHERE id=$post_id";
            if ($conn->query($sql) === TRUE) {
                $message2 = "<div class='message success'>Post updated successfully.</div>";
            } else {
                $message2 = "<div class='message error'>Error updating post: " . $conn->error . "</div>";
            }
        } elseif ($action === 'delete_post') {
            $post_id = $_POST['post_id'];
        
            $sql = "INSERT INTO deleted_posts (id, title, content, image_url, created_at, position) 
                    SELECT id, title, content, image_url, created_at, position FROM posts WHERE id=$post_id";
            if ($conn->query($sql) === TRUE) {
                $sql_delete = "DELETE FROM posts WHERE id=$post_id";
                if ($conn->query($sql_delete) === TRUE) {
                    // Update positions of remaining posts
                    $conn->query("UPDATE posts SET position = position - 1 WHERE position > (SELECT position FROM deleted_posts WHERE id=$post_id)");
                    
                    $message2 = "<div class='message success'>Post deleted successfully.</div>";
                    header("Location: manage_content.php?message2=" . urlencode($message2));
                    exit();
                } else {
                    $message2 = "<div class='message error'>Error deleting post: " . $conn->error . "</div>";
                }
            } else {
                $message2 = "<div class='message error'>Error archiving post: " . $conn->error . "</div>";
            }
        } elseif ($action === 'restore_post') {
            $post_id = $_POST['post_id'];
        
            // Get the original position of the post being restored
            $sql_get_position = "SELECT position FROM deleted_posts WHERE id=$post_id";
            $result_position = $conn->query($sql_get_position);
            $original_position = $result_position->fetch_assoc()['position'];
        
            // Get the current maximum position in the posts table
            $sql_max_position = "SELECT MAX(position) as max_position FROM posts";
            $result_max_position = $conn->query($sql_max_position);
            $max_position = $result_max_position->fetch_assoc()['max_position'];
        
            // Determine the new position for the restored post
            $new_position = ($original_position > $max_position + 1) ? $max_position + 1 : $original_position;
        
            // Shift positions of existing posts to make room for the restored post
            $conn->query("UPDATE posts SET position = position + 1 WHERE position >= $new_position");
        
            // Restore the post
            $sql = "INSERT INTO posts (id, title, content, image_url, created_at, position) 
                    SELECT id, title, content, image_url, created_at, $new_position FROM deleted_posts WHERE id=$post_id";
            if ($conn->query($sql) === TRUE) {
                $sql_delete = "DELETE FROM deleted_posts WHERE id=$post_id";
                if ($conn->query($sql_delete) === TRUE) {
                    $message3 = "<div class='message success'>Post restored successfully.</div>";
                    header("Location: manage_content.php?message3=" . urlencode($message3));
                    exit();
                } else {
                    $message3 = "<div class='message error'>Error deleting post from archive: " . $conn->error . "</div>";
                }
            } else {
                $message3 = "<div class='message error'>Error restoring post: " . $conn->error . "</div>";
            }
        } elseif ($action === 'move_up' || $action === 'move_down') {
            $post_id = $_POST['post_id'];
            $current_position = $_POST['current_position'];
        
            if ($action === 'move_up') {
                // Перемещение вверх
                $new_position = $current_position - 1;
            } else {
                // Перемещение вниз
                $new_position = $current_position + 1;
            }
        
            // Обновление позиции только если новая позиция в пределах допустимого диапазона
            if ($new_position > 0) {
                // Обновление позиции другого поста, чтобы освободить место
                $sql_update_other = "UPDATE posts SET position = $current_position WHERE position = $new_position";
                $conn->query($sql_update_other);
        
                // Обновление позиции текущего поста
                $sql_update_current = "UPDATE posts SET position = $new_position WHERE id = $post_id";
                if ($conn->query($sql_update_current) === TRUE) {
                    $message2 = "<div class='message success'>Post position updated successfully.</div>";
                } else {
                    $message2 = "<div class='message error'>Error updating post position: " . $conn->error . "</div>";
                }
            } else {
                $message2 = "<div class='message error'>The position is already initial.</div>";
            }
        }
    }
}

$sql = "SELECT * FROM home_content WHERE id=1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<div class="message-container first-message">
    <?php echo $message; ?>
</div>

<h2>Edit Home Content</h2>
<form method="post" action="manage_content.php">
    <input type="hidden" name="action" value="update_home">
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" value="<?php echo $row['title']; ?>" required><br>
    <label for="subtitle">Subtitle:</label><br>
    <textarea id="subtitle" name="subtitle" required><?php echo $row['subtitle']; ?></textarea><br><br>
    <input type="submit" value="Update">
</form>

<div class="message-container">
    <?php echo $message1; ?>
</div>

<h2>Add New Post</h2>
<form method="post" action="manage_content.php">
    <input type="hidden" name="action" value="add_post">
    <label for="post_title">Post Title:</label><br>
    <input type="text" id="post_title" name="post_title" required><br>
    <label for="post_content">Post Content:</label><br>
    <textarea id="post_content" name="post_content" required></textarea><br>
    <label for="post_image_url">Post Image URL:</label><br>
    <input type="text" id="post_image_url" name="post_image_url"><br><br>
    <input type="submit" value="Add Post">
</form>

<h2>Manage Existing Posts</h2>
<?php
$sql = "SELECT * FROM posts ORDER BY position ASC, created_at DESC";
$result = $conn->query($sql);
?>

<div class="message-container">
    <?php
    if (isset($_GET['message2'])) {
        echo urldecode($_GET['message2']);
    }

    echo $message2; 
    ?>
</div>

<table>
    <tr>
        <th>Title</th>
        <th>Content</th>
        <th>Image</th>
        <th>Position</th>
        <th colspan="4">Actions</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <form method="post" action="manage_content.php">
                    <input type="hidden" name="action" value="edit_post">
                    <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                    <td><input type="text" name="post_title" value="<?php echo $row['title']; ?>" required></td>
                    <td><textarea name="post_content" required><?php echo $row['content']; ?></textarea></td>
                    <td><input type="text" name="post_image_url" value="<?php echo $row['image_url']; ?>"></td>
                    <td><?php echo $row['position']; ?></td>
                    <td>
                        <input type="submit" value="Update">
                    </td>
                </form>
                <td>
                    <form method="post" action="manage_content.php" style="display:inline;" class="no-background">
                        <input type="hidden" name="action" value="delete_post">
                        <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
                <td>
                    <form method="post" action="manage_content.php" style="display:inline;" class="no-background">
                        <input type="hidden" name="action" value="move_up">
                        <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="current_position" value="<?php echo $row['position']; ?>">
                        <input type="submit" value="Up" <?php echo ($row['position'] == 1) ? 'disabled' : ''; ?>>
                    </form>
                </td>
                <td>
                    <form method="post" action="manage_content.php" style="display:inline;" class="no-background">
                        <input type="hidden" name="action" value="move_down">
                        <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="current_position" value="<?php echo $row['position']; ?>">
                        <?php
                        $result_max_position = $conn->query("SELECT MAX(position) as max_position FROM posts");
                        $max_position = $result_max_position->fetch_assoc()['max_position'];
                        ?>
                        <input type="submit" value="Down" <?php echo ($row['position'] == $max_position) ? 'disabled' : ''; ?>>
                    </form>
                </td>
            </tr>
            <?php
        }
    } else {
        echo "<tr><td colspan='8'>No posts available.</td></tr>";
    }
    ?>
</table>

<div class="message-container">
    <?php if (isset($_GET['message3'])) {
        echo urldecode($_GET['message3']);
    } ?>
</div>

<h2>Restore Deleted Posts</h2>
<?php
$sql_deleted = "SELECT * FROM deleted_posts";
$result_deleted = $conn->query($sql_deleted);
?>
<table>
    <tr>
        <th>Title</th>
        <th>Content</th>
        <th>Image</th>
        <th>Actions</th>
    </tr>
    <?php
    if ($result_deleted->num_rows > 0) {
        while($row = $result_deleted->fetch_assoc()) {
            ?>
            <tr>
                <form method="post" action="manage_content.php">
                    <input type="hidden" name="action" value="restore_post">
                    <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['content']; ?></td>
                    <td><?php echo !empty($row['image_url']) ? "<img src='" . $row['image_url'] . "' alt='" . $row['title'] . "' style='max-width:100px;'>" : ""; ?></td>
                    <td><input type="submit" value="Restore"></td>
                </form>
            </tr>
            <?php
        }
    } else {
        echo "<tr><td colspan='4'>No deleted posts available.</td></tr>";
    }
    ?>
</table>

<?php
$conn->close();
renderFooter();
?>
