<?php
	header('Content-type: application/json; charset=UTF-8');
	
	$labNo = $_GET['labNo'];

	require('connectDB.php');

	$sqlSearchLabNo = "select * from documentlab where docnolab='$labNo';";
	$resultSearchLabNo = mysqli_query($con,$sqlSearchLabNo);

	if($resultSearchLabNo == null)
	{
		echo "คำสั่งผิด";
	}
	
	$numrowSearchLabNo = mysqli_num_rows($resultSearchLabNo); 
	
	$check = 'false';
	
	if($numrowSearchLabNo == 0)
	{
		$check = 'true';
	}
	
	$record_json = new stdClass();
	$record_json->result = $check;

	echo json_encode($record_json);

?>