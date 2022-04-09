<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';

$data = json_decode(file_get_contents("php://input"));
// get OTP and it's associated user id
$OTP = $data->OTP;
$UserID = $data->ID;
$ConnectToDatabase = ConnectToDataBase();
// check if a recod contains entered otp with same user id and otp is not expired
$SelectStatement = "SELECT * FROM `otp` WHERE `otp` = ? AND `student_id` = ? AND `is_expired` = 0 AND NOW() <= DATE_ADD(created_at, INTERVAL 5 MINUTE) ";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param("ii", $OTP,$UserID);
$CheckError = $Query->execute();
$Result = $Query->get_result();
$NumOfRows = $Result->num_rows;
echo json_encode($NumOfRows);
// if exists
if ($NumOfRows) {
    // set `is_expired` column to 1 , so otp wont work again
    $UpdateStatement = "UPDATE `otp` SET `is_expired` = 1  WHERE OTP = ? AND 'student_id' = ? ";
    $Query = $ConnectToDatabase->prepare($UpdateStatement);
    $Query->bind_param("ii", $OTP,$UserID);
    $CheckError = $Query->execute();
    if ($CheckError) {
        // generate a Token that means that user now is logged in
        $Token = md5(rand() + rand() + 11);
        // insert in `signedin` table [when user id in this table exists, this means that user is currently logged in]
        $InsertStatement = "INSERT INTO `signedin` VALUES(?,?,DEFAULT)";
        $Query = $ConnectToDatabase->prepare($InsertStatement);
        $Query->bind_param("is", $UserID,$Token);
        $CheckError = $Query->execute();
        // Close Connection After Executing Query
        $Query->close();
        $ConnectToDatabase->close();
        // output in JSON format
        echo json_encode(array(
            "message" => "Welcome Back",
            "UserID" => $UserID,
            "Token" => $Token
        ));
    } else echo json_encode(array("message" => "Something Went Wrong Please Try Again"));
    
} else {
    // Check If An Otp Exists In Database But It Is Expired Or It Does Not Exist At All
    $SelectStatement = "SELECT * FROM `otp` WHERE `otp` = ? ";
    $Query = $ConnectToDatabase->prepare($SelectStatement);
    $Query->bind_param("i", $OTP);
    $Query->execute();
    $Result = $Query->get_result();
    $NumOfRows = $Result->num_rows;
    // Close Connection After Executing Query
    $Query->close();
    $ConnectToDatabase->close();
    // if exists in database, then it is expired
    if ($NumOfRows) echo json_encode(array("message" => "OTP Is Expired, Please Sign In Again"));
    // else otp is wrong
    else echo json_encode(array("message" => "OTP Is Wrong"));
}


/*
    {
        "ID":6,
        "OTP":"767145"
    }

*/