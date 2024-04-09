<?php include('connection.php');

$output= array();
$sql = "SELECT id, fullname, email, phone, problem, doctor, apt, apt_time FROM appointment";

$totalQuery = mysqli_query($con,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
	0 => 'id',
	1 => 'fullname',
	2 => 'email',
	3 => 'phone',
	4 => 'problem',
    5 => 'doctor',
    6 => 'apt',
    7 => 'apt_time',
);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE id like '%".$search_value."%'";
	$sql .= " OR fullname like '%".$search_value."%'";
	$sql .= " OR email like '%".$search_value."%'";
	$sql .= " OR phone like '%".$search_value."%'";
    $sql .= " OR problem like '%".$search_value."%'";
	$sql .= " OR doctor like '%".$search_value."%'";
	$sql .= " OR apt like '%".$search_value."%'";
	$sql .= " OR apt_time like '%".$search_value."%'";
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
	$sql .= " ORDER BY id desc";
}

if($_POST['length'] != -1)
{
	$start = $_POST['start'];
	$length = $_POST['length'];
	$sql .= " LIMIT  ".$start.", ".$length;
}	

$query = mysqli_query($con,$sql);
$count_rows = mysqli_num_rows($query);
$data = array();
while($row = mysqli_fetch_assoc($query))
{
	$sub_array = array();
	$sub_array[] = $row['id'];
	$sub_array[] = $row['fullname'];
	$sub_array[] = $row['email'];
	$sub_array[] = $row['phone'];
	$sub_array[] = $row['problem'];
    $sub_array[] = $row['doctor'];
    $sub_array[] = $row['apt'];
	$sub_array[] = $row['apt_time'];
    $data[] = $sub_array;
}

$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$count_rows ,
	'recordsFiltered'=>   $total_all_rows,
	'data'=>$data,
);
echo  json_encode($output);
