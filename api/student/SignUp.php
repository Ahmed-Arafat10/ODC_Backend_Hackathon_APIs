<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//StudentName Email Phone  Address College
$StudentName = $data->StudentName;
$Email = $data->Email;
$Password = $data->Password;
$HashedPassword = password_hash($Password, PASSWORD_DEFAULT);
$Phone = $data->Phone;
$Address = $data->Address;
$College = $data->College;
$ConnectToDatabase = ConnectToDataBase();
$InsertStatement  = "INSERT INTO `students` VALUES(NULL,?,?,?,?,?,?,DEFAULT)";
$Query = $ConnectToDatabase->prepare($InsertStatement);
$Query->bind_param('ssssss', $StudentName, $Email, $HashedPassword, $Phone, $Address, $College);
$CheckError = $Query->execute();
if ($CheckError)
    echo json_encode(array(
        "message" => "Done Adding Student Data"
    ));
else
    echo json_encode(array(
        "message" => "Failed To Add Student Data"
    ));

/*
I/P:
{
    "StudentName":"hisoka",
    "Email":"ahmedmoyousry.bis@gmail.com",
    "Password":"123",
    "Phone":"01013769331",
    "Address":"Hello Course",
    "College":"BIS"
}

*/