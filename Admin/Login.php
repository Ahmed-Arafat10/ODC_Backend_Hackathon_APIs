<?php

include("../DatabaseConfig/ConfigDB.php");


if (isset($_POST['AdminBtn'])) {


    $AdminUsername = $_POST['AdminUserName'];
    $Password = $_POST['Password'];

    $ConnectToDatabase = ConnectToDataBase();
    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? LIMIT 1";
    //    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
    $Query = $ConnectToDatabase->prepare($SelectStatement);
    $Query->bind_param('s', $AdminUsername);
    $Query->execute();
    $Result = $Query->get_result();
    $NumOfRows = $Result->num_rows;
    // Close Connection After Executing Query
    $Query->close();
    $ConnectToDatabase->close();
    // If Enterd Username/Email Exists In Database
    if ($NumOfRows) {
        $Fetch = $Result->fetch_assoc();
        $HashedPasswordFromDatabae = $Fetch['password'];
        // Store Some Data Of User [I Will Use Them Later]
        // $UserID = $Fetch['User_ID'];
        // $UserName = $Fetch['UserName'];
        // $EmailOfUser = $Fetch['Email'];
        // $IsEmailVerfied = $Fetch['Is_Verified'];
        // Check Entered Password With Hashed Password In Database
        if (password_verify($Password, $HashedPasswordFromDatabae)) {
            header("Location:ViewPage.php");
            $_SESSION['IsAuthorized'] = $Fetch['authority'];
            exit;
        } else {
            PrintMessage("Password Is Wrong", "Danger");
        }
    } else    PrintMessage("Admin Not Exist", "Danger");
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
        <input type="submit" name="AdminBtn" value="SignIn">
    </form>


</body>

</html>