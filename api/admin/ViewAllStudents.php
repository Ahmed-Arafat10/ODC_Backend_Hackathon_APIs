<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';


// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
$ConnectToDatabase = ConnectToDataBase();
$SelectStatement = "SELECT * FROM `students` ";
//    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
$Query = $ConnectToDatabase->query($SelectStatement);
$Num = $Query->num_rows;
echo json_encode($Num);
if ($Num) {
    $AllStudents = array();
    foreach ($Query as $EachOne) :
        extract($EachOne);
        $Item = array(
            'id' => $id,
            'student_name' => $student_name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'college' => $college,
            'created_at' => $created_at,
        );
        array_push($AllStudents, $Item);
    endforeach;

    // Close Connection After Executing Query
    $Query->close();
    $ConnectToDatabase->close();
    // If Enterd Username/Email Exists In Database
    echo json_encode($AllStudents);
} else {
    echo json_encode(array(
        "message" => "No records"
    ));
}
