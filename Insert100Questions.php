<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once 'DatabaseConfig/ConfigDB.php';
include_once 'UsedFunction/Functions.php';
$ConnectToDatabase = ConnectToDataBase();
for ($i = 1; $i <= 100; $i++) {
    $question = "Question Number #" . "$i";
    $choice1 = "MSQ 1";
    $choice2 = "MSQ 2";
    $choice3 = "MSQ 3";
    $choice4 = "MSQ 4";
    $answer = "4";
    $exam_id = 1;
    $InsertStatement = "INSERT INTO `questions` VALUES (NULL,?,?,?,?,?,?,?)";
    //    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
    $Query = $ConnectToDatabase->prepare($InsertStatement);
    $Query->bind_param('ssssssi', $question, $choice1, $choice2, $choice3, $choice4, $answer, $exam_id);
    $CheckError = $Query->execute();
    // Close Connection After Executing Query

    // If Enterd Username/Email Exists In Database
    if ($CheckError) {
        echo  "Question Is Added";
    } else
        echo "Failed To Add Question";
} 

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



{
    "AdminID":2,
    "question":"hi",
    "choice1":"hi1",
    "choice2":"hi2",
    "choice3":"hi3",
    "choice4":"hi4 Search",
    "answer":4,
    "exam_id":1
}


*/