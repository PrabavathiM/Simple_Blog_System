<?php
session_start();
include(__DIR__ . '/App/database/connect.php');

if (!isset($_SESSION['Username'])) {
    header('Location: Login.php');
    exit;
}

$id = $_GET['id'];
$Username = $_SESSION['Username'];

$stmt = $conn->prepare("SELECT * FROM blog_posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("is", $id, $Username);
$stmt->execute();
$result = $stmt->get_result();
$blog = $result->fetch_assoc();

if (!$blog) {
    echo "No blog post found or unauthorized access.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $update = $conn->prepare("UPDATE blog_posts SET title = ?, content = ? WHERE id = ? AND user_id = ?");
    $update->bind_param("ssis", $title, $content, $id, $Username);
    $update->execute();

    header("Location: Dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Blog</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #c2e9fb, #a1c4fd);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #34495e;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
            margin-bottom: 20px;
            font-size: 1rem;
            resize: vertical;
        }

        button {
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            background-color: #3498db;
            transform: scale(1.02);
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #2c3e50;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📝 Edit Blog</h2>
        <form method="POST">
            <label>Title:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($blog['title']) ?>" required>

            <label>Content:</label>
            <textarea name="content" rows="10" required><?= htmlspecialchars($blog['content']) ?></textarea>

            <button type="submit">💾 Update</button>
        </form>

        <div class="back-link">
            <p><a href="Dashboard.php">← Back to Dashboard</a></p>
        </div>
    </div>
</body>
</html>
