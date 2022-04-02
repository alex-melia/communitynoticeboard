<?php

require_once "header.php";

//Define message
$message = "";

//If user is an admin..
if ($_SESSION['username'] == "admin")
{
    //Connection string
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    //If connection fails, produce error
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    //Define query, result and number of rows
    $query = "SELECT uid, username, firstname, lastname FROM users";
    $result = mysqli_query($connection, $query);

    $n = mysqli_num_rows($result);

    //If there is a result..
    if ($n > 0) {

        echo "<table border='2' cellspacing='2' cellpadding='2' width='50%'>";

        //Loop through results
        for($i=0; $i<$n; $i++)
        {
            //Define row
            $row = mysqli_fetch_assoc($result);

            echo "<tr>";
                echo "<th>ID</th><th>Username</th><th>First Name</th><th>Last Name</th>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>{$row['uid']}</td><td>{$row['username']}</td><td>{$row['firstname']}</td><td>{$row['lastname']}</td>";
                echo "<td><form method='POST' action='edit_user.php'><button type='submit' name='edit_this_user' value=".$row['uid'].">Edit</button></form></td>";
                echo "<td><form method='POST' action='delete_user.php'><button type='submit' name='delete_this_user' value=".$row['uid'].">Delete</button></form></td>";
            echo "</tr>";
        }

        echo "</table>";
    }

    else
    {
        $message = "Could not process data!<br>";
        echo $message . " " . "<a href='index.php'>Please click here to return to go to the homepage</a>";
    }

}
//If user is not an admin..
else
{
    $message = "You must be an admin to view this page!<br>";
    echo $message . " " . "<a href='index.php'>Please click here to return to go to the homepage</a>";
}

require_once "footer.php";
?>