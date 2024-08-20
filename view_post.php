<?php
require_once 'posts.php';

// Check if the ID is set and is a valid number
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid post ID.");
}

$id = intval($_GET['id']);
$post = new Post();

try {
    $post->read($id);
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://bootswatch.com/5/sketchy/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .content-wrap {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .btn-view {
        color: #ffc107;
        border-color: #ffc107;
    }
    .btn-view:hover {
        background-color: #ffc107;
        color: white;
    }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center bg-light min-vh-100 p-4">
    <div class="bg-white p-5 rounded-lg shadow-lg w-100" style="max-width: 600px;">
        <h1 class="text-center mb-4"><?php echo htmlspecialchars($post->getTitle()); ?></h1>
        <p class="text-muted mb-4 content-wrap"><?php echo nl2br(htmlspecialchars($post->getContent())); ?></p>
        <p class="text-muted mb-4"><strong>Author:</strong> <?php echo htmlspecialchars($post->getAuthor()); ?></p>
        <p class="text-muted mb-4"><strong>Created at:</strong> <?php echo htmlspecialchars($post->getCreatedAt()); ?></p>
        <p class="text-muted mb-4"><strong>Updated at:</strong> <?php echo htmlspecialchars($post->getUpdatedAt()); ?></p>
        <a href="list_post.php" class="btn btn-Warning w-100 btn-view">Back to All Posts</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>


