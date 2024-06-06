<?php
include('includes/template.php');
include('includes/db.php');

renderHeader('Computer Parts Store');

// Получение текущего контента главной страницы
$sql = "SELECT * FROM home_content WHERE id=1";
$result = $conn->query($sql);
$home_content = $result->fetch_assoc();
?>

<h2><?php echo $home_content['title']; ?></h2>
<p><?php echo $home_content['subtitle']; ?></p>

<h2>Latest Posts</h2>
<div class="posts-container">
<?php
// Получение постов с учетом позиции
$sql_posts = "SELECT * FROM posts ORDER BY position ASC, created_at DESC";
$result_posts = $conn->query($sql_posts);

if ($result_posts->num_rows > 0) {
    while($post = $result_posts->fetch_assoc()) {
        ?>
        <div class="post">
            <h3><?php echo $post['title']; ?></h3>
            <p><?php echo $post['content']; ?></p>
            <?php if (!empty($post['image_url'])): ?>
                <img src="<?php echo $post['image_url']; ?>" alt="<?php echo $post['title']; ?>">
            <?php endif; ?>
        </div>
        <?php
    }
} else {
    echo "<p>No posts available.</p>";
}
?>
</div>

<?php
$conn->close();

renderFooter();
?>
