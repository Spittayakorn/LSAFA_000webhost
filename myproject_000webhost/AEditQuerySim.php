<?php
	
	$anaCode = $_REQUEST['anaCode'];
	$anaName = $_REQUEST['anaName'];
	$pageNo = $_REQUEST['pageNo'];

	//echo "$anaCode$anaName";
	require('connectDB.php');
	
	$sqlUpdate = " update simplelist set simName='$anaName' where simCode='$anaCode';";
	$resultUpdate = mysqli_query($con,$sqlUpdate);

	if($resultUpdate == null)
	{
		echo "<script>
				alert('คำสั่งผิด');
				window.open('AManageSimple.php?pageNo=$pageNo','_self');
			</script>";
	}else
	{
		echo "<script>
				alert('แก้ไขข้อมูลค่าชนิดตัวอย่างสำเร็จ');
				window.open('AManageSimple.php?pageNo=$pageNo','_self');
			</script>";
	}
?>