<?php
// Start session
session_start();

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // database connection
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "gsu_real_estate";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Get username and password from form
    $emailid = $_POST['emailid'];
    $pwd = $_POST['pwd'];
    
    // Check login credentials
    $sql = "SELECT * FROM login WHERE email = '$emailid' AND pwd = '$pwd'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['emailid'] = $emailid;
        
        // Redirect to gsu_real_estate_search page
        header("Location: gsu_real_estate_search.php");
    } else {
        echo "Invalid username or password.";
    }
}
?>
