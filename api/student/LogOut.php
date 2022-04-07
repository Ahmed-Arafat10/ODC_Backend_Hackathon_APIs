<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';

$data = json_decode(file_get_contents("php://input"));
$UserID = $data->ID;
$ConnectToDatabase = ConnectToDataBase();

// I Have To Change `is_Expired` Column To True, So This OTP Become Expired And Cannot Me Used Again
$UpdateStatement = "DELETE FROM  `signedin` WHERE `user_id` = ? ";
$Query = $ConnectToDatabase->prepare($UpdateStatement);
$Query->bind_param("i", $UserID);
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
    "ID":4
}

   */