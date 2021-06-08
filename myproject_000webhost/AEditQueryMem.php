<?php

	require('connectDB.php');

	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	$memlevel = $_REQUEST['level'];
	$name = $_REQUEST['name'];
	$email = $_REQUEST['email'];
	$passmail = $_REQUEST['passmail'];
	$depCode = $_REQUEST['depCode'];
	$memCode = $_REQUEST['memCode'];
	$pageNo = $_POST['pageNo'];
	$tel = count($_POST['tel']);

	
	$sqlUpdateMember = "update member set username='$username',password='$password',memlevel='$memlevel',name='$name',email='$email',passmail='$passmail',depCode='$depCode' where memCode='$memCode';";

	$resultUpdateMember = mysqli_query($con,$sqlUpdateMember);

	if($resultUpdateMember == null)
	{
		echo "<script>
				alert('คำสั่งผิด');
				window.open('AManageMember.php?pageNo=$pageNo','_self')
		</script>";
	}

	$sqlDelTel = " delete from telephone where memCode = '$memCode';";
	$resultDelTel = mysqli_query($con,$sqlDelTel);

	if($tel >= 1)
	{
		for($i=0,$lv=0;$i<$tel;$i++)
		{
			if(trim($_POST['tel'][$i]) != '')
			{
				$sqlAddTel = "insert into telephone(telName,memCode,telLevel) values('".$_POST['tel'][$i]."','$memCode','$lv');";
				
				$resultAddTel = mysqli_query($con,$sqlAddTel);
				$lv++;
			}
		}
	}

	echo "<script>
			alert('แก้ไขข้อมูลสมาชิกสำเร็จ');
			window.open('AManageMember.php?pageNo=$pageNo','_self')
		</script>";
?>