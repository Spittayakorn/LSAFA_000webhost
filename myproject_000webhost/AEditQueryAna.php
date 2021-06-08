<?php
	
	$anaCode = $_REQUEST['anaCode'];
	$anaName = $_REQUEST['anaName'];
	$pageNo = $_REQUEST['pageNo'];

	//echo "$anaCode$anaName";
	require('connectDB.php');
	
	$sqlUpdate = " update analysislist set anaName='$anaName' where anaCode='$anaCode';";
	$resultUpdate = mysqli_query($con,$sqlUpdate);

	if($resultUpdate == null)
	{
		echo "<script>
				alert('คำสั่งผิด');
				window.open('manageAnalysis.php?pageNo=$pageNo','_self');
			</script>";
	}else
	{
		echo "<script>
				alert('แก้ไขข้อมูลค่าวิเคราะห์สำเร็จ');
				window.open('AManageAnalysis.php?pageNo=$pageNo','_self');
			</script>";
	}
?>