<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';

$data = json_decode(file_get_contents("php://input"));
// get id of user and id of course user want to enroll to
$UserID = $data->ID;
$CourseID = $data->CourseID;

// check if user is logged in
$Token = IsLoggedIn($UserID);
if ($Token == 0) {
    echo json_encode(array("message" => "Please Log In First"));
    exit;
}
$ConnectToDatabase = ConnectToDataBase();
// check if user has enrolled in the same course before
$SelectStatement = "SELECT * FROM `student_course_enroll` WHERE `student_id` = ? AND `course_id` = ? ";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param("ii", $UserID, $CourseID);
$CheckError = $Query->execute();
$Result = $Query->get_result();
$NumOfRows = $Result->num_rows;
// if not
if (!$NumOfRows) {
    // add new record with user id and course id
    $InsertStatement = "INSERT INTO `student_course_enroll` VALUES(NULL,?,?,DEFAULT,NULL,NULL,0)";
    $Query = $ConnectToDatabase->prepare($InsertStatement);
    $Query->bind_param("ii", $UserID, $CourseID);
    $CheckError = $Query->execute();
    // Close Connection After Executing Query
    $Query->close();
    $ConnectToDatabase->close();
    if ($CheckError)  echo json_encode(array("message" => "Congratulations, You Have Enrolled In This Course Successfully"));
    else echo json_encode(array("message" => "Something Went Wrong Please Try Again"));
} else echo json_encode(array("message" => "You Are Already Enrolled In This Course"));

/*

{
    "ID":1,
    "CourseID":24
}

*/