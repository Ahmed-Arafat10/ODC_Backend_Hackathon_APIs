<?php
function CheckIfAdminIsAuthorized($AdminID)
{
    $ConnectToDatabase = ConnectToDataBase();
    $SelectStatement  = "SELECT * FROM `admin` WHERE id = ?";
    $Query = $ConnectToDatabase->prepare($SelectStatement);
    $Query->bind_param('i', $AdminID);
    $CheckError = $Query->execute();
    $Result = $Query->get_result();
    $Fetch = $Result->fetch_assoc();
    return $Fetch['authorized'];
}


function IsLoggedIn($UserID)
{
    $ConnectToDatabase = ConnectToDataBase();
    $SelectStatement = "SELECT * FROM `signedin` WHERE `user_id` = ?";
    $Query = $ConnectToDatabase->prepare($SelectStatement);
    $Query->bind_param("i", $UserID);
    $CheckError = $Query->execute();
    $Result = $Query->get_result();
    $Query->close();
    $ConnectToDatabase->close();
    $NumOfRows = $Result->num_rows;
    if ($NumOfRows) return 1;
    else return 0;
}
