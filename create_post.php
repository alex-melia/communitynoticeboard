<?php

require_once "header.php";

$show_form = true;

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$message = "";

if (!$connection)
{
    die("Connection failed: " . $mysqli_connect_error);
}

//If user is logged in
if(isset($_SESSION['loggedIn']))
{
    //Define query, result and number of rows
    $query = "SELECT uid FROM users WHERE username='{$_SESSION['username']}'";
    $result = mysqli_query($connection, $query);

    $n = mysqli_num_rows($result);

    //If there is a result
    if ($n == 1)
    {
        $row = mysqli_fetch_assoc($result);
        $uid = $row['uid'];
    }

    //If user attempts to submit
    if ((isset($_POST['title'])) && (isset($_POST['content'])))
    {
        //Define variables
        $title = $_POST['title'];
        $created = date("Y/m/d") . " " . date("H:i:s");
        $content = $_POST['content'];

        //Define query and result
        $new_post_query = "INSERT INTO posts (uid, title, created, content) VALUES ('$uid', '$title', '$created', '$content')";
        $new_post_result = mysqli_query($connection, $new_post_query);

        //If there is a result..
        if($new_post_result)
        {
            $show_form = false;
            $message = "Posted successfully!";
            echo $message . " " . "<a href='index.php'>Please click here to return to the previous page</a>";
        }
        else
        {
            $show_form = true;
            $message = "Could not post!";
            echo $message . " " . "<a href='index.php'>Please click here to return to the previous page</a>";
        }

    }
    //If user posts invalid input
    else
    {
        $show_form = true;
        $message = "Could not post!";
    }
}

//If user is not logged in
else
{
    //If user attempts to submit
    if ((isset($_POST['title'])) && (isset($_POST['content'])))
    {
        $title = $_POST['title'];
        $created = date("Y/m/d") . " " . date("H:i:s");
        $content = $_POST['content'];

        $new_post_query = "INSERT INTO posts (title, created, content) VALUES ('$title', '$created', '$content')";
        $new_post_result = mysqli_query($connection, $new_post_query);

        //If there is a result..
        if($new_post_result)
        {
            $show_form = false;
            $message = "Posted successfully!";
            echo $message . " " . "<a href='index.php'>Please click here to return to the previous page</a>";
        }
        else
        {
            $show_form = true;
            $message = "Could not post!";
            echo $message . " " . "<a href='index.php'>Please click here to return to the previous page</a>";
        }

    }
    else
    {
        $show_form = true;
        $message = "Could not post!";
    }
}

//Form to create new post
if($show_form)
{
echo <<<_END
    <div class="new_post_form">
    <h3><b><i>Create a new post</i></b></h3>
    <form method="post" action="create_post.php">
        Title: <input type="text" minlength = "1" maxlength = "120" name="title" required><br>
        Content: <input type="text" minlength= "1" maxlength = "800" name="content" required><br>
    <input type="submit" value="Submit">
    </form>
    </div><br>
_END;
}

//Close connection
mysqli_close($connection);

?>