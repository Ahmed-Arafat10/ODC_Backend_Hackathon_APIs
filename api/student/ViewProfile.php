<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';
include_once '../../UsedFunction/Functions.php';

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
$ID = $data->ID;

$Token = IsLoggedIn($ID);
if ($Token == 0) {
    echo json_encode(array(
        "message" => "Please Log In First"
    ));
    exit;
}

$ConnectToDatabase = ConnectToDataBase();
$SelectStatement = "SELECT * FROM `students` WHERE id = ?";
//    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param('i', $ID);
$Query->execute();
$Result = $Query->get_result();
$Num = $Result->num_rows;
//echo json_encode($Num);
if ($Num) {
    $Fetch = $Result->fetch_assoc();
    extract($Fetch);
    $StudentData = array(
        'id' => $id,
        'student_name' => $student_name,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'college' => $college,
    );

    // Close Connection After Executing Query
    $Query->close();
    $ConnectToDatabase->close();
    // If Enterd Username/Email Exists In Database
    echo json_encode($StudentData);
} else {
    echo json_encode(array(
        "message" => "No Records"
    ));
}



/*

{
    "ID":4
}

*/

?>

