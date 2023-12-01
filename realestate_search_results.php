<html>
<head>
    <title>Skyline Haven Real Estate Property Search Results</title>
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
        h1 {
            color: white; 
            text-align: center; 
        }
    </style>
</head>
<body>
    <h1>GSU Real Estate Property Search Results</h1>
    
    <BR><BR><BR><a href='http://localhost:8888/realestate_search_page.php'>GSU Real Estate Search Page (NO SIGN-IN required)</a><BR><BR>";
    <a href='http://localhost:8888/gsu_real_estate_search.php'>GSU Real Estate Search Page (SIGN-IN required)</a><BR><BR><BR><BR>";

    <?php
    // Database connection details
    $servername = "localhost";
    $username = "root"; // replace with your database username
    $password = "root"; // replace with your database password
    $dbname = "gsu_real_estate"; // replace with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $property_id = $_GET['property_id'];
    $seller_id = $_GET['seller_id'];
    $address = $_GET['address'];
    $street_name = $_GET['street_name'];
    $zip_code = $_GET['zip_code'];
    $school_rating = $_GET['school_rating'];
    $min_price = $_GET['min_price'];
    $max_price = $_GET['max_price'];
    $area = $_GET['area'];
    $environmental_rating = $_GET['environmental_rating'];
    $energy_efficiency_rating = $_GET['energy_efficiency_rating'];

    // Construct SQL query
    $sql = "SELECT * FROM property WHERE 1 = 1";

    // Append conditions to SQL based on form input
    if (!empty($property_id)) $sql .= " AND Property_ID = " . intval($property_id);
    if (!empty($seller_id)) $sql .= " AND Seller_ID = " . intval($seller_id);
    if (!empty($address)) $sql .= " AND Address LIKE '%" . $conn->real_escape_string($address) . "%'";
    if (!empty($street_name)) $sql .= " AND StreetName LIKE '%" . $conn->real_escape_string($street_name) . "%'";
    if (!empty($zip_code)) $sql .= " AND ZipCode = '" . $conn->real_escape_string($zip_code) . "'";
    if (!empty($school_rating)) $sql .= " AND SchoolRating = " . intval($school_rating);
    if (!empty($min_price)) $sql .= " AND Price >= " . floatval($min_price);
    if (!empty($max_price)) $sql .= " AND Price <= " . floatval($max_price);
    if (!empty($area)) $sql .= " AND Area = " . intval($area);
    if (!empty($environmental_rating)) $sql .= " AND EnvironmentalSustainabilityRating = '" . $conn->real_escape_string($environmental_rating) . "'";
    if (!empty($energy_efficiency_rating)) $sql .= " AND EnergyEfficiencyRating = '" . $conn->real_escape_string($energy_efficiency_rating) . "'";

    // Execute query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
                <th>Property ID</th>
                <th>Seller ID</th>
                <th>Address</th>
                <th>Street Name</th>
                <th>Zip Code</th>
                <th>School Rating</th>
                <th>Price</th>
                <th>Area</th>
                <th>Environmental Rating</th>
                <th>Energy Efficiency Rating</th>
              </tr>";

        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["Property_ID"] . "</td>";
            echo "<td>" . $row["Seller_ID"] . "</td>";
            echo "<td>" . $row["Address"] . "</td>";
            echo "<td>" . $row["StreetName"] . "</td>";
            echo "<td>" . $row["ZipCode"] . "</td>";
            echo "<td>" . $row["SchoolRating"] . "</td>";
            echo "<td>" . $row["Price"] . "</td>";
            echo "<td>" . $row["Area"] . "</td>";
            echo "<td>" . $row["EnvironmentalSustainabilityRating"] . "</td>";
            echo "<td>" . $row["EnergyEfficiencyRating"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

    $conn->close();
    ?>
</body>
</html>

