<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';



// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
$ConnectToDatabase = ConnectToDataBase();
//StudentName Email Phone  Address College
$StudentName = $data->StudentName;
$Email = $data->Email;
$Password = $data->Password;
if (CheckEmail($Email, $ConnectToDatabase)) {
    echo json_encode(array(
        "message" => "E-mail Already Exits"
    ));
    exit;
}
// if (!PasswordStrength($Password)) {
//     echo json_encode(array(
//         "message" => "*Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character."
//     ));
//     exit;
// }

$HashedPassword = password_hash($Password, PASSWORD_DEFAULT);
$Phone = $data->Phone;
$Address = $data->Address;
$College = $data->College;
$Token = md5(rand() + rand() + 11);
$InsertStatement  = "INSERT INTO `students` VALUES(NULL,?,?,?,?,?,?,DEFAULT,?,0)";
$Query = $ConnectToDatabase->prepare($InsertStatement);
$Query->bind_param('sssssss', $StudentName, $Email, $HashedPassword, $Phone, $Address, $College, $Token);
$CheckError = $Query->execute();
if ($CheckError) {
    SendEmailToVerifyAcc($StudentName, $Email, $Token);
    echo json_encode(array(
        "message" => "Done Adding Student Data",
        "message1" => "Please Check Your Email To Verify Your New Account",
    ));
} else
    echo json_encode(array(
        "message" => "Failed To Add Student Data"
    ));

/*
I/P:
{
    "StudentName":"Ahmed Arafat",
    "Email":"ahmedmoyousry.bis@gmail.com",
    "Password":"123",
    "Phone":"01013769331",
    "Address":"Cairo",
    "College":"BIS"
}

*/