<?php
session_start();
$servername = "localhost";
$usern = "root";
$passw = "";
$databaseName = "aiims3";

$user = $_POST['username'];
$pass = md5($_POST['password']);

// print $pass . "_" . $email;
$conn = mysqli_connect($servername, $usern, $passw, $databaseName);
$query = "SELECT * FROM register WHERE username='$user' AND password='$pass'";
$result = mysqli_query($conn, $query);
$count = mysqli_num_rows($result);
$result_fetch = mysqli_fetch_assoc($result);
if ($count == 1 && $result_fetch['verify_status'] == 1) {

    $_SESSION['email'] = $result_fetch['email'];
    $_SESSION['username'] = $result_fetch['username'];
    if (isset($_POST["remember"])) {

        setcookie("user_login", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
        setcookie("userpassword", $_POST["password"], time() + (10 * 365 * 24 * 60 * 60));
    } else {
        setcookie("user_login", '', time() - (10 * 365 * 24 * 60 * 60));
        setcookie("userpassword", '', time() - (10 * 365 * 24 * 60 * 60));
    }
    $_SESSION['aiims3'] = 'true';
    $message = "Welcome $result_fetch[firstname] $result_fetch[lastname]";
    echo "<script type='text/javascript'>alert('$message');window.location.href='appointment.php'</script>";
}
else if($count == 1 && $result_fetch['verify_status'] == 0)
{
    $message = "Please verify your email and then try to login !";
    echo "<script type='text/javascript'>alert('$message');window.location.href='homepage.php'</script>";
}
else {
    $message = "Invalid Username or Password !";
    echo "<script type='text/javascript'>alert('$message');window.location.href='homepage.php'</script>";
}
?>