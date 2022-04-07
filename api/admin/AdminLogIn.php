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

// If Enterd Username/Email Exists In Database

if ($NumOfRows) {
    $Fetch = $Result->fetch_assoc();
    $HashedPasswordFromDatabase = $Fetch['password'];
    $AdminID = $Fetch['id'];
   // echo json_encode($HashedPasswordFromDatabase);
    $IsAuthorized = $Fetch['authorized'];
    //$HashedPasswordFromDatabae = password_hash($Password, PASSWORD_DEFAULT);
    if (password_verify($Password, $HashedPasswordFromDatabase)) {
        $Token = md5(rand() + rand() + 11);
        $InsertStatement = "INSERT INTO `signedin_admin` VALUES(?,?,DEFAULT)";
        $Query = $ConnectToDatabase->prepare($InsertStatement);
        $Query->bind_param("is", $AdminID,$Token);
        $CheckError = $Query->execute();
        // Close Connection After Executing Query
        $Query->close();
        $ConnectToDatabase->close();
        echo json_encode(array(
            "message" => "Hello Admin",
            "IsAdmin" => 1,
            "IsAuthorized" => $IsAuthorized,
            "Token" => $Token
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

/*

{
 "AdminName":"arafat",
 "Password":"Ahmedging241@"
}


*/