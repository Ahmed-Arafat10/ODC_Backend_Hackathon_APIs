<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';
// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//StudentName Email Phone  Address College
// get emaila and token sent to user
$Email = $data->Email;
$Token = $data->Token;
$ConnectToDatabase = ConnectToDataBase();
//check if email exists in db
$InsertStatement  = "SELECT * FROM `students` WHERE Email = ? ";
$Query = $ConnectToDatabase->prepare($InsertStatement);
$Query->bind_param('s', $Email);
$CheckError = $Query->execute();
$Result = $Query->get_result();
$num = $Result->num_rows;
// if exists
if ($num) {
    $Fetch = $Result->fetch_assoc();
    // get token from db
    $DBToken = $Fetch['Token'];
    // check if token entered by user is same as token stored in db
    if ($Token == $DBToken) {
        // generate a new token
        $NewToken = md5(rand() + rand() + 11);
        // update record to onlcude new token so old one if used again wont work
        // change `is_verified` column to 1
        $InsertStatement  = "UPDATE `students` SET `Token` = ? , `is_verified` = 1 WHERE Email = ? ";
        $Query = $ConnectToDatabase->prepare($InsertStatement);
        $Query->bind_param('ss', $NewToken, $Email);
        $CheckError = $Query->execute();
        echo json_encode(array("message" => "Your Email Is Activated Successfully"));
    } 
    else echo json_encode(array("message" => "Token Is Not Valid"));
    
} else echo json_encode(array("message" => "Email Does Not Exist"));

/*
I/P:
{
    "Email":"ahmedmoyousry.bis@gmail.com",
    "Token":"27e6e782d5d2b592f7756106dc8b9ceb"
}

*/