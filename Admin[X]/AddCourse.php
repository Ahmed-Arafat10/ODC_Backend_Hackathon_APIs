<?php

include("../DatabaseConfig/ConfigDB.php");

if (isset($_SESSION['IsAuthorized'])) {

    if (!$_SESSION['IsAuthorized']) {
        PrintMessage("Not Authoerized", "Danger");
        exit;
    }
} else {
    PrintMessage("Not Authoerized", "Danger");
    exit;
}



if (isset($_POST['AddCourseBtn'])) {
    //Name Level Description Category
    $Inserted_ID = NULL;
    $Name = $_POST['Name'];
    $Level = $_POST['Level'];
    $Description = $_POST['Description'];
    $Category = $_POST['Category'];
    $ConnectToDatabase = ConnectToDataBase();
    $InsertStatement = "INSERT INTO `courses` VALUES (NULL,?,?,?,DEFAULT,?)";
    //    $InsertStatement = "Insert * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
    $Query = $ConnectToDatabase->prepare($InsertStatement);
    $Query->bind_param('sssi', $Name, $Level, $Description, $Category);
    $CheckError = $Query->execute();
    $Inserted_ID = $Query->insert_id;
    if ($CheckError) {
        PrintMessage("Done", "Normal");
        $InsertStatement = "INSERT INTO `exams` VALUES (NULL,?)";
        //    $InsertStatement = "Insert * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
        $Query = $ConnectToDatabase->prepare($InsertStatement);
        $Query->bind_param('i', $Inserted_ID);
        $CheckError = $Query->execute();
    } else PrintMessage("Error", "Danger");
    // Close Connection After Executing Query
    $Query->close();
    $ConnectToDatabase->close();
    // If Enterd Username/Email Exists In Database

}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form action="" method="post">

        <label for="">Course Name :</label>
        <input required type="text" name="Name" id="">
        <br>
        <label for="">Course Level :</label>
        <input required type="text" name="Level" id="">
        <br>
        <label for="">Course Description:</label>
        <input required type="text" name="Description" id="">
        <br>

        <label for="">Category</label>
        <select name="Category" id="">
            <?php $ConnectToDataBase = ConnectToDataBase();
            $SelectStataement = "SELECT * FROM `category`";
            $Query = $ConnectToDataBase->query($SelectStataement);
            foreach ($Query as $Category) :
            ?>
                <option value="<?php echo $Category['id'] ?>"> <?php echo $Category['category_name'] ?></option>
            <?php endforeach; ?>
        </select>


        <br>
        <input type="submit" name="AddCourseBtn" value="Add Course">
    </form>


</body>

</html>