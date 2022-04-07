<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';
// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//StudentName Email Phone  Address College

$Email = $data->Email;
$ConnectToDatabase = ConnectToDataBase();
$InsertStatement  = "SELECT * FROM `students` WHERE Email = ? ";
$Query = $ConnectToDatabase->prepare($InsertStatement);
$Query->bind_param('s', $Email);
$CheckError = $Query->execute();
$Result = $Query->get_result();
$num = $Result->num_rows;
if ($num) {
    $Fetch = $Result->fetch_assoc();
    $DBToken = $Fetch['Token'];
    $Username = $Fetch['student_name'];
    SendEmailToResetPassword($Username,$Email,$DBToken);
        echo json_encode(array(
            "message" => "An Email Is Sent To You With A Token"
        ));
} else
    echo json_encode(array(
        "message" => "Email Does Not Exist"
    ));

/*
I/P:
{
    "Email":"ahmedmoyousry.bis@gmail.com"
}

*/