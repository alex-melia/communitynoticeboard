<?php

require_once "header.php";

//Set form variable to false initially
$show_form = false;

//Set variables
$firstnameInput = "";
$lastnameInput = "";
$emailInput = "";
$ageInput = "";
$cityInput = "";
$countyInput = "";
$countryInput = "";
$phoneInput = "";

//Set errors
$firstname_errors="";
$lastname_errors="";
$email_errors="";
$age_errors="";
$city_errors="";
$county_errors="";
$country_errors="";
$phone_errors="";
$errors = "";

//Set message
$message = "";

//Set userId variable
$userId = $_POST['edit_this_user'];

//If user is logged in..
if(isset($_SESSION['loggedIn']))
{
    //If user is an admin..
    if($_SESSION['username'] == "admin")
    {
        //If userId has been set, show form
        if(isset($userId))
        {
            $show_form = true;
        }
        else
        {
            $message = "No data was received!";
            echo $message . " " . "<a href='manage_users.php'>Please click here to return to the previous page</a>";
        }

        //If user attempts to post valid input..
        if(isset($_POST['firstname']))
        {
            //Set variables to be input
            $newFirstname = $_POST['firstname'];
            $newLastname = $_POST['lastname'];
            $newEmail = $_POST['email'];
            $newAge = $_POST['age'];
            $newCity = $_POST['city'];
            $newCounty = $_POST['county'];
            $newCountry = $_POST['country'];
            $newPhone = $_POST['phone'];

            //Connection string
            $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
            //If connection fails, produce error
            if (!$connection)
            {
                die("Connection failed: " . $mysqli_connect_error);
            }

            //Sanitise input
            $newFirstname = sanitise($newFirstname, $connection);
            $newLastname = sanitise($newLastname, $connection);
            $newEmail = sanitise($newEmail, $connection);
            $newAge = sanitise($newAge, $connection);
            $newCity = sanitise($newCity, $connection);
            $newCounty = sanitise($newCounty, $connection);
            $newCountry = sanitise($newCountry, $connection);
            $newPhone = sanitise($newPhone, $connection);
        
            $firstname_errors = validateString($newFirstname, 1, 64);
            $lastname_errors = validateString($newLastname, 1, 64);
            $email_errors = validateString($newEmail, 1, 128);
            $age_errors = validateInt($newAge, 1, 999);
            $city_errors = validateString($newCity, 1, 32);
            $county_errors = validateString($newCounty, 1, 40);
            $country_errors = validateString($newCountry, 1, 60);
            $phone_errors = validateString($newPhone, 1, 24);
        
            //Set error variable
            $errors = $firstname_errors . $lastname_errors . $email_errors . $age_errors . $city_errors . $county_errors . $country_errors . $phone_errors;

            //If there are no errors..
            if($errors == "")
            {
                //Define query and result
                $query = "UPDATE users SET firstname = '$newFirstname', lastname = '$newLastname', email = '$newEmail', age = '$newAge', city = '$newCity', county = '$newCounty', country = '$newCountry', phone = '$newPhone' WHERE uid = $userId";
                $result = mysqli_query($connection,$query);

                //If there is a result..
                if ($result)
                {
                    $show_form = false;
                    $message = "User updated successfully!";
                    echo $message . " " . "<a href='manage_users.php'>Please click here to return to the previous page</a>";
                }
                else
                {   
                    $message = "User update was unsuccessful!";
                    echo $message . " " . "<a href='manage_users.php'>Please click here to return to the previous page</a>";
                }
    
                //Close the connection
                mysqli_close($connection);
            }
        }
        else
        {
            $show_form = true;
        }

    }
    //If user is logged in but not an admin..
    else
    {
        $message = "You must be an admin to view this page";
        echo $message . " " . "<a href='index.php'>Please click here to return to go to the homepage</a>";
    }

}
//If user is not logged in..
else
{
    $message = "You must be an admin to view this page";
    echo $message . " " . "<a href='index.php'>Please click here to return to go to the homepage</a>";
}

//Form to be shown
if($show_form)
{
    echo <<<_END
    <div class="customiser_form">
    <form method="POST" action="edit_user.php">
    <label for="firstname" id="firstname">First Name: </label><br/>
        <input name="firstname" type="text" value="$firstnameInput"><br/>
    <label for="lastname" id="lastname">Last Name: </label><br/>
        <input name="lastname" type="text" value="$lastnameInput"><br/>
    <label for="email" id="email">Email: </label><br/>
        <input name="email" type="text" value="$emailInput"><br/>
    <label for="age" id="age">Age: </label><br/>
        <input name="age" type="number" value="$ageInput"><br/>
    <label for="city" id="city">City: </label><br/>
        <input name="city" type="text" value="$cityInput"><br/>
    <label for="county" id="county">County: </label><br/>
        <input name="county" type="text" value="$countyInput"><br/>
    <label for="country" id="country">Country: </label><br/>
        <input name="country" type="text" value="$countryInput"><br/>
    <label for="phone" id="phone">Phone: </label><br/>
        <input name="phone" type="number" value="$phoneInput"><br/>
    <button name="edit_this_user" value="$userId" type="submit">Submit</button>
    </form>
    </div>
    _END; 
}

?>