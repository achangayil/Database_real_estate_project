
<!DOCTYPE html>
<html>
<head>
    <title>Skyline Haven Real Estate NonMember Property Search Page</title>
    <style>
        body {
            text-align: left;
            background-color: #5F9EA0; 
            margin: 20;
            height: 100vh;
            color: #333333; 
        }
        h1 {
            color: white;
            text-align: center; 
        }
        form {
            padding: 20px; 
            margin: auto; 
            width: 50%; 
            background-color: white; 
            border-radius: 10px; 
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }
        .linkbox {
            background-color: rgba(255, 255, 255, 0.8); 
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 15px;
        }
    </style>
</head>
<body>
    <h1>Skyline Haven Real Estate NonMember Property Search Page</h1>
    <div class="linkbox">
    	<h4><a href="index.html"> Home Page</a></h4>
    	<h4><a href="gsu_real_estate_search.php"> Real Estate Buyer Search Page (SIGN-IN required)</a></h4>
    </div>
    
    <form action="realestate_search_results.php" method="get">
        <label for="property_id">Property ID:</label>
        <input type="number" id="property_id" name="property_id" placeholder="Enter Property ID"><br><br>

        <label for="seller_id">Seller ID:</label>
        <input type="number" id="seller_id" name="seller_id" placeholder="Enter Seller ID"><br><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" placeholder="Enter Address"><br><br>

        <label for="street_name">Street Name:</label>
        <input type="text" id="street_name" name="street_name" placeholder="Enter Street Name"><br><br>

        <label for="zip_code">Zip Code:</label>
        <input type="text" id="zip_code" name="zip_code" placeholder="Enter Zip Code"><br><br>

        <label for="school_rating">School Rating:</label>
        <input type="number" id="school_rating" name="school_rating" placeholder="Enter School Rating"><br><br>

        <label for="min_price">Min Price:</label>
        <input type="number" id="min_price" name="min_price" placeholder="No minimum"><br><br>

        <label for="max_price">Max Price:</label>
        <input type="number" id="max_price" name="max_price" placeholder="No maximum"><br><br>

        <label for="area">Area (sq ft):</label>
        <input type="number" id="area" name="area" placeholder="Enter Area in sq ft"><br><br>

        <label for="environmental_rating">Environmental Sustainability Rating:</label>
        <input type="text" id="environmental_rating" name="environmental_rating" placeholder="Enter Rating"><br><br>

        <label for="energy_efficiency_rating">Energy Efficiency Rating:</label>
        <input type="text" id="energy_efficiency_rating" name="energy_efficiency_rating" placeholder="Enter Rating"><br><br>

        <input type="submit" value="Search">
    </form>
</body>
</html>


