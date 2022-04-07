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

function IsLoggedInAdmin($AdminID)
{
    $ConnectToDatabase = ConnectToDataBase();
    $SelectStatement = "SELECT * FROM `signedin_admin` WHERE `admin_id` = ?";
    $Query = $ConnectToDatabase->prepare($SelectStatement);
    $Query->bind_param("i", $AdminID);
    $CheckError = $Query->execute();
    $Result = $Query->get_result();
    $Query->close();
    $ConnectToDatabase->close();
    $NumOfRows = $Result->num_rows;
    if ($NumOfRows) return 1;
    else return 0;
}

function PasswordStrength($Password)
{
    // Store Password That Comes From Ajax
    $Uppercase = preg_match('@[A-Z]@', $Password);
    $Lowercase = preg_match('@[a-z]@', $Password);
    $Number = preg_match('@[0-9]@', $Password);
    $SpecialChars = preg_match('@[^\w]@', $Password);
    if (!$Uppercase || !$Lowercase || !$Number || !$SpecialChars || strlen($Password) < 8) return 0;
    else return 1;
}
function CheckEmail($Email,$ConnectToDatabase)
{
    $InsertStatement  = "SELECT * FROM `students` WHERE Email = ? ";
    $Query = $ConnectToDatabase->prepare($InsertStatement);
    $Query->bind_param('s', $Email);
    $CheckError = $Query->execute();
    $Result = $Query->get_result();
    $num = $Result->num_rows;
    return $num;
}
