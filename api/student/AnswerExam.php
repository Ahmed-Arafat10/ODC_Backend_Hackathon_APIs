<?php


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';

$ConnectToDatabase = ConnectToDataBase();

$data = json_decode(file_get_contents("php://input"),true);
$User_ID = $data["UserID"]["ID"];
$Code = $data["UserID"]["Code"];
$Exam_ID =  $data["Q1"]["exam_id"];
// echo $data["Answer"]['q1'];
$SelectStatement = "SELECT * FROM `exam_result` WHERE `student_id` = ? AND `exam_id` = ?";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param("ii",$User_ID,$Exam_ID);
 $Query->execute();
 $Result = $Query->get_result();
$num = $Result->num_rows;
if($num)
{
    echo json_encode(array(
        "message" => "You Have Taken This Exam Before"
    ));
    exit;
}

$SelectStatement = "SELECT * FROM `student_course_enroll` WHERE `student_id` = ? AND `Code` = ?";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param("is",$User_ID,$Code);
 $Query->execute();
 $Result = $Query->get_result();
$num = $Result->num_rows;
if(!$num)
{
    echo json_encode(array(
        "message" => "This Code Is Wrong"
    ));
    exit;
}

$SelectStatement = "SELECT * FROM `student_course_enroll` WHERE `student_id` = ? AND `Code` = ? AND NOW() <= NOW() <= DATE_ADD(Code_Date, INTERVAL 2 DAY) ";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param("is",$User_ID,$Code);
 $Query->execute();
 $Result = $Query->get_result();
$num = $Result->num_rows;
if(!$num)
{
    echo json_encode(array(
        "message" => "Sorry, Code Is Expired As It IsOnly Valid For Two Days"
    ));
    exit;
}



$TotalRightAnswer = 0;
$i = 1;
for($j=0;$j<15;$j++)
{
    $key1 = "q".$i;
    $UserAns = $data["Answer"][$key1];
   
    $key2 = "Q".$i;
    $RightAns = $data[$key2]["answer"];
    if($UserAns == $RightAns) $TotalRightAnswer++;
   // echo $UserAns . "-->".  $RightAns;
    $i++;
}

// $User_ID =  $data["Q1"]["id"];
//echo $TotalRightAnswer;
//echo "this".$Exam_ID;
//echo "this".$User_ID;

$InsertStatement = "INSERT INTO `exam_result` VALUES (NULL,15,?,?,?)";
//    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
$Query = $ConnectToDatabase->prepare($InsertStatement);
$Query->bind_param('iii', $TotalRightAnswer, $Exam_ID, $User_ID);
$ErrorCheck = $Query->execute();
// If Enterd Username/Email Exists In Database
if ($ErrorCheck) {
    $JoinStatement = "SELECT DISTINCT exams.course_id AS _ID_ FROM questions
    INNER JOIN exams
    on exams.id = questions.exam_id;";
    $Query = $ConnectToDatabase->query($JoinStatement);
    $Result = $Query->fetch_assoc();
    $CourseID = $Result['_ID_'];
    

    $InsertStatement = "UPDATE `student_course_enroll` SET Is_Code_Expired = 1 WHERE `student_id` = ? AND `course_id` = ? ";
//    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
$Query = $ConnectToDatabase->prepare($InsertStatement);
$Query->bind_param('ii', $User_ID, $CourseID);
$ErrorCheck = $Query->execute();
    echo json_encode(array(
        "message" => "The Exam Has Been Finished, Good Luck :)"
    ));
}
else{
    echo json_encode(array(
        "message" => "Something Went Wrong Try Again"
    ));
}

/*
{
    "UserID":
    {
        "ID":4,
        "Code":"ALGO46826"
    },
     "Answer":
    {
        "q1":1,
        "q2":1,
        "q3":1,
        "q4":1,
        "q5":1,
        "q6":1,
        "q7":1,
        "q8":1,
        "q9":1,
        "q10":1,
        "q11":1,
        "q12":1,
        "q13":1,
        "q14":1,
        "q15":1
    },
    "Q1": {
        "id": 48,
        "question": "Question Number #41",
        "choice1": "MSQ 1",
        "choice2": "MSQ 2",
        "choice3": "MSQ 3",
        "choice4": "MSQ 4",
        "answer": "4",
        "exam_id": 1
    },
    "Q2": {
        "id": 24,
        "question": "Question Number #17",
        "choice1": "MSQ 1",
        "choice2": "MSQ 2",
        "choice3": "MSQ 3",
        "choice4": "MSQ 4",
        "answer": "4",
        "exam_id": 1
    },
    "Q3": {
        "id": 82,
        "question": "Question Number #75",
        "choice1": "MSQ 1",
        "choice2": "MSQ 2",
        "choice3": "MSQ 3",
        "choice4": "MSQ 4",
        "answer": "4",
        "exam_id": 1
    },
    "Q4": {
        "id": 92,
        "question": "Question Number #85",
        "choice1": "MSQ 1",
        "choice2": "MSQ 2",
        "choice3": "MSQ 3",
        "choice4": "MSQ 4",
        "answer": "4",
        "exam_id": 1
    },
    "Q5": {
        "id": 45,
        "question": "Question Number #38",
        "choice1": "MSQ 1",
        "choice2": "MSQ 2",
        "choice3": "MSQ 3",
        "choice4": "MSQ 4",
        "answer": "4",
        "exam_id": 1
    },
    "Q6": {
        "id": 67,
        "question": "Question Number #60",
        "choice1": "MSQ 1",
        "choice2": "MSQ 2",
        "choice3": "MSQ 3",
        "choice4": "MSQ 4",
        "answer": "4",
        "exam_id": 1
    },
    "Q7": {
        "id": 42,
        "question": "Question Number #35",
        "choice1": "MSQ 1",
        "choice2": "MSQ 2",
        "choice3": "MSQ 3",
        "choice4": "MSQ 4",
        "answer": "4",
        "exam_id": 1
    },
    "Q8": {
        "id": 58,
        "question": "Question Number #51",
        "choice1": "MSQ 1",
        "choice2": "MSQ 2",
        "choice3": "MSQ 3",
        "choice4": "MSQ 4",
        "answer": "4",
        "exam_id": 1
    },
    "Q9": {
        "id": 56,
        "question": "Question Number #49",
        "choice1": "MSQ 1",
        "choice2": "MSQ 2",
        "choice3": "MSQ 3",
        "choice4": "MSQ 4",
        "answer": "4",
        "exam_id": 1
    },
    "Q10": {
        "id": 66,
        "question": "Question Number #59",
        "choice1": "MSQ 1",
        "choice2": "MSQ 2",
        "choice3": "MSQ 3",
        "choice4": "MSQ 4",
        "answer": "4",
        "exam_id": 1
    },
    "Q11": {
        "id": 12,
        "question": "Question Number #5",
        "choice1": "MSQ 1",
        "choice2": "MSQ 2",
        "choice3": "MSQ 3",
        "choice4": "MSQ 4",
        "answer": "4",
        "exam_id": 1
    },
    "Q12": {
        "id": 35,
        "question": "Question Number #28",
        "choice1": "MSQ 1",
        "choice2": "MSQ 2",
        "choice3": "MSQ 3",
        "choice4": "MSQ 4",
        "answer": "4",
        "exam_id": 1
    },
    "Q13": {
        "id": 27,
        "question": "Question Number #20",
        "choice1": "MSQ 1",
        "choice2": "MSQ 2",
        "choice3": "MSQ 3",
        "choice4": "MSQ 4",
        "answer": "4",
        "exam_id": 1
    },
    "Q14": {
        "id": 93,
        "question": "Question Number #86",
        "choice1": "MSQ 1",
        "choice2": "MSQ 2",
        "choice3": "MSQ 3",
        "choice4": "MSQ 4",
        "answer": "4",
        "exam_id": 1
    },
    "Q15": {
        "id": 23,
        "question": "Question Number #16",
        "choice1": "MSQ 1",
        "choice2": "MSQ 2",
        "choice3": "MSQ 3",
        "choice4": "MSQ 4",
        "answer": "1",
        "exam_id": 1
    }
}


*/
