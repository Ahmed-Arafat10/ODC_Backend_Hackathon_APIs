
<?php 
// SendExamCode.php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
$AdminID = $data->AdminID;
$IsAuthourized = CheckIfAdminIsAuthorized($AdminID);
if ($IsAuthourized == 1) {
    $ConnectToDatabase = ConnectToDataBase();
    $JoinStatement = "SELECT *
FROM `student_course_enroll`
INNER JOIN `students`
on `students`.`id` = `student_course_enroll`.`student_id` AND `students`.`id`
INNER JOIN courses
on courses.id = student_course_enroll.course_id";
    //    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
    $Query = $ConnectToDatabase->query($JoinStatement);
    $Num = $Query->num_rows;
    //echo json_encode($Num);
    if ($Num) {
        $AllCourses = array();
        foreach ($Query as $EachOne) :
            extract($EachOne);
            $Item = array(
                'id' => $id,
                'student_name' => $student_name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'college' => $college,
                'created_at' => $created_at,
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
        // If Enterd Username/Email Exists In Database
        echo json_encode($AllCourses);
    } else {
        echo json_encode(array(
            "message" => "No Records"
        ));
    }
} else echo json_encode(array(
    "message" => "Admin Is Not Authorized [Sub-Admin]"
));

/*


{
"AdminID":1
}

*/