<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require('PHPMailer/Exception.php');
require('PHPMailer/PHPMailer.php');
require('PHPMailer/SMTP.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'aiims3';

    $conn = mysqli_connect($host, $user, $pass, $dbname);
    function mail_verify($email)
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth   = true;
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through 
        $mail->Username   = 'aiims.24x7@gmail.com';
        $mail->Password   = 'zlzg xrrl bjqw fpsp';                     //use email password                       //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = 587;
        $mail->setFrom('aiims.24x7@gmail.com', 'AIIMS OPD'); //use email
        $mail->addAddress($email);
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Password Reset from AIIMS OPD';
        $mail_template = "<h1>You have requested for Password Reset with AIIMS Kalyani OPD.</h1>
        <h2><u>Given Details :-</u></h2>
        <h3>Email - $_POST[email]</h3>
        <br>
        <a href = 'http://localhost/KU%20Project(version-8)/forgotpass.php'>Click Me</a>";
        $mail->Body = $mail_template;
        $mail->send();
        return true;
    }

    // checking_email_existance
    $check_email_query = "select email from register where email = '$email' limit 1";
    $check_email_query_run = mysqli_query($conn, $check_email_query);
    if (mysqli_num_rows($check_email_query_run) > 0) {
        mail_verify($email);
        $message = "$email ------- Reset link sent !";
        echo "<script type='text/javascript'>alert('$message');window.close()</script>";
    }
    else {
            $message = "Email does not exist !";
            echo "<script type='text/javascript'>alert('$message');window.location.href='forgot.php'</script>";
        } 
    }
?>