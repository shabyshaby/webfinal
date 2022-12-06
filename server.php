<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>

    <?php 
    /*PHP ACCOUNT VALIDATION OR INSERT */

    /* Database Information for both the Account and Orders Tables*/
    $server = "localhost";
    $database = "dbh9efiblg6paz";
    $user = "urdpwpzt7zxal";
    $pwd = "1gd6hrg}~tIf";

    $conn = mysqli_connect($server, $user, $pwd, $database);
    //connects to the database

    if (!$conn) {//if connection fails
        die("Connection failed: " . mysqli_connect_error());
    }

    $check = "SELECT Email, Passwrd FROM Accounts WHERE Email LIKE '" . $_POST['email_adr'] . "' AND Passwrd LIKE '" .  $_POST['passwrd'] . "'";
    // check is making sure the user's account has not been already created 
    $result = mysqli_query($conn, $check);
    
    if (mysqli_num_rows($result) > 0) { // if there is a result from the database then the account already exists
        echo '<p>Account already exists </p>'; //noftify user account already exists 
    } else { //if not, then can insert user information to the database

        //feel free to change $_POST[] variable names to the name of the inputs in your page
        $insert = "INSERT INTO Accounts (User, Email, Phone, Passwrd) VALUES ( ' "
            . combinename($_POST['fname'], $_POST['lname']) . "', '" . $_POST['email_adr'] . "' , '"
            . convert($_POST['phone_num']) . "', '" . $_POST['passwrd'] . "')";

        $result = mysqli_query($conn, $insert);
        if ($result) { //if the info has been inserted succcessfully
            //change alert message for your web page 
            echo "<p>Table has been successfully updated: " . $result . "</p>";
        } else { //display any errors to the console
            //change error message to javascript
            echo "<p>'Error':" . $sql . " ; " .  mysqli_error($conn) . " </p>";
        }
    }
        function combinename($first, $last) {
            return $last . " " .  $first;
        }

        function convert($string){
            return intval($string);
        }
        ?>
        
    </body>
</html>