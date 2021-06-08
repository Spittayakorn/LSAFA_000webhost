<?php
	
	$labCode = $_POST['labCode'];
	$catCode = $_POST['catCode'];
	$anaCode = $_POST['anaCode'];
	$simCode = $_POST['simCode'];
	
	require('connectDB.php');

	$sqlSearchCheckAna = "select da.daCode,da.volume,da.repeats,da.labCode,da.scCode,sc.scCode,sc.catCode,sc.anaCode,sc.simCode,sc.price from dataanalysis as da,servicechargelist as sc where da.scCode=sc.scCode and da.labCode='$labCode' and catCode='$catCode' and anaCode='$anaCode' and simCode='$simCode';";

	$resultSearchCheckAna = mysqli_query($con,$sqlSearchCheckAna);

	if($resultSearchCheckAna==null)
	{
		echo "คำสั่งผิด";
	}
	
	$check ='false';
	$numRowSearchCheckAna = mysqli_num_rows($resultSearchCheckAna);
	if($numRowSearchCheckAna != 0)
	{
		$check ='true';
	}

	echo $check;

?>