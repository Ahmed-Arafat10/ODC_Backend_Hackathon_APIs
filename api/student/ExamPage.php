<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../DatabaseConfig/ConfigDB.php';


// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
$ExamID = $data->ExamID;
$ConnectToDatabase = ConnectToDataBase();
$SelectStatement = "SELECT * FROM `questions` WHERE `exam_id` = ?";
//    $SelectStatement = "SELECT * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
$Query = $ConnectToDatabase->prepare($SelectStatement);
$Query->bind_param("i", $ExamID);
$Query->execute();
$Result = $Query->get_result();
$Num = $Result->num_rows;
//echo json_encode($Num);
if ($Num) {
    $AllStudents= array();
    $cnt = 1;
    foreach ($Result as $EachOne) :
        extract($EachOne);
        $Item = array(
                'id' => $id,
                'question' => $question,
                'choice1' => $choice1,
                'choice2' => $choice2,
                'choice3' => $choice3,
                'choice4' => $choice4,
                'answer' => $answer,
                'exam_id' => $exam_id
           
        );
        array_push($AllStudents, $Item);
        $cnt++;
    endforeach;

    // Close Connection After Executing Query
    $Query->close();
    $ConnectToDatabase->close();
    // If Enterd Username/Email Exists In Database
    // echo json_encode($AllStudents[1]);
    $sz = count($AllStudents);
    $RandQuestion = array();
    $Keys = array();
    $x = 1;
    while (count($RandQuestion) != 15) {
        $Rang = rand() % count($AllStudents);
        if (!in_array($Rang, $Keys)) {
            $RandQuestion["Q".$x] = $AllStudents[$Rang];
            $Keys[] = $Rang;
            $x++;
        }
    }
    echo json_encode($RandQuestion);
    //echo json_encode(count($RandQuestion));
} else {
    echo json_encode(array(
        "message" => "No records"
    ));
}

/*

{
    "ExamID":1
}





{
    "day": [],
    "0": {
        "27": {
            "id": 33,
            "question": "Question Number #26",
            "choice1": "MSQ 1",
            "choice2": "MSQ 2",
            "choice3": "MSQ 3",
            "choice4": "MSQ 4",
            "answer": "4"
        }
    },
    "1": {
        "74": {
            "id": 80,
            "question": "Question Number #73",
            "choice1": "MSQ 1",
            "choice2": "MSQ 2",
            "choice3": "MSQ 3",
            "choice4": "MSQ 4",
            "answer": "4"
        }
    },
    "2": {
        "82": {
            "id": 88,
            "question": "Question Number #81",
            "choice1": "MSQ 1",
            "choice2": "MSQ 2",
            "choice3": "MSQ 3",
            "choice4": "MSQ 4",
            "answer": "4"
        }
    },
    "3": {
        "11": {
            "id": 17,
            "question": "Question Number #10",
            "choice1": "MSQ 1",
            "choice2": "MSQ 2",
            "choice3": "MSQ 3",
            "choice4": "MSQ 4",
            "answer": "4"
        }
    },
    "4": {
        "31": {
            "id": 37,
            "question": "Question Number #30",
            "choice1": "MSQ 1",
            "choice2": "MSQ 2",
            "choice3": "MSQ 3",
            "choice4": "MSQ 4",
            "answer": "4"
        }
    },
    "5": {
        "83": {
            "id": 89,
            "question": "Question Number #82",
            "choice1": "MSQ 1",
            "choice2": "MSQ 2",
            "choice3": "MSQ 3",
            "choice4": "MSQ 4",
            "answer": "4"
        }
    },
    "6": {
        "85": {
            "id": 91,
            "question": "Question Number #84",
            "choice1": "MSQ 1",
            "choice2": "MSQ 2",
            "choice3": "MSQ 3",
            "choice4": "MSQ 4",
            "answer": "4"
        }
    },
    "7": {
        "97": {
            "id": 103,
            "question": "Question Number #96",
            "choice1": "MSQ 1",
            "choice2": "MSQ 2",
            "choice3": "MSQ 3",
            "choice4": "MSQ 4",
            "answer": "4"
        }
    },
    "8": {
        "87": {
            "id": 93,
            "question": "Question Number #86",
            "choice1": "MSQ 1",
            "choice2": "MSQ 2",
            "choice3": "MSQ 3",
            "choice4": "MSQ 4",
            "answer": "4"
        }
    },
    "9": {
        "42": {
            "id": 48,
            "question": "Question Number #41",
            "choice1": "MSQ 1",
            "choice2": "MSQ 2",
            "choice3": "MSQ 3",
            "choice4": "MSQ 4",
            "answer": "4"
        }
    },
    "10": {
        "94": {
            "id": 100,
            "question": "Question Number #93",
            "choice1": "MSQ 1",
            "choice2": "MSQ 2",
            "choice3": "MSQ 3",
            "choice4": "MSQ 4",
            "answer": "4"
        }
    },
    "11": {
        "36": {
            "id": 42,
            "question": "Question Number #35",
            "choice1": "MSQ 1",
            "choice2": "MSQ 2",
            "choice3": "MSQ 3",
            "choice4": "MSQ 4",
            "answer": "4"
        }
    },
    "12": {
        "48": {
            "id": 54,
            "question": "Question Number #47",
            "choice1": "MSQ 1",
            "choice2": "MSQ 2",
            "choice3": "MSQ 3",
            "choice4": "MSQ 4",
            "answer": "4"
        }
    },
    "13": {
        "60": {
            "id": 66,
            "question": "Question Number #59",
            "choice1": "MSQ 1",
            "choice2": "MSQ 2",
            "choice3": "MSQ 3",
            "choice4": "MSQ 4",
            "answer": "4"
        }
    }
}


*/