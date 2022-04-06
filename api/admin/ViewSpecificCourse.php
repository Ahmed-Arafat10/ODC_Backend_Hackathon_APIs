<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';


// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
$ID = $data->id;
$ConnectToDatabase = ConnectToDataBase();
$SelectStatement = "SELECT * FROM `courses` WHERE id = ?";
//    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param('i', $ID);
$Query->execute();
$Result = $Query->get_result();
$Num = $Result->num_rows;
//echo json_encode($Num);
if ($Num) {
    $AllCourses = array();
    $Fetch = $Result->fetch_assoc();
    extract($Fetch);
    $Item = array(
        'id' => $id,
        'course_name' => $course_name,
        'course_level' => $course_level,
        'description' => $description,
        'created_at' => $created_at,
        'category_id' => $category_id,
        'course_tag' => $Course_Tag,
        'is_running' => $Is_Running,
    );

    // Close Connection After Executing Query
    $Query->close();
    $ConnectToDatabase->close();
    // If Enterd Username/Email Exists In Database
    echo json_encode($Item);
} else {
    echo json_encode(array(
        "message" => "No Records"
    ));
}



/*

{
    "id":13
}

*/

?>

