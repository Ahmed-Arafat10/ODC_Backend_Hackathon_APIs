<?php

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
    <?php 
     $Pass = "123";
   $HashedPass =  password_hash($Pass,PASSWORD_DEFAULT);
   echo  "<h1>$HashedPass</h1>" ;
 ?>   
</body>
</html>