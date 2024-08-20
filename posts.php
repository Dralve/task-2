<?php

require_once 'database.php';
require_once 'TimestampTrait.php';

class Post {

    use TimestampTrait;

    private $pdo;
    private $id;
    private $title;
    private $content;
    private $author;
    private $created_at;
    private $updated_at;

    public function __construct() {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function create($title, $content, $author) {

        if ($this->pdo === null) {
            throw new Exception('Database connection is not initialized.');
        }

        $sql = "INSERT INTO posts (title, content, author, created_at, updated_at) 
                VALUES (:title, :content, :author, NOW(), NOW())";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':title' => $title,
                ':content' => $content,
                ':author' => $author
            ]);
            $this->id = $this->pdo->lastInsertId();
            $this->title = $title;
            $this->content = $content;
            $this->author = $author;
            $this->created_at = $this->getCurrentTimestamp();
            $this->updated_at = $this->getCurrentTimestamp();
        } catch (PDOException $e) {
            throw new Exception('Database error: ' . $e->getMessage());
        }
    }

    public function read($id) {
        if ($this->pdo === null) {
            throw new Exception('Database connection is not initialized.');
        }

        $sql = "SELECT * FROM posts WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($post) {
            $this->id = $post['id'];
            $this->title = $post['title'];
            $this->content = $post['content'];
            $this->author = $post['author'];
            $this->created_at = $post['created_at'];
            $this->updated_at = $post['updated_at'];
        } else {
            throw new Exception("Post not found");
        }
    }

    public static function search($query) {
        $post = new Post();
        $pdo = $post->pdo;

        if ($pdo === null) {
            throw new Exception('Database connection is not initialized.');
        }

        $sql = "SELECT * FROM posts WHERE title LIKE :query OR content LIKE :query";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':query' => "%$query%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($title, $content, $author) {
        if ($this->pdo === null) {
            throw new Exception('Database connection is not initialized.');
        }

        if (!$this->id) {
            throw new Exception("Post ID is not set");
        }

        $sql = "UPDATE posts SET title = :title, content = :content, author = :author, updated_at = NOW() WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':author' => $author,
            ':id' => $this->id
        ]);

        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->updated_at = $this->getCurrentTimestamp();
    }

    public function delete($id) {
        if ($this->pdo === null) {
            throw new Exception('Database connection is not initialized.');
        }
    
        $sql = "DELETE FROM posts WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    public static function reindexPosts() {
        global $pdo;

        if ($pdo === null) {
            throw new RuntimeException('Database connection is not available.');
        }

        try {
            // Fetch all posts
            $stmt = $pdo->query("SELECT id FROM posts ORDER BY id");
            $posts = $stmt->fetchAll(PDO::FETCH_COLUMN);

            // Start with the first ID
            $newId = 1;

            // Update IDs
            foreach ($posts as $postId) {
                $stmt = $pdo->prepare("UPDATE posts SET id = ? WHERE id = ?");
                $stmt->execute([$newId, $postId]);
                $newId++;
            }
            
            // Reset auto-increment value
            $pdo->query("ALTER TABLE posts AUTO_INCREMENT = 1");

        } catch (PDOException $e) {
            // Handle SQL errors
            die("SQL Error: " . $e->getMessage());
        } catch (Exception $e) {
            // Handle general errors
            die("Error: " . $e->getMessage());
        }
    }
    

    public static function listAll() {
        $post = new Post();
        $pdo = $post->pdo;

        if ($pdo === null) {
            throw new Exception('Database connection is not initialized.');
        }

        $sql = "SELECT * FROM posts";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Getter methods for private properties
    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }
}
?>
