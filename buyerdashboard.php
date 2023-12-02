<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: realEstateLogin.php");
    exit;
}

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "test";

$error = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch user data by username
    $query = "SELECT * FROM properties WHERE user = :username AND usersaved = 'Yes'";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":username", $_SESSION["username"]);
    $stmt->execute();
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard</title>
    <style>
        body {
            background-image: url('body3.jpg'); 
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .header-title {
            text-align: center;
            flex-grow: 1; 
        }

        .logout-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin-right: 20px; 
        }

        .button-row {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        .button-row a {
            text-decoration: none;
            color: white;
            margin: 0 20px;
        }

        .button-row a:hover {
            text-decoration: underline;
        }

        .content-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: calc(100vh - 120px);
        }

        .property-info-table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px;
        }

        .property-info-table th, .property-info-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <header>
        <h1 class="header-title"><br>Buyer Dashboard</h1>
        <form method="post" action="realEstateLogin.php"> <!-- Updated action attribute -->
            <button type="submit" name="logout" class="logout-button">Logout</button>
        </form>
    </header>
    <div class="button-row">
        <a href="index.html">Home Page</a>
        <a href="updatebuyerprofile.php">My Profile</a>
    </div>
    <section class="content-wrapper">
        <h2>My Saved Properties</h2>
        <table class="property-info-table">
            <tr>
                <th>Address</th>
                <th>Street Name</th>
                <th>Zip Code</th>
                <th>School Rating</th>
                <th>Property Price</th>
                <th>Area</th>
                <th>Environmental Sustainability Rating</th>
                <th>Energy Efficiency Rating</th>

            </tr>
            <?php foreach ($properties as $property) { ?>
                <tr>
                    <td><?php echo $property['Address']; ?></td>
                    <td><?php echo $property['street_name']; ?></td>
                    <td><?php echo $property['zip_code']; ?></td>
                    <td><?php echo $property['school_rating']; ?></td>
                    <td><?php echo $property['property_price']; ?></td>
                     <td><?php echo $property['Area']; ?></td>
                    <td><?php echo $property['environmental_rating']; ?></td>
                    <td><?php echo $property['energy_efficiency_rating']; ?></td>

                </tr>
            <?php } ?>
        </table>
    </section>
    <footer class="bottom-box">
        &copy; 2023 Skyline Haven
    </footer>
</body>
</html>
