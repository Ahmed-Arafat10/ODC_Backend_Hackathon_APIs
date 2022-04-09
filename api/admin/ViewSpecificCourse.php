<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';


// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
// get course id
$CourseID = $data->CourseID;
$ConnectToDatabase = ConnectToDataBase();
// search with that id in `courses` table 
$SelectStatement = "SELECT * FROM `courses` WHERE id = ?";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param('i', $CourseID);
$Query->execute();
$Result = $Query->get_result();
$Num = $Result->num_rows;
//echo json_encode($Num);
// if a record exists with that id
if ($Num) {
    $Fetch = $Result->fetch_assoc();
    extract($Fetch);
    $Course = array(
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
    echo json_encode($Course);
} else echo json_encode(array("message" => "No Records"));




/*

{
    "CourseID":13
}

*/
