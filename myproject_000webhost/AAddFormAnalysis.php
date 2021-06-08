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
			    //echo $_REQUEST['anaName'][$i];
				$sqlAddAnaName = "INSERT INTO analysislist(anaName) VALUES ('".$_REQUEST['anaName'][$i]."');";
				$resultAddAnaName = mysqli_query($con,$sqlAddAnaName);		
			}
		}
	}

	echo "<script>
				alert('เพิ่มค่าวิเคราะห์สำเร็จ');
			    window.open('AManageServiceChargeQueryAna.php','_self');
			</script>";
		
?>