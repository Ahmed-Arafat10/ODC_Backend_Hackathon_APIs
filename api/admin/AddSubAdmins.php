<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$AdminID = $data->AdminID;
$IsAuthourized = CheckIfAdminIsAuthorized($AdminID);
if($IsAuthourized == 1){

$AdminName = $data->AdminName;
$Password = $data->Password;
$ConnectToDatabase = ConnectToDataBase();
$InsertStatement = "INSERT INTO `admin` VALUES (NULL,?,?,0)";
//    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
$Query = $ConnectToDatabase->prepare($InsertStatement);
$Hashed = password_hash($Password,PASSWORD_DEFAULT);
$Query->bind_param('ss', $AdminName,$Hashed);
$CheckError = $Query->execute();
// Close Connection After Executing Query
$Query->close();
$ConnectToDatabase->close();
// If Enterd Username/Email Exists In Database
if($CheckError)   echo json_encode(array(
    "message" => "Subadmin Is Added"
));
else 
echo json_encode(array(
    "message" => "Failed To Add Subadmin"
));
}
else echo json_encode(array(
    "message" => "Admin Is Not Authorized [Sub-Admin]"
));



/*

{
    "AdminID":2,
    "AdminName":"xyz",
    "Password":"123"
}


*/

?>