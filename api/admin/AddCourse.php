<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
$AdminID = $data->AdminID;
$Token = IsLoggedInAdmin($AdminID);
if ($Token == 0) {
    echo json_encode(array(
        "message" => "Please Log In First"
    ));
    exit;
}


$IsAuthourized = CheckIfAdminIsAuthorized($AdminID);
if($IsAuthourized == 1){
$CourseName = $data->CourseName;
$Level = $data->Level;
$Description = $data->Description;
$Category_ID = $data->Category_ID;
$Course_Tag = $data->Course_Tag;
$ConnectToDatabase = ConnectToDataBase();
$SelectStatement  = "SELECT * FROM `category` WHERE id = ?";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param('i', $Category_ID);
$CheckError = $Query->execute();
$Result = $Query->get_result();
$Num = $Result->num_rows;

//error_reporting(0);
if ($Num) {
    $InsertStatement = "INSERT INTO `courses` VALUES (NULL,?,?,?,Default,?,?,1)";
    //    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
    $Query = $ConnectToDatabase->prepare($InsertStatement);
    $Query->bind_param('sssis', $CourseName, $Level, $Description, $Category_ID, $Course_Tag);
    try {
        $ErrorCheck = $Query->execute();
        // If Enterd Username/Email Exists In Database
        if ($CheckError) {
            $Inserted_ID = $Query->insert_id;
            $InsertStatement = "INSERT INTO `exams` VALUES (NULL,?)";
            //    $InsertStatement = "Insert * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
            $Query = $ConnectToDatabase->prepare($InsertStatement);
            $Query->bind_param('i', $Inserted_ID);
            $CheckError = $Query->execute();
            $Query->close();
            $ConnectToDatabase->close();
            echo json_encode(array(
                "message" => "Course Is Added"
            ));
        } else
            echo json_encode(array(
                "message" => "Failed To Add Course"
            ));
    } catch (Exception $e) {
        echo json_encode(array(
            "message" => "Course Tag Must be Unique"
        ));
    }
} else echo json_encode(array(
    "message" => "category_id Is Wrong"
));
}
else echo json_encode(array(
    "message" => "Admin Is Not Authorized [Sub-Admin]"
));
/*
I/P:
{
    "AdminID":1,
    "CourseName":"Data",
    "Level":"Advanced",
    "Description":"Hello Course",
    "Category_ID":2,
    "Course_Tag":"DS"
}

*/