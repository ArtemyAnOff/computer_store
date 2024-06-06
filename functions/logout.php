<?php
session_start();
session_destroy();
header("Location: ../index.php");  // Обновление пути после логаута
exit();
?>
