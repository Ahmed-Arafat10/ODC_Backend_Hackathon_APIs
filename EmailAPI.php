<?php


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

// Function To Send A Link To Email With OTP To Sign In, Used In [OTP.php] Page
function SendLinkToEmailForOTP($Name, $Email, $OTP)
{
    try {
        $mail = new PHPMailer(true);

        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP

        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'khub.developers.bis@gmail.com'; //SMTP username
        $mail->Password = 'deihpjvttokamdou'; //SMTP password

        $mail->SMTPSecure = "Tls"; //Enable implicit TLS encryption
        $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom("khub.developers.bis@gmail.com", $Name);
        // $mail->addAddress('joe@example.net', 'Joe User');//Add a recipient
        $mail->addAddress($Email); //Name is optional

        $EmailTemplate = "
        <h2>Hello, $Name</h2>
        <h3>This Is An Email For The Generated OTP</h3>
        <br/><br/>
        <p>Your OTP is : <b>$OTP</b> </p>
        <h4>Best Regards</h4>
        <h4>K-Hub Developers</h4>
        <h4>Ahmed Arafat</h4>
        <h4>Ahmed Farag</h4>
        ";
        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Generated OTP';
        $mail->Body = $EmailTemplate;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        //echo 'Message has been sent';
    } catch (Exception $e) {
        PrintMessage("OTP Could Not Be Sent. Error: {$mail->ErrorInfo}", "Danger");
    }
}


// Function To Send A Link To Email To Veify The Created Account, Used In [SignUp.php] Page
function SendLinkToEmailToVerifyAccount($Name, $Email, $Token)
{
    try {
        $mail = new PHPMailer(true);

        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP

        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'khub.developers.bis@gmail.com'; //SMTP username
        $mail->Password = 'deihpjvttokamdou'; //SMTP password

        $mail->SMTPSecure = "Tls"; //Enable implicit TLS encryption
        $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom("khub.developers.bis@gmail.com", $Name);
        // $mail->addAddress('joe@example.net', 'Joe User');//Add a recipient
        $mail->addAddress($Email); //Name is optional

        $EmailTemplate = "
        <h2>Hello, $Name</h2>
        <h3>Please Verify Your Account By Clicking On Below Link</h3>
        <br/><br/>
        <a href='http://localhost/K-Hub/Pages/VerifyYourEmail.php?Token=$Token&Email=$Email'>Click Me</a>
        <h4>Best Regards</h4>
        <h4>K-Hub Developers</h4>
        <h4>Ahmed Arafat</h4>
        <h4>Ahmed Farag</h4>
        ";

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Verify Your Account';
        $mail->Body = $EmailTemplate;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->send();
    } catch (Exception $e) {
        PrintMessage("Email could not be sent. Error: {$mail->ErrorInfo}", "Danger");
    }
}



// Function To Send A Link To Email To Reset Password, Used In [PasswordResetAPI.php] Page
function SendLinkToEmailToResetPassword($Name, $Email, $Token)
{
    try {
        $mail = new PHPMailer(true);

        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;//Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP

        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'khub.developers.bis@gmail.com'; //SMTP username
        $mail->Password = 'deihpjvttokamdou'; //SMTP password

        $mail->SMTPSecure = "Tls"; //Enable implicit TLS encryption
        $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom("khub.developers.bis@gmail.com", $Name);
        // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
        $mail->addAddress($Email);               //Name is optional

        $EmailTemplate = "
        <h2>Hello, $Name</h2>
        <h3>You Are Receiving This Email Because We Recieved A Password Reset Request For Your Account</h3>
        <h3>Click On Below Link To Reset Your Pasasword</h3>
        <br/><br/>
        <a href='http://localhost/K-Hub/Pages/PasswordChangeRequested.php?Token=$Token&Email=$Email'>Click Me</a>
        <h4>Best Regards</h4>
        <h4>K-Hub Developers</h4>
        <h4>Ahmed Arafat</h4>
        <h4>Ahmed Farag</h4>
        ";
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Reset Password Notification';
        $mail->Body    = $EmailTemplate;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
    } catch (Exception $e) {
        PrintMessage("Email could not be sent. Error: {$mail->ErrorInfo}", "Danger");
    }
}


// Function To Send An Email To User To Inform Him/Her That Password Is Changed, Used In [ChangePassword.php] Page
function InformUserThatPasswordHasChanged($Name, $Email)
{
    try {
        $mail = new PHPMailer(true);

        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;//Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP

        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'khub.developers.bis@gmail.com'; //SMTP username
        $mail->Password = 'deihpjvttokamdou'; //SMTP password

        $mail->SMTPSecure = "Tls"; //Enable implicit TLS encryption
        $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom("khub.developers.bis@gmail.com", $Name);
        // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
        $mail->addAddress($Email);               //Name is optional

        $EmailTemplate = "
        <h2>Hello, $Name</h2>
        <h3>Your Password Has Been Changed Successfully</h3>
        <h3>If You Think That Something Is Wrong Please Contact K-Hub Developers ASAP</h3>
        <br/><br/>
        <h4>Best Regards</h4>
        <h4>K-Hub Developers</h4>
        <h4>Ahmed Arafat</h4>
        <h4>Ahmed Farag</h4>
        ";
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Your Password Has Been Changed';
        $mail->Body    = $EmailTemplate;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
    } catch (Exception $e) {
        PrintMessage("Email could not be sent. Error: {$mail->ErrorInfo}", "Danger");
    }
}

function SendInterviewDetails($Name,$Email,$Details)
{
    try {
        $mail = new PHPMailer(true);

        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP

        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'khub.developers.bis@gmail.com'; //SMTP username
        $mail->Password = 'deihpjvttokamdou'; //SMTP password

        $mail->SMTPSecure = "Tls"; //Enable implicit TLS encryption
        $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom("khub.developers.bis@gmail.com", $Name);
        // $mail->addAddress('joe@example.net', 'Joe User');//Add a recipient
        $mail->addAddress($Email); //Name is optional

        $EmailTemplate = "
        <h2>Hello, $Name</h2>
        <h3>This Is An Email For Details Of Interview</h3>
        <br/><br/>
        <p>$Details </p>
        <h4>Best Regards</h4>
        <h4>Orange Digital Center</h4>
        ";
        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Congratulations, You Passed The Exam';
        $mail->Body = $EmailTemplate;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        //echo 'Message has been sent';
    } catch (Exception $e) {
        PrintMessage("OTP Could Not Be Sent. Error: {$mail->ErrorInfo}", "Danger");
    }
}




function SendEmailToVerifyAcc($Name, $Email, $Token)
{
    try {
        $mail = new PHPMailer(true);

        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP

        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'khub.developers.bis@gmail.com'; //SMTP username
        $mail->Password = 'deihpjvttokamdou'; //SMTP password

        $mail->SMTPSecure = "Tls"; //Enable implicit TLS encryption
        $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom("khub.developers.bis@gmail.com", $Name);
        // $mail->addAddress('joe@example.net', 'Joe User');//Add a recipient
        $mail->addAddress($Email); //Name is optional

        $EmailTemplate = "
        <h2>Hello, $Name</h2>
        <h3>This Is An Email To Verify Your New Account</h3>
        <br/><br/>
        <p>Your Your Token is : <b>$Token</b> </p>
        <h4>Best Regards</h4>
        <h4>K-Hub Developers</h4>
        <h4>Ahmed Arafat</h4>
        <h4>Ahmed Farag</h4>
        ";
        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Verify Your New Account';
        $mail->Body = $EmailTemplate;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        //echo 'Message has been sent';
    } catch (Exception $e) {
        PrintMessage("OTP Could Not Be Sent. Error: {$mail->ErrorInfo}", "Danger");
    }
}
