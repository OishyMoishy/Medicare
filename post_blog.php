<?php
session_start();
require 'database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: bloglogin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO blogs (title, content, user_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $title, $content, $user_id);

    if ($stmt->execute()) {
        header('Location: blogindex.php');
        exit();
    } else {
        $error = "Failed to post the blog.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post Blog</title>
    <link rel="stylesheet" href="blogstyle.css">
</head>
<body>
    <h1>Post Blog</h1>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="content" placeholder="Content" required></textarea>
        <button type="submit">Post</button>
    </form>
</body>
</html>