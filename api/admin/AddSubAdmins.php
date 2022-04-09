<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
// store value with key `AdminID` in raw section in postman
$AdminID = $data->AdminID;

// if logged in admin is authorized to edit/add/update then he will be able to use page else functionality in page wont work
$IsAuthourized = CheckIfAdminIsAuthorized($AdminID);
if ($IsAuthourized == 1) {
    // data of subadmin want to be stored in db, comes from raw section in postman
    $AdminName = $data->AdminName;
    $Password = $data->Password;
    $ConnectToDatabase = ConnectToDataBase();
    $InsertStatement = "INSERT INTO `admin` VALUES (NULL,?,?,0)";
    $Query = $ConnectToDatabase->prepare($InsertStatement);
    // hash password
    $Hashed = password_hash($Password, PASSWORD_DEFAULT);
    $Query->bind_param('ss', $AdminName, $Hashed);
    $CheckError = $Query->execute();
    // Close Connection After Executing Query
    $Query->close();
    $ConnectToDatabase->close();
    // succeeded
    if ($CheckError)   echo json_encode(array("message" => "Subadmin Is Added"));
    else echo json_encode(array("message" => "Failed To Add Subadmin"));
} else echo json_encode(array("message" => "Admin Is Not Authorized [Sub-Admin]"));



/*

{
    "AdminID":1,
    "AdminName":"ging",
    "Password":"123"
}


*/
