<?php
	
	$anaCode = $_GET['anaCode'];
	$pageNo = $_GET['pageNo'];
	require('connectDB.php');
	
	$sqlDelServicePrice = "delete from servicechargelist where catCode='$anaCode';";
	$resultDelServicePrice = mysqli_query($con,$sqlDelServicePrice);

	$sqlDelAna = "delete from categorys where catCode='$anaCode';";
	
	if(mysqli_query($con,$sqlDelAna))
	{
		echo "<script>
				alert('บันทึกข้อมูลสำเร็จ');
				window.open('AManageCat.php?pageNo=$pageNo','_self');
			</script>";
	}else
	{
		echo "<script>
				alert('บันทึกข้อมูลล้มเหลว');
				window.open('AManageCat.php?pageNo=$pageNo','_self');
			</script>";
	}
	
?>