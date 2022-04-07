
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $JSON = file_get_contents('php://input');
    $date = json_decode(($JSON));
    echo json_encode($date->email);
    //print_r($JSON);
//

}



if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $JSON = file_get_contents('php://input');
    $date = json_decode(($JSON));
    echo json_encode($date->email);
    //print_r($JSON);
//

}

if($_SERVER['REQUEST_METHOD'] == 'PATCH')
{
    $JSON = file_get_contents('php://input');
    $date = json_decode(($JSON));
    echo json_encode($date->email);
    //print_r($JSON);
//

}
?>