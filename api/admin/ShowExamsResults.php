
<?php 
// SendExamCode.php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
$CourseID = $data->CourseID;
    $ConnectToDatabase = ConnectToDataBase();
    $JoinStatement = "SELECT * FROM `exam_result` 
    INNER join students
    on students.id = exam_result.student_id
    inner join exams
    on exam_result.exam_id = exams.id
    Inner Join courses
    on courses.id = exams.course_id AND courses.id = ?
    WHERE exam_result.Is_Interview_Send = 0
    ORDER BY exam_result.total_right_degree DESC
    ";
    //    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
    $Query = $ConnectToDatabase->prepare($JoinStatement);
    $Query->bind_param('i',$CourseID);
    $Query->execute();
    $Result = $Query->get_result();
    $Num = $Result->num_rows;
    //echo json_encode($Num);
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
                'college' => $college,
                'created_at' => $created_at,
                'course_name' => $course_name,
                'total_degree' => $total_degree,
                'total_right_degree' => $total_right_degree,
                'Course_Tag' => $Course_Tag
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
    "CourseID":24
    }

*/