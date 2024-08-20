<?php

require_once 'Database.php';
require_once 'posts.php';
require_once 'validateData.php'; 


// Instantiate the Post object
$post = new Post();
$validator = new Validator();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];

    // Validate the form data using the trait
    $validation = $validator->validateData($title, $content, $author);

    if ($validation['isValid']) {
        // If the data is valid, attempt to create the post
        try {
            $post->create($title, $content, $author);
            header('Location: list_post.php');
            exit();
        } catch (Exception $e) {
            $error = "Failed to create the post: " . htmlspecialchars($e->getMessage());
        }
    } else {
        // If validation fails, display errors
        $error = implode('<br>', $validation['errors']);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://bootswatch.com/5/sketchy/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    .btn-create {
        color: #0d6efd;
        border-color: #0d6efd;
    }
    .btn-create:hover {
        background-color: #0d6efd;
        color: white;
    }
    .btn-back {
        color: #dc3545;        
        border-color: #dc3545;
    }
    .btn-back:hover {
        background-color: #dc3545;
        color: white;
    }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center bg-light min-vh-100 p-4">
    <div class="bg-white p-5 rounded-lg shadow-lg w-100" style="max-width: 600px;">
        <h1 class="text-center mb-4" style="color: #0d6efd;">Create Post</h1>

        <!-- Error Message -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Form to create a new post -->
        <form method="post" action="create_post.php">
        <div class="mb-3">
            <label for="title" class="form-label" style="color: #0d6efd">Title:</label>
            <input type="text" id="title" name="title" 
                        class="form-control" style="border-color:#0d6efd">
        </div>

            <div class="mb-3">
                <label for="content" class="form-label" style="color: #0d6efd">Content:</label>
                <textarea id="content" name="content" rows="4" 
                        class="form-control" style="border-color:#0d6efd"></textarea>
            </div>

            <div class="mb-3">
                <label for="author" class="form-label" style="color: #0d6efd">Author:</label>
                <input type="text" id="author" name="author" 
                        class="form-control" style="border-color: #0d6efd">
            </div>

            <button type="submit" class="btn btn-outline-primary btn-sm me-2 btn-create w-100 ">Create Post</button>
        </form>
        <a href="list_post.php" class="btn btn-outline-primary btn-sm me-2 btn-back w-100 mt-3">Cancel</a>


