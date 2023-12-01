
<?php
//session_start();

// Redirect if not an admin
//if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
//    header('Location: login.php');
//    exit();
//}

// Database configuration
$host = 'localhost';
$dbname = 'gsu_real_estate';
$username = 'root';
$password = 'root';


try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch logins
    $loginsStmt = $conn->prepare("SELECT Email, PWD FROM Login");
    $loginsStmt->execute();
    $logins = $loginsStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch properties
    $propertiesStmt = $conn->prepare("SELECT * FROM Property");
    $propertiesStmt->execute();
    $properties = $propertiesStmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style_original.css">
    <style>
        body {
            text-align: center;
            background-color: #5F9EA0; /* Sea blue color */
            color: #333333; /* Optional: Sets the default text color for better readability */
        }
        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 80%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {background-color: #f2f2f2;}
    </style>
</head>

<body>
    <h1>Admin Dashboard</h1>
    <section>
        <h2>Login Management</h2>
        <table border="1">
            <tr>
                <th>Email</th>
                <th>Password</th>
                <th>Action</th>
            </tr>
            <?php foreach ($logins as $login): ?>
                <tr>
                    <td><?php echo htmlspecialchars($login['Email']); ?></td>
                    <td><?php echo htmlspecialchars($login['PWD']); ?></td>
                    <td>
                        <form method="post" action="delete_login.php">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($login['Email']); ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>
    <section>
        <h2>Property Listings</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Address</th>
                <!-- Add other property fields here -->
                <th>Action</th>
            </tr>
            <?php foreach ($properties as $property): ?>
                <tr>
                    <td><?php echo htmlspecialchars($property['Property_ID']); ?></td>
                    <td><?php echo htmlspecialchars($property['Address']); ?></td>
                    <!-- Add other property fields here -->
                    <td>
                        <form method="post" action="delete_property.php">
                            <input type="hidden" name="property_id" value="<?php echo htmlspecialchars($property['Property_ID']); ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>
</body>
</html>x


