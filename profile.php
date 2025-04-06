<?php
session_start();
include(__DIR__ . '/App/database/connect.php');

$Username = $_SESSION['Username'];

$stmt = $conn->prepare("SELECT * FROM register WHERE Username = ?");
$stmt->bind_param("s", $Username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #74ebd5, #acb6e5);
            margin: 0;
            padding: 0;
        }

        .profile-container {
            max-width: 600px;
            margin: 60px auto;
            background-color: #fff;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .info-box {
    background-color: #f5f9ff;
    border-left: 6px solid #0d6efd;
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.info-box label {
    font-weight: bold;
    color: #0d6efd;
    font-size: 16px;
    display: block;
    margin-bottom: 5px;
}

.info-value {
    font-size: 18px;
    color: #333;
}


        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        p {
            font-size: 18px;
            color: #444;
            margin: 20px 0;
        }

        strong {
            color: #1c1c1c;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-top: 30px;
        }

        .buttons a {
            text-decoration: none;
            background-color: #2c3e50;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s ease;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .buttons a:hover {
            background-color: #0d6efd;
            transform: scale(1.05);
        }

        .label {
            display: inline-block;
            width: 100px;
        }

    </style>
</head>
<body>

<div class="profile-container">
    <h2>👤 My Profile</h2>
    <!-- <p><strong class="label">Username:</strong> <?= htmlspecialchars($user['Username']) ?></p>
    <p><strong class="label">Email:</strong> <?= htmlspecialchars($user['Email_id']) ?></p> -->
    <div class="info-box">
    <label>👤 Username</label>
    <div class="info-value"><?= htmlspecialchars($user['Username']) ?></div>
</div>

<div class="info-box">
    <label>📧 Email</label>
    <div class="info-value"><?= htmlspecialchars($user['Email_id']) ?></div>
</div>


    <div class="buttons">
        <a href="Dashboard.php">🏠 Dashboard</a>
        <a href="edit_profile.php">✏️ Edit Profile</a>
    </div>
</div>

</body>
</html>
