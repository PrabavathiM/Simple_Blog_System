<!-- PHP code remains the same at the top -->
<?php
include(__DIR__ . '/App/database/connect.php');

if (isset($_POST['submit'])) {
    $Username = $_POST['Username'] ?? null;
    $Email_id = $_POST['Email_id'] ?? null;
    $Password = $_POST['Password'] ?? null;

    if (empty($Username) || empty($Email_id) || empty($Password)) {
        echo "<script>alert('Please fill in all fields.');</script>";
        exit;
    }

    $hashedPassword = password_hash($Password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("SELECT * FROM register WHERE Username = ? OR Email_id = ?");
    $stmt->bind_param("ss", $Username, $Email_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "<script>alert('Username or Email ID already exists. Please try with different details.'); window.history.back();</script>";
        $stmt->close();
        exit;
    }
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO register (Username, Email_id, Password) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sss", $Username, $Email_id, $hashedPassword);
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location.href='Login.php';</script>";
            exit;
        } else {
            echo "Error executing statement: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
?>

<!-- HTML + CSS Starts -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Blog System</title>
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

        p {
            text-align: center;
            color: #666;
            font-size: 14px;
        }

        label {
            display: block;
            margin-top: 20px;
            margin-bottom: 6px;
            font-weight: 600;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
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

        .submit_button {
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

        .submit_button:hover {
            background-color: #084298;
            transform: scale(1.03);
        }

        .login {
            text-align: center;
            margin-top: 20px;
            font-size: 15px;
        }

        .login a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: bold;
        }

        .login a:hover {
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

    <form method="POST" action="Register.php">
        <div class="container">
            <h1>✨ Create an Account</h1>
            <p>Fill in the details to register</p>

            <label for="Username">Username</label>
            <input type="text" name="Username" id="Username" placeholder="Enter Username" required>

            <label for="Email_id">Email ID</label>
            <input type="email" name="Email_id" id="Email_id" placeholder="Enter Email ID" required>

            <label for="Password">Password</label>
            <input type="password" name="Password" id="Password" placeholder="Enter Password" required>

            <p style="font-size: 13px; text-align: center;">By registering, you agree to our <a href="#" style="color: #0d6efd;">Terms & Privacy</a>.</p>

            <button type="submit" name="submit" class="submit_button">Register</button>

            <div class="login">
                <p>Already have an account? <a href="Login.php">Login</a></p>
            </div>
        </div>
    </form>

</body>
</html>
