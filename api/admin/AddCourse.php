<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
// store value with key `AdminID` in raw section in postman
$AdminID = $data->AdminID;
// if user is not logged in then this message will appears and all functionality in page wont work
$Token = IsLoggedInAdmin($AdminID);
if ($Token == 0) {
    echo json_encode(array("message" => "Please Log In First"));
    exit;
}

// if logged in admin is authorized to edit/add/update then he will be able to use page else functionality in page wont work
$IsAuthourized = CheckIfAdminIsAuthorized($AdminID);
if ($IsAuthourized == 1) {
    // data of course want to be stored in db, comes from raw section in postman
    $CourseName = $data->CourseName;
    $Level = $data->Level;
    $Description = $data->Description;
    $Category_ID = $data->Category_ID;
    $Course_Tag = $data->Course_Tag;

    $ConnectToDatabase = ConnectToDataBase();
    // check if entered category id exists in db
    $SelectStatement  = "SELECT * FROM `category` WHERE id = ?";
    $Query = $ConnectToDatabase->prepare($SelectStatement);
    $Query->bind_param('i', $Category_ID);
    $CheckError = $Query->execute();
    $Result = $Query->get_result();
    $Num = $Result->num_rows;

    //error_reporting(0);

    // if exists
    if ($Num) {
        // inseret data of course in db
        $InsertStatement = "INSERT INTO `courses` VALUES (NULL,?,?,?,Default,?,?,1)";
        $Query = $ConnectToDatabase->prepare($InsertStatement);
        $Query->bind_param('sssis', $CourseName, $Level, $Description, $Category_ID, $Course_Tag);
        // if course tag is not unique then catch body will be executed
        try {
            // execute query
            $ErrorCheck = $Query->execute();
            // if query executed successfully
            if ($CheckError) {
                // store id of course that is automatically generated
                $Inserted_ID = $Query->insert_id;
                // insert in `exams` table as each course [id] will be connected with only on exam [id]
                $InsertStatement = "INSERT INTO `exams` VALUES (NULL,?)";
                $Query = $ConnectToDatabase->prepare($InsertStatement);
                $Query->bind_param('i', $Inserted_ID);
                $CheckError = $Query->execute();
                $Query->close();
                $ConnectToDatabase->close();
                echo json_encode(array("message" => "Course Is Added"));
            } else
                echo json_encode(array("message" => "Failed To Add Course"));
        } catch (Exception $e) {
            echo json_encode(array("message" => "Course Tag Must be Unique"));
        }
    } else echo json_encode(array("message" => "category_id Is Wrong"));
} else echo json_encode(array("message" => "Admin Is Not Authorized [Sub-Admin]"));

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