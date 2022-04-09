<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';

// Get raw posted data
//$data = json_decode(file_get_contents("php://input"));
$ConnectToDatabase = ConnectToDataBase();
// get all course that are not currently running
$SelectStatement = "SELECT * FROM `courses` WHERE `Is_Running` = 0 ";
$Query = $ConnectToDatabase->query($SelectStatement);
$Num = $Query->num_rows;
//echo json_encode($Num);
if ($Num) {
    $AllCourses = array();
    foreach ($Query as $EachOne) :
        extract($EachOne);
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
        array_push($AllCourses, $Item);
    endforeach;

    // Close Connection After Executing Query
    $Query->close();
    $ConnectToDatabase->close();
    // print output in JSON format
    echo json_encode($AllCourses);
} else echo json_encode(array("message" => "No Records"));

