<?php 
include('connection.php');
$username = $_POST['username'];
$problem = $_POST['problem'];
$mobile = $_POST['mobile'];
$date = $_POST['date'];
$id = $_POST['id'];

$sql = "UPDATE `users` SET  `username`='$username' , `problem`= '$problem', `mobile`='$mobile',  `date`='$date' WHERE id='$id' ";
$query= mysqli_query($con,$sql);
$lastId = mysqli_insert_id($con);
if($query ==true)
{
   
    $data = array(
        'status'=>'true',
    );

    echo json_encode($data);
}
else
{
     $data = array(
        'status'=>'false',
    );

    echo json_encode($data);
} 

?>