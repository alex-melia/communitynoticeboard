<?php

require_once "header.php";

//Set message variable
$message = "";

//If admin tries to delete..
if(isset($_POST['delete_this_user']))
{
    //Set userId variable
    $userId = $_POST['delete_this_user'];

    //Connection string
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    //If connection fails, produce error
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    //Define query and result
    $query = "DELETE FROM users WHERE uid = $userId";
    $result = mysqli_query($connection, $query);

    //If there is a result..
    if ($result)
    {
        $message = "User deleted successfully!";
        echo $message . " " . "<a href='manage_users.php'>Please click here to return to the previous page</a>";
    }
    //No result
    else
    {    
        $message = "User deletion failed!";
        echo $message . " " . "<a href='manage_users.php'>Please click here to return to the previous page</a>";
    }

    //Close connection
    mysqli_close($connection);
}
else
{
    $message = "User deletion failed!";
    echo $message . " " . "<a href='manage_users.php'>Please click here to return to the previous page</a>";
}

?>