<?php
$username = $_POST['username'];
$password = md5($_POST['password']);

// Establish database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'aiims3';

$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sample insert query
$sql = "INSERT INTO `admin` (`username`,`password`) values ('$username', '$password')";

if ($conn->query($sql) === TRUE) {
    // Alert message
    echo "<script>alert('Admin added successfully !');</script>";
    // Redirect to a specific page
    echo "<script>window.location.href = 'crud.php';</script>";
} else {
    $message = "Failed to add admin !";
    echo "<script type='text/javascript'>alert('$message');window.location.href='crud.php</script>";
}

$conn->close();
?>
