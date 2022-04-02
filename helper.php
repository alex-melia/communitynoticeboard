<?php

require_once "credentials.php";

//Function to sanitise data
function sanitise($str, $connection)
{    
    $str = mysqli_real_escape_string($connection, $str);
    $str = htmlentities($str);

    return $str;
}

//Function to validate string
function validateString($field, $minlength, $maxlength)
{
    //If input is less than minimum length, produce error message
    if (strlen($field)<$minlength)
    {
        return "Minimum length: " . $minlength;
    }
    //If input is more than maximum length, produce error message
    elseif (strlen($field)>$maxlength)
    {
        return "Maximum length: " . $maxlength;
    }
    //If input is valid, produce empty string
    return "";
}

//Function to validate integer
function validateInt($field, $min, $max)
{
    //Create associative array of min and max range
    $options = array("options" => array("min_range"=>$min,"max_range"=>$max));

    if (!filter_var($field, FILTER_VALIDATE_INT, $options))
    {
        //If input is not valid, produce error message
        return "Not a valid number (must be whole and in the range: " . $min . " to " . $max . ")";
    }
    //If input is valid, produce empty string
    return "";
}

?>