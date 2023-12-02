<?php

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "test";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = $_POST["fname"];
    $last_name = $_POST["lname"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $user_role = $_POST["user_role"];

    if (empty($first_name) || empty($last_name) || empty($email) || empty($username) || empty($password) || empty($user_role)) {
        $errors[] = "All fields are mandatory.";
    }

    if (empty($errors)) {
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM signup WHERE username = :username";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            $user = $stmt->fetch();

            if ($user) {
                $errors[] = "Username already exists. Please choose a different one.";
            } else {
                $query = "INSERT INTO signup (fname, lname, email, username, password, user_role) VALUES (:fname, :lname, :email, :username, :password, :user_role)";
                $stmt = $conn->prepare($query);
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bindParam(":fname", $first_name);
                $stmt->bindParam(":lname", $last_name);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":password", $hashed_password);
                $stmt->bindParam(":user_role", $user_role); 
                $stmt->execute();

                header("Location: realEstateLogin.php");
                exit; 
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn = null;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup Page</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .signup-box {
            width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }

        .signup-box h1 {
            text-align: center;
        }

        .signup-box label,
        .signup-box input[type="text"],
        .signup-box input[type="email"],
        .signup-box input[type="password"],
        .signup-box select,
        .signup-box input[type="submit"] {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }

        .signup-box input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }

        .signup-box input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
        }

      
        .success-message {
            text-align: center;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin-bottom: 10px;
        }

   
        .bottom-center {
            text-align: center;
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>

     <link rel="stylesheet" type="text/css" href="style_original.css">

</head>
<body>
    <div class="signup-box">
        <h1>Signup</h1>
        <?php
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p class='error-message'>$error</p>";
            }
        } elseif (isset($registration_successful)) {
            echo "<div class='success-message'>Registration successful!</div>";

            echo "<p><a href='realEstateLogin.php'>Go to Login Page</a></p>";
        }
        ?>
        <form method="post" action="">
            <label for="first_name">First Name:</label>
            <input type="text" name="fname" id="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" name="lname" id="last_name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="user_role">User Role:</label>
            <select name="user_role" id="user_role" required>
                <option value="" disabled selected>Select a role</option>
                <option value="Buyer">Buyer</option>
                <option value="Seller">Seller</option>
            </select>

            <input type="submit" value="Register">
        </form>
    </div>

    <p class="bottom-center">Go back to <a href="index.html">Home Page</a></p>
</body>
</html>
