<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';



// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
$ConnectToDatabase = ConnectToDataBase();
// get data of user
$StudentName = $data->StudentName;
$Email = $data->Email;
$Password = $data->Password;
// check if email exists or not
if (CheckEmail($Email, $ConnectToDatabase)) {
    echo json_encode(array("message" => "E-mail Already Exits"));
    exit;
}
// check if inpur is in email format [@ .com]
if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(array("message" => "Invalid Email Format"));
    exit;
}
//check of password is weak
if (!PasswordStrength($Password)) {
    echo json_encode(array("message" => "*Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character."));
    exit;
}
//hash password
$HashedPassword = password_hash($Password, PASSWORD_DEFAULT);
$Phone = $data->Phone;
$Address = $data->Address;
$College = $data->College;
// generate a random token
$Token = md5(rand() + rand() + 11);
// insert a new record
$InsertStatement  = "INSERT INTO `students` VALUES(NULL,?,?,?,?,?,?,DEFAULT,?,0)";
$Query = $ConnectToDatabase->prepare($InsertStatement);
$Query->bind_param('sssssss', $StudentName, $Email, $HashedPassword, $Phone, $Address, $College, $Token);
$CheckError = $Query->execute();
if ($CheckError) {
    // send an email that contains a token to verifiy newly created account
    SendEmailToVerifyAcc($StudentName, $Email, $Token);
    // print a message on JSON format
    echo json_encode(array(
        "message" => "Done Adding Student Data",
        "message1" => "Please Check Your Email To Verify Your New Account",
    ));
} else echo json_encode(array("message" => "Failed To Add Student Data"));

/*
I/P:
{
    "StudentName":"Ahmed Arafat",
    "Email":"ahmed222s@gmail.com",
    "Password":"ASADASDMmddd333$$",
    "Phone":"015488410",
    "Address":"Cairo",
    "College":"BIS"
}

*/