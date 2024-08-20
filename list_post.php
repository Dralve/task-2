<?php
require_once 'database.php';
require_once 'posts.php';

$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

try {
    if ($searchQuery !== '') {
        $posts = Post::search($searchQuery);
    } else {
        // Retrieve all posts if no search query is provided
        $posts = Post::listAll();
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Posts</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://bootswatch.com/5/sketchy/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .btn-group {
            margin-left: 0;
        }
        .btn-group .btn {
            margin-left: 8px;
        }
        .post-title {
            display: block;
            margin-top: 5px;
            font-weight: bold;
        }
        .post-content {
            margin-top: 10px;
            color: #6c757d;
        }
        .btn-view {
            color: #ffc107;
            border-color: #ffc107;
        }
        .btn-view:hover {
            background-color: #ffc107;
            color: white;
        }

        .btn-edit {
            color: #198754;
            border-color: #198754;
        }
        .btn-edit:hover {
            background-color: #198754;
            color: white;
        }

        .btn-delete {
            color: #dc3545;
            border-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #dc3545;
            color: white;
        }
        .btn-create {
            color: #0d6efd;
            border-color: #0d6efd;
        }
        .btn-create:hover {
            background-color: #0d6efd;
            color: white;
        }

        .search-input {
            border-color: #0d6efd;
            box-shadow: none;
        }
        .search-input:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .btn-cancel {
            color: #dc3545;
            border-color: #dc3545;
        }
        .btn-cancel:hover {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-dark border-bottom border-bottom-dark sticky-top bg-body-tertiary" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand fw-light"><span class="fas fa-brain me-1"> </span>Share Your Ideas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<!-- Main Container -->
<div class="container py-4 bg-light">
    <div class="row justify-content-center">
        <div class="col-8">
            <h4 style="color: #007bff;">List of Posts</h4>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="create_post.php" class="btn btn-outline-primary btn-sm me-2 btn-create">Create New Post</a>
                <form class="d-flex" method="GET" action="">
                    <input class="form-control me-2 search-input" type="search" placeholder="Search posts" aria-label="Search" name="search" value="<?php echo htmlspecialchars($searchQuery); ?>">
                    <button class="btn btn-outline-success me-2" type="submit">Search</button>
                    <?php if ($searchQuery): ?>
                        <a href="?" class="btn btn-outline-secondary btn-sm btn-cancel">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>
            <!-- List of Posts -->
            <div class="mt-4">
                <?php if ($posts): ?>
                    <?php foreach ($posts as $post): ?>
                        <div class="card mb-3" style="border-color: #0d6efd">
                            <div class="card-body">
                                <p class="mb-1">
                                    <strong><?php echo htmlspecialchars($post['author']); ?></strong>
                                </p>
                                <span class="post-title">
                                    <?php echo htmlspecialchars($post['title']); ?>
                                </span>
                                <div class="btn-group float-end" role="group" aria-label="Post actions">
                                    <a href="view_post.php?id=<?php echo $post['id']; ?>" class="btn btn-outline-primary btn-sm me-2 btn-view">View</a>
                                    <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-outline-primary btn-sm me-2 btn-edit">Edit</a>
                                    <a href="delete_post.php?id=<?php echo $post['id']; ?>" 
                                        onclick="return confirm('Are you sure you want to delete this post?');" 
                                        class="btn btn-outline-primary btn-sm me-2 btn-delete">Delete</a>
                                </div>
                                <p class="post-content"><?php echo htmlspecialchars(substr($post['content'], 0, 100)) . '...'; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-warning">No posts found.</div>
                <?php endif; ?>
            </div>            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

