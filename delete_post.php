<?php
require_once 'database.php';
require_once 'posts.php';

// Check if the ID is set and is a valid number
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid post ID.");
}

$id = intval($_GET['id']);
$post = new Post();

try {
    $post->delete($id); // Call the delete method
    header('Location: list_post.php');
    exit;
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
