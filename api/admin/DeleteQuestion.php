
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
// get id of admin from postman raw
$AdminID = $data->AdminID;
// check if admin is athorized to use this page
$IsAuthourized = CheckIfAdminIsAuthorized($AdminID);
if ($IsAuthourized == 1) {
    //get question id
    $QuestionID = $data->QuestionID;
    $ConnectToDatabase = ConnectToDataBase();
    $DeleteStatement = "DELETE FROM `questions` WHERE id = ?";
    $Query = $ConnectToDatabase->prepare($DeleteStatement);
    $Query->bind_param('i', $QuestionID);
    $ErrorCheck = $Query->execute();
    if ($ErrorCheck) echo json_encode(array("message" => "Question Is Deleted"));
    else echo json_encode(array("message" => "Failed To Delete Question"));

} else echo json_encode(array( "message" => "Admin Is Not Authorized [Sub-Admin]"));


/*

{
    "AdminID":1,
    "QuestionID":100
}

*/
?>
