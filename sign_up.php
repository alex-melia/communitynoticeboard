<?php

require_once "header.php";

//Define variables
$show_form = false;

$usernameInput = "";
$passwordInput = "";
$firstnameInput = "";
$lastnameInput = "";
$emailInput = "";
$ageInput = "";
$cityInput = "";
$countyInput = "";
$countryInput = "";
$phoneInput = "";

$username_errors="";
$password_errors="";
$firstname_errors="";
$lastname_errors="";
$email_errors="";
$age_errors="";
$city_errors="";
$county_errors="";
$country_errors="";
$phone_errors="";

$errors = "";
$message = "";

//If the user is already logged in..
if (isset($_SESSION['loggedIn']))
{
    echo "You are already logged in!<br>";
}

//If the user tries to sign up..
elseif (isset($_POST['username']))
{
    //Store input in relevant variables
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $city = $_POST['city'];
    $county = $_POST['county'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];

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
    $firstname = sanitise($firstname, $connection);
    $lastname = sanitise($lastname, $connection);
    $email = sanitise($email, $connection);
    $age = sanitise($age, $connection);
    $city = sanitise($city, $connection);
    $county = sanitise($county, $connection);
    $country = sanitise($country, $connection);
    $phone = sanitise($phone, $connection);

    $username_errors = validateString($username, 1, 32);
    $password_errors = validateString($password, 1, 64);
    $firstname_errors = validateString($firstname, 1, 64);
    $lastname_errors = validateString($lastname, 1, 64);
    $email_errors = validateString($email, 1, 128);
    $age_errors = validateInt($age, 1, 999);
    $city_errors = validateString($city, 1, 32);
    $county_errors = validateString($county, 1, 40);
    $country_errors = validateString($country, 1, 60);
    $phone_errors = validateString($phone, 1, 24);

    //Define errors
    $errors = $username_errors . $password_errors . $firstname_errors . $lastname_errors . $email_errors . $age_errors . $city_errors . $county_errors . $country_errors . $phone_errors;

    //If there are no errors..
    if($errors == "") {

        //Define query and result
        $query = "INSERT INTO users (username, password, firstname, lastname, email, age, city, county, country, phone) VALUES ('$username', '$password', '$firstname', '$lastname', '$email', '$age', '$city', '$county', '$country', '$phone');";
        $result = mysqli_query($connection, $query);

        if(!$result)
        {
            echo "Nope";
        }
        //If there is result
        else if ($result)
        {
            $message = "Sign up successful!";
            echo $message . " " . "<a href='log_in.php'>Please click here to log in</a>";
            
        }
        //No result
        else
        {
            $message = "Sign up was unsuccessful!";
            echo $message;
        }

        //Close connection
        mysqli_close($connection);

    }
    //If there are errors
    else
    {
        $message = "Sign up was unsuccessful!";
        echo $message;
    }

}

else
{
    $show_form = true;
}

//Form to be shown
if ($show_form)
{
    echo <<<_END
    <div class="sign_up_form">
    <h3><b><i>Sign Up</i></b></h3>
    <br>
    <form action="sign_up.php" method="post">
        Username: <input type="text" minlength="1" maxlength="32" name="username" value="$usernameInput" required> <b><i>$username_errors</b></i>
        <br>
        Password: <input type="password" minlength="1" maxlength="64" name="password" value="$passwordInput" required> <b><i>$password_errors</b></i>
        <br>
        First Name: <input type="text" minlength="1" maxlength="64" name="firstname" value="$firstnameInput" required> <b><i>$firstname_errors</b></i>
        <br>
        Last Name: <input type="text" minlength="1" maxlength="64" name="lastname" value="$lastnameInput" required> <b><i>$lastname_errors</b></i>
        <br>
        Email: <input type="text" minlength="1" maxlength="128" name="email" value="$emailInput" required> <b><i>$email_errors</b></i>
        <br>
        Age: <input type="text" minlength="1" maxlength="3" name="age" value="$ageInput" required> <b><i>$age_errors</b></i>
        <br>
        City: <input type="text" minlength="1" maxlength="32"name="city" value="$cityInput" required> <b><i>$city_errors</b></i>
        <br>
        County: <input type="text" minlength="1" maxlength="40" name="county" value="$countyInput" required> <b><i>$county_errors</b></i>
        <br>
        Country: <input type="text" minlength="1" maxlength="60" name="country" value="$countryInput" required> <b><i>$country_errors</b></i>
        <br>
        Phone: <input type="text" minlength="1" maxlength="24" name="phone" value="$phoneInput" required> <b><i>$phone_errors</b></i>
        <br><br>
        <input type="submit" value="Sign Up">
    </form>
    </div>
    _END;
}

require_once "footer.php";



?>