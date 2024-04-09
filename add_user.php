<?php 
include('connection.php');
$username = $_POST['username'];
$problem = $_POST['problem'];
$mobile = $_POST['mobile'];
$date = $_POST['date'];

$sql = "INSERT INTO `users` (`username`,`mobile`,`problem`,`date`) values ('$username', '$mobile', '$problem', '$date' )";
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