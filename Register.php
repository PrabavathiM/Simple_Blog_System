<!-- connect the database -->
<?php
include(__DIR__ . '/App/database/connect.php');

// check if the form is submitted
if (isset($_POST['submit'])) {
    // get the form data
    $Username = $_POST['Username'] ?? null;
    $Email_id = $_POST['Email_id'] ?? null;
    $Password = $_POST['Password'] ?? null;

    if (empty($Username) || empty($Email_id) || empty($Password)) {
        echo "<script>alert('Please fill in all fields.');</script>";
        exit;
    }

    // hash the password
    $hashedPassword = password_hash($Password, PASSWORD_BCRYPT);

    // check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM register WHERE Username = ? OR Email_id = ?");
    $stmt->bind_param("ss", $Username, $Email_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "<script>alert('Username or Email ID already exists.');</script>";
        $stmt->close();
        exit;
    } else {
        $stmt->close();
    }
    $stmt->close();
    $conn->close();
    

    // insert the data into the database
    $stmt = $conn->prepare("INSERT INTO register (Username, Email_id, Password) VALUES (?, ?, ?)");

    if ($stmt) {
        // bind the parameters
        $stmt->bind_param("sss", $Username, $Email_id, $hashedPassword);

        // execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!');</script>";
        } else {
            echo "Error executing statement: " . $stmt->error;
        }

        // close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
?>

<!-- HTML code for the registration form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
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
        input[type="Email_id"],
        input[type="password"] {
            width: 90%;
            padding: 12px 20px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .submit_button {
            background-color: rgb(46, 195, 254);
            color: white;
            padding: 12px 18px;
            margin: 8px auto;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            display: flex;
            justify-content: center;
            font-size: 18px;
            font-weight: bold;
        }

        .submit_button:hover {
            background-color: rgb(9, 8, 8);
            color: white;
        }

        .login {
            text-align: center;
        }
    </style>
</head>

<body>
    <form method="POST" action="Register.php">
        <div class="container">
            <h1>Create an Account</h1>
            <p>Please fill in the information to create an account</p>
            <hr>

            <!-- username -->
            <label for="Username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="Username" id="Username" required>

            <!-- email -->
            <label for="Email_id"><b>Email ID</b></label>
            <input type="Email_id" placeholder="Enter Email ID" name="Email_id" id="Email_id" required>

            <!-- password -->
            <label for="Password"><b>Password</b></label>
            <input type="Password" placeholder="Enter Password" name="Password" id="Password" required>
            <hr>

            <p>By creating an account you agree to our <a href="#">Terms & Privacy</a></p>

            <button class="submit_button" type="submit" name="submit">Register</button>
        </div>

        <div class="container login">
            <p>Already have an account? <a href="Login.php">Login</a></p>
        </div>
    </form>
</body>
</html>
