<?php
session_start();
$servername = "localhost";
$usern = "root";
$passw = "";
$databaseName = "aiims3";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require('PHPMailer/Exception.php');
require('PHPMailer/PHPMailer.php');
require('PHPMailer/SMTP.php');

$idpat = $_POST['idpat'];
$conn = mysqli_connect($servername, $usern, $passw, $databaseName);

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->SMTPAuth   = true;
$mail->Host       = 'smtp.gmail.com';
$mail->Username   = 'aiims.24x7@gmail.com';
$mail->Password   = 'zlzg xrrl bjqw fpsp';
$mail->SMTPSecure = 'tls';
$mail->Port       = 587;
$mail->setFrom('aiims.24x7@gmail.com', 'AIIMS OPD');
$query = "SELECT * FROM appointment WHERE id LIKE '$idpat%'";
$result = mysqli_query($conn, $query);
$result_fetch = mysqli_fetch_assoc($result);
$date = $result_fetch['apt'];
$doctor = $result_fetch['doctor'];
$problem = $result_fetch['problem'];
if (mysqli_num_rows($result) > 1) {
    $mail->addReplyTo("aiims.24x7@gmail.com");
    while($x = mysqli_fetch_assoc($result))
    {
        $mail->addBCC($x['email'],"AIIMS OPD");
    }
    $mail->isHTML(true);
    $mail->Subject = 'Appointment Cancellation';
    $mail_template = "<h1>Hello There !</h1>
        <h2>We hope this email finds you well, we are very sorry to inform you that your appointment on $result_fetch[apt] under $result_fetch[doctor] of $result_fetch[problem] department has been cancelled.</h2>";
    $mail->Body = $mail_template;
    if ($mail->send()) {
        $message = "Mail Sent !";
        echo "<script type='text/javascript'>alert('$message');window.location.href='online.php'</script>";
    } else {
        $message = "Unable to send mail !";
        echo "<script type='text/javascript'>alert('$message');window.location.href='online.php'</script>";
    }
    $q = "INSERT INTO cancel (doctor, problem, date) VALUES ('$doctor','$problem','$date')";
    $r = mysqli_query($conn, $q);
    $qu = "DELETE FROM appointment WHERE id LIKE '$idpat%'";
    $re = mysqli_query($conn, $qu);
}
else if (mysqli_num_rows($result) == 1)
{
    $mail->addReplyTo("aiims.24x7@gmail.com");
    $mail->addAddress($result_fetch['email']);
    $mail->isHTML(true);
    $mail->Subject = 'Appointment Cancellation';
    $mail_template = "<h1>Hello There !</h1>
    <h2>We hope this email finds you well, we are very sorry to inform you that your appointment on $result_fetch[apt] under $result_fetch[doctor] of $result_fetch[problem] department has been cancelled.</h2>";
    $mail->Body = $mail_template;
    if ($mail->send()) {
        $message = "Mail Sent !";
        echo "<script type='text/javascript'>alert('$message');window.location.href='online.php'</script>";
    } else {
        $message = "Unable to send mail !";
        echo "<script type='text/javascript'>alert('$message');window.location.href='online.php'</script>";
    }
    $q1 = "INSERT INTO cancel (doctor, problem, date) VALUES ('$doctor','$problem','$date')";
    $r1 = mysqli_query($conn, $q1);
    $qu1 = "DELETE FROM appointment WHERE id LIKE '$idpat%'";
    $re1 = mysqli_query($conn, $qu1);
}
else
{
    $message = "Result not found !";
    echo "<script type='text/javascript'>alert('$message');window.location.href='online.php'</script>";
}