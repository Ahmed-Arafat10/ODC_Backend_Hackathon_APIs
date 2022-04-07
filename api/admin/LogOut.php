<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';

$data = json_decode(file_get_contents("php://input"));
$AdminID = $data->AdminID;
$ConnectToDatabase = ConnectToDataBase();

// I Have To Change `is_Expired` Column To True, So This OTP Become Expired And Cannot Me Used Again

$SelectStatement = "SELECT * FROM `signedin_admin` WHERE `admin_id` = ? ";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param("i", $AdminID);
$CheckError = $Query->execute();
$Result = $Query->get_result();
$num = $Result->num_rows;
if (!$num) {
    echo json_encode(array(
        "message" => "This ID Is Not Valid"
    ));
    exit;
}
$DeleteStatement = "DELETE FROM `signedin_admin` WHERE `admin_id` = ? ";
$Query = $ConnectToDatabase->prepare($DeleteStatement);
$Query->bind_param("i", $AdminID);
$CheckError = $Query->execute();
// Close Connection After Executing Query
if ($CheckError)  echo json_encode(array(
    "message" => "Logged Out Successfully"
));
else echo json_encode(array(
    "message" => "Something Went Wrong Please Try Again"
));
 



   /*
{
    "AdminID":1
}

   */