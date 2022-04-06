<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';


// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$AdminName = $data->AdminName;
$Password = $data->Password;
$ConnectToDatabase = ConnectToDataBase();
$SelectStatement = "SELECT * FROM `admin` WHERE `admin_name` = ? LIMIT 1";
//    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param('s', $AdminName);
$Query->execute();
$Result = $Query->get_result();
$NumOfRows = $Result->num_rows;
// Close Connection After Executing Query
$Query->close();
$ConnectToDatabase->close();
// If Enterd Username/Email Exists In Database

if ($NumOfRows) {
    $Fetch = $Result->fetch_assoc();
    $HashedPasswordFromDatabase = $Fetch['password'];
   // echo json_encode($HashedPasswordFromDatabase);
    $IsAuthorized = $Fetch['authorized'];
    //$HashedPasswordFromDatabae = password_hash($Password, PASSWORD_DEFAULT);
    if (password_verify($Password, $HashedPasswordFromDatabase)) {
        echo json_encode(array(
            "message" => "Hello Admin",
            "IsAdmin" => 1,
            "IsAuthorized" => $IsAuthorized
        ));
    } else {
        echo json_encode(array(
            "message" => "Password Is Wrong",
            "IsAdmin" => 0,
            "IsAuthorized" => 0
        ));
    }
} else      echo json_encode(array(
    "message" => "Admin Not Exit",
    "IsAdmin" => 0,
    "IsAuthorized" => 0
));
