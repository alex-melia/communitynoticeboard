<?php

//Database connectivity
require_once "credentials.php";
require_once "helper.php";

//Set the default timezone to local timezone
date_default_timezone_set('Europe/London');

//Start the session
session_start();

//Provide HTML for all pages
echo <<< _END
    <!DOCTYPE html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <meta name="viewport" content="width=device-width">
        <link id="stylesheet" rel="stylesheet" href="css/custom.css"/>
        <title>Community Noticeboard</title>
    </head>

    <script>
    $(document).ready(function(){

        updateTime();

        setInterval(updateTime, 1000);

        function updateTime(){
            var today = new Date();
            var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            var dateTime = date+' '+time;

            $("#dateTime").text(dateTime);
        }
    });
    </script>

    <script>
    $(document).ready(function(){
        function changeColour(theme){
            if(theme === "dark")
            {
                document.getElementById("background").style.backgroundColor = "black";
                document.getElementById("background").style.color = "white";
                document.getElementById("card-body").style.color = "white";
            }
            if (theme === "light")
            {
                document.getElementById("background").style.backgroundColor = rgb(252, 222, 177);
                document.getElementById("background").style.color = "black";
            }
        }
    });
    </script>

    <script>
    $(document).ready(function(){
        $("#dark").click(function(){
            $("#background-color").css("color", "black");
    });
    </script>

    <body id="background" class="background">
_END;

//If user is logged in and NOT an admin:
if ((isset($_SESSION['loggedIn'])) && ($_SESSION['username'] != "admin"))
{
    echo <<< _END
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <a class="navbar-brand">Community Noticeboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContext" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="font-size: 20px">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="user_posts.php">My Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="customiser.php">Customiser</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="log_out.php">Log Out ({$_SESSION['username']})</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <div id="dateTime"></div>
                </span>
            </div>
        </div>
    </nav>

_END;
}

//If user is logged in and IS an admin:
else if ((isset($_SESSION['loggedIn'])) && ($_SESSION['username'] == "admin"))
{
    echo <<< _END
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <a class="navbar-brand">Community Noticeboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContext" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="font-size: 20px">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="user_posts.php">My Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="manage_users.php">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="customiser.php">Customiser</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="log_out.php">Log Out ({$_SESSION['username']})</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <div id="dateTime"></div>
                </span>
            </div>
        </div>
    </nav>
_END;
}

//If the user IS NOT logged in, show the following options
else 
{
    echo <<< _END
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <a class="navbar-brand">Community Noticeboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContext" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="font-size: 20px">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="sign_up.php">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="log_in.php">Log In</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <div id="dateTime"></div>
                </span>
            </div>
        </div>
    </nav>
_END;
}

error_reporting(0);

//Dark Mode
echo <<< _END
    <div id="darkLight">
        <button id="dark">Dark</button>
        <button id="light">Light</button>
    </div>

    <script>
    $(document).ready(function(){
    $("#dark").click(function(){
        $("body").css("background-color", "black");
        $("body").css("color", "white");
    });
    $("#light").click(function(){
        $("body").css("background-color", "bisque");
        $("body").css("color", "black");
    });
});
</script>
_END;

?>