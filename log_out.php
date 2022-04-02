<?php

require_once "header.php";

//If user is logged in..
if(isset($_SESSION['loggedIn']))
{
    //Destroy session
    $_SESSION = array();
    setcookie(session_name(), "", time() - 20592000, '/');
    session_destroy();

    echo "You have successfully logged out!";
}
else
{
    echo "You are not logged in!<br>";
}

require_once "footer.php";

?>