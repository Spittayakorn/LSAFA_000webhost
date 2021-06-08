<?php

	$anaCode = $_REQUEST['anaCode'];//ค่าวิเคราะห์
	
	if(!(isset($_POST['price']) || isset($_POST['level'])))
	{
		
		echo "<script>	
				window.open('AManageServiceCharge.php','_self');
			</script>";
	}else
	{
	$price = count($_POST['price']);//ราคา
	$level = count($_POST['level']);//ประเภทนักวิจัย

	require('connectDB.php');
		
	for($i=0;$i<$level;$i++)
	{
		//ชนิดตัวอย่าง ที่มีอยู่ ณ ปัจจุบัน
		$sqlSearchSim = "select * from simplelist;";
		$resultSearchSim = mysqli_query($con,$sqlSearchSim);
		
		while($recnumSearchSim = mysqli_fetch_array($resultSearchSim))
		{
			//ไปดูราคาในดาต้าดิก 
			$sqlSearchPrice = "select * from servicechargelist where anaCode='$anaCode' and catCode='".$_POST['level'][$i]."' and simCode='$recnumSearchSim[0]';";
			$resultSearchPrice = mysqli_query($con,$sqlSearchPrice);

			if($resultSearchPrice == null)
			{
				echo "คำสั่งผิด";
			}
			
			$recnumRow = mysqli_num_rows($resultSearchPrice);
			
			if($recnumRow==0)
			{

			//--------------------->เริ่มต้นส่วนเพิ่ม
			//ตรวจสอบ ถ้าไม่เป็นช่องว่าง ให้ เป็น ค่าที่กรอก ถ้าไม่ใช่ใส่ 0 ลงในราคา
				if(trim($_POST['price'][$i])!='')
				{	
					$sqlAddServiceCharge = "insert into servicechargelist values('','".$_POST['level'][$i]."','$anaCode','$recnumSearchSim[0]',".$_POST['price'][$i].");";

				}else
				{
					$sqlAddServiceCharge = "insert into servicechargelist values('','".$_POST['level'][$i]."','$anaCode','$recnumSearchSim[0]',0);";

				}

				$resultServiceCharge = mysqli_query($con,$sqlAddServiceCharge);

				if($resultServiceCharge == null)
				{
					echo "คำสั่งผิด";
				}

			//--------------------->จบส่วนเพิ่ม
			}else
			{
				//กรณีมีข้อมูล ให้อัพเดทราคาได้
				//เมื่ออัพเดทแล้ว ราคาไม่เป็นช่องว่างใส่ค่านั้นได้
				if(trim($_POST['price'][$i])!='')
				{	
					$sqlAddServiceCharge = "update servicechargelist set price=".$_POST['price'][$i]." where catCode='".$_POST['level'][$i]."' and anaCode='$anaCode';";

				}else
				{
					//ราคาเป็นช่องว่าง
					$sqlAddServiceCharge = "update servicechargelist set price=0 where catCode='".$_POST['level'][$i]."' and anaCode='$anaCode';";

				}

				$resultServiceCharge = mysqli_query($con,$sqlAddServiceCharge);

				if($resultServiceCharge == null)
				{
					echo "คำสั่งผิด";
				}
			}
		}
	}

	echo "<script>
			
			alert('จัดการอัตราค่าบริการสำเร็จ');
			window.open('AManageServiceCharge.php','_self');
		</script>";
	}
?>