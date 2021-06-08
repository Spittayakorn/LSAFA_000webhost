<?php
	
	$labCode = count($_POST['labCode']);
	$anaCode = count($_POST['anaCode']);
	$repeat = count($_POST['repeat']);
	$pageNo = $_POST['pageNo'];

	
	require('connectDB.php');
	
	$sumZero = 0;
	$j=0;
	for($i=0;$i<$anaCode;$i++)
	{
		$sqlSearchAna = "select da.daCode,da.volume,da.repeats,da.labCode,da.scCode,sc.scCode,sc.catCode,sc.anaCode,sc.simCode,sc.price,sl.simCode,sl.simName from dataanalysis as da,servicechargelist as sc,simplelist as sl where da.scCode=sc.scCode and sc.simCode=sl.simCode and da.labCode='".$_POST['labCode'][$i]."' and anaCode='".$_POST['anaCode'][$i]."'";
		
		$resultSearchAna = mysqli_query($con,$sqlSearchAna);

		if($resultSearchAna== null)
		{
			echo "คำสั่งผิด1";
		}
		

		$sumZero += $_POST['repeat'][$i];

		while($recnumSearchAna = mysqli_fetch_array($resultSearchAna))
		{
			if(is_numeric($_POST['repeat'][$i]))
			{
				$sqlUpdatRepeat = "update dataanalysis set repeats=".$_POST['repeat'][$i]." where daCode='$recnumSearchAna[0]'";
				$resultUpdatRepeat = mysqli_query($con,$sqlUpdatRepeat);

				if($resultUpdatRepeat == null)
				{
					echo "คำสั่งผิด2";
				}
			}
		}

	}

	if($sumZero > 0 )
	{
		$sqlUpdateStatusLRepeatLab = "update lab set repeatStatus='1' where labCode='".$_POST['labCode'][$j]."';";
		$resultUpdateStatusLRepeatLab = mysqli_query($con,$sqlUpdateStatusLRepeatLab);

		if($resultUpdateStatusLRepeatLab == null)
		{
			echo "คำสั่งผิด";
		}

	}else
	{
		$sqlUpdateStatusLRepeatLab = "update lab set repeatStatus='0' where labCode='".$_POST['labCode'][$j]."';";
		$resultUpdateStatusLRepeatLab = mysqli_query($con,$sqlUpdateStatusLRepeatLab);

		if($resultUpdateStatusLRepeatLab == null)
		{
			echo "คำสั่งผิด";
		}
	}

		
	echo "<script>
			alert('บันทึกขอมูลเสร็จสิ้น');
			window.open('AManageRepeatLab.php?labCode=".$_POST['labCode'][$j]."&statusLab=1&labStatus=0&pageNo=$pageNo','_self');
		</script>";
	
?>