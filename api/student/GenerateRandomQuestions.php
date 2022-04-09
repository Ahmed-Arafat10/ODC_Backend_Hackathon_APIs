<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';


// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
// get id of exam
$ExamID = $data->ExamID;
$ConnectToDatabase = ConnectToDataBase();
// get all questions that are associated to that exam [exam refers to course]
$SelectStatement = "SELECT * FROM `questions` WHERE `exam_id` = ?";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param("i", $ExamID);
$Query->execute();
$Result = $Query->get_result();
$Num = $Result->num_rows;
//echo json_encode($Num);
if ($Num) {
    $AllQuestions = array();
    foreach ($Result as $EachOne) :
        extract($EachOne);
        $EachQuestion = array(
            'id' => $id,
            'question' => $question,
            'choice1' => $choice1,
            'choice2' => $choice2,
            'choice3' => $choice3,
            'choice4' => $choice4,
            'answer' => $answer,
            'exam_id' => $exam_id
        );
        array_push($AllQuestions, $EachQuestion);
    endforeach;

    // Close Connection After Executing Query
    $Query->close();
    $ConnectToDatabase->close();

    // echo json_encode($AllStudents[1]);
    // get number of questions for that exam
    $sz = count($AllQuestions);
    // array to store random questions
    $RandQuestion = array();
    $Index = array();
    $x = 1;
    while (count($RandQuestion) != 15) {
        $Rang = rand() % count($AllQuestions);
        // check if rand index generated not in used index before
        if (!in_array($Rang, $Index)) {
            $RandQuestion["Q" . $x] = $AllQuestions[$Rang];
            $Index[] = $Rang;
            $x++;
        }
    }
    echo json_encode($RandQuestion);
    //echo json_encode(count($RandQuestion));
} else echo json_encode(array("message" => "No Exam With Such ID"));

/*

{
    "ExamID":1
}

*/