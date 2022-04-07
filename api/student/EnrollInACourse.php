<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';

$data = json_decode(file_get_contents("php://input"));

$UserID = $data->ID;
$CourseID = $data->CourseID;

$Token = IsLoggedIn($UserID);
if ($Token == 0) {
    echo json_encode(array(
        "message" => "Please Log In First"
    ));
    exit;
}
$ConnectToDatabase = ConnectToDataBase();

$SelectStatement = "SELECT * FROM `student_course_enroll` WHERE `student_id` = ? AND `course_id` = ? ";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param("ii", $UserID, $CourseID);
$CheckError = $Query->execute();
$Result = $Query->get_result();
$NumOfRows = $Result->num_rows;
if (!$NumOfRows) {
    $InsertStatement = "INSERT INTO `student_course_enroll` VALUES(NULL,?,?,DEFAULT,NULL,NULL)";
    $Query = $ConnectToDatabase->prepare($InsertStatement);
    $Query->bind_param("ii", $UserID, $CourseID);
    $CheckError = $Query->execute();
    // Close Connection After Executing Query
    if ($CheckError)  echo json_encode(array(
        "message" => "Congratulations, You Have Enrolled In This Course Successfully"
    ));
    else echo json_encode(array(
        "message" => "Something Went Wrong Please Try Again"
    ));
} else echo json_encode(array(
    "message" => "You Are Already Enrolled In This Course"
));

/*

{
    "ID":1,
    "CourseID":24
}

*/