<?php
	session_start();
	use PHPMailer\PHPMailer\PHPMailer;
	header('Content-Type: text/html; charset=utf-8');
	
	require('connectDB.php');
	
	require_once "PHPMailer/PHPMailer.php";
	require_once "PHPMailer/SMTP.php";
	require_once "PHPMailer/Exception.php";
	
	$offCM = $_POST['offCM'];
	$offStatus = $_POST['btOffSubmit'];
	$labCode = $_POST['labCode'];
	$boCode = $_POST['boCode'];
	$teaName = $_POST['teaName'];
	$labNo = $_POST['labNo'];
	$labYear = $_POST['labYear'];
	$statusLab = $_POST['statusLab'];
	$pageNo = $_POST['pageNo'];
	$memCode = $_SESSION['memCode'];
	$facName = $_SESSION['facName'];
	$depName = $_SESSION['depName'];
	$senderCode = $_POST['senderCode'];
		

	//เมื่อกรอกข้อมูลส่วนตัวไม่ครบ
	function getMember($memCode)
	{
		require('connectDB.php');

		$sqlSearchMem = "select m.memCode,m.username,m.password,m.memlevel,m.name,m.email,m.passmail,m.depCode,d.depCode,d.depName,f.facCode,f.facName,d.facCode from member as m,department as d,faculty as f where d.depCode= m.depCode and f.facCode=d.facCode and m.memCode='$memCode';";

		$resultSearchMem = mysqli_query($con,$sqlSearchMem);

		if($resultSearchMem == null)
		{
			echo "คำสั่ง1ผิด";
		}
	
		$recnumSearchMem = mysqli_fetch_array($resultSearchMem);
		if($recnumSearchMem ==0)
		{
			echo "ไม่พบข้อมู2ล";
		}
	
		$memName  = $recnumSearchMem[4];
		$email = $recnumSearchMem[5];
		$passmail = $recnumSearchMem[6];
		$facName = $recnumSearchMem[11];
		$depName = $recnumSearchMem[9];
		$level = '';

		switch($recnumSearchMem[3])
		{
			case '1' : $level = 'นักศึกษา';break;
			case '2' : $level = 'อาจารย์';break;
			case '3' : $level = 'เจ้าหน้าที่ห้องปฏิบัติการ';break;
			case '4' : $level = 'ผู้บริหาร';break;
		}


		return array($memName,$email,$passmail,$depName,$facName,$level);
	}

	list($AmemName,$Aemail,$Apassmail,$AdepName,$AfacName,$Alevel) = getMember($memCode);
	
	$AName = "$Alevel : $AmemName";

	if(trim($AmemName) == '' || trim($Aemail) == '' || trim($Apassmail) == '')
	{
		echo "<script>
				alert('กรุณากรอกข้อมูลส่วนตัวให้สมบูรณ์');
				window.open('AEditProfile.php?memCode=$memCode','_self')
			</script>";

	}
	
	//------จบ กรอกข้อมูลส่วนตัว-----
	
	if($offStatus =='2')
	{
		
		
		$updateStatueTeacher = "update lab set offCm='$offCM',offStatus='$offStatus',labStatus='1' where labCode='$labCode';";
		
		$resultStatueTeacher = mysqli_query($con,$updateStatueTeacher);

		if($resultStatueTeacher == null)
		{
			echo "คำสั่ง3ผิด";
		}
		//ส่งไปที่ นศ 
		
		list($sName,$sReciver,$spassmail,$sdepName,$sfacName,$slevel) = getMember($senderCode);
		
		$fromSender = "$slevel $sName $sfacName $sdepName";

		$arrayMail = array($senderCode);
		
		foreach($arrayMail as $mailCode)
		{
			
			list($loopName,$loopMail,$loopPassmail,$loopDepName,$loopFacName,$loopLevel) = getMember($mailCode);
				
	//mail---------------------------
    
	$mail = new PHPMailer;
    $mail->CharSet = "utf-8";
    $mail->isSMTP(); 
    $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
    $mail->Host = gethostbyname('smtp.gmail.com'); // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
    $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
    $mail->Port = 587; // TLS only
    $mail->SMTPSecure = 'tls'; // ssl is deprecated
    $mail->SMTPAuth = true;
	
	
	//------------------
			
			$gmail_username = $Aemail; // gmail ที่ใช้ส่ง
			$gmail_password = $Apassmail; // รหัสผ่าน gmail
			// ตั้งค่าอนุญาตการใช้งานได้ที่นี่ https://myaccount.google.com/lesssecureapps?pli=1

			$sender = $AName; // ชื่อผู้ส่ง
			$email_sender = $Aemail; // เมล์ผู้ส่ง 
			$email_receiver = $loopMail; // เมล์ผู้รับ ***

			$subject = "ขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ ภาควิชาสัตวศาสตร์ คณะทรัพยากรธรรมชาติ"; // หัวข้อเมล์


			$mail->Username = $gmail_username;
			$mail->Password = $gmail_password;
			$mail->setFrom($email_sender, $sender);
			$mail->addAddress($email_receiver);
			$mail->Subject = $subject;

			$contentTxt = "<!DOCTYPE html>
			<html>
				<head>
					<meta charset=utf-8'/>
					<title>ขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ ภาควิชาสัตวศาสตร์ คณะทรัพยากรธรรมชาติ</title>
				</head>
				<body>
					ระบบแจ้งเตือนขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ ภาควิชาสัตวศาสตร์ คณะทรัพยากรธรรมชาติ<br>
					ของ&nbsp;$fromSender
					<table>
						<tr>
							<td align='left' colspan='3'><u>สถานะขอใช้ห้องปฏิบัติการ</u></td>
						</tr>
						<tr>
							<td>อาจารย์ที่ปรึกษา : $teaName</td>
							<td style='color:green;'>อนุมัติ</td>
						</tr>
	
						<tr>
							<td>$AName</td>
							<td style='color:red;'>ไม่อนุมัติ</td>
						</tr>
					</table>
				 
					<br>
					โปรดตรวจสอบข้อมูลเพิ่มเติม<a href='shorturl.asia/SFWCc'>เข้าสู่ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์</a>
				</body>
			</html>";
	
			$email_content = $contentTxt;
			
			//  ถ้ามี email ผู้รับ
			if($email_receiver)
			{
				$mail->isHTML(true);
	            $mail->Body = $email_content;
	
				if (!$mail->send()) 
				{  // สั่งให้ส่ง email
		
				$errorTxt = $mail->ErrorInfo;
				// กรณีส่ง email ไม่สำเร็จ
				echo "<script>
						alert('โปรดตรวจสอบการเชื่อมต่อสัญญาณอินเทอร์เน็ต ');
						window.open('AGetLabT.php?statusLab=$statusLab&pageNo=$pageNo','_self');
					</script>";
				}
					
			}else
			{	
				
				echo "<script>
					alert('ไม่พบอีเมล์ผู้ส่งโปรดลองใหม่ในภายหลัง');
					window.open('AGetLabT.php?statusLab=$statusLab&pageNo=$pageNo','_self');
					</script>";
			}
		
		
		}

		//-------------
		
		echo "<script>
				alert('บันทึกข้อมูลเสร็จสิ้น');
				window.open('AGetLabT.php?statusLab=$statusLab&pageNo=$pageNo','_self');
			</script>";

	}

	if($offStatus =='1')
	{
		$updateSetTeacher = "update lab set headCode='$boCode' where labCode='$labCode';";
		$resultSetTeacher = mysqli_query($con,$updateSetTeacher);

		if($resultSetTeacher == null)
		{
			echo "คำสั่งผิด";
		}
			
		//ส่งไปที่ นศ , ผู้บริหาร 
		list($boName,$boReciver,$bopassmail,$bodepName,$bofacName,$bolevel) = getMember($boCode);
		list($sName,$sReciver,$spassmail,$sdepName,$sfacName,$slevel) = getMember($senderCode);
		
		$toReciverMail = "ถึง$bolevel $boName $bofacName $bodepName";
		$fromSender = "$slevel $sName $sfacName $sdepName";

		$arrayMail = array($senderCode,$boCode);
		
		$count = 1;
		foreach($arrayMail as $mailCode)
		{
			
			list($loopName,$loopMail,$loopPassmail,$loopDepName,$loopFacName,$loopLevel) = getMember($mailCode);
				
			//mail---------------------------
    
	$mail = new PHPMailer;
    $mail->CharSet = "utf-8";
    $mail->isSMTP(); 
    $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
    $mail->Host = gethostbyname('smtp.gmail.com'); // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
    $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
    $mail->Port = 587; // TLS only
    $mail->SMTPSecure = 'tls'; // ssl is deprecated
    $mail->SMTPAuth = true;
	
	
	//------------------

			$gmail_username = $Aemail; // gmail ที่ใช้ส่ง
			$gmail_password = $Apassmail; // รหัสผ่าน gmail
			// ตั้งค่าอนุญาตการใช้งานได้ที่นี่ https://myaccount.google.com/lesssecureapps?pli=1

			$sender = $AName; // ชื่อผู้ส่ง
			$email_sender = $Aemail; // เมล์ผู้ส่ง 
			$email_receiver = $loopMail; // เมล์ผู้รับ ***

			$subject = "ขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ ภาควิชาสัตวศาสตร์ คณะทรัพยากรธรรมชาติ"; // หัวข้อเมล์


			$mail->Username = $gmail_username;
			$mail->Password = $gmail_password;
			$mail->setFrom($email_sender, $sender);
			$mail->addAddress($email_receiver);
			$mail->Subject = $subject;

			$contentTxt = "<!DOCTYPE html>
			<html>
				<head>
					<meta charset=utf-8'/>
					<title>ขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ ภาควิชาสัตวศาสตร์ คณะทรัพยากรธรรมชาติ</title>
				</head>
				<body>
					$toReciverMail ระบบแจ้งเตือนขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ ภาควิชาสัตวศาสตร์ คณะทรัพยากรธรรมชาติ<br>
					ของ&nbsp;$fromSender
					<table>
						<tr>
							<td align='left' colspan='3'><u>สถานะขอใช้ห้องปฏิบัติการ</u></td>
						</tr>
						<tr>
							<td>อาจารย์ที่ปรึกษา : $teaName</td>
							<td style='color:green;'>อนุมัติ</td>
						</tr>
	
						<tr>
							<td>$AName</td>
							<td style='color:green;'>อนุมัติ</td>
						</tr>
					</table>
				 
					<br>
					โปรดตรวจสอบข้อมูลเพิ่มเติม<a href='shorturl.asia/SFWCc'>เข้าสู่ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์</a>
				</body>
			</html>";
	
			$email_content = $contentTxt;
			
			if($count =='1')
			{
				$toReciverMail ='';
			}

			//  ถ้ามี email ผู้รับ
			if($email_receiver)
			{
				$mail->isHTML(true);
            	$mail->Body = $email_content;

				if (!$mail->send()) 
				{  // สั่งให้ส่ง email
		
				$errorTxt = $mail->ErrorInfo;
				// กรณีส่ง email ไม่สำเร็จ
				echo "<script>
						alert('โปรดตรวจสอบการเชื่อมต่อสัญญาณอินเทอร์เน็ต ');
						window.open('AGetLabT.php?statusLab=$statusLab&pageNo=$pageNo','_self');
					</script>";
				}
					
			}else
			{	
				
				echo "<script>
					alert('ไม่พบอีเมล์ผู้ส่งโปรดลองใหม่ในภายหลัง');
					window.open('AGetLabT.php?statusLab=$statusLab&pageNo=$pageNo','_self');
					</script>";
			}
		
		
		}

		//-------------
				
		$updateStatusTeacher = "update lab set offCm='$offCM',offStatus='$offStatus',labNo='$labNo',labYear='$labYear',labStatus='0',send='1' where labCode='$labCode';";
		
		$resultStatusTeacher = mysqli_query($con,$updateStatusTeacher);

		if($resultStatusTeacher == null)
		{
			echo "คำสั่งผิด";
		}
		//----
		$sqlSearchLabNo = "select * from lab where labCode='$labCode'";
		$resultSearchLabNo = mysqli_query($con,$sqlSearchLabNo);

		if($resultSearchLabNo == null)
		{
			echo "คำสั่งผิด";
		}

		$recnumSearchLabNo = mysqli_fetch_array($resultSearchLabNo);
		
		$sqlDelDocNo = " delete from documentlab where docnoLab='$recnumSearchLabNo[2]';";
		$resultDelDocNo = mysqli_query($con,$sqlDelDocNo);
		
		if($resultDelDocNo == null)
		{
			echo "คำสั่งผิด";
		}
		
		$sqlInsertDocNo = "insert into documentlab values($labNo,'$labNo');";
		$resultInsertDocNo = mysqli_query($con,$sqlInsertDocNo);
		if($resultInsertDocNo == null)
		{
			echo "คำสั่งผิด";
		}

		// กรณีส่ง email สำเร็จ
		echo "<script>
				alert('ระบบได้ส่งข้อความไปเรียบร้อย');
				window.open('AGetLabT.php?statusLab=$statusLab&pageNo=$pageNo','_self');
			</script>";
		
	}
	
?>