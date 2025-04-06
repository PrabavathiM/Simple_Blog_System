<?php
session_start();
include(__DIR__ . '/App/database/connect.php');

if (!isset($_SESSION['Username'])) {
    header('Location: Login.php');
    exit;
}

$Username = $_SESSION['Username'];

// Fetch current user data
$stmt = $conn->prepare("SELECT * FROM register WHERE Username = ?");
$stmt->bind_param("s", $Username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Update user data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = $_POST['Username'] ?? '';
    $newEmail = $_POST['Email_id'] ?? '';

    if (!empty($newUsername) && !empty($newEmail)) {
        $stmt = $conn->prepare("UPDATE register SET Username = ?, Email_id = ? WHERE Username = ?");
        $stmt->bind_param("sss", $newUsername, $newEmail, $Username);

        if ($stmt->execute()) {
            $_SESSION['Username'] = $newUsername;
            echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
        } else {
            echo "<script>alert('Failed to update profile.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please fill in all fields.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #74ebd5, #acb6e5);
            margin: 0;
            padding: 0;
        }

        .edit-container {
            max-width: 500px;
            margin: 70px auto;
            background-color: #fff;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #0d6efd;
            margin-bottom: 25px;
        }

        label {
            font-weight: bold;
            display: block;
            margin: 15px 0 8px;
            color: #333;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 12px 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 10px;
            transition: 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
        }

        .btn-container {
            text-align: center;
            margin-top: 25px;
        }

        /* button {
            background-color: #0d6efd;;
            color: white;
            padding: 12px 25px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #0d6efd;
            transform: scale(1.03);
        } */

        button {
            background-color: #0d6efd;
            color: white;
            padding: 12px 25px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-weight: bold;
        }


        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            text-decoration: none;
            color: #0d6efd;
            font-weight: bold;
            transition: 0.2s;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .edit-container {
                margin: 30px 20px;
                padding: 25px;
            }
        }
    </style>
</head>
<body>

<div class="edit-container">
    <h2>✏️ Edit Profile</h2>
    <form method="POST">
        <label for="Username">Username:</label>
        <input type="text" id="Username" name="Username" value="<?= htmlspecialchars($user['Username']) ?>" required>

        <label for="Email_id">Email ID:</label>
        <input type="email" id="Email_id" name="Email_id" value="<?= htmlspecialchars($user['Email_id']) ?>" required>

        <div class="btn-container">
            <button type="submit">Update Profile</button>
        </div>
    </form>
    <a class="back-link" href="profile.php">← Back to Profile</a>
</div>

</body>
</html>
