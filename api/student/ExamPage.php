<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';


// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
$ExamID = $data->ExamID;
$ConnectToDatabase = ConnectToDataBase();
$SelectStatement = "SELECT * FROM `questions` WHERE `exam_id` = ?";
//    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param("i", $ExamID);
$Query->execute();
$Result = $Query->get_result();
$Num = $Result->num_rows;
//echo json_encode($Num);
if ($Num) {
    $AllStudents= array();
    $cnt = 1;
    foreach ($Result as $EachOne) :
        extract($EachOne);
        $Item = array(
                'id' => $id,
                'question' => $question,
                'choice1' => $choice1,
                'choice2' => $choice2,
                'choice3' => $choice3,
                'choice4' => $choice4,
                'answer' => $answer,
                'exam_id' => $exam_id
           
        );
        array_push($AllStudents, $Item);
        $cnt++;
    endforeach;

    // Close Connection After Executing Query
    $Query->close();
    $ConnectToDatabase->close();
    // If Enterd Username/Email Exists In Database
    // echo json_encode($AllStudents[1]);
    $sz = count($AllStudents);
    $RandQuestion = array();
    $Keys = array();
    $x = 1;
    while (count($RandQuestion) != 15) {
        $Rang = rand() % count($AllStudents);
        if (!in_array($Rang, $Keys)) {
            $RandQuestion["Q".$x] = $AllStudents[$Rang];
            $Keys[] = $Rang;
            $x++;
        }
    }
    echo json_encode($RandQuestion);
    //echo json_encode(count($RandQuestion));
} else {
    echo json_encode(array(
        "message" => "No records"
    ));
}

/*

{
    "ExamID":1
}




*/