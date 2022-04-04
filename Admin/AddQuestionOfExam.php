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



if (isset($_POST['AddQuestionBtn'])) {
    //Name Level Description Category
    //Question Choice1 Choice2 Choice3 Choice4 Answer Exam_ID
    $Question = $_POST['Question'];
    $Choice1 = $_POST['Choice1'];
    $Choice2 = $_POST['Choice2'];
    $Choice3 = $_POST['Choice3'];
    
    $Choice4 = $_POST['Choice4'];
    $Answer = $_POST['Answer'];
    $Exam_ID = $_POST['Exam_ID'];

    $ConnectToDatabase = ConnectToDataBase();
    $InsertStatement = "INSERT INTO `questions` VALUES (NULL,?,?,?,?,?,?,?)";
    //    $InsertStatement = "Insert * FROM `admin` WHERE `admin_username` = ? OR `password` = ? LIMIT 1";
    $Query = $ConnectToDatabase->prepare($InsertStatement);
    $Query->bind_param('ssssssi', $Question, $Choice1, $Choice2, $Choice3,$Choice4,$Answer,$Exam_ID);
    $CheckError = $Query->execute();
    $Inserted_ID = $Query->insert_id;
    if ($CheckError) {
        PrintMessage("Done", "Normal");
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

        <label for="">Question:</label> 
        <input required type="text" name="Question" id="">
        <br>
        
        <label for="">Choice 1:</label>
        <input required type="text" name="Choice1" id="">
        <br>
        
        <label for="">Choice 2:</label>
        <input required type="text" name="Choice2" id="">
        <br>
        
        <label for="">Choice 3:</label>
        <input required type="text" name="Choice3" id="">
        <br>

        <label for="">Choice 4:</label>
        <input required type="text" name="Choice4" id="">
        <br>

        <label for="">Answer:</label>
        <input required type="text" name="Answer" id="">
        <br>

        <label for="">Exam For Course: </label>
        <select name="Exam_ID" id="">
            <?php $ConnectToDataBase = ConnectToDataBase();
            $SelectStatement = "SELECT exams.id As Exam__ID ,
            courses.course_name AS CourseName
            FROM `exams`
            INNER JOIN courses
            ON exams.course_id = courses.id";
            $Query = $ConnectToDataBase->query($SelectStatement);
            foreach ($Query as $Courses) :
            ?>
                <option value="<?php echo $Courses['Exam__ID'] ?>"> <?php echo $Courses['CourseName'] ?></option>
            <?php endforeach; ?>
        </select>


        <br>
        <input type="submit" name="AddQuestionBtn" value="Add Question">
    </form>


</body>

</html>


