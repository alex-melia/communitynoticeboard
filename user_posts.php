<?php

require_once "header.php";

//If user is logged in
if(isset($_SESSION['loggedIn']))
{
    //Connection string
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    //If connection fails, produce error
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    //Define query, result and number of rows
    $query = "SELECT postid, title, content, image FROM posts INNER JOIN users ON posts.uid = users.uid WHERE username = '{$_SESSION['username']}'";
    $result = mysqli_query($connection, $query);

    $n = mysqli_num_rows($result);

    //If there is data...
    if ($n > 0) {

        echo "<br><h1><b><i>Your Posts</i></b></h1><br>";
        echo "<div id='my_posts'>";

        //Loop through data
        while($rows = mysqli_fetch_assoc($result))
        {
            //Produce a card for each row
            echo "<div class='card'>";
                echo "<img class='card-img-top' src='".$rows['image']."'>";
                echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>".$rows['title']."</h5>";
                    echo "<p class='card-text'>".$rows['content']."</p>";
                echo "</div>";
                echo "<div class='card-body'>";
                    echo "<form method='POST' action='edit_post.php'><button type='submit' name='edit_this_post' value=".$rows['postid'].">Edit</button></form>";
                    echo "<form method='POST' action='delete_post.php'><button type='submit' name='delete_my_post' value=".$rows['postid'].">Delete</button></form>";
            echo "</div>";
            echo "</div>";
            echo "<br>";
        }
        echo "</div>";
    
    }

    //If there is no data...
    else {
        echo "<br><h3>You have no posts!</h3><br>";
    }

    //Close connection
    mysqli_close($connection);
    
}
//If user is not logged in
else
{
    echo "You must be logged in to view this page!";
}

require_once "footer.php";


?>