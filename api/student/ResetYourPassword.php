<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';
// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//StudentName Email Phone  Address College

$Email = $data->Email;
$TokenForPass = $data->TokenForChangingPassword;
$NewPassword = $data->NewPassword;
$ConnectToDatabase = ConnectToDataBase();
$InsertStatement  = "SELECT * FROM `students` WHERE Email = ? ";
$Query = $ConnectToDatabase->prepare($InsertStatement);
$Query->bind_param('s', $Email);
$CheckError = $Query->execute();
$Result = $Query->get_result();
$num = $Result->num_rows;
if ($num) {
    $Fetch = $Result->fetch_assoc();
    $DBToken = $Fetch['Token'];
    $Username = $Fetch['student_name'];
    if ($TokenForPass == $DBToken) {
        $HashedPass = password_hash($NewPassword,PASSWORD_DEFAULT);
        $NewToken = md5(rand() + rand() + 11);
        $InsertStatement  = "UPDATE `students` SET `password` = ? , `Token` = ? WHERE Email = ? ";
        $Query = $ConnectToDatabase->prepare($InsertStatement);
        $Query->bind_param('sss',$HashedPass, $NewToken, $Email);
        $CheckError = $Query->execute();
        InformUserThatPasswordIsChanged($Username,$Email);
        echo json_encode(array(
            "message" => "Your Password Has Been Changed Successfully"
        ));
    } 
    else {
        echo json_encode(array(
            "message" => "Token Is Not Valid"
        ));
    }
} else
    echo json_encode(array(
        "message" => "Email Does Not Exist"
    ));

/*

I/P:
{
    "Email":"ahmedmoyousry.bis@gmail.com",
    "TokenForChangingPassword":"XX",
    "NewPassword":"1234"
}

*/