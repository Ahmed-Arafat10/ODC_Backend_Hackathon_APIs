<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';

$data = json_decode(file_get_contents("php://input"));
// get id of admin
$AdminID = $data->AdminID;
$ConnectToDatabase = ConnectToDataBase();

$SelectStatement = "SELECT * FROM `signedin_admin` WHERE `admin_id` = ? ";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param("i", $AdminID);
$CheckError = $Query->execute();
$Result = $Query->get_result();
$num = $Result->num_rows;
// if id of admin is not in `signedin_admin` table, this means that he is logged out
if (!$num) {
    echo json_encode(array("message" => "Admin Already Logged Out"));
    exit;
}
// else delete user token [logged in]
$DeleteStatement = "DELETE FROM `signedin_admin` WHERE `admin_id` = ? ";
$Query = $ConnectToDatabase->prepare($DeleteStatement);
$Query->bind_param("i", $AdminID);
$CheckError = $Query->execute();
// Close Connection After Executing Query
$Query->close();
$ConnectToDatabase->close();
if ($CheckError)  echo json_encode(array("message" => "Logged Out Successfully"));
else echo json_encode(array("message" => "Something Went Wrong Please Try Again"));



/*

{
    "AdminID":1
}

*/