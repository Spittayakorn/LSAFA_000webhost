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
	$teaCode = $_POST['boCode'];
	$memCode = $_POST['memCode'];
	
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
	echo "$labCode&nbsp;$labDate&nbsp;$labName&nbsp;$catCode&nbsp;$labTel&nbsp;$objCode&nbsp;$objTitle&nbsp;$labNRepeat&nbsp;$labSDate &nbsp;$labEDate&nbsp;$teaCode&nbsp;$memCode<br>";
	*/

	require('connectDB.php');

	$sqlEditLab = "update lab set			labDate='$labDate',labName='$labName',catCode='$catCode',labTel='$labTel',objCode='$objCode',objTitle='$objTitle',labNRepeat=$labNRepeat,labSDate='$labSDate',labEDate='$labEDate',teaCode='$teaCode',teaStatus='0',offStatus='0',boStatus='0',repeatStatus='0',teaCm='',offCm='',boCm='',labStatus='0',memCode='$memCode',offCode='0',headCode='0' where labCode='$labCode';";

	$resultEditLab = mysqli_query($con,$sqlEditLab);

	if($resultEditLab == null)
	{
		echo "คำสั่งผิด";
	}

	
	$sqlDelDataAnalysis = " delete from dataanalysis where labCode='$labCode';";
	$resultDelDataAnalysis = mysqli_query($con,$sqlDelDataAnalysis);

	if($resultDelDataAnalysis==null)
	{
		echo "คำสั่งผิด";
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
				echo "คำสั่งผิด";
			}

			$recnumSearchServicePrice = mysqli_fetch_array($resultSearchServicePrice);
			$scCode = $recnumSearchServicePrice[0];

			//echo $scCode;
		
			$sqlAddDataAnalysis = "INSERT INTO dataanalysis(volume,repeats,labCode,scCode) VALUES (".$_POST['volume'][$i].",0,$labCode,$scCode);";
			$resultAddDataAnalysis = mysqli_query($con,$sqlAddDataAnalysis);

			if($resultAddDataAnalysis == null)
			{
				echo "คำสั่งผิด";
			}

		}

	}

	echo "<script>
			alert('แก้ไขขอใช้ห้องปฏิบัติการสมบูรณ์');
			window.open('SManageLab.php','_self');
		</script>";
?>