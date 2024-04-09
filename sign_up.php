<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require('PHPMailer/Exception.php');
require('PHPMailer/PHPMailer.php');
require('PHPMailer/SMTP.php');

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $confirm_password = md5($_POST['confirm_password']);
    $verify_token = bin2hex(random_bytes(16));

    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'aiims3';

    // function maskPassword($password){
    
    //     $mask_number =  substr($password, -4) . str_repeat("*", strlen($password)-4);
        
    //     return $mask_number;
    // }

    // maskPassword($password);

    $conn = mysqli_connect($host, $user, $pass, $dbname);
    function mail_verify($email, $verify_token)
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth   = true;
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through 
        $mail->Username   = 'aiims.24x7@gmail.com';
        $mail->Password   = 'zlzg xrrl bjqw fpsp';                      //use email password                       //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = 587;
        $mail->setFrom('aiims.24x7@gmail.com', 'AIIMS OPD'); //use email
        $mail->addAddress($email);
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Email Verification from AIIMS OPD';
        $mail_template = "<h1>You have registered with AIIMS Kalyani OPD</h1>
        <h2><u>Given Details :-</u></h2>
        <h3>Name - $_POST[firstname] $_POST[lastname]</h3>
        <h3>Email - $_POST[email]</h3>
        <h3>Username - $_POST[username]</h3>
        <h3>Password - XX*****XX</h3>
        <br>
        <h3>If you have given this details, verify your email address by clicking the link given below</h3>
        <a href = 'http://localhost/KU%20Project(version-8)/verify-email.php?email=$email&verify_token=$verify_token'>Click Me</a>
        <h3><b><u>If you have not given this details, ignore this email</u></b></h3>";
        $mail->Body = $mail_template;
        $mail->send();
        return true;
    }

    // checking_email_existance
    $check_email_query = "select email from register where email = '$email' limit 1";
    $check_email_query_run = mysqli_query($conn, $check_email_query);
    // checking username existance
    $check_username_query = "select username from register where username = '$username' limit 1";
    $check_username_query_run = mysqli_query($conn, $check_username_query);
    if (mysqli_num_rows($check_email_query_run) > 0) {
        $message = "$_POST[username] ------- Email already exists !";
        echo "<script type='text/javascript'>alert('$message');window.location.href='homepage.php'</script>";
    }
    else if (mysqli_num_rows($check_username_query_run) > 0) {
        $message = "$_POST[username] ------- Username already exists !";
            echo "<script type='text/javascript'>alert('$message');window.location.href='homepage.php'</script>";
    }
    else {
        $sql = "insert into register(firstname, lastname, email, username, password, confirm_password, verify_token)values('$firstname','$lastname','$email','$username','$password','$confirm_password','$verify_token')";
        if (mysqli_query($conn, $sql) && mail_verify($_POST['email'],$verify_token)) {
            $message = "Registration Successful, Please verify your Email !";
            echo "<script type='text/javascript'>alert('$message');window.location.href='homepage.php'</script>";
        } else {
            $message = "Server Down !";
            echo "<script type='text/javascript'>alert('$message');window.location.href='homepage.php'</script>";
        }
    }
}
?>