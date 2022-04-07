
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$UserID = $data->ID;

$Token = IsLoggedIn($UserID);
if ($Token == 0) {
    echo json_encode(array(
        "message" => "Please Log In First"
    ));
    exit;
}



$student_name = $data->student_name;
$email = $data->email;
$password = $data->password;
$Hashed = password_hash($password, PASSWORD_DEFAULT);
$phone = $data->phone;
$address = $data->address;
$college = $data->college;
$ConnectToDatabase = ConnectToDataBase();
$SelectStatement = "UPDATE `students` SET `student_name` = ? ,
`email` = ? ,
`password` = ? ,
`phone` = ? ,
`address` = ? ,
`college` = ? 
 WHERE id = ?";
//    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param('ssssssi', $student_name, $email, $Hashed, $phone, $address, $college, $UserID);
try {
    $ErrorCheck = $Query->execute();
    if ($ErrorCheck) {
        echo json_encode(array(
            "message" => "Your Profile Is Updated"
        ));
    } else {
        echo json_encode(array(
            "message" => "Failed To Update Course Your Profile"
        ));
    }
} catch (Exception $e) {
    echo json_encode(array(
        "message" => "Please Try Again"
    ));
}
//echo json_encode($Num);



/*
student_name email password phone address college
{
    "ID":4,
    "student_name":"HISOKA",
    "email": "ahmedmoyousry.bis@gmail.com",
    "password": "123",
    "phone": "0101376",
    "address": "Haram",
    "college": "BIS"
}

*/
?>
