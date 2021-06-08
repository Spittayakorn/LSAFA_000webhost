<?php
	header('Content-type: application/json; charset=UTF-8');
	
	$labCode = $_GET['labCode'];

	require('connectDB.php');

	$sqlSearchLab = "select * from lab where labCode='$labCode'";
	$resultSearchLab = mysqli_query($con,$sqlSearchLab);

	if($resultSearchLab == null)
	{
		echo "คำสั่งผิด";
	}

	$recnumSearchLab = mysqli_fetch_array($resultSearchLab);

	$sqlSearchAna = "select * from analysislist;";
	$resultSearchAna = mysqli_query($con,$sqlSearchAna);
													
	if($resultSearchAna == null)
	{
		echo "คำสั่งผิด";
	}
													
													
	function getSimName($labCode,$anaCode)
	{
		require('connectDB.php');
														
		$simName= '';
		$sumSim = 0;
		$repeat = 0;
													
		$sqlSearchAna = "select da.daCode,da.volume,da.repeats,da.labCode,da.scCode,sc.scCode,sc.catCode,sc.anaCode,sc.simCode,sc.price,sl.simCode,sl.simName from dataanalysis as da,servicechargelist as sc,simplelist as sl where da.scCode=sc.scCode and sc.simCode=sl.simCode and da.labCode='$labCode' and anaCode='$anaCode';";
													
		$resultSearchAna = mysqli_query($con,$sqlSearchAna);
													
		if($resultSearchAna== null)
		{
			echo "คำสั่งผิด";
		}
														
		$numRowSearchAna = mysqli_num_rows($resultSearchAna);
													
		if($numRowSearchAna!=0)
		{
			$count = 1;
					
			while($recnumSearchAna = mysqli_fetch_array($resultSearchAna))
			{
				$simName .= $recnumSearchAna[11];
				$sumSim += $recnumSearchAna[1];
				$repeat = $recnumSearchAna[2];							
				if($count != $numRowSearchAna)
				{
					$simName .= " ,";
				}
				$count++;
			}
		}
														
		return array($simName,$sumSim,$repeat);
	}
													
													
	function getCharge($anaCode,$catCode)
	{
		require('connectDB.php');
		$price = 0;
													
		$sqlSearchCharge = "select * from servicechargelist where anaCode='$anaCode' and catCode='$catCode' limit 1;";
														
		$resultSearchCharge = mysqli_query($con,$sqlSearchCharge);
													
		if($resultSearchCharge == null)
		{
			echo "คำสั่งผิด";
		}
														
		$numRowSearchCharge = mysqli_num_rows($resultSearchCharge);
													
		if($numRowSearchCharge !=0)
		{
			$recnumSearchCharge = mysqli_fetch_array($resultSearchCharge);
			$price = $recnumSearchCharge[4];
		}
													
		return $price;
	}
													
	$j = 0;
	$sumTotalAna = 0;
	while($recnumSearchAna = mysqli_fetch_array($resultSearchAna))
	{												
		list($getSimName,$getSumSim,$getRepeat) = getSimName($labCode,$recnumSearchAna[0]);
														
		//คำนวณในแต่ละค่าวิเคราะห์
		$anaVal = 0;
														
		if($getSimName!='')
		{
			$json_record = new stdClass();
			
			$json_record->labCode = $labCode;
			$json_record->anaCode = $recnumSearchAna[0];
			$json_record->repeat = $getRepeat;
			$result_json[$j] = ($json_record);
			$j++;
		}
			
	}

	echo json_encode($result_json);
	

?>