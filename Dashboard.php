<?php
session_start();
include(__DIR__ . '/App/database/connect.php');

if (!isset($_SESSION['Username'])) {
    header('Location: Login.php');
    exit;
}

$Username = $_SESSION['Username'];
$result = $conn->query("SELECT * FROM blog_posts WHERE user_id = '$Username' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(120deg, #a1c4fd, #c2e9fb);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            font-size: 2rem;
        }

        h3 {
            text-align: center;
            color: #34495e;
            margin-top: 40px;
        }

        .nav-links {
            text-align: center;
            margin: 30px 0;
        }

        .nav-links a {
            margin: 0 10px;
            text-decoration: none;
            font-weight: bold;
            padding: 12px 24px;
            border-radius: 8px;
            transition: 0.3s ease;
            background: #2c3e50;
            color: #fff;
            border: none;
            display: inline-block;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .nav-links a:hover {
            background: #3498db;
            transform: translateY(-2px);
        }

        .blog-post {
            background: linear-gradient(135deg, #fdfbfb, #ebedee);
            border-left: 5px solid #3498db;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }

        .blog-post:hover {
            transform: scale(1.01);
        }

        .blog-post h4 {
            margin-top: 0;
            color: #2c3e50;
        }

        .blog-post p {
            color: #555;
            line-height: 1.6;
        }

        .blog-post small {
            color: #888;
            display: block;
            margin: 8px 0 12px;
        }

        .blog-post a {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
            margin-right: 15px;
        }

        .blog-post a:hover {
            text-decoration: underline;
            color: #c0392b;
        }

        .no-blogs {
            text-align: center;
            color: #555;
            font-style: italic;
            font-size: 1.1rem;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?= htmlspecialchars($Username); ?>!</h2>

        <div class="nav-links">
            <a href="write_blog.php">✍️ Write Blog</a>
            <a href="profile.php">👤 Profile</a>
            <a href="logout.php">🚪 Logout</a>
        </div>

        <?php if ($result->num_rows == 0): ?>
            <p class="no-blogs">No blogs found. Write your first blog! 🚀</p>
        <?php else: ?>
            <h3>📝 Blogs</h3>

            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="blog-post">
                    <h4><?= htmlspecialchars($row['title']) ?></h4>
                    <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                    <small>Posted on <?= $row['created_at'] ?></small>
                    <a href="edit_blog.php?id=<?= $row['id'] ?>">Edit</a>
                    <a href="delete_blog.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this blog?')">Delete</a>
                </div>
            <?php } ?>
        <?php endif; ?>
    </div>
</body>
</html>
