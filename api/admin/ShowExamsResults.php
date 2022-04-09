
<?php
// SendExamCode.php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
// get id of course
$CourseID = $data->CourseID;
$ConnectToDatabase = ConnectToDataBase();
/* a join statement to get data of students and course
 for specific course id
 + exam results where interview details has not been sent yet 
 + in arrange with highest degree [Descending]  */
$JoinStatement = "SELECT * FROM `exam_result` 
    INNER JOIN students
    ON students.id = exam_result.student_id
    inner JOIN exams
    ON exam_result.exam_id = exams.id
    Inner JOIN courses
    ON courses.id = exams.course_id AND courses.id = ?
    WHERE exam_result.Is_Interview_Send = 0
    ORDER BY exam_result.total_right_degree DESC
    ";
$Query = $ConnectToDatabase->prepare($JoinStatement);
$Query->bind_param('i', $CourseID);
$Query->execute();
$Result = $Query->get_result();
$Num = $Result->num_rows;
//echo json_encode($Num);
if ($Num) {
    $AllCourses = array();
    //get details for each record
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
} else echo json_encode(array("message" => "No Records"));



/*


    {
    "CourseID":24
    }

*/