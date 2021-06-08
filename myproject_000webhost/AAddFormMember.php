<?php

	$name = $_REQUEST['name'];
	$email = $_REQUEST['email'];
	$passmail = $_REQUEST['passmail'];
	$depCode= $_REQUEST['depCode'];
	$username = $_REQUEST['username'];
	$password= $_REQUEST['password'];
	$level= $_REQUEST['level'];
	$tel = count($_POST['tel']);
	
	
	require('connectDB.php');

	//-------------------
	
	$sqlSearchUsernameMember = "select * from member where username='$username';";
	$resultSearchUsernameMember = mysqli_query($con,$sqlSearchUsernameMember);

	if($resultSearchUsernameMember == null)
	{
		echo "คำสั่งผิด";
	}

	$numRowSearchUsernameMember = mysqli_num_rows($resultSearchUsernameMember);

	if($numRowSearchUsernameMember == 0)
	{
	
	
	//echo "$name $email $depCode $password $level";
	$sqlAddMem = "INSERT INTO member(username, password, memlevel, name, email, passmail, depCode) VALUES ('$username','$password','$level','$name','$email','$passmail','$depCode');";
	$resultAddMem = mysqli_query($con,$sqlAddMem);

	$sqlSearchCodeMem = "select * from member where username='$username' and password='$password';";
	$resultSearchCodeMem = mysqli_query($con,$sqlSearchCodeMem);
	$recNumSearchCodeMem = mysqli_fetch_array($resultSearchCodeMem);

	if($resultSearchCodeMem == null)
	{
		echo "คำสั่งผิด";
	}
	if($recNumSearchCodeMem == 0)
	{
		echo "ไม่มีข้อมูล";
	}
	
	if($tel >= 1)
	{
		for($i=0,$lv=0;$i<$tel;$i++)
		{
			
			if(trim($_POST['tel'][$i]) != '')
			{
				$sqlAddTellMem = "insert into telephone(telName,memCode,telLevel) values('".$_POST['tel'][$i]."','$recNumSearchCodeMem[0]','$lv');";
				$resultAddTellMem = mysqli_query($con,$sqlAddTellMem);
				$lv++;
			}
		}

	echo "<script>
			alert('เพิ่มข้อมูลสมาชิกสำเร็จ');
			window.open('AManageMember.php','_self');
		</script>";



	}
	

	}else{
		
		echo "<script>
				alert('ขออภัยมีชื่อผู้ใช้งานนี้อยู่ในระบบแล้ว');
				window.open('AAddMember.php','_self');
			</script>";
	}

	//-------------------
	

?>