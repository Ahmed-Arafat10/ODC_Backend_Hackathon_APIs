<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';

$data = json_decode(file_get_contents("php://input"));
$OTP = $data->OTP;
$UserID = $data->ID;
$ConnectToDatabase = ConnectToDataBase();
// Insert New Generated Otp To `otp` Table With `Is_Expired` Column is FAlSE + Time At Which It Is Created At [Default SQL timestamp()]
$SelectStatement = "SELECT * FROM `otp` WHERE `otp` = ? AND `student_id` = ? AND `is_expired` = 0 AND NOW() <= DATE_ADD(created_at, INTERVAL 5 MINUTE) ";
$Query = $ConnectToDatabase->prepare($SelectStatement);
//$Date = "date('Y-m-d H:i:s')"; #Debug
$Query->bind_param("ii", $OTP,$UserID);
$CheckError = $Query->execute();
$Result = $Query->get_result();
$NumOfRows = $Result->num_rows;
echo json_encode($NumOfRows);
if ($NumOfRows) {
    // I Have To Change `is_Expired` Column To True, So This OTP Become Expired And Cannot Me Used Again
    $UpdateStatement = "UPDATE `otp` SET is_expired = 1  WHERE OTP = ? AND 'student_id' = ? ";
    $Query = $ConnectToDatabase->prepare($UpdateStatement);
    $Query->bind_param("ii", $OTP,$UserID);
    $CheckError = $Query->execute();
    // Close Connection After Executing Query
    $Query->close();
    $ConnectToDatabase->close();
    if ($CheckError) {
        echo json_encode(array(
            "message" => "Welcome Back",
            "UserID" => $UserID,
            "IsSignedIn" => 1
        ));
    } else {
        echo json_encode(array(
            "message" => "Something Went Wrong Please Try Again"
        ));
    }
} else {
    // If An OTP Exists In Database But It Is Expired Or It Does Not Exist At All
    $SelectStatement = "SELECT * FROM `otp` WHERE `otp` = ? ";
    $Query = $ConnectToDatabase->prepare($SelectStatement);
    $Query->bind_param("i", $OTP);
    $Query->execute();
    $Result = $Query->get_result();
    $NumOfRows = $Result->num_rows;
    // Close Connection After Executing Query
    $Query->close();
    $ConnectToDatabase->close();
    if ($NumOfRows) echo json_encode(array(
        "message" => "OTP Is Expired, Please Sign In Again"
    ));
    else echo json_encode(array(
        "message" => "OTP Is Wrong"
    ));
}



   /*
{
    "ID":4,
    "OTP":"730282"
}

   */