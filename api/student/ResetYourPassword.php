<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';
// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//StudentName Email Phone  Address College

// get data that will be used in this API
$Email = $data->Email;
$TokenForPass = $data->TokenForChangingPassword;
$NewPassword = $data->NewPassword;

$ConnectToDatabase = ConnectToDataBase();
// check if a record exists with that email or not
$SelectStatement  = "SELECT * FROM `students` WHERE Email = ? ";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param('s', $Email);
$CheckError = $Query->execute();
$Result = $Query->get_result();
$NumOfRows = $Result->num_rows;
// if exists
if ($NumOfRows) {
    $Fetch = $Result->fetch_assoc();
    // fetch token from db
    $DBToken = $Fetch['Token'];
    $Username = $Fetch['student_name'];
    // check if entered token is same as token fetched from db
    if ($TokenForPass == $DBToken) {
        // hash entered password
        $HashedPass = password_hash($NewPassword,PASSWORD_DEFAULT);
        // generate a new token that will replace old one stored in db, so it wont work again
        $NewToken = md5(rand() + rand() + 11);
        // update new password and new token for that record
        $UpdateStatement  = "UPDATE `students` SET `password` = ? , `Token` = ? WHERE Email = ? ";
        $Query = $ConnectToDatabase->prepare($UpdateStatement);
        $Query->bind_param('sss',$HashedPass, $NewToken, $Email);
        $CheckError = $Query->execute();
        // send an email to user to inform him that his password is changed
        InformUserThatPasswordIsChanged($Username,$Email);
        echo json_encode(array(
            "message" => "Your Password Has Been Changed Successfully"
        ));
    } 
    else echo json_encode(array("message" => "Token Is Not Valid"));
} else echo json_encode(array("message" => "Email Does Not Exist"  ));

/*

I/P:
{
    "Email":"ging@gmail.com",
    "TokenForChangingPassword":"XX",
    "NewPassword":"1234"
}

*/