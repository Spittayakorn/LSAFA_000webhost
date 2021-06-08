<?php
	header('Content-type: application/json; charset=UTF-8');
	
	$facCode = $_GET['facCode'];
	//$facCode = '001';
	
	require('connectDB.php');	
	
	$sqlDep = "select * from department where facCode='$facCode';";
	$resultDep = mysqli_query($con,$sqlDep);
	
	if($resultDep == null)
	{
		echo "คำสั่งผิด";
	}

	$result_json = array();
	$i = 0;

	while($recnumDep = mysqli_fetch_array($resultDep))
	{
		$record_json = new stdClass();
		$record_json->depCode = $recnumDep[0];
		$record_json->depName = $recnumDep[1];
		$record_json->facCode = $recnumDep[2];
		$result_json[$i] = ($record_json); 
		$i++;
	}
	
	echo json_encode($result_json);
	
?>