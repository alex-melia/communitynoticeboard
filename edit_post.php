<?php

require_once "header.php";

//Set form value to false for now
$show_form = false;

//If user is logged in..
if(isset($_SESSION['loggedIn']))
{
    //Define postId variable
    $postId = $_POST['edit_this_post'];

    //Once this is set, show the form
    if(isset($postId))
    {
        $show_form = true;
    }
    else
    {
        echo "No data was received!";
    }

    //If user attempts to post valid input
    if(isset($_POST['title']))
    {
        $title = $_POST['title'];
        $content = $_POST['content'];
        
        //Connection string
        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
        // Attempt to connect. Return an error if not.
        if (!$connection)
        {
            die("Connection failed: " . $mysqli_connect_error);
        }

        //Sanitise the input
        $title = sanitise($title, $connection);
        $content = sanitise($content, $connection);
    
        $title_errors = validateString($title, 1, 120);
        $content_errors = validateString($content, 1, 800);
    
        $errors = $title_errors . $content_errors;
        
        //If there are no errors..
        if($errors == "")
        {
            //Set query and result
            $query = "UPDATE posts SET title = '$title', content = '$content' WHERE postid = $postId";
            $result = mysqli_query($connection,$query);
    
            //If there is a result
            if ($result)
            {
                $show_form = false;
                $message = "Post updated successfully!";
                echo $message . " " . "<a href='index.php'>Please click here to return to the homepage</a>";
            }
            //No result
            else
            {    
                $show_form = true;
                $message = "Post update failed!";
                echo $message . " " . "<a href='index.php'>Please click here to return to the homepage</a>";
            }
    
            //Close connection
            
            mysqli_close($connection);
        }
        else
        {
            echo $message;
        }  
    }

}

//If user is not logged in
else
{
    echo "You are not logged in!";
}

//Form to be shown
if($show_form)
{
    echo <<<_END
    <div class="edit_post">
        <br><h1><b><i>Edit your post</i></b></h1>
        <form method="POST" action="#">
            <label for="title" id="title">Title: </label><br/>
            <input name="title" type="text"><br/>
            <label for="content" id="content">Content: </label><br/>
            <input name="content" type="content"><br/>
            <button name="edit_this_post" value="$postId" type="submit">Submit</button>
        </form>
    </div>
    _END;    
}
?>