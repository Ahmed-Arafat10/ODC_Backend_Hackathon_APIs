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
