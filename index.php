<?php
include(__DIR__ . '/App/database/connect.php');

// Fetch public blogs
$sql = "SELECT * FROM blog_posts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog System Home Page</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(120deg, #89f7fe 0%, #66a6ff 100%);
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 25px 15px;
            font-size: 34px;
            font-weight: bold;
            position: relative;
        }

        .nav-buttons {
            position: absolute;
            top: 15px;
            left: 20px;
            right: 20px;
            display: flex;
            justify-content: space-between;
        }

        .nav-buttons a button {
            background-color: #0d6efd;
            color: white;
            padding: 10px 20px;
            font-size: 14px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s ease;
        }

        .nav-buttons a button:hover {
            background-color: #084298;
            transform: scale(1.05);
        }

        .blog-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .blog-card {
            background-color: #ffffff;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
            border-left: 6px solid #0d6efd;
        }

        .blog-card:hover {
            transform: translateY(-5px);
        }

        .blog-title {
            font-size: 22px;
            color: #0d6efd;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .blog-date {
            color: #777;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .blog-content {
            font-size: 16px;
            color: #333;
        }

        .no-posts {
            text-align: center;
            font-size: 20px;
            color: #444;
            margin-top: 50px;
        }

        @media (max-width: 600px) {
            .header {
                font-size: 26px;
                padding: 20px 10px;
            }

            .nav-buttons {
                flex-direction: column;
                gap: 10px;
                align-items: center;
                top: 10px;
            }

            .nav-buttons a button {
                padding: 10px 16px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        🌐 Blog System
        <div class="nav-buttons">
            <a href="Register.php"><button>Register</button></a>
            <a href="Login.php"><button>Login</button></a>
        </div>
    </div>

    <div class="blog-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="blog-card">
                    <div class="blog-title"><?php echo htmlspecialchars($row['title']); ?></div>
                    <div class="blog-date">
                        <?php echo date("F j, Y", strtotime($row['created_at'])); ?>
                    </div>
                    <div class="blog-content">
                        <?php echo nl2br(htmlspecialchars($row['content'])); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-posts">No blog posts available.</div>
        <?php endif; ?>
    </div>

</body>
</html>
