<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
//echo json_encode($data->question);
$AdminID = $data->AdminID;
$IsAuthourized = CheckIfAdminIsAuthorized($AdminID);
if($IsAuthourized == 1){
$question = $data->question;
$choice1 = $data->choice1;
$choice2 = $data->choice2;
$choice3 = $data->choice3;
$choice4 = $data->choice4;
$answer = $data->answer;
$exam_id = $data->exam_id;
$ConnectToDatabase = ConnectToDataBase();
$SelectStatement  = "SELECT * FROM `exams` WHERE id = ?";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param('i', $exam_id);
$CheckError = $Query->execute();
$Result = $Query->get_result();
$Num = $Result->num_rows;

//error_reporting(0);
if ($Num) {
    $InsertStatement = "INSERT INTO `questions` VALUES (NULL,?,?,?,?,?,?,?)";
    //    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
    $Query = $ConnectToDatabase->prepare($InsertStatement);
    $Query->bind_param('ssssssi', $question, $choice1, $choice2, $choice3, $choice4,$answer,$exam_id);
    $CheckError = $Query->execute();
    // Close Connection After Executing Query
    $Query->close();
    $ConnectToDatabase->close();
    
    // If Enterd Username/Email Exists In Database
    if ($CheckError) {  
        echo json_encode(array(
        "message" => "Question Is Added"
    ));
}
    else
        echo json_encode(array(
            "message" => "Failed To Add Question"
        ));
} else echo json_encode(array(
    "message" => "exam_id Is Wrong"
));
}
else echo json_encode(array(
    "message" => "Admin Is Not Authorized [Sub-Admin]"
));
/*

/*
//question  choice1 choice2 choice3 choice4 answer  exam_id
I/P:
{
    "AdminID":2,
    "question":"... is an algorithm",
    "choice1":"stack",
    "choice2":"queue",
    "choice3":"graph",
    "choice4":"Binary Search",
    "answer":4,
    "exam_id":1
}

*/