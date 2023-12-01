

<!DOCTYPE html>
<html>
<head>
    <title>Real Estate Buyer Property Search Page</title>
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
    <h1>Skyline Haven Real Estate Buyer Property Search Page</h1>
    <div class="linkbox">
    	<h4><a href="index.html"> Home Page</a></h4>
    	<h4><a href="Database_HW/realestate_search_page.php"> Real Estate NonMember Search Page (NO SIGN-IN required)</a></h4>
    </div>
               
    <form action="admin_dashboard.php" method="post">
        <input type="text" id="emailid" name="emailid" placeholder="Email ID">
        <input type="text" id="pwd" name="pwd" placeholder="Password">
        <input type="submit" value="Login">
    </form>
    
</body>
</html>
