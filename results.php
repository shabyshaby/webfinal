<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap');
</style>
</head>
<body>
        
        <button href="#search.html">Search Again</button>
        
        <h2>Search Results</h2>
        <?php 
        $server = // your server
        $userid =  // your user id
        $pw = // your pw
        $db=  // your database
        $conn = new mysqli($server, $userid, $pw );
        
        if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
        }
        $conn->select_db($db);
        
        $searchtype = $_POST['search'];
        $pagemin = $_POST['minpages'];
        $pagemax = $_POST['maxpages'];
        $searchvalue = $_POST['searchbar'];
        $sql = "SELECT";
        
        if ($searchvalue = "" || $searchvalue = " "){
                $sql = $sql. " ". "*";
        }
        else if($searchtype = "title"){
                $sql = $sql. " ". "TITLE";
        }
        
        else if($searchtype = "author"){
                $sql = $sql. " ". "AUTHOR";
        }
        
        else if($searchtype != "genre"){
                $sql = $sql. " ". "GENRE";
        }
        
        $sql = $sql. "FROM" //add db table name for books;
        
        if($pagemin != "" && $pagemax !=""){
                $sql = $sql. " ". "WHERE". " PAGES BETWEEN ". $pagemin. " AND ". $pagemax;
        } else if ($pagemin != ""){
                $sql = $sql. " ". "WHERE PAGES >= ". $pagemin;
        } else if ($pagemax != ""){
                $sql = $sql. " ". "WHERE PAGES <= ". $pagemax;
        }

        $result = $conn->query($sql);
        
        while($row = $result->fetch_assoc()){
            $titlesql = "";//add sql for attributes of book
            $authorsql = " ";
            $genresql = " ";
            $pagesql = "";
            $descripsql = "";
            $title = $conn->query($costsql);
            $author = $conn->query($authorsql);
            $genre = $conn->query($genresql);
            $pages = $conn->query($authorsql);
            $descrip = $conn->query($descripsql);
            echo "<div style='result'> 
                <p>".$title." by ". $author. "</br> Genre(s): ". $genre. 
                "Page Count: ".$pages."</div>";
        }
        
        ?>

</body>
</html>