<?php

session_start();

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Orders</title>

        <style media="screen">
            table, th, td {
            border: 1px double black;

            orderTable {
                background-color: #f7e7b5;
                background-image: linear-gradient(#f7e7b5, #DCE1DE);
                margin-left: 30%;
                margin-right: 30%;
            }

        }
            
        </style>
    </head>
    <body>
        
        
            <link rel="stylesheet" href="style.css">
        <nav>
                <div class="logo"><a alt="logo" href="index.html" ><img id="fLogo" src="BostonBooksDark.png"></a></div>
                <div class="nav-links">
                    <div class="toggle">
                        <a href="#"><ion-icon name="menu-outline"></ion-icon></a>
                    </div>
                    <ul class="menu">
                            <li class='nav'><a href="/index.html" class="nav">Home</a></li>
                            <li class='nav'><a href="/register.html" class="nav">Log In</a></li>
                            <li class='nav'><a href="/search.html" class="nav">Search</a></li>
                            <li class='nav'><a href="/cart.html" class="nav">My Cart</a></li>
                            <li class='nav'><a href="/orders.html" class="nav">My Orders</a></li>
                    </ul>
                </div>
        </nav>
        
        <h1>Your Orders:</h1>
        
        
        <?php 
        
        
    	
    	//establish connection info
    $server = "127.0.0.1";// your server
    $userid = "u6tlgvskjxeca"; // your user id
    $pw = "byrzzin3pfch"; // your pw
    $db= "dbh9efiblg6paz"; // your database
    		
    // Create connection
    $conn = new mysqli($server, $userid, $pw, $db);
    
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
   
    	
    //select the database
    $conn->select_db($db);
    
   
        
    	//run a query
    $sql = "SELECT Book, Author, Order_Date, Return_Date, Price FROM Orders INNER JOIN Accounts ON Orders.CustomerID = Accounts.Account_ID WHERE User = '";
    $sql .= $_SESSION["User"];
    $sql .= "'";


    $result = $conn->query($sql);
    
    // $_SESSION["prices"] = array();
    // $_SESSION["images"] = array();
    // $_SESSION["items"] = array();
    // $_SESSION["orderNumber"] = 0;


    //get results
    if ($result->num_rows > 0) 
    {
        echo "<div style = 'background-color: #f7e7b5;
                background-image: linear-gradient(#f7e7b5, #DCE1DE);
                margin-left: 30%;
                margin-right: 29%'><table>
            <tr style = 'color: #49A078'>
                <th style = 'padding: 0px 20px'>Title</th>
                <th style = 'padding: 0px 20px'>Author</th>
                <th style = 'padding: 0px 20px'>Order date</th>
                <th style = 'padding: 0px 20px'>Return date</th>
                <th style = 'padding: 0px 20px'>Price</th>
            </tr>";
            
            
        while($row = $result->fetch_assoc()) 
       {
        	//echo "<tr><td>" .$row["Book"] ."</td><td>" .$row["Author"] ."</td><td>" .$row["Order_Date"] ."/<td><td>" .$row["Return_Date"] ."</td><td>" .$row["Price"] ."</td></tr>";
            echo "<tr><td style = 'padding: 0px 20px'>";
            echo $row["Book"] ."</td><td style = 'padding: 0px 20px'>";
            echo $row["Author"] ."</td><td style = 'padding: 0px 20px'>";
            echo $row["Order_Date"] ."</td><td style = 'padding: 0px 20px'>";
            echo $row["Return_Date"] ."</td><td style = 'padding: 0px 20px'>";
            echo "$" .$row["Price"] ."</td></tr>";
            
            

       }
       echo "</table></div>";
       
    } 
    else 
      echo "<br><h2>no results</h2>";
    	
    //close the connection	
    $conn->close();
    
    	
    	?>
        
        
        
        
        
        
    </body>
</html>
