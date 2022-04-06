
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
$ID = $data->id;
$CourseName = $data->course_name;
$Level = $data->course_level;
$Description = $data->description;
$Category_ID = $data->category_id;
$Course_Tag = $data->course_tag;
$Is_Running = $data->is_running;
$ConnectToDatabase = ConnectToDataBase();
$SelectStatement = "UPDATE `courses` SET `course_name` = ? ,
`course_level` = ? ,
`description` = ? ,
`category_id` = ? ,
`course_tag` = ? ,
`is_running` = ? 
 WHERE id = ?";
//    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param('sssisii', $CourseName,$Level,$Description,$Category_ID,$Course_Tag,$Is_Running,$ID);
try {
$ErrorCheck = $Query->execute();
if ($ErrorCheck) {
    echo json_encode(array(
        "message" => "Course Is Updated"
    ));
} else {
    echo json_encode(array(
        "message" => "Failed To Update Course"
    ));
}
}
catch (Exception $e) {
    echo json_encode(array(
        "message" => "Course Tag Must be Unique"
    ));
}
//echo json_encode($Num);
}
else echo json_encode(array(
    "message" => "Admin Is Not Authorized [Sub-Admin]"
));


/*
{
    "AdminID":2,
    "id": 13,
    "course_name": "Data",
    "course_level": "Easy",
    "description": "Hello Course",
    "created_at": "2022-04-06 21:22:16",
    "category_id": 2,
    "course_tag": "sss",
    "is_running": 1
}

*/
?>
