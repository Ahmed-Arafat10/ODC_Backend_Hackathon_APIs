<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';

$data = json_decode(file_get_contents("php://input"));
// get user id
$UserID = $data->UserID;
$ConnectToDatabase = ConnectToDataBase();

// check if user is logged in or not
$SelectStatement = "SELECT * FROM `signedin` WHERE `user_id` = ? ";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param("i", $AdminID);
$CheckError = $Query->execute();
$Result = $Query->get_result();
$num = $Result->num_rows;
if (!$num) {
echo json_encode(array("message" => "User Is Not Logged In"));
    exit;
}
// delete token [record] that means user is logged in
$UpdateStatement = "DELETE FROM  `signedin` WHERE `user_id` = ? ";
$Query = $ConnectToDatabase->prepare($UpdateStatement);
$Query->bind_param("i", $UserID);
$CheckError = $Query->execute();
// Close Connection After Executing Query
$Query->close();
$ConnectToDatabase->close();
if ($CheckError) echo json_encode(array("message" => "Logged Out Successfully"));
else echo json_encode(array("message" => "Something Went Wrong Please Try Again"));


/*

    {
        "UserID":6
    }

*/