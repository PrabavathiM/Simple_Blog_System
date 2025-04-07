<?php
session_start();
include(__DIR__ . '/App/database/connect.php');

if (!isset($_SESSION['Username'])) {
    header('Location: Login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Username = $_SESSION['Username'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $imagePath = '';

// Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $uploadDir = 'image/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create folder if it doesn't exist
        }

        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile;
        }
    }

//Insert blog post with image and author
    $stmt = $conn->prepare("INSERT INTO blog_posts (user_id, title, content, image_path, author) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $Username, $title, $content, $imagePath, $Username);
    $stmt->execute();

    header('Location: Dashboard.php');
    exit;
}

?>
<!-- HTML -->
<!DOCTYPE html>
<html>
<head>
    <title>Write a Blog</title>
<!-- styling -->
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

        .custom-file-input {
    padding: 10px;
    background-color: #ecf0f1;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 1rem;
    color: #2c3e50;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-bottom: 20px;
}

.custom-file-input:hover {
    background-color: #d0e6f7;
}

    </style>
</head>
<body>
    <div class="container">
        <h2>✍️ Write a Blog</h2>
<!-- form -->
<form method="POST" enctype="multipart/form-data">
    <label>Title:</label>
    <input type="text" name="title" required>

    <label>Content:</label>
    <textarea name="content" rows="10" required></textarea>

    <label>Upload Image:</label>
    <input type="file" name="image" accept="image/*" class="custom-file-input">

    <button type="submit">🚀 Publish</button>
</form>

        <div class="back-link">
            <p><a href="Dashboard.php">← Back to Dashboard</a></p>
        </div>
    </div>
</body>
</html>