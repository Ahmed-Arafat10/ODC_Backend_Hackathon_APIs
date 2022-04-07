<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';

$data = json_decode(file_get_contents("php://input"));
$Email = $data->Email;
$Password = $data->Password;
$ConnectToDatabase = ConnectToDataBase();
// Insert New Generated Otp To `otp` Table With `Is_Expired` Column is FAlSE + Time At Which It Is Created At [Default SQL timestamp()]
$SelectStatement = "SELECT * FROM `students` WHERE `email` = ? LIMIT 1";
$Query = $ConnectToDatabase->prepare($SelectStatement);
//$Date = "date('Y-m-d H:i:s')"; #Debug
$Query->bind_param("s", $Email);
$CheckError = $Query->execute();
$Result = $Query->get_result();
$NumOfRows = $Result->num_rows;
if ($NumOfRows) {
    $Fetch = $Result->fetch_assoc();
    $HashedPasswordFromDatabase = $Fetch['password'];
    $Username = $Fetch['student_name'];
    $UserID = $Fetch['id'];
    $is_verified = $Fetch['is_verified'];
 
    // echo json_encode($HashedPasswordFromDatabase);
    //$HashedPasswordFromDatabae = password_hash($Password, PASSWORD_DEFAULT);
    if (password_verify($Password, $HashedPasswordFromDatabase)) {
        if($is_verified  == 0)
        {
            echo json_encode(array(
                "message" => "Please Verify Your Account First, Check Your Email"
            ));
            exit;
        }
        // Generate A Random Number
        $OTP = rand(100000, 999999);
        // Send OTP To This Email Of User + His Name Is Mentioned
        $MailStatus = SendLinkToEmailForOTP($Username, $Email, $OTP);
        // Insert New Generated Otp To `otp` Table With `Is_Expired` Column is FAlSE + Time At Which It Is Created At [Default SQL timestamp()]
        $InsertStatement = "INSERT INTO `otp` VALUES (NULL,?,0,default,?)";
        $Query = $ConnectToDatabase->prepare($InsertStatement);
        //$Date = "date('Y-m-d H:i:s')"; #Debug
        $Query->bind_param("ii", $OTP,$UserID);
        $CheckError = $Query->execute();
        if ($CheckError)
            echo json_encode(array(
                "message" => "OTP Is Sent Please Check Your Email"
            ));
        else
            echo json_encode(array(
                "message" => "Failed To Send OTP"
            ));
        // Close Connection After Executing Insert Query
        $Query->close();
        $ConnectToDatabase->close();
    } else {
        echo json_encode(array(
            "message" => "Password Is Wrong"
        ));
    }
} else      echo json_encode(array(
    "message" => "User Does Not Exit"
));


   /*
{
    "Email":"ahmedmoyousry.bis@gmail.com",
    "Password":"Ahmedging241@"
}

   */