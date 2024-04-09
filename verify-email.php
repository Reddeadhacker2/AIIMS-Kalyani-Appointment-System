<?php
session_start();
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'aiims3';
$conn = mysqli_connect($host, $user, $pass, $dbname);

if (isset($_GET['email']) && isset($_GET['verify_token'])) {
    $query = "select * from register where email='$_GET[email]' and verify_token = '$_GET[verify_token]'";
    $result1 = mysqli_query($conn, $query);
    if ($result1) {
        if (mysqli_num_rows($result1) == 1) {
            $result1_fetch = mysqli_fetch_assoc($result1);
            if ($result1_fetch['verify_status'] == 0) {
                $update = "update register set verify_status = 1 where email = '$result1_fetch[email]'";
                if(mysqli_query($conn,$update))
                {
                    $message = "Email verification successful !";
                echo "<script type='text/javascript'>alert('$message');window.location.href='logged_out.php'</script>";
                }
                else{
                    $message = "Cannot run query !";
                echo "<script type='text/javascript'>alert('$message');window.location.href='logged_out.php'</script>";
                }
            } else {
                $message = "Email already verified !";
                echo "<script type='text/javascript'>alert('$message');window.location.href='logged_out.php'</script>";
            }
        }
        else
        {
            $message = "Not found !";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    } else {
        $message = "Server Down !";
        echo "<script type='text/javascript'>alert('$message');window.location.href='logged_out.php'</script>";
    }
}
?>