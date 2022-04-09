
<?php
// SendExamCode.php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// get student id & exam id to use it in `exam_result` table
$StudentID = $data->StudentID;
$ExamID = $data->ExamID;

$ConnectToDatabase = ConnectToDataBase();

$SelectStatement = "SELECT * FROM `exam_result` WHERE `exam_id` = ? AND `student_id` = ? ";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param("ii", $ExamID, $StudentID);
$Query->execute();
$Result = $Query->get_result();
$Num = $Result->num_rows;
// if student has finished exam
if ($Num) {
    $Fetch = $Result->fetch_assoc();
    // check if interview details has not been send to him
    $Interview = $Fetch['Is_Interview_Send'];
    if ($Interview) echo json_encode(array("message" => "An Email Is Already Sent To You With Details Of Interview"));
     else {
         // get student name+ email that will be used to send an email
        $SelectStatement = "SELECT * FROM `students` WHERE `id` = ? ";
        $Query = $ConnectToDatabase->prepare($SelectStatement);
        $Query->bind_param("i", $StudentID);
        $Query->execute();
        $Result = $Query->get_result();
        $Fetch = $Result->fetch_assoc();
        $Username = $Fetch['student_name'];
        $Email = $Fetch['email'];
        // text of interview details
        $Details = "Interview Details Are XYZ";
        SendInterviewDetails($Username, $Email, $Details);
        // now as email is sent to student then `Is_Interview_Send` column should be changed to 1
        $UpdateStatement = "UPDATE `exam_result` SET Is_Interview_Send = 1 WHERE `exam_id` = ? AND `student_id` = ? ";
        $Query = $ConnectToDatabase->prepare($UpdateStatement);
        $Query->bind_param("ii", $ExamID, $StudentID);
        $Query->execute();
        echo json_encode(array("message" => "An Email Is Sent To You With Details Of Interview"));
    }
} else echo json_encode(array("message" => "StudentID or ExamID is/are Wrong"));



/*


{
"StudentID":4,
"ExamID":1
}

*/