<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog System Home Page</title>

    <!--  h1 style -->
    <style>
        h1 {
            font-size: 40px;
            text-align: center;
            margin-top: 30px;
            color: white;
        }
    </style>

    <!-- button style -->
    <style>
        .button {
            background-color: rgb(46, 195, 254);
            color: white;
            border: none;
            padding: 12px 20px;
            margin: 8px 0;
            border-radius: 4px;
            font-weight: bold;
            text-align: center;
            display: inline;
            font-size: 20px;
            margin-top: auto;
            cursor: pointer;
            transition-duration: 0.6s;
        }

        .Register:hover,
        .Login:hover {
            background-color: rgb(9, 8, 8);
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            color: white;
            border-radius: 5px;
            padding: 12px 18px;
            border: none;
        }

        .Register {
            position: absolute;
            top: 10%;
            left: 9%;
            transform: translate(-50%, -50%);
            background-color: rgb(46, 195, 254);
        }

        .Login {
            position: absolute;
            top: 10%;
            left: 90%;
            transform: translate(-50%, -50%);
            background-color: rgb(46, 195, 254);
        }
    </style>
</head>

<body
    style="background-image: url('image/homepage.avif'); background-size: cover; background-repeat: no-repeat; background-attachment: fixed;">
    <h1 style="text-align: center; color: rgb(9, 8, 8);">Welcome to the Blog System</h1>
    <!-- button  -->
    <a href="register.php">
        <button class="button Register">Register</button>
    </a>
    <a href="Login.php">
        <button class="button Login">Login</button>
    </a>
</body>


</html>