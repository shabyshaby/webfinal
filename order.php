<?php

session_start();
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Orders</title>
    </head>
    <body>
        
        <h1>Your Orders:</h1>
        
        
        <?php 
        
        
    	
    	//establish connection info
    $server = "127.0.0.1";// your server
    $userid = "urdpwpzt7zxal"; // your user id
    $pw = "1gd6hrg}~tIf"; // your pw
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
    $sql = "SELECT Book, Author, Order_Date, Return_Date, Price FROM Orders INNER JOIN Accounts ON Orders.CustomerID = Accounts.Account_ID WHERE User = '" .$_SESSION["User"] ."'";
    $result = $conn->query($sql);
    
    // $_SESSION["prices"] = array();
    // $_SESSION["images"] = array();
    // $_SESSION["items"] = array();
    // $_SESSION["orderNumber"] = 0;


    //get results
    if ($result->num_rows > 0) 
    {
        echo "<table> name = 'orderTable'
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Order date</th>
                <th>Return date</th>
                <th>Price</th>
            </tr>";
            
            
        while($row = $result->fetch_assoc()) 
       {
        	echo "<tr><td>". $row["Book"]. "</td><td>". $row["Author"]. "</td><td>". $row["Order_Date"]. "/<td><td>". $row["Return_Date"]. "</td><td>" .$row["Price"] ."</td></tr>";

            array_push($_SESSION["prices"], $row["unitPrice"]);
            array_push($_SESSION["images"], $row["image"]);
            array_push($_SESSION["items"], $row["itemName"]);

       }
       echo "</table>";
       
    } 
    else 
      echo "no results";
    	
    //close the connection	
    $conn->close();
    
    	
    	?>
        
        
        
        
        
        
    </body>
</html>