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
$successMessage = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];

        $updateQuery = "UPDATE signup SET fname = :fname, lname = :lname, email = :email WHERE username = :username";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bindParam(":fname", $fname);
        $updateStmt->bindParam(":lname", $lname);
        $updateStmt->bindParam(":email", $email);
        $updateStmt->bindParam(":username", $_SESSION["username"]);

        if ($updateStmt->execute()) {
            $successMessage = "Profile updated successfully!";
        } else {
            $error = "Error updating profile. Please try again.";
        }
    }

    $query = "SELECT * FROM signup WHERE username = :username and user_role='Seller'";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":username", $_SESSION["username"]);
    $stmt->execute();
    $user = $stmt->fetch();
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
    <title>Seller Profile</title>
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

        .user-info-table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px;
        }

        .user-info-table th, .user-info-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
        }

        .edit-button {
            background-color: white;
            color: black;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            margin: 5px;
            font-weight: bold;
        }

        .confirmation {
            color: green;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1 class="header-title"><br>Seller Profile</h1>
        <form method="post" action="realEstateLogin.php"> 
            <button type="submit" name="logout" class="logout-button">Logout</button>
        </form>
    </header>
    <div class="button-row">
        <a href="index.html">Home Page</a>
        <a href="sellerdashboard.php">Seller Dashboard</a>
    </div>
    <section class="content-wrapper">
        <h2>My Profile Information</h2>
        <?php if (!empty($error)) { ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php } ?>
        <?php if (!empty($successMessage)) { ?>
            <div class="confirmation"><?php echo $successMessage; ?></div>
        <?php } ?>
        <table class="user-info-table">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Username</th>
                <th>User Role</th>
            </tr>
            <tr>
                <td><?php echo $user['fname']; ?></td>
                <td><?php echo $user['lname']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['user_role']; ?></td>
            </tr>
        </table>
        <button onclick="showEditForm()" class="edit-button">Edit Profile</button>
        <!-- Updated code for the edit form -->
        <form id="edit-form" style="display: none;" method="post">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" value="<?php echo $user['fname']; ?>"><br>
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" value="<?php echo $user['lname']; ?>"><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>"><br>
            <input type="submit" value="Update">
        </form>
    </section>
    <footer class="bottom-box">
        &copy; 2023 Skyline Haven
    </footer>
    <script>
        function showEditForm() {
            document.getElementById("edit-form").style.display = "block";
        }
    </script>
</body>
</html>
