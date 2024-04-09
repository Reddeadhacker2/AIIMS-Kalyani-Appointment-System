<?php
session_start();
$servername = "localhost";
$usern = "root";
$passw = "";
$databaseName = "aiims3";

$user = $_POST['username'];
$pass = md5($_POST['password']);

$conn = mysqli_connect($servername, $usern, $passw, $databaseName);
$query = "SELECT * FROM admin WHERE username='$user' AND password ='$pass'";
$result = mysqli_query($conn, $query);
$count = mysqli_num_rows($result);

if ($count>0) {
    $_SESSION['login'] = 'true';
    $message = "Welcome Admin $_POST[username] !";
    echo "<script type='text/javascript'>alert('$message');window.location.href='crud.php'</script>";
}

else {
    $_SESSION['login'] = 'false';
    $message = "Invalid Username or Password !";
    echo "<script type='text/javascript'>alert('$message');window.location.href='admin.php'</script>";
}
?>