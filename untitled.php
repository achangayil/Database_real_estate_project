<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to create the table
$sql = "CREATE TABLE usersignup (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Fname VARCHAR(255) NOT NULL,
    Lname VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'usersignup' created successfully!";
} else {
    echo "Error creating table: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
