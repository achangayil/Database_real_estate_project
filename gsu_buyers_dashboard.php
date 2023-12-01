<!DOCTYPE html>
<html>
<head>
    <title>Skyline Haven Real Estate Search Results</title>
    <link rel="stylesheet" type="text/css" href="style_original.css">
    <style>
        body {
            text-align: left;
            background-color: #5F9EA0; /* Sea blue color */
            color: #333333; /* Optional: Sets the default text color for better readability */
        }
        table {
            margin-left: auto;
            margin-right: auto; 
            border-collapse: collapse;
            width: 90%;
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
    <h1>Skyline Haven Real Estate Buyer's Dashboard</h1>

    <?php
    session_start(); // Start the session at the beginning of the script
    echo "emailid session ". $_SESSION['emailid'];
    
    // Check if user is logged in
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        // Check if emailid is set in the session
        if (isset($_SESSION['emailid'])) {
            
            $emailid = $_SESSION['emailid']; // Retrieve emailid from session
            echo "emailid:  " . $emailid . "<BR>";
            echo "loggedin:  " . $_SESSION['loggedin'] . "<BR> <BR>";
            
            echo "<h2>Logged in User Email ID : <span style='color: white;'>" . htmlspecialchars($emailid) . "</span></h2>";
            echo "<BR><BR><BR><a href='http://localhost:8888/realestate_search_page.php'>GSU Real Estate Search Page (NO SIGN-IN required)</a><BR><BR>";
            echo "<a href='http://localhost:8888/gsu_real_estate_search.php'>GSU Real Estate Search Page (SIGN-IN required)</a><BR><BR><BR><BR>";
            
    
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dbname = "gsu_real_estate";
    
            $conn = new mysqli($servername, $username, $password, $dbname);
    
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            //commented delete. used for testing
            //echo "<BR> delete from saved_searches <BR><BR>"  ;          
            //$resultDel = $conn->query("DELETE FROM saved_searches"); 
            //echo "Delete success <BR><BR>"  ;
            
            
            //echo "Select start <BR><BR>"  ;
          
            // Retrieve form data
            $property_id = $_POST['property_id'];
            $seller_id = $_POST['seller_id'];
            $address = $_POST['address'];
            $street_name = $_POST['street_name'];
            $zip_code = $_POST['zip_code'];
            $school_rating = $_POST['school_rating'];
            $min_price = $_POST['min_price'];
            $max_price = $_POST['max_price'];
            $area = $_POST['area'];
            $environmental_rating = $_POST['environmental_rating'];
            $energy_efficiency_rating = $_POST['energy_efficiency_rating'];
            
            //echo "property_id:  " . $property_id . "<BR> <BR>";
            //echo "seller_id:  " . $seller_id . "<BR> <BR>";
            //echo "address:  " . $address . "<BR> <BR>";
            //echo "street_name:  " . $street_name . "<BR> <BR>";
            //echo "zip_code:  " . $zip_code . "<BR> <BR>";
            //echo "school_rating:  " . $school_rating . "<BR> <BR>";
            //echo "min_price:  " . $min_price . "<BR> <BR>";
            //echo "max_price:  " . $max_price . "<BR> <BR>";
            //echo "area:  " . $area . "<BR> <BR>";
            //echo "environmental_rating:  " . $environmental_rating . "<BR> <BR>";
            //echo "energy_efficiency_rating:  " . $energy_efficiency_rating . "<BR> <BR>";
            
            
            // Get buyer_id from the database
            $sqlSelect = "SELECT b.Buyer_ID 
                            FROM buyer b 
                            JOIN login l ON l.email = b.email 
                            AND b.email = '$emailid'";
            //echo "<BR> ". $sqlSelect. " <BR><BR><BR>"  ;
            
            $resultSelect = $conn->query($sqlSelect);
            $buyerid = "";
            if ($resultSelect->num_rows > 0) {
                while($rowselect = $resultSelect->fetch_assoc()) {
                    //echo "Inside select result... <BR>"  ;
                    $buyerid = $rowselect["Buyer_ID"];
                    
                }              
            }
            //echo "buyerid:  " . $buyerid . "<BR> <BR>";
            //echo "Select end <BR><BR>"  ;
            
            
            //Select the property ids that match buyers criteria
            
            // Builts the query
            $sqlSelectProp = "SELECT p.Property_ID FROM Property p WHERE 1 = 1";  // Default condition that's always true
            
            // Append conditions to SQL based on form input
            if (!empty($property_id)) $sqlSelectProp .= " AND p.Property_ID = " . intval($property_id);
            if (!empty($seller_id)) $sqlSelectProp .= " AND p.Seller_ID = " . intval($seller_id);
            if (!empty($address)) $sqlSelectProp .= " AND p.Address LIKE '%" . $conn->real_escape_string($address) . "%'";
            if (!empty($street_name)) $sqlSelectProp .= " AND p.StreetName LIKE '%" . $conn->real_escape_string($street_name) . "%'";
            if (!empty($zip_code)) $sqlSelectProp .= " AND p.ZipCode = '" . $conn->real_escape_string($zip_code) . "'";
            if (!empty($school_rating)) $sqlSelectProp .= " AND p.SchoolRating = " . intval($school_rating);
            if (!empty($min_price)) $sqlSelectProp .= " AND p.Price >= " . floatval($min_price);
            if (!empty($max_price)) $sqlSelectProp .= " AND p.Price <= " . floatval($max_price);
            if (!empty($area)) $sqlSelectProp .= " AND p.Area = " . intval($area);
            if (!empty($environmental_rating)) $sqlSelectProp .= " AND p.EnvironmentalSustainabilityRating = '" . $conn->real_escape_string($environmental_rating) . "'";
            if (!empty($energy_efficiency_rating)) $sqlSelectProp .= " AND p.EnergyEfficiencyRating = '" . $conn->real_escape_string($energy_efficiency_rating) . "'";
            
            //echo "<BR>sqlSelectProp " . $sqlSelectProp . " <BR><BR><BR>";
            $resultSelectProp = $conn->query($sqlSelectProp);
            if (!$resultSelectProp) {
                echo "Error: " . $conn->error;
            }
                     
            $propertyIds = []; // Initialize an empty array to store Property_ID values           
            if ($resultSelectProp->num_rows > 0) {
                //echo "Inside select resultSelectProp 1... <BR>";
                while($rowSelectProp = $resultSelectProp->fetch_assoc()) {
                    //echo "Inside select resultSelectProp 2... <BR>";
                    $propertyIds[] = $rowSelectProp["Property_ID"]; // Append Property_ID to the array
                }
            }         
            
            // Buyer selected Property ids in table
            echo "<table width: 15%; background-color: lightblue;'>";
            echo "<tr><th>Property ID (Buyer selected)</th></tr>";           
            foreach ($propertyIds as $id) {
                echo "<tr><td>" . htmlspecialchars($id) . "</td></tr>";
            }           
            echo "</table>";
            
            
            //echo "Insert start <BR><BR>"  ;
            // Save search to the database
            $currentDateTime = date('Y-m-d H:i:s');
            $values = [];
            
            foreach ($propertyIds as $propertyId) {
                // Assuming $buyerid is previously defined and sanitized
                // Append each value set to the $values array, make sure to escape it properly if it's from user input
                $values[] = "('$buyerid', $propertyId, '$currentDateTime', 'Very good location')";
            }
            
            // Join all the value sets with commas to form the complete VALUES part of the SQL statement
            $sqlinsert = "INSERT INTO saved_searches (Buyer_ID, Property_ID, SearchDate, AdditionalCriteria) VALUES " . join(', ', $values);
            
            //echo "<BR>sqlinsert:   ". $sqlinsert. " <BR><BR><BR>"  ;
            
            $resultInsertSavedSearches = $conn->query($sqlinsert);
 
            //echo "Insert success <BR><BR>"  ;
            
            $sql2 = "SELECT b.name, p.* FROM saved_searches s 
                        JOIN Buyer b ON s.buyer_id = b.buyer_id 
                        JOIN Property p ON p.property_id = s.property_id 
                        WHERE b.email = '$emailid'";
            //echo "<BR><H3>SQL query to be executed <BR>". $sql2. "<BR></H3>"  ;
            echo "<BR><BR>"  ;
            
            $result = $conn->query($sql2);
            //echo "3333333";
            
            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr>
                    <th>Buyer Name</th>
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
                    echo "<td>" . $row["name"] . "</td>";
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
        } else {
            echo "No email ID found. Please login again.";
        }
    }
    ?>
</body>
</html>
