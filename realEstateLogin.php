<?php
session_start();

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "test";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $user_role = $_POST["user_role"]; 
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT * FROM signup WHERE username = :username AND user_role = :user_role";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":user_role", $user_role);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION["username"] = $username;
            if ($user_role === "Buyer") {
                header("Location: buyerdashboard.php");
            } elseif ($user_role === "Seller") {
                header("Location: sellerdashboard.php");
            }
            exit;
        } else {
            $error = "Invalid username, password, or user role. Please try again.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .back-to-home {
            margin-top: 20px;
            text-align: center;
        }

        .back-to-home a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .back-to-home a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>
    <section class="content-wrapper">
        <form method="post" action="">
            <table class="login-table">
                <tr>
                    <td>User Role:</td>
                    <td>
                        <select name="user_role">
                            <option value="Buyer">Buyer</option>
                            <option value="Seller">Seller</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" placeholder="Enter your username" required></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" placeholder="Enter your password" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Login"></td>
                </tr>
            </table>
        </form>
    </section>
    
    <div class="back-to-home">
        <a href="index.html">Back to Home</a>
    </div>
    
    <footer class="bottom-box">
        &copy; 2023 Skyline Haven
    </footer>
</body>
</html>
