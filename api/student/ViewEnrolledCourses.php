
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
$UserID = $data->ID;   
$Token = IsLoggedIn($UserID);
if ($Token == 0) {
    echo json_encode(array(
        "message" => "Please Log In First"
    ));
    exit;
} 
$ConnectToDatabase = ConnectToDataBase();
$JoinStatement = "SELECT *
FROM `student_course_enroll`
INNER JOIN `students`
on `students`.`id` = `student_course_enroll`.`student_id` AND `students`.`id` = ?
INNER JOIN courses
on courses.id = student_course_enroll.course_id";
//    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
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
        if($Code == NULL) $Code = "Pending Status...";
        $Item = array(  
            'course_name' => $course_name,
            'course_level' => $course_level,
            'description' => $description,
            'created_at' => $created_at,
            'category_id' => $category_id,
            'course_tag' => $Course_Tag,
            'is_running' => $Is_Running,
            'code' => $Code,
        );
        array_push($AllCourses, $Item);
    endforeach;

    // Close Connection After Executing Query
    $Query->close();
    $ConnectToDatabase->close();
    // If Enterd Username/Email Exists In Database
    echo json_encode($AllCourses);
} else {
    echo json_encode(array(
        "message" => "No Records"
    ));
}


/*


{
    "ID":4
}

*/