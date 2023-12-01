<?php

//session_start();

// Database configuration
$servername = "localhost";
$db_username = "root";
$pwddb = "root";
$dbname = "gsu_real_estate";

// Error messages
$errors = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the form data
    //$first_name = $_POST["fname"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $user_role = $_POST["user_role"];
    #echo "name  ","$name"."<BR>";
    #echo "email  ","$email"."<BR>";
    #echo "username  ","$username"."<BR>";
    #echo "pwd  ","$pwd"."<BR>";
    #echo "user_role  ","$user_role"."<BR>";

    // Validate the form fields (make them mandatory)
    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($user_role) ) {
        $errors[] = "All fields are mandatory.";
    }

    // If there are no errors, proceed with database insertion
    if (empty($errors)) {
        try {
            // Create connection
            $conn = new mysqli($servername, $db_username, $pwddb, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } else{
                //echo("----connection success----<BR>");
            }

            // Check if the user already exists in the database
            $query1 = "SELECT * FROM signup WHERE username = '$username' ";
            //echo("----query1---<BR>". $query1);
            
            $result1 = $conn->query($query1);          
            if ($result1->num_rows > 0) {            
                $errors[] = "Username already exists. Please choose a different one.";
            } else {
                //echo("----are you here----<BR>");
                // Insert the new user into the database
                //$query = "INSERT INTO signup (name, email, username, pwd, userrole) VALUES (:name, :email, :username, :pwd, :user_role)";
                $query2 = "INSERT INTO signup (name, email, username, pwd, userrole) VALUES ('$name', '$email', '$username', '$pwd', '$user_role')";
                
                //echo "insert query------   ","$query"."<BR>";  
                $result2 = $conn->query($query2); 
                if ($result2) {
                    echo "Insert query successful!";
                    
                    // Registration successful, redirect to the login page
                    header("Location: realEstateLogin.php");
                    exit; // Make sure to exit after redirection
                } else {
                    echo "Insert query failed.";
                }

                
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        // Close the database connection
        $conn = null;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup Page</title>
    <style>
        /* Add CSS to style the signup box */
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
        .signup-box input[type="pwd"],
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

        /* Add CSS for success message */
        .success-message {
            text-align: center;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin-bottom: 10px;
        }

         /* CSS for the link to index.html */
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
        // Display any errors encountered during form submission
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p class='error-message'>$error</p>";
            }
        } elseif (isset($registration_successful)) {
            // Display success message after successful registration
            echo "<div class='success-message'>Registration successful!</div>";

            // Add a link to go back to the main page (index.html)
            echo "<p><a href='realEstateLogin.php'>Go to Login Page</a></p>";
        }
        ?>
        <form method="post" action="">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="pwd">Password:</label>
            <input type="text" name="pwd" id="pwd" required>

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
