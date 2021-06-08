<?php
	

	$memCode = $_REQUEST['anaCode'];
	$pageNo = $_REQUEST['pageNo'];
	require('connectDB.php');

	
	$sqlSearchLabFromMemCode = "select * from lab where memCode ='$memCode';";
	$resultSearchLabFromMemCode = mysqli_query($con,$sqlSearchLabFromMemCode);

	if($resultSearchLabFromMemCode == null)
	{
		echo "คำสั่งผิด";
	}
	
	while($recnumSearchLabFromMemCode = mysqli_fetch_array($resultSearchLabFromMemCode))
	{
		$sqlDelDataAnalysis = "delete from dataanalysis where labCode='$recnumSearchLabFromMemCode[0]';";
		$resultDelDataAnalysis = mysqli_query($con,$sqlDelDataAnalysis);

		if($resultDelDataAnalysis == null)
		{
			echo "คำสั่งผิด";
		}
	}

	$sqlDelLab = "delete from lab where memCode='$memCode';";
	$resultDelLab = mysqli_query($con,$sqlDelLab);

	if($resultDelLab == null)
	{
		echo "คำสั่งผิด";
	}
	
	$sqlDelMemCode = "delete from telephone where memCode='$memCode'";
	$resultDelMemCode = mysqli_query($con,$sqlDelMemCode);
	if($resultDelMemCode==null)
	{
		echo "คำสั่งผิด";
	}
		
	$sqlDelMem = "delete from member where memCode='$memCode';";
	
	if(mysqli_query($con,$sqlDelMem))
	{
		echo "<script>
				
				window.open('AManageMember.php?pageNo=$pageNo','_self');
			</script>";
	}else
	{
		echo "<script>
				alert('บันทึกข้อมูลล้มเหลว');
				window.open('AManageMember.php?pageNo=$pageNo','_self');
			</script>";
	}
	
?>