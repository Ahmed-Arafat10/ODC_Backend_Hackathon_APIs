<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';


// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
// get id of student
$StudentID = $data->StudentID;
$ConnectToDatabase = ConnectToDataBase();
$SelectStatement = "SELECT * FROM `students` WHERE id = ?";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param('i', $StudentID);
$Query->execute();
$Result = $Query->get_result();
$Num = $Result->num_rows;
//echo json_encode($Num);
// if a record exists with that id
if ($Num) {
    $Fetch = $Result->fetch_assoc();
    extract($Fetch);
    $Student = array(
        'id' => $id,
        'student_name' => $student_name,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'college' => $college,
        'created_at' => $created_at,
    );

    // Close Connection After Executing Query
    $Query->close();
    $ConnectToDatabase->close();
    echo json_encode($Student);
} else echo json_encode(array("message" => "No records"));





/*

{
    "StudentID":1
}

*/