<?php
	
	$anaCode = $_REQUEST['anaCode'];
	$anaName = $_REQUEST['anaName'];
	$pageNo = $_REQUEST['pageNo'];

	//echo "$anaCode$anaName";
	require('connectDB.php');
	
	$sqlUpdate = " update objective set objName='$anaName' where objCode='$anaCode';";
	$resultUpdate = mysqli_query($con,$sqlUpdate);

	if($resultUpdate == null)
	{
		echo "<script>
				alert('คำสั่งผิด');
				window.open('AManageObj.php?pageNo=$pageNo','_self');
			</script>";
	}else
	{
		echo "<script>
				alert('แก้ไขข้อมูลค่าวิเคราะห์สำเร็จ');
				window.open('AManageObj.php?pageNo=$pageNo','_self');
			</script>";
	}
?>