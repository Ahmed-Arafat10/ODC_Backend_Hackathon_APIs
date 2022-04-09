
<?php
// SendExamCode.php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';

// Get raw posted data
// view all students enrolled in a specific course [id]
$data = json_decode(file_get_contents("php://input"));
$AdminID = $data->AdminID;
$CourseID = $data->CourseID;
$IsAuthourized = CheckIfAdminIsAuthorized($AdminID);
if ($IsAuthourized == 1) {
    $ConnectToDatabase = ConnectToDataBase();
    $JoinStatement = "SELECT *
FROM `student_course_enroll`
INNER JOIN `students`
on `students`.`id` = `student_course_enroll`.`student_id` AND `students`.`id`
INNER JOIN courses
on courses.id = student_course_enroll.course_id AND courses.id = ? ";
    // $Query = $ConnectToDatabase->query($JoinStatement);
    $Query = $ConnectToDatabase->prepare($JoinStatement);
    $Query->bind_param("i", $CourseID);
    $Query->execute();
    $Result = $Query->get_result();
    $Num = $Result->num_rows;
    if ($Num) {
        $AllCourses = array();
        foreach ($Result as $EachOne) :
            extract($EachOne);
            $Item = array(
                'id' => $id,
                'student_name' => $student_name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'CourseID' => $course_id,
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
        echo json_encode($AllCourses);
    } else echo json_encode(array("message" => "No Records"));
} else echo json_encode(array("message" => "Admin Is Not Authorized [Sub-Admin]"));

/*


{
    "AdminID":1,
    "CourseID":24
}

*/