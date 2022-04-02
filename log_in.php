<?php

//Include header
require_once "header.php";
require_once "helper.php";

//Define variables
$show_form = false;
$message = "";

$username = "";
$password = "";

//Error messages
$username_error = "";
$password_error = "";
$overall_error = "";

//If the user is already logged in
if (isset($_SESSION['loggedIn']))
{
    echo "You are already logged in!<br>";
}

//If the user tries to log in
elseif (isset($_POST['username']))
{
    //Store input in relevant variables
    $username = $_POST['username'];
    $password = $_POST['password'];

    //Connect to the database
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    //If connection fails, produce error
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    //Sanitise input
    $username = sanitise($username, $connection);
    $password = sanitise($password, $connection);

    $username_error = validateString($username, 1, 32);
    $password_error = validateString($password, 1, 64);

    $overall_error = $username_error . $password_error;

    //If there are no errors..
    if ($overall_error == "")
    {
        //Define query, result and number of rows
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($connection, $query);

        $n = mysqli_num_rows($result);

        //If there is a result..
        if ($n > 0) {

            //Set session variables
            $_SESSION['loggedIn'] = true;
            $_SESSION['username'] = $username;

            $message = "Logged in successfully! ";
            echo $message . " " . "<a href='index.php'>Please click here to go to the homepage</a>";
        }
        else
        {
            $show_form = true;
            $message = "Invalid username and/or password!<br>";
            echo $message;
        }

        //Close connection
        mysqli_close($connection);

    }
    //No result
    else
    {
        $show_form = true;
        echo "No data";
    }

}
else
{
    $show_form = true;
}

//Show the log in form
if ($show_form)
{
    echo <<<_END
    <span class="lol">
    <form class="log_in_form" action="log_in.php" method="post">
        <h3><b><i>Log In</i></b></h3>
        Username: <input type="text" minlength="1" maxlength="16" name="username" value="$username" required>
        <br>
        Password: <input type="password" minlength="1" maxlength="16" name="password" value="$password" required>
        <br><br>
        <input type="submit" value="Log In">
    </form>
    </span>
    _END;
}

require_once "footer.php";

?>