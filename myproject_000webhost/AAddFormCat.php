<?php


	$anaName = count($_REQUEST['anaName']);
	//echo $anaName;
	
	require('connectDB.php');
	
	if($anaName>0)
	{
		for($i=0;$i<$anaName;$i++)
		{
			if(trim($_REQUEST['anaName'][$i])!='')
			{
				$sqlAddAnaName = "INSERT INTO categorys(catName) VALUES ('".$_REQUEST['anaName'][$i]."');";
				$resultAddAnaName = mysqli_query($con,$sqlAddAnaName);		
			}
		}
	}

	echo "<script>
				alert('เพิ่มประเภทนักวิจัยสำเร็จ');
				window.open('AManageServiceChargeQueryCat.php','_self');
			</script>";
	
?>