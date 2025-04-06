<!-- PHP code remains unchanged -->

<?php
session_start();
include(__DIR__ . '/App/database/connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Username = $_POST['Username'] ?? '';
    $Password = $_POST['Password'] ?? '';

    if (empty($Username) || empty($Password)) {
        echo "<script>alert('Please enter both username and password.'); 
        window.location.href='Dashboard.php';</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM register WHERE Username = ?");
    $stmt->bind_param("s", $Username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($Password, $user['Password'])) {
            $_SESSION['Username'] = $user['Username'];
            echo "<script>alert('Login successful!'); window.location.href='Dashboard.php';</script>";
        } else {
            echo "<script>alert('Incorrect password.'); window.location.href='Login.php';</script>";
        }
    } else {
        echo "<script>alert('User not found.'); window.location.href='Login.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- HTML & CSS Styled Section -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Blog System</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #89f7fe 0%, #66a6ff 100%);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 80px auto;
            background-color: #fff;
            padding: 35px 30px;
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #0d6efd;
            font-size: 32px;
        }

        label {
            display: block;
            margin-top: 20px;
            margin-bottom: 6px;
            font-weight: 600;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #0d6efd;
            outline: none;
            box-shadow: 0 0 6px rgba(13, 110, 253, 0.3);
        }

        .loginbtn {
            width: 100%;
            padding: 14px;
            margin-top: 30px;
            background-color: #0d6efd;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .loginbtn:hover {
            background-color: #084298;
            transform: scale(1.03);
        }

        .register {
            text-align: center;
            margin-top: 20px;
            font-size: 15px;
        }

        .register a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: bold;
        }

        .register a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .container {
                margin: 40px 20px;
                padding: 25px;
            }
        }
    </style>
</head>
<body>

    <form action="Login.php" method="POST">
        <div class="container">
            <h1>🔐 Login to Your Account</h1>

            <label for="Username">Username</label>
            <input type="text" placeholder="Enter Username" id="Username" name="Username" required>

            <label for="Password">Password</label>
            <input type="password" placeholder="Enter Password" id="Password" name="Password" required>

            <button type="submit" class="loginbtn">Login</button>

            <div class="register">
                <p>Don't have an account? <a href="Register.php">Register here</a></p>
            </div>
        </div>
    </form>

</body>
</html>
