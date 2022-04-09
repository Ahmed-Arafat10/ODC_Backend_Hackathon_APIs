
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
// get id of user
$UserID = $data->UserID;
//checko if user is logged in or not
$Token = IsLoggedIn($UserID);
if ($Token == 0) {
    echo json_encode(array("message" => "Please Log In First"));
    exit;
}

$ConnectToDatabase = ConnectToDataBase();
// get all courses in which user is not enrolled in it
$JoinStatement = "SELECT 
*
FROM `student_course_enroll`
INNER JOIN `students`
on `students`.`id` = `student_course_enroll`.`student_id` AND `students`.`id` = ?
RIGHT JOIN courses
on courses.id = student_course_enroll.course_id
WHERE students.id is null;";
$Query = $ConnectToDatabase->prepare($JoinStatement);
$Query->bind_param("i",$UserID);
$Query->execute();
$Result = $Query->get_result();
$Num = $Result->num_rows;
//echo json_encode($Num);
if ($Num) {
    $AllCourses = array();
    foreach ($Result as $EachOne) :
        extract($EachOne);
        $Item = array(  
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

/*

{
    "UserID":4
}

*/