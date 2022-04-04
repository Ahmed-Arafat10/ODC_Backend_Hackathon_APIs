<?php

include("../DatabaseConfig/ConfigDB.php");

if (isset($_SESSION['IsAuthorized'])) {

    if (!$_SESSION['IsAuthorized']) {
        PrintMessage("Not Authoerized", "Danger");
        exit;
    }
} else {
    PrintMessage("Not Authoerized", "Danger");
    exit;
}



if (isset($_POST['AddAdminBtn'])) {
    $AdminUsername = $_POST['AdminUserName'];
    $Password = $_POST['Password'];
    $Hashed = password_hash($Password,PASSWORD_DEFAULT);
    $ConnectToDatabase = ConnectToDataBase();
    $InsertStatement = "INSERT INTO `admin` VALUES (NULL,?,?,0)";
    //    $InsertStatement = "Insert * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
    $Query = $ConnectToDatabase->prepare($InsertStatement);
    $Query->bind_param('ss', $AdminUsername,$Hashed);
    $CheckError = $Query->execute();
    if($CheckError) PrintMessage("Done","Normal");
    else PrintMessage("Error","Danger");
    // Close Connection After Executing Query
    $Query->close();
    $ConnectToDatabase->close();
    // If Enterd Username/Email Exists In Database

}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

<form action="" method="post">

<label for="">Admin Username</label>
<input required type="text" name="AdminUserName" id="">
<br>

<label for="">Password</label>
<input required type="password" name="Password" id="">
<br>
<input type="submit" name="AddAdminBtn" value="SignIn">
</form>


</body>

</html>