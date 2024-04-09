<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $new_password = md5($_POST["new_password"]);
    $confirm_password = md5($_POST["confirm_password"]);
    
    // Perform validation
    $errors = array();
    
    // Check if email is valid (you can add more comprehensive email validation)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script type='text/javascript'>alert('Incorrect Email !');window.location.href='forgotpass.php'</script>";
    }
    
    // Check if passwords match
    if ($new_password !== $confirm_password) {
        echo "<script type='text/javascript'>alert('Incorrect Password !');window.location.href='forgotpass.php'</script>";
    }
    
    if (empty($errors)) {
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $dbname = 'aiims3';

        $conn = mysqli_connect($host, $user, $pass, $dbname);
        
        $check_email_query = "select email from register where email = '$email' limit 1";
        $check_email_query_run = mysqli_query($conn, $check_email_query);
    if (mysqli_num_rows($check_email_query_run) > 0) {
        $reset_emailpass_query = "update register set password='$new_password',confirm_password='$confirm_password' where email='$email'";
        $reset_emailpass_query_run=mysqli_query($conn,$reset_emailpass_query);
        $message = "Password reset done successfully, Please login with the newly updated password in the website !";
        echo "<script type='text/javascript'>alert('$message');window.close()</script>";
    }
    else {
            $message = "Email not exist !";
            echo "<script type='text/javascript'>alert('$message');window.location.href='forgotpass.php'</script>";
        }
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}
?>
