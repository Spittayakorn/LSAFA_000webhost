<?php
	
	session_start();

	//รับ username และ password
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];

	//เชื่อมต่อฐานข้อมูล
	require('connectDB.php');
	
	//หาผู้ใช้จาก ฐานข้อมูล
	$sqlChk = "select m.memCode,m.username,m.password,m.memlevel,m.name,m.email,m.depCode,f.facCode,f.facName,d.depCode,d.depName ,d.facCode,m.passmail from member as m ,faculty as f ,department as d where m.depCode = d.depCode and d.facCode = f.facCode and m.username='".$username."' and m.password='".$password."';";
	$resultChk = mysqli_query($con,$sqlChk);
	
	if($resultChk == null)
	{
		echo "
			<script>
				alert('คำสั่งผิด $sqlChk');
				window.open('login.php','_self');
			</script>";
	}
	
	//ตรวจสอบจำนวนแถวที่ query ได้
	$numRowsqlChk = mysqli_num_rows($resultChk);

	if($numRowsqlChk == 0)
	{
		echo"
			<script>
				alert('ไม่พบบัญชีผู้ใช้');
				window.open('login.php','_self');
			</script>";
	}else
	{
		$recnumChk = mysqli_fetch_array($resultChk);
		$_SESSION['memCode'] = $recnumChk[0];
		$_SESSION['memName'] = $recnumChk[4];
		$_SESSION['facCode'] = $recnumChk[7];
		$_SESSION['facName'] = $recnumChk[8];
		$_SESSION['depCode'] = $recnumChk[6];
		$_SESSION['depName'] = $recnumChk[10];
		$_SESSION['email'] = $recnumChk[5];
		$_SESSION['passmail'] = $recnumChk[12];
		$_SESSION['username'] = $recnumChk[1];
		$_SESSION['password'] = $recnumChk[2];
		
		if($recnumChk[3]=='1')
		{
			echo "<script>
					
					window.open('Smain.php','_self');
				</script>";
		}

		if($recnumChk[3]=='2')
		{
			echo "<script>
					
					window.open('Tmain.php','_self');
				</script>";
			
		}
		
		if($recnumChk[3]=='3')
		{
			echo "<script>
					
					window.open('Amain.php','_self');
				</script>";
			
		}

		if($recnumChk[3]=='4')
		{
			echo "<script>
					window.open('Hmain.php','_self');
				</script>";
			
		}
	}


?>




