
<?php
// SendExamCode.php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
$AdminID = $data->AdminID;
$StudentID = $data->StudentID;
$CourseID = $data->CourseID;
$IsAuthourized = CheckIfAdminIsAuthorized($AdminID);
if ($IsAuthourized == 1) {
    $ConnectToDatabase = ConnectToDataBase();

    $SelectStatement = "SELECT * FROM `student_course_enroll` WHERE `course_id` = ? AND `student_id` = ? ";
    $Query = $ConnectToDatabase->prepare($SelectStatement);
    $Query->bind_param("ii", $CourseID, $StudentID);
    $Query->execute();
    $Result = $Query->get_result();
    $Num = $Result->num_rows;
    if (!$Num) {
        echo json_encode(array(
            "message" => "No Such StudentID Enrolled In That CourseID"
        ));
        exit;
    } else {
        $Fetch = $Result->fetch_assoc();
        $Code = $Fetch['Code'];
        if ($Code != NULL) {
            echo json_encode(array(
                "message" => "Code Is Already Sent"
            ));
            exit;
        }
    }
    $SelectStatement = "SELECT * FROM `student_course_enroll` WHERE `course_id` = ? AND `Code` IS NOT NULL";
    $Query = $ConnectToDatabase->prepare($SelectStatement);
    $Query->bind_param("i", $CourseID);
    $Query->execute();
    $Result = $Query->get_result();
    $Num = $Result->num_rows;
    //echo json_encode($Num);
    $GeneratedNumber = 46825 + $Num + 1;

    $SelectStatement = "SELECT * FROM `courses` WHERE `id` = ?";
    $Query = $ConnectToDatabase->prepare($SelectStatement);
    $Query->bind_param("i", $CourseID);
    $Query->execute();
    $Result = $Query->get_result();
    $Fetch = $Result->fetch_assoc();
    $CourseTag = $Fetch['Course_Tag'];
    $Code =  $CourseTag . $GeneratedNumber;
    //echo json_encode($Code);    
    $UpdateStatement = "UPDATE `student_course_enroll` SET `Code` = ? , `Code_Date` = NOW() WHERE `student_id` = ? AND `course_id` = ?";
    $Query = $ConnectToDatabase->prepare($UpdateStatement);
    $Query->bind_param("sii",$Code, $StudentID, $CourseID);
    $CheckError = $Query->execute();
    if ($CheckError) echo json_encode(array(
        "message" => "Code Is Sent"
    ));
    else  echo json_encode(array(
        "message" => "Something Went Wrong"
    ));
} else echo json_encode(array(
    "message" => "Admin Is Not Authorized [Sub-Admin]"
));

/*


{
"AdminID":1,
"StudentID":1,
"CourseID":24
}

*/