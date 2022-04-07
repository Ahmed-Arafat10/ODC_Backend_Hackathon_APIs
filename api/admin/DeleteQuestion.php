
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$AdminID = $data->AdminID;
$IsAuthourized = CheckIfAdminIsAuthorized($AdminID);
if ($IsAuthourized == 1) {
    $ID = $data->id;
    $ConnectToDatabase = ConnectToDataBase();
    $DeleteStatement = "DELETE FROM `questions` WHERE id = ?";
    //    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
    $Query = $ConnectToDatabase->prepare($DeleteStatement);
    $Query->bind_param('i', $ID);
    $ErrorCheck = $Query->execute();
    if ($ErrorCheck) {
        echo json_encode(array(
            "message" => "Question Is Deleted"
        ));
    } else {
        echo json_encode(array(
            "message" => "Failed To Deleted Question"
        ));
    }

    //echo json_encode($Num);
} else echo json_encode(array(
    "message" => "Admin Is Not Authorized [Sub-Admin]"
));


/*

{
    "AdminID":1,
    "id": 109
}

*/
?>
