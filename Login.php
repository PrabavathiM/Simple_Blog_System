
<?php
session_start();
include(__DIR__ . '/App/database/connect.php');

// Get form data
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    echo "<script>alert('Please enter both username and password.'); window.location.href='Login.php';</script>";
    exit;
}

// Check if the user exists
$stmt = $conn->prepare("SELECT * FROM register WHERE Username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verify the password
    if (password_verify($password, $user['Password'])) {
        // Password is correct
        $_SESSION['username'] = $user['Username']; // you can store more info like ID, role etc.
        echo "<script>alert('Login successful!'); window.location.href='dashboard.php';</script>";
    } else {
        // Invalid password
        echo "<script>alert('Incorrect password.'); window.location.href='Login.php';</script>";
    }
} else {
    // Username not found
    echo "<script>alert('User not found.'); window.location.href='Login.php';</script>";
}

$stmt->close();
$conn->close();
?>

<!-- login page -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fffdfd;
        }

        .container {
            width: 50%;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 12px 20px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .loginbtn {
            background-color: rgb(46, 195, 254);
            color: white;
            padding: 12px 18px;
            margin: 8px auto;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

        }


        .loginbtn:hover {
            background-color: rgb(9, 8, 8);
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
        }

        .register {
            text-align: center;
        }
    </style>

</head>

<body>



    <h1>Login</h1>
    <form action="process_login.php" method="POST">
        <div class="container">
            <!-- username field -->
            <label for="Username">Username:</label><br>
            <input type="text" placeholder="Enter Username" id="Username" name="Username" required><br><br>
            <!-- password field -->
            <label for="Password">Password:</label><br>
            <input type="Password" placeholder="Enter Password" id="Password" name="Password" required><br><br>
            <!-- login button -->
            <button type="submit" class="loginbtn">Login</button>
        </div>

        <div class="register">
            <p>Don't have an account? <a href="Register.php">Register here</a></p>
        </div>
    </form>

</body>

</html>