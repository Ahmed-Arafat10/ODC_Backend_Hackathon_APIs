<?php

/** header for restful api **/
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// include database
include_once '../../DatabaseConfig/ConfigDB.php';


// Get raw posted data in Postman
$data = json_decode(file_get_contents("php://input"));

// key -> pair values from raw in postman
$AdminName = $data->AdminName;
$Password = $data->Password;

$ConnectToDatabase = ConnectToDataBase();
// first check if admin name exists in db
$SelectStatement = "SELECT * FROM `admin` WHERE `admin_name` = ? LIMIT 1";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param('s', $AdminName);
$Query->execute();
$Result = $Query->get_result();
$NumOfRows = $Result->num_rows;
// if admin name exists
if ($NumOfRows) {
    $Fetch = $Result->fetch_assoc();
    $HashedPasswordFromDatabase = $Fetch['password'];
    $AdminID = $Fetch['id'];
    // echo json_encode($HashedPasswordFromDatabase);
    $IsAuthorized = $Fetch['authorized'];
    // check if entered password is same as password stored in db
    if (password_verify($Password, $HashedPasswordFromDatabase)) {
        // create a token
        $Token = md5(rand() + rand() + 11);
        // when a record in `signedin_admin` table with id of admin exists, this means that admin is logged in
        $InsertStatement = "INSERT INTO `signedin_admin` VALUES(?,?,DEFAULT)";
        $Query = $ConnectToDatabase->prepare($InsertStatement);
        $Query->bind_param("is", $AdminID, $Token);
        // if admin tries to log in while he is already logged in previously [without logging out] 
        try {
            $CheckError = $Query->execute();
        } catch (Exception $e) {
            echo json_encode(array("message" => "You Are Already Logged In"));
            exit;
        }
        // Close Connection After Executing Query
        $Query->close();
        $ConnectToDatabase->close();
        /* if admin logged in successfully
        is authorized is stored so athorized admin can edit/delete/update while sub admin only view data in ALL PAGES
        */
        echo json_encode(array(
            "message" => "Hello Admin",
            "IsAdmin" => 1,
            "IsAuthorized" => $IsAuthorized,
            "Token" => $Token
        ));
    } else {
        // this means that password entered by admin is incorrect
        echo json_encode(array("message" => "Password Is Wrong"));
    }
}
// if no record is found with entered admin name
else echo json_encode(array(
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