
<?php
// SendExamCode.php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';
include_once '../../EmailAPI.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
// we will use admin id to check if he is authorized
// while student id & course id to check in `student_course_enroll` table
$AdminID = $data->AdminID;
$StudentID = $data->StudentID;
$CourseID = $data->CourseID;

$IsAuthourized = CheckIfAdminIsAuthorized($AdminID);
if ($IsAuthourized == 1) {
    $ConnectToDatabase = ConnectToDataBase();

    /* check first if student id & course id both are right [student with that id has really
    enrolled in course of that id] */
    $SelectStatement = "SELECT * FROM `student_course_enroll` WHERE `course_id` = ? AND `student_id` = ? ";
    $Query = $ConnectToDatabase->prepare($SelectStatement);
    $Query->bind_param("ii", $CourseID, $StudentID);
    $Query->execute();
    $Result = $Query->get_result();
    $Num = $Result->num_rows;
    if (!$Num) {
        echo json_encode(array("message" => "No Such StudentID Enrolled In That CourseID"));
        exit;
    } else {
        // check if code is previously send to student [code column is not null in that case]
        $Fetch = $Result->fetch_assoc();
        $Code = $Fetch['Code'];
        if ($Code != NULL) {
            echo json_encode(array("message" => "Code Is Already Sent"));
            exit;
        }
    }
    /* here i will search for all students that has a code in a specific course [id] then 
    then concatenate course tag along with number of rows + 1 [if you have 3 students
     then next code must be 3+1 -> this means that 4th student has now a code] */
    $SelectStatement = "SELECT * FROM `student_course_enroll` WHERE `course_id` = ? AND `Code` IS NOT NULL";
    $Query = $ConnectToDatabase->prepare($SelectStatement);
    $Query->bind_param("i", $CourseID);
    $Query->execute();
    $Result = $Query->get_result();
    $Num = $Result->num_rows;
    //46825 is just a standard number, so numbers dont start from 1 so user doent know number of users enrolled
    $GeneratedNumber = 46825 + $Num + 1;
    // get course tag with entered course id
    $SelectStatement = "SELECT * FROM `courses` WHERE `id` = ?";
    $Query = $ConnectToDatabase->prepare($SelectStatement);
    $Query->bind_param("i", $CourseID);
    $Query->execute();
    $Result = $Query->get_result();
    $Fetch = $Result->fetch_assoc();
    // course tag
    $CourseTag = $Fetch['Course_Tag'];
    //concatenate both code + generated number  DS + 46829 = DS46829
    $Code =  $CourseTag . $GeneratedNumber;
    //echo json_encode($Code);   
    // now updated record to save new generated code + date of generating it [to check later if code has passed 2 days then user wont bel able to make exam] 
    $UpdateStatement = "UPDATE `student_course_enroll` SET `Code` = ? , `Code_Date` = NOW() WHERE `student_id` = ? AND `course_id` = ?";
    $Query = $ConnectToDatabase->prepare($UpdateStatement);
    $Query->bind_param("sii", $Code, $StudentID, $CourseID);
    $CheckError = $Query->execute();
    if ($CheckError) {
        // get data of user that will be used to send him an email
        $SelectStatement = "SELECT * FROM `students` WHERE `id` = ? LIMIT 1";
        $Query = $ConnectToDatabase->prepare($SelectStatement);
        //$Date = "date('Y-m-d H:i:s')"; #Debug
        $Query->bind_param("s", $Email);
        $CheckError = $Query->execute();
        $Result = $Query->get_result();
        $Fetch = $Result->fetch_assoc();
        $Username = $Fetch['student_name'];
        $Email = $Fetch['email'];
        // send him the code
        SendCodeToEmail($Username, $Email, $Code);
        echo json_encode(array("message" => "Code Is Sent"));
    } else echo json_encode(array("message" => "Something Went Wrong"));
} else echo json_encode(array("message" => "Admin Is Not Authorized [Sub-Admin]"));

/*


{
"AdminID":1,
"StudentID":1,
"CourseID":24
}


*/