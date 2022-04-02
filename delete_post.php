<?php

require_once "header.php";

//Connection string
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

//If user wants to delete their post
if(isset($_POST['delete_my_post']))
{
    
    //If connection fails, produce error
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    //Define postId variable
    $postId = $_POST['delete_my_post'];

    //Define query and result
    $query = "DELETE FROM posts WHERE postid = $postId";
    $result = mysqli_query($connection, $query);

    $query2 = "SELECT title, content FROM posts WHERE postid = $postId";
    $result2 = mysqli_query($connection, $query2);
    $n = mysqli_num_rows($result2);

    //If there is a result..
    if ($result)
    {
        $message = "Post successfully deleted!";
        echo $message . " " . "<a href='user_posts.php'>Please click here to return to the previous page</a>";
    }
    //No result
    else
    {    
        $message = "Post deletion failed!";
        echo $message . " " . "<a href='user_posts.php'>Please click here to return to the previous page</a>";
    }

    //Close connection
    mysqli_close($connection);
}

//If admin wants to delete another user's post
else if(isset($_POST['delete_this_post']))
{
    
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    $postId = $_POST['delete_this_post'];

    //Define query and results
    $query = "DELETE FROM posts WHERE postid = $postId";
    $result = mysqli_query($connection, $query);

    //If there is a result..
    if ($result)
    {
        $message = "Post succesfully deleted!";
        echo $message . " " . "<a href='index.php'>Please click here to return to the previous page</a>";
    }
    //No result
    else
    {    
        $message = "Post deletion failed!";
        echo $message . " " . "<a href='index.php'>Please click here to return to the previous page</a>";
    }

    //Close connection
    mysqli_close($connection);
}

//If no data was posted
else
{
    $message = "No data was posted!";
    echo $message . " " . "<a href='index.php'>Please click here to return to go to the homepage</a>";

    //Close connection
    mysqli_close($connection);
}


?>