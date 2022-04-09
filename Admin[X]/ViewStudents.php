<?php
include("../DatabaseConfig/ConfigDB.php");
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
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">College</th>
                <th scope="col">Address</th>
            </tr>
        </thead>
        <tbody>

        <?php
    $ConnectToDataBase = ConnectToDataBase();
    $SelectStataement = "SELECT * FROM `students`";
    $Query = $ConnectToDataBase->query($SelectStataement);
    foreach($Query as $Student):    
            ?>
            <tr>
                <th scope="row">1</th>
                <td><?php echo $Student['student_name']; ?></td>
                <td><?php echo $Student['email']; ?></td>
                <td><?php echo $Student['phone']; ?></td>
                <td><?php echo $Student['address']; ?></td>
                <td><?php echo $Student['college']; ?></td>
            </tr>
       <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>