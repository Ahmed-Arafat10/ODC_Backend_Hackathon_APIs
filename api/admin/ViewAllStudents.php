<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';


// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$ConnectToDatabase = ConnectToDataBase();
//select all students
$SelectStatement = "SELECT * FROM `students` ";
$Query = $ConnectToDatabase->query($SelectStatement);
$Num = $Query->num_rows;
//echo json_encode($Num);
// if one or more student exists
if ($Num) {
    // a bigger array where each student [array] will be stored in it
    $AllStudents = array();
    // iterate over each record [student] 
    foreach ($Query as $EachOne) :
        // key which is column name, will be a variable and its value will be assigned to that variable
        extract($EachOne);
        // store data of student in form of key value pairs 
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
    // print data of all students in JSON format
    echo json_encode($AllStudents);
} else echo json_encode(array("message" => "No records"));

