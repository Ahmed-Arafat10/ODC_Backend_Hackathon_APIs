<?php
include("../NavBar.php");
session_start();

// Function To Connect To Database Everytime Before Executing A Query
$ConnectToDataBase = NULL;
function ConnectToDataBase()
{
    $DatabaseHost = "localhost";
    $DatabaseUserName = "root";
    $DatabasePassword = "";
    $DatabaseName = "odc";
    $ConnectToDataBase = new mysqli($DatabaseHost, $DatabaseUserName, $DatabasePassword, $DatabaseName);
    $ConnectError = $ConnectToDataBase->connect_error;
    if ($ConnectError) {
        die("Connection Failed: " . $ConnectError);
    } else {
     //echo "Done Connecting To Database";
    }
    return $ConnectToDataBase;
}


function PrintMessage($text, $Type)
{
    if ($Type == "Danger") echo "<div style='text-align:center;margin-bottom:0;' class = 'alert alert-danger' role = 'alert' >" . $text . "</div>";
    else echo "<div style='text-align:center;margin-bottom:0;' class = 'alert alert-primary' role = 'alert' >" . $text . "</div>";
}

?>