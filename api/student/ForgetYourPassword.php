<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';
// Get raw posted data
$data = json_decode(file_get_contents("php://input"));


// get email of user
$Email = $data->Email;
$ConnectToDatabase = ConnectToDataBase();
// check if a record exists with that email or not
$InsertStatement  = "SELECT * FROM `students` WHERE Email = ? ";
$Query = $ConnectToDatabase->prepare($InsertStatement);
$Query->bind_param('s', $Email);
$CheckError = $Query->execute();
$Result = $Query->get_result();
$num = $Result->num_rows;
// if exists
if ($num) {
    $Fetch = $Result->fetch_assoc();
    // fetch token and username from record as they are going to be sent in email
    // in which user will use this token to be able to change his password
    $DBToken = $Fetch['Token'];
    $Username = $Fetch['student_name'];
    // send email to user that contains token
    SendEmailToResetPassword($Username,$Email,$DBToken);
        echo json_encode(array("message" => "An Email Is Sent To You With A Token"));
} else echo json_encode(array("message" => "Email Does Not Exist"  ));

/*
I/P:
{
    "Email":"ahmedmoyousry.bis@gmail.com"
}

*/