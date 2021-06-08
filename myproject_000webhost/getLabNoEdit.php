<?php
	header('Content-type: application/json; charset=UTF-8');
	
	$labNo = $_GET['labNo'];
	$labCode = $_GET['labCode'];

	require('connectDB.php');
	
	$sqlSearchLabCode = "select * from lab where labCode='$labCode';";
	$resultSearchLabCode = mysqli_query($con,$sqlSearchLabCode);

	if($resultSearchLabCode == null)
	{
		echo "คำสั่งผิด";
	}
	
	$recnumSearchLabCode = mysqli_fetch_array($resultSearchLabCode);
	
	$check = 'false';
	
	if($recnumSearchLabCode[2]==$labNo)
	{
		$check = 'true';
	
	}else{
	
		$sqlSearchLabNo = "select * from documentlab where docnolab='$labNo';";
		$resultSearchLabNo = mysqli_query($con,$sqlSearchLabNo);

		if($resultSearchLabNo == null)
		{
			echo "คำสั่งผิด";
		}
	
		$numrowSearchLabNo = mysqli_num_rows($resultSearchLabNo); 
		
		if($numrowSearchLabNo == 0)
		{
			$check = 'true';
		}
	
	}
	
	$record_json = new stdClass();
	$record_json->result = $check;

	echo json_encode($record_json);

?>