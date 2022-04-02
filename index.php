<?php

require_once "header.php";

//Form variables set to default values
$show_form = false;
$show_post_form = false;
$show_sort_form = false;

$descending = "";
$ascending = "";

$show_posts_descending = false;
$show_posts_ascending = false;
$show_posts_normal = false;

$admin_show_posts_descending = false;
$admin_show_posts_ascending = false;
$admin_show_posts_normal = false;

//Connection string
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

//If user is logged in
if (isset($_SESSION['loggedIn']))
{
    //If user is not admin
    if($_SESSION['username'] != "admin")
    {
        echo "<br><h1><b><i>Welcome, {$_SESSION['username']}</i></b></h1><br>";

        //Change form variables to required state
        $show_post_form = true;
        $show_sort_form = true;
        $show_posts_normal = true;

        //If the user opts to show the posts in descending order
        if(isset($_POST['descend']))
        {
            //Only descending order form variable is true, the rest false
            $show_posts_descending = true;
            $show_posts_ascending = false;
            $show_posts_normal = false;
        }
        //If the user opts to show the posts in ascending order
        else if(isset($_POST['ascend']))
        {
            //Only ascending order form variable is true, the rest false
            $show_posts_ascending = true;
            $show_posts_descending = false;
            $show_posts_normal = false;
        }
        //If the user has not selected any order
        else
        {
            //Only normal order form variable is true, the rest false
            $show_posts_normal = true;
            $show_posts_ascending = false;
            $show_posts_descending = false;
        }
    }
    //If user is an admin
    else
    {
        echo "<br><h1><b><i>Welcome, {$_SESSION['username']}</i></b></h1><br>";

        //Form variables set to default values
        $show_post_form = true;
        $show_sort_form = true;
        $admin_show_posts_normal = true;

        //If the user opts to show the posts in descending order
        if(isset($_POST['descend']))
        {
            //Only descending order form variable is true, the rest false
            $admin_show_posts_descending = true;
            $admin_show_posts_ascending = false;
            $admin_show_posts_normal = false;
        }
        //If the user opts to show the posts in ascending order
        else if(isset($_POST['ascend']))
        {
            //Only ascending order form variable is true, the rest false
            $admin_show_posts_ascending = true;
            $admin_show_posts_descending = false;
            $admin_show_posts_normal = false;
        }
        //If the user opts to show the posts in normal order
        else
        {
            //Only normal order form variable is true, the rest false
            $admin_show_posts_normal = true;
            $admin_show_posts_ascending = false;
            $admin_show_posts_descending = false;
        }
    }

}
//If user is not logged in
else
{
    echo "<br><h1><b><i>Welcome, unregistered user!</i></b></h1><br>";

    $show_post_form = true;
    $show_sort_form = true;
    $show_posts_normal = true;

    //If the user opts to show the posts in descending order
    if(isset($_POST['descend']))
    {
        //Only descending order form variable is true, the rest false
        $show_posts_descending = true;
        $show_posts_ascending = false;
        $show_posts_normal = false;
    }
    //If the user opts to show the posts in ascending order
    else if(isset($_POST['ascend']))
    {
        //Only ascending order form variable is true, the rest false
        $show_posts_ascending = true;
        $show_posts_descending = false;
        $show_posts_normal = false;
    }
    //If the user opts to show the posts in normal order
    else
    {
        //Only normal order form variable is true, the rest false
        $show_posts_normal = true;
        $show_posts_ascending = false;
        $show_posts_descending = false;
    }
}

//If sort form variable is true, show the following...
if($show_sort_form)
{
    //Contains the inputs to be posted which determines the order of posts
    echo <<<_END
    <div class="user_posts">
        <h1 style="display: inline"><b>User Posts</b></h1>
        <div class="sort_form"> 
            <h3>Sort By: </h3>
            <form action="index.php" method="post">
                <input type="radio" name="normal">Default</button>
                <input type="radio" name="descend">Newest</button>
                <input type="radio" name="ascend">Oldest</button>
                <input type="submit" value="Submit">
            </form>
        </div>
        <br><br><br><br>
    _END;
}

//Form used to create posts
if($show_post_form)
{
    echo <<<_END
    <div class="new_post_form">
    <h3><b><i>Got something to say?</i></b></h3><br>
    <form method="post" action="create_post.php">
        <input type="submit" value="Create Post">
    </form>
    <br>
    _END;
}

//Shows posts in descending order
if($show_posts_descending)
{
    //Define query
    $posts_query = "SELECT title, created, content, image, firstname, lastname FROM posts LEFT OUTER JOIN users ON users.uid = posts.uid ORDER BY created DESC;";
    $posts_result = mysqli_query($connection, $posts_query);
    $n = mysqli_num_rows($posts_result);

    if ($n > 0)
    {
        for ($i = 0; $i < $n; $i++) {
            $row = mysqli_fetch_assoc($posts_result);

            echo "<div class='card'>";
                echo "<img class='card-img-top' src='".$row['image']."'>";
                echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>".$row['title']."</h5>";
                    echo "<p class='card-text'>".$row['content']."</p>";
                    if (isset($row['firstname']))
                    {
                        echo "<h5 class='card-title'>Posted by: ".$row['firstname']. ' ' . $row['lastname']."</h5>";
                        echo "<h6 class='card-title'>Posted on: ".$row['created']."</h6>";
                    }
                    else 
                    {
                        echo "<h5 class='card-title'>Posted by: Unregistered User</h5>";
                        echo "<h6 class='card-title'>Posted on: ".$row['created']."</h6>";
                    }
                echo "</div>";
            echo "</div>";
            echo "<br>";
        }
    }
}

//Show posts in ascending order
if($show_posts_ascending)
{
    //Define query
    $posts_query = "SELECT title, created, content, image, firstname, lastname FROM posts LEFT OUTER JOIN users ON users.uid = posts.uid ORDER BY created ASC;";
    $posts_result = mysqli_query($connection, $posts_query);
    $n = mysqli_num_rows($posts_result);

    if ($n > 0)
    {
        for ($i = 0; $i < $n; $i++) {
            $row = mysqli_fetch_assoc($posts_result);

            echo "<div class='card'>";
                echo "<img class='card-img-top' src='".$row['image']."'>";
                echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>".$row['title']."</h5>";
                    echo "<p class='card-text'>".$row['content']."</p>";
                    if (isset($row['firstname']))
                    {
                        echo "<h5 class='card-title'>Posted by: ".$row['firstname']. ' ' . $row['lastname']."</h5>";
                        echo "<h6 class='card-title'>Posted on: ".$row['created']."</h6>";
                    }
                    else {
                        echo "<h5 class='card-title'>Posted by: Unregistered User</h5>";
                        echo "<h6 class='card-title'>Posted on: ".$row['created']."</h6>";
                    }
                echo "</div>";
            echo "</div>";
            echo "<br>";
        }
    }
}

//Shows posts in default order
if($show_posts_normal)
{
    //Define query
    $posts_query = "SELECT title, created, content, image, firstname, lastname FROM posts LEFT OUTER JOIN users ON users.uid = posts.uid";
    $posts_result = mysqli_query($connection, $posts_query);
    $n = mysqli_num_rows($posts_result);

    if ($n > 0)
    {
        for ($i = 0; $i < $n; $i++) {
            $row = mysqli_fetch_assoc($posts_result);

            echo "<div class='card'>";
                echo "<img class='card-img-top' src='".$row['image']."'>";
                echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>".$row['title']."</h5>";
                    echo "<p class='card-text'>".$row['content']."</p>";
                    if (isset($row['firstname']))
                    {
                        echo "<h5 class='card-title'>Posted by: ".$row['firstname']. ' ' . $row['lastname']."</h5>";
                        echo "<h6 class='card-title'>Posted on: ".$row['created']."</h6>";
                    }
                    else {
                        echo "<h5 class='card-title'>Posted by: Unregistered User</h5>";
                        echo "<h6 class='card-title'>Posted on: ".$row['created']."</h6>";
                    }
                echo "</div>";
            echo "</div>";
            echo "<br>";
        }
    }
}

//If user is an admin, show posts in descending order
if($admin_show_posts_descending)
{
    $posts_query = "SELECT postid, title, created, content, image, firstname, lastname FROM posts LEFT OUTER JOIN users ON users.uid = posts.uid ORDER BY created DESC;";
    $posts_result = mysqli_query($connection, $posts_query);
    $n = mysqli_num_rows($posts_result);

    if ($n > 0)
    {
        for ($i = 0; $i < $n; $i++) {
            $row = mysqli_fetch_assoc($posts_result);

            echo "<div class='card'>";
                echo "<img class='card-img-top' src='".$row['image']."'>";
                echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>".$row['title']."</h5>";
                    echo "<p class='card-text'>".$row['content']."</p>";
                    if (isset($row['firstname']))
                    {
                        echo "<h5 class='card-title'>Posted by: ".$row['firstname']. ' ' . $row['lastname']."</h5>";
                        echo "<h6 class='card-title'>Posted on: ".$row['created']."</h6>";
                    }
                    else {
                        echo "<h5 class='card-title'>Posted by: Unregistered User</h5>";
                        echo "<h6 class='card-title'>Posted on: ".$row['created']."</h6>";
                    }
                echo "</div>";
                //Options to edit and delete user posts (exclusive to admin)
                echo "<div class='card-body'>";
                    echo "<form method='POST' action='edit_post.php'><button type='submit' name='edit_this_post' value=".$row['postid'].">Edit</button></form>";
                    echo "<form method='POST' action='delete_post.php'><button type='submit' name='delete_this_post' value=".$row['postid'].">Delete</button></form>";
                echo "</div>";
            echo "</div>";
            echo "<br>";
        }
    }
}

//If user is an admin, show posts in ascending order
if($admin_show_posts_ascending)
{
    $posts_query = "SELECT postid, title, created, content, image, firstname, lastname FROM posts LEFT OUTER JOIN users ON users.uid = posts.uid ORDER BY created ASC;";
    $posts_result = mysqli_query($connection, $posts_query);
    $n = mysqli_num_rows($posts_result);

    if ($n > 0)
    {
        for ($i = 0; $i < $n; $i++) {
            $row = mysqli_fetch_assoc($posts_result);

            echo "<div class='card'>";
                echo "<img class='card-img-top' src='".$row['image']."'>";
                echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>".$row['title']."</h5>";
                    echo "<p class='card-text'>".$row['content']."</p>";
                    if (isset($row['firstname']))
                    {
                        echo "<h5 class='card-title'>Posted by: ".$row['firstname']. ' ' . $row['lastname']."</h5>";
                        echo "<h6 class='card-title'>Posted on: ".$row['created']."</h6>";
                    }
                    else {
                        echo "<h5 class='card-title'>Posted by: Unregistered User</h5>";
                        echo "<h6 class='card-title'>Posted on: ".$row['created']."</h6>";
                    }
                echo "</div>";
                echo "<div class='card-body'>";
                //Options to edit and delete user posts (exclusive to admin)
                    echo "<form method='POST' action='edit_post.php'><button type='submit' name='edit_this_post' value=".$row['postid'].">Edit</button></form>";
                    echo "<form method='POST' action='delete_post.php'><button type='submit' name='delete_this_post' value=".$row['postid'].">Delete</button></form>";
                echo "</div>";
            echo "</div>";
            echo "<br>";
        }
    }
}

//If user is an admin, show posts in default order
if($admin_show_posts_normal)
{
    $posts_query = "SELECT postid, title, created, content, image, firstname, lastname FROM posts LEFT OUTER JOIN users ON users.uid = posts.uid";
    $posts_result = mysqli_query($connection, $posts_query);
    $n = mysqli_num_rows($posts_result);

    if ($n > 0)
    {
        for ($i = 0; $i < $n; $i++) {
            $row = mysqli_fetch_assoc($posts_result);

            echo "<div class='card'>";
                echo "<img class='card-img-top' src='".$row['image']."'>";
                echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>".$row['title']."</h5>";
                    echo "<p class='card-text'>".$row['content']."</p>";
                    if (isset($row['firstname']))
                    {
                        echo "<h5 class='card-title'>Posted by: ".$row['firstname']. ' ' . $row['lastname']."</h5>";
                        echo "<h6 class='card-title'>Posted on: ".$row['created']."</h6>";
                    }
                    else {
                        echo "<h5 class='card-title'>Posted by: Unregistered User</h5>";
                        echo "<h6 class='card-title'>Posted on: ".$row['created']."</h6>";
                    }
                echo "</div>";
                echo "<div class='card-body'>";
                //Options to edit and delete user posts (exclusive to admin)
                    echo "<form method='POST' action='edit_post.php'><button type='submit' name='edit_this_post' value=".$row['postid'].">Edit</button></form>";
                    echo "<form method='POST' action='delete_post.php'><button type='submit' name='delete_this_post' value=".$row['postid'].">Delete</button></form>";
                echo "</div>";
            echo "</div>";
            echo "<br>";
        }
    }
}

require_once "footer.php";

?>