<?php
	
	$labCode = $_POST['labCode'];
	$labDate = $_POST['labDate'];
	$labName = $_POST['labName'];
	$catCode = $_POST['catCode'];
	$labTel = $_POST['labTel'];
	$objCode = $_POST['objCode'];
	$objTitle = $_POST['objTitle'];
	$labNRepeat = $_POST['labNRepeat'];
	$labSDate = $_POST['labSDate'];
	$labEDate = $_POST['labEDate'];
	$boCode = $_POST['boCode'];
	$memCode = $_POST['memCode'];
	$labNo = $_POST['labNo'];
	$labYear = $_POST['labYear'];
	
	if(isset($_POST['anaCode']))
	{
		$anaCode = count($_POST['anaCode']);
	}

	if(isset($_POST['simCode'])){
		$simCode = count($_POST['simCode']);
	}

	if(isset($_POST['volume']))
	{
		$volume = count($_POST['volume']);
	}
	
	/*
	echo "$labCode&nbsp;$labDate&nbsp;$labName&nbsp;$catCode&nbsp;$labTel&nbsp;$objCode&nbsp;$objTitle&nbsp;$labNRepeat&nbsp;$labSDate &nbsp;$labEDate&nbsp;$boCode&nbsp;$memCode<br>";
	*/

	require('connectDB.php');
	
	$sqlSearchAttrLabNo = "select * from lab where labCode='$labCode';"; 
	$resultSearchAttrLabNo = mysqli_query($con,$sqlSearchAttrLabNo);

	if($resultSearchAttrLabNo == null)
	{
		echo "คำสั่ง1ผิด";
	}
	
	$recnumSearchAttrLabNo = mysqli_fetch_array($resultSearchAttrLabNo);
	
	$sqlEditLab ='';
	
	if($recnumSearchAttrLabNo[2] == $labNo )
	{
		$sqlEditLab = "update lab set			labDate='$labDate',labName='$labName',catCode='$catCode',labTel='$labTel',objCode='$objCode',objTitle='$objTitle',labNRepeat=$labNRepeat,labSDate='$labSDate',labEDate='$labEDate',headCode='$boCode',teaStatus='0',offStatus='1',boStatus='0',repeatStatus='0',teaCm='',offCm='',boCm='',labStatus='0',memCode='$memCode',teaCode='0',labNo='$labNo',labYear='$labYear' where labCode='$labCode';";
		
		$resultEditLab = mysqli_query($con,$sqlEditLab);

		if($resultEditLab == null)
		{
			echo "คำสั่ง2ผิด";
		}

	
		$sqlDelDataAnalysis = " delete from dataanalysis where labCode='$labCode';";
		$resultDelDataAnalysis = mysqli_query($con,$sqlDelDataAnalysis);

		if($resultDelDataAnalysis==null)
		{
			echo "คำสั่ง3ผิด";
		}
	
		if(isset($_POST['anaCode']))
		{
			for($i=0;$i<$anaCode;$i++)
			{
				/*
				echo "<br>รหัสประเภทนักวิจัย คือ $catCode รหัสค่าวิเคราะห์    คือ   '".$_POST['anaCode'][$i]."'  รหัสชนิดตัวอย่าง คือ    '".$_POST['simCode'][$i]."'ปริมาณ คือ '".$_POST['volume'][$i]."'<br>";
				*/

				$sqlSearchServicePrice = "select * from servicechargelist where anaCode='".$_POST['anaCode'][$i]."' and simCode='".$_POST['simCode'][$i]."' and catCode='$catCode';";
				$resultSearchServicePrice = mysqli_query($con,$sqlSearchServicePrice);

				if($resultSearchServicePrice == null)
				{
					echo "คำสั่ง4ผิด";
				}

				$recnumSearchServicePrice = mysqli_fetch_array($resultSearchServicePrice);
				$scCode = $recnumSearchServicePrice[0];

				//echo $scCode;
		
				$sqlAddDataAnalysis = "INSERT INTO dataanalysis(volume,repeats,labCode,scCode) VALUES (".$_POST['volume'][$i].",0,$labCode,$scCode);";
				
				$resultAddDataAnalysis = mysqli_query($con,$sqlAddDataAnalysis);

				if($resultAddDataAnalysis == null)
				{
					echo "คำสั่ง5ผิด";
				}

			}

		}

			echo "<script>
				alert('แก้ไขขอใช้ห้องปฏิบัติการสมบูรณ์');
		    	window.open('AManageLab.php','_self');
				</script>";
	//	
	}else
	{
		$sqlSearchLabNo = "select * from documentlab where docnoLab = '$labNo';";
		$resultSearchLabNo = mysqli_query($con,$sqlSearchLabNo);
	
		if($resultSearchLabNo == null)
		{
			echo "คำสั่ง6ผิด";
		}
	
		$numRowSearchLabNo = mysqli_num_rows($resultSearchLabNo);

		if($numRowSearchLabNo == 0)
		{
			
			$sqlDelLabNo = "delete from documentlab where docnoLab='$recnumSearchAttrLabNo[2]';";
			$resultDelLabNo = mysqli_query($con,$sqlDelLabNo);

			if($resultDelLabNo == null)
			{
				echo "คำสั่ง7ผิด";
			}


			$sqlAddLabNo = " insert into documentlab values($labNo,'$labNo');";
			$resultAddLabNo = mysqli_query($con,$sqlAddLabNo);
			
			if($resultAddLabNo == null)
			{
				echo "คำสั่ง8ผิด";
			}

			
			$sqlEditLab = "update lab set			labDate='$labDate',labName='$labName',catCode='$catCode',labTel='$labTel',objCode='$objCode',objTitle='$objTitle',labNRepeat=$labNRepeat,labSDate='$labSDate',labEDate='$labEDate',headCode='$boCode',teaStatus='0',offStatus='1',boStatus='0',repeatStatus='0',teaCm='',offCm='',boCm='',labStatus='0',memCode='$memCode',teaCode='0',labNo='$labNo',labYear='$labYear' where labCode='$labCode';";
			
			//---

			$resultEditLab = mysqli_query($con,$sqlEditLab);

			if($resultEditLab == null)
			{
				echo "คำสั่ง9ผิด";
			}

	
			$sqlDelDataAnalysis = " delete from dataanalysis where labCode='$labCode';";
			$resultDelDataAnalysis = mysqli_query($con,$sqlDelDataAnalysis);

			if($resultDelDataAnalysis==null)
			{
				echo "คำสั่ง10ผิด";
			}
	
			if(isset($_POST['anaCode']))
			{
				for($i=0;$i<$anaCode;$i++)
				{
					/*
					echo "<br>รหัสประเภทนักวิจัย คือ $catCode รหัสค่าวิเคราะห์    คือ   '".$_POST['anaCode'][$i]."'  รหัสชนิดตัวอย่าง คือ    '".$_POST['simCode'][$i]."'ปริมาณ คือ '".$_POST['volume'][$i]."'<br>";
					*/

					$sqlSearchServicePrice = "select * from servicechargelist where anaCode='".$_POST['anaCode'][$i]."' and simCode='".$_POST['simCode'][$i]."' and catCode='$catCode';";
					$resultSearchServicePrice = mysqli_query($con,$sqlSearchServicePrice);

					if($resultSearchServicePrice == null)
					{
						echo "คำสั่ง11ผิด";
					}

					$recnumSearchServicePrice = mysqli_fetch_array($resultSearchServicePrice);
					$scCode = $recnumSearchServicePrice[0];

					//echo $scCode;
		
					$sqlAddDataAnalysis = "INSERT INTO dataanalysis(volume,repeats,labCode,scCode) VALUES (".$_POST['volume'][$i].",0,$labCode,$scCode);";
					$resultAddDataAnalysis = mysqli_query($con,$sqlAddDataAnalysis);

					if($resultAddDataAnalysis == null)
					{
						echo "คำสั่ง12ผิด";
					}

				}

			}

			echo "<script>
					alert('แก้ไขขอใช้ห้องปฏิบัติการสมบูรณ์');
					window.open('AManageLab.php','_self');
				</script>";

//
			//---
		}else
		{
			echo "<script>
					alert('เลขที่ซ้ำ');
				    window.open('AEditLab.php?labCode=$labCode','_self');
				</script>";
		}
//	
	}

?>