<?php
session_start();


// Database configuration
$servername = "localhost";
$db_username = "root";
$db_password = "root";
$dbname = "gsu_real_estate";

// Error message
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $user_role = $_POST["user_role"]; // Added user role selection
    
    //change the form action based on this.
    //$formAction = "gsu_real_estate_search.php";
    //if ($user_role === "Seller") {
    //    $formAction = "sellerdashboard.php";
    //}

    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query to fetch user data by username and user role
        $query1 = "SELECT * FROM signup WHERE username = :username AND userrole = :user_role";
        
        $result1 = $conn->query($query1);
        while($row = $result->fetch_assoc()) {
            $usernamedb = $row["username"];
            $pwddb = $row["pwd"];
            $userrole = $row["userrole"];
            $_SESSION['loggedin'] = true;
            $_SESSION['usernamedb'] = $usernamedb;
            echo $_SESSION['emailid'];
            echo $_SESSION['loggedin'];
        }
        if ($result1->num_rows > 0) {
            if ($row["username"] && $row["pwd"] && $row["userrole"] ) {
                // Redirect to the appropriate dashboard based on the user role
                if ($user_role === "Buyer") {                   
                    header("Location: gsu_real_estate_search.php");                   
                } elseif ($user_role === "Seller") {
                    header("Location: sellerdashboard.php");
                }
            }else {
                $error = "Invalid username, password, or user role. Please try again.";
            }
            
        } else {
            $error = "No result sent from database. Invalid username, password, or user role. Please try again.";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
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
        /* Add custom CSS styles for the back-to-home box */
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
        <form method="post" action="gsu_real_estate_search.php">
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
    
    <!-- Add the "Back to Home" link under the login table -->
    <div class="back-to-home">
        <a href="index.html">Back to Home</a>
    </div>
    
    <footer class="bottom-box">
        &copy; 2023 Skyline Haven
    </footer>
</body>
</html>
