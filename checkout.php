<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap');
p, h2 {text-align: center;}

</style>
</head>
<body>
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

        <br/><br/><br/>
        <div>
        <h1>Check Out</h1>
        <div id="recommended" class="result"></div>
        <?php
                session_start();
                
                if(!(isset($_SESSION["login"]) && $_SESSION["login"] == "OK")) {
                        header("Location: login.php");
                        exit;
                } else {
                        $user = $_SESSION["user"];
                }
                
                $server = "localhost";
                $database = "dbh9efiblg6paz";
                $user = "urdpwpzt7zxal";
                $pwd = "1gd6hrg}~tIf";
                $conn = new mysqli($server, $userid, $pwd);

                if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                }

                $conn->select_db($database);
                $sql = "SELECT customer_id FROM Accounts WHERE username ==". $user;
                
                $result = $conn->query($sql);
                if($result->num_rows == 1){
                        while($row = $result->fetch_assoc()){
                                $cid = $row['customer_id'];
                        }
                }
                
                $bookquery = "SELECT Book FROM Orders WHERE customer_id ==".$cid;
                $books = $conn->query($sql);
                $titlelist = array();
                if($books->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                                array_push($titlelist, $row["Book"]);
                        }
                }
                $_SESSION["booklist"] = $titlelist;
        ?>
        <script>
        
        let booklist = <?php $_SESSION["booklist"]?>;
        const genrearr = [];
        for(var i = 0; i < booklist.length; i++){
                let title = message.replaceAll(' ','+');
                req = new XMLHttpRequest();
                search = "https://www.googleapis.com/books/v1/volumes?q=" + title +"&key=AIzaSyAGIH-IR7IyPY41F7JrFyvMw-ZgfhtN1U0";
                req.open("GET", search, true);
                console.log("opened file");
                req.onreadystatechange = function(){
                console.log("event fired");
                if(req.readyState == 4 && req.status == 200){
                        data = req.responseText;
                        link_data = JSON.parse(data);
                        link_list = link_data.items;
                        genrearr.push(link_list[0].volumeInfo.genre);
                        document.getElementById("recommended").value =
                } else if (req.readyState == 4 && req.status != 200){
                        document.getElementById("recommended").value = "Something went wrong"
                } else if (req.readyState == 3){
                        document.getElementById("recommended").value = "Try again"
                }
                }
                console.log("sent request");
                req.send()
        }        
        
        const genrelist = [];
        for(i = 0, len = genrearr.length; i < len; i++){
                if genrelist.includes(genrearr[i]){
                        genrelist.push([genrearr[i], 0]);
                }
        }
        for(i = 0, len = genrearr.length; i < len; i++){
                for(j = 0, len2 = genrelist.length; j < len2; j++){
                        if(genrearr[i] == genrelist[j][0]){
                                genrelist[1] = genrelist[1] + 1;
                        }
                }
        }
        var best;
        var bestval = 0;
        for(j = 0, len2 = genrelist.length; j < len2; j++){
                if(genrelist[j][1] > bestval){
                        bestval = genrelist[j][1];
                        best = genrelist[j][0];
                }
        }

        req = new XMLHttpRequest();
        search2 = "https://www.googleapis.com/books/v1/volumes?q=+subject:" + best +"&key=AIzaSyAGIH-IR7IyPY41F7JrFyvMw-ZgfhtN1U0";
        req.open("GET", "", true);
        console.log("opened file");
        req.onreadystatechange = function(){
        console.log("event fired");
        if(req.readyState == 4 && req.status == 200){
                data = req.responseText;
                link_data = JSON.parse(data);
                link_list = link_data.items;
                x = Math.round(link_list.length * Math.random()); //gets a random color from JSON
                book = link_list[x].volumeInfo;
                document.getElementById("recommended").value = book.title+" By: "+book.authors[0]+" Pages: " book.pageCount;
        } else if (req.readyState == 4 && req.status != 200){
                document.getElementById("image").alt = "Something went wrong"
        } else if (req.readyState == 3){
                document.getElementById("image").alt = "Try again"
        }
        console.log("sent request"); 
        }
        req.send();
        }
        </script>
        </div>  

</body>
</html>