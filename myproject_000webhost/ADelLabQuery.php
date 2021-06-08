<?php

	$labCode = $_GET['labCode'];
	
	require('connectDB.php');

	$sqlDelDataAnalysis = "delete from dataanalysis where labCode='$labCode';";
	$resultDelDataAnalysis = mysqli_query($con,$sqlDelDataAnalysis);

	if($resultDelDataAnalysis == null)
	{
		echo "คำสั่งผิด";
	}
	
	$sqlSearchLabNo = "select * from lab where labCode='$labCode'";
	$resultSearchLabNo = mysqli_query($con,$sqlSearchLabNo);

	if($resultSearchLabNo == null)
	{
		echo "คำสั่งผิด";
	}
	
	$recnumSearchLabNo = mysqli_fetch_array($resultSearchLabNo);
	$labNoQ = $recnumSearchLabNo[2];

	if($labNoQ !='')
	{
		$sqlDelLabNo ="delete from documentlab where docnoLab='$labNoQ';";
		$resultDelLabNo = mysqli_query($con,$sqlDelLabNo);
		
		if($resultDelLabNo == null)
		{
			echo "คำสั่งผิด";
		}
	}

	$sqlDelLab = "delete from lab where labCode='$labCode';";
	$resultDelLab = mysqli_query($con,$sqlDelLab);

	if($resultDelLab == null)
	{
		echo "คำสั่งผิด";
	}
	
	echo "<script>
			alert('ลบข้อมูลเสร็จสิ้น');
			window.open('AGetLabH.php?statusLab=1&labStatus=1','_self');
		</script>";

?>