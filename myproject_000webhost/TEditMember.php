<?php
	session_start();

		if(!(isset($_SESSION['memCode']) && isset($_SESSION['memName'])&& isset($_SESSION['facCode'])&& isset($_SESSION['facName'])&& isset($_SESSION['depCode']) && isset($_SESSION['depName'])))
		{
			echo "<script>
					alert('กรุณาเข้าสู่ระบบใหม่อีกครั้ง');
					window.open('login.php','_self');
			</script>";

		}else{
			
			$memCode = $_SESSION['memCode'];
			
			//-----
			require('connectDB.php');
			$sqlSearchSessionMember = "select * from member where memCode='$memCode';";
			$resultSearchSessionMember = mysqli_query($con,$sqlSearchSessionMember);
			
			if($resultSearchSessionMember == null)
			{
				echo "คำสั่งผิด";
			}

			$recnumSearchSessionMember = mysqli_fetch_array($resultSearchSessionMember);
			
			$memName = $recnumSearchSessionMember[4];
			
			//---

			$facCode = $_SESSION['facCode'];
			$facName = $_SESSION['facName'];
			$depCode = $_SESSION['depCode'];
			$depName = $_SESSION['depName'];
		}	
?>

<html>
<head>
	<title>จัดการสมาชิก</title>
	<meta charset="utf-8">
	<style>
	body {
			font-family: sarabun;
			font-size: 100%;	
			line-height: 1.5;
			height:90%
		}
		img {
			height:40%;
			width:100%;
		}
		table,#fixTB{
			border:0px solid black;
			border-collapse: collapse;
		}

		#tbLog {
			border-left: none;
			border-right:none;
			border-top:none;
			border-bottom:none;
		}
		
		#signOut{
			background-color: #4CAF50;
			border: none;
			color: white;
			padding:10px 10px;
			text-align:center;
			text-decoration:none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			cursor: pointer;
		}
		
		input[type="text"],input[type="password"],input[type='email']{
			width: 300px;
			padding: 0.4em;
			border-radius: 0.2em;
			border: 1px solid #ccc;
			outline: none;
		}

		input[type="submit"]{
			width: 100%;
			padding: 1em;
			border-radius: 30px; 
			border: none;
			color: #fff;
			background-color: #5ABEFF;
			font-size: 1em;
			cursor:pointer;
		}

		#addTel,.delTel {
			cursor:pointer;
		}

		select, textarea {
			width: 300px;
			padding: 0.4em;
			border-radius: 0.2em;
			border: 1px solid #ccc;
			outline: none;
		}

		select:focus, textarea:focus {
			box-shadow: 0 0 0.5em #2a76e6;
			border-color: #2a76e6;
			padding: 0.4em;
			border: 1px solid #2a76e6;
			outline: none;
		}

		input[type="text"]:focus,input[type="password"]:focus,input[type='email']:focus {
			box-shadow: 0 0 0.5em #2a76e6;
			border-color: #2a76e6;
			padding: 0.4em;
			border: 1px solid #2a76e6;
			outline: none;
		}

		#myTables {
			border: 1px solid black;
			border-collapse: separate;
			border-radius: 5px;
			padding:10px;
		}
	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>	
	<script>
		$(document).ready(function(){

			depCode = $('#depChange').val();
			$('#depCodes').val(depCode);



			$('#signOut').click(function(){
				window.open('logout.php','_self');
			});

			//เมื่อselect เปลี่ยน -> ให้รับ value->หาว่ามีภาควิชาอะไรบ้าง เก็บใส่ json->แสดงออกมา
			$('#facChange').change(function(){
				facCode = $('#facChange').val();
				
				//alert(facCode);
				$.get("getDepartment.php?facCode="+facCode,function(data,status){
					if(status=="success")
					{
						
						$('#depChange').html("");
						$('#depChange').append("<option name='-1' value='-1' selected>กรุณาเลือกสาขา</option>");
						for(i=0; i<data.length ; i++)
						{
							$('#depChange').append("<option name="+data[i].depCode+" value="+data[i].depCode+">"+ data[i].depName+"</option>");
						}
						
					}else
					{
						alert('ERROR');
					}
				});
			});

			//รับค่า จาก hidden เพื่อดูว่า เบอร์มีจำนวนทั้งหมดกี่ row
			var i = $('#countTel').val();

			$('#addTel').click(function(){
				//ขึ้นแถวไหม
				i++;
				$('#myTable').append("<tr id='"+i+"'><td></td><td><input type='text' name='tel[]' id='tel' onkeypress='return chkNumber(event.charCode)'><u id='"+i+"' class='delTel' style='color:red'>X</u></td></tr>");
			});
			
			
			$(document).on('click','.delTel',function(){
				
				var bt_id = $(this).attr('id');
				txt_rowID = "#"+bt_id;
				$(txt_rowID).remove();
				
			});
			
			//------------
			$('#chkPassword').on('click',function(){
				
				if($(this).is(':checked'))
				{
					$('#password').attr('type','text');
				}else
				{
					$('#password').attr('type','password');
				}
			
			});

			$('#chkPassmail').on('click',function(){
				
				if($(this).is(':checked'))
				{
					$('#passmail').attr('type','text');
				}else
				{
					$('#passmail').attr('type','password');
				}
			
			});


//-----------
			
		});
		

		
		function chkData()
		{
			check = false;
			
			username = $('#username').val();
			password = $('#password').val();
			facCode = $('#facChange').val();
			depCode = $('#depChange').val();
			
			if(username.trim() != '' && password.trim() != '' && facCode !='-1' && depCode !='-1')
			{
				check = true;
			}else
			{
				if(facCode =='-1')
				{
					alert('กรุณาเลือกคณะ');
					$('#facChange').focus();

				}else
				{
					if(depCode =='-1')
					{
						alert('กรุณาเลือกสาขา');
						$('#depChange').focus();
					}else
					{
						if(username.trim() == '')
						{
							alert('กรุณากรอกรหัสบัญชี');
							$('#username').focus();
						}
						else
						{
							if(password.trim() == '')
							{	
								alert('กรุณากรอกรหัสผ่าน');
								$('#password').focus();
							}
						}
					}
				}
			}

			return check;
		}


		function chkNumber(digit)
		{
			chkTel = false;
			
			if(digit >=48 && digit <=57)
			{
				chkTel = true;
			}
			else
			{
				alert('กรุณากรอกเฉพาะตัวเลข');
			}
	
			return chkTel;
		}
	</script>

</head>
<body>
<?php
	
	$memCode = $memCode;
	
	//echo $memCode;

	require('connectDB.php');

	//ดูข้อมูลสมาชิก 
	$sqlSearchMem = "select * from member where memCode='$memCode';";
	$resultSearchMem = mysqli_query($con,$sqlSearchMem);
	$recnumSearchMem = mysqli_fetch_array($resultSearchMem);
	
	if($resultSearchMem == null)
	{
		echo "คำสั่งไม่ถูกต้อง";
	}

?>
	
	<center>
		<img src='img/hrm_3.jpg'>
	</center>

	<table id='tbLog' cellpadding='5' width='100%'>
		
		<tr align='right'>
			<td width='90%'>
				<?php echo "$memName $facName วิทยาเขตหาดใหญ่";  ?>
			</td>
			<td align='center'>
				<button id='signOut'>ออกจากระบบ</button>
			</td>
		</tr>
	</table>
	
	<!--- ส่วนข้อมูล   -->
	
	<table id='myTables' width='100%' cellspacing='10' cellpadding='5'>
		<tr>
			<td colspan='3'><a href='Tmain.php'> ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ > อาจารย์</a> > จัดการข้อมูลส่วนตัว</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<div align='center'>
					<h2>จัดการข้อมูลส่วนตัว</h2>
				</div>
	
	<form name='addMember' id='addMember' action='TEditQueryMem.php' method='POST' onsubmit='Javascript:return chkData()'>
		<table border='0' id='myTable' cellpadding='10' align='center'>			
			<tr>
				<td>กลุ่มผู้ใช้งาน</td>
				<td>
					
					<?php if($recnumSearchMem[3]=='1') echo "นักศึกษา";?>
					
					<?php if($recnumSearchMem[3]=='2') echo "อาจารย์";?>
					
					<?php if($recnumSearchMem[3]=='3') echo "เจ้าหน้าที่";?>
					
					<?php if($recnumSearchMem[3]=='4') echo "ผู้บริหาร";?>
				</td>
			</tr>
			
			<tr>
				<td>คณะ</td>
				<td>
					<select name='facCode' id='facChange' disabled>
						<option name='-1' value='-1' selected>กรุณาเลือกคณะ</option>
			
<?php
	//ต้องการคณะ
	$sqlFac = "select * from faculty;";
	$resultFac = mysqli_query($con,$sqlFac);
	//ตรวจสอบคำสั่งถูกไหม
	if($resultFac == null)
	{
		echo "คำสั่งผิด";
	}
	
	//เอาภาควิชาคนนี้ ไปหาว่า ภาควิชานี้อยู่ในคณะอะไร
	$sqlFacMem = "select * from department where depCode='$recnumSearchMem[7]'";
	$resultFacMem = mysqli_query($con,$sqlFacMem);
	$recnumFacMem = mysqli_fetch_array($resultFacMem);

	if($resultFacMem == null)
	{
		echo "คำสั่งผิด";
	}
	if($recnumFacMem =='0')
	{
		echo "ไม่พบข้อมูล";
	}
	
	//แสดงผลลัพธ์
	while($recnumFac = mysqli_fetch_array($resultFac))
	{
?>
		<option name=<?php echo $recnumFac[0]; ?> value=<?php echo $recnumFac[0]; ?> <?php if($recnumFac[0]==$recnumFacMem[2]) echo "selected"; ?>><?php echo $recnumFac[1];?></option>

<?php
	}
?>
					</select>
				</td>
			</tr>
			
			<tr>
				<td id='dep'>สาขา</td>
				<td>
					<select name='depCode' id='depChange' disabled>
						<option name='-1' value='-1' selected>กรุณาเลือกสาขา</option>
						
<?php
	
	$sqlShowDep = "select * from department where facCode='$recnumFacMem[2]';";
	$resultShowDep = mysqli_query($con,$sqlShowDep);
	
	if($resultShowDep == null)
	{
		echo "คำสั่งผิด";
	}
	
	while($recnumShowDep = mysqli_fetch_array($resultShowDep))
	{
?>
		<option name=<?php echo $recnumShowDep[0]; ?> value=<?php echo $recnumShowDep[0]; ?> <?php if($recnumShowDep[0]==$recnumSearchMem[7]) echo "selected"; ?>><?php echo $recnumShowDep[1]; ?></option>
<?php
	}
?>

					</select>						
				</td>
			</tr>
			<tr>
				<td>รหัสบัญชี</td>
				<td>
					<input type='text' name='username' id='username' value=<?php echo $recnumSearchMem[1]; ?> disabled>
				</td>
			</tr>
	
			<tr>
				<td>รหัสผ่าน</td>
				<td>
					<input type='password' name='password' id='password' value=<?php echo $recnumSearchMem[2];  ?>>
					<input type='checkbox' id='chkPassword'>แสดง
				</td>
			</tr>
			
			<tr>
				<td for='name'>ชื่อ-นามสกุล</td>
				<td>
				<!-- ต้องการชื่อ และนามสกุล ต้องเขียนด้วย php -->
					<?php
						echo "<input type='text' name='name' id='name' value='".$recnumSearchMem[4]."'>";	
					?>
				</td>
			</tr>
			
			<tr>
				<td for='email'>อีเมล์</td>
				<td>
					<input type='email' name='email' id='email' value=<?php echo $recnumSearchMem[5]; ?>>
					&nbsp;&nbsp;Access the&nbsp;
					<a href='https://myaccount.google.com/lesssecureapps?pli=1' target='_blank'>URL1</a>,
					<a href='https://accounts.google.com/b/0/DisplayUnlockCaptcha' target='blank'>URL2</a>
				</td>
			</tr>

			<tr>
				<td for='passmail'>รหัสผ่านอีเมล์</td>
				<td>
					<input type='password' name='passmail' id='passmail' value=<?php echo $recnumSearchMem[6];  ?>>
					<input type='checkbox' id='chkPassmail'>แสดง
				</td>
			</tr>

<!---- ส่วนของเบอร์ -->
			
<?php
	
	$sqlSearchTel = "select * from telephone where memCode='$memCode ';";
	$resultSearchTel = mysqli_query($con,$sqlSearchTel);
	
	if($resultSearchTel == null)
	{
		echo "คำสั่งผิด";
	}
	
	//ตรวจสอบก่อนว่า มีข้อมูลเบอร์โทรของคนนี้ถูกใส่ไปไหม
	$sqlNumRow = mysqli_num_rows($resultSearchTel);
	
	$i = 0;//ใส่เพื่อบอก row ที่ใช้ไปแล้ว เริ่มจาก 0,1,2,3,4,... เวลากดปุ่มเพิ่ม จะได้ ต่อเป็น 5
			

	if($sqlNumRow == 0)
	{
		echo "<tr>
					<td>เบอร์โทร</td>
					<td>
						<input type='text' name='tel[]' id='tel' onkeypress='return chkNumber(event.charCode)'>
						<u id='addTel' style='color:blue'>เพิ่มเบอร์</u>
					</td>
				</tr>";	
	}
	else{

		while($recnumSearchTel = mysqli_fetch_array($resultSearchTel))
		{
			if($recnumSearchTel[3]=='0')
			{
				echo "<tr>
						<td>เบอร์โทร</td>
						<td>
							<input type='text' name='tel[]' id='tel' onkeypress='return chkNumber(event.charCode)'   value='".$recnumSearchTel[1]."'>
							<u id='addTel' style='color:blue'>เพิ่มเบอร์</u>
						</td>
					</tr>";		
			}else
			{
				echo "<tr id='".$recnumSearchTel[3]."'><td></td><td><input type='text' name='tel[]' id='tel' onkeypress='return chkNumber(event.charCode)'   value='".$recnumSearchTel[1]."'><u id='".$recnumSearchTel[3]."' class='delTel' style='color:red'>X</u></td></tr>";

				$i++;
			}
		}
	}

?>

<!--- ส่วนของเบอร์ -->
		</table>
		<br><br>
		
		<input type='hidden' name='depCodes' id='depCodes'>
		<input type='hidden' id='countTel' value=<?php echo $i; ?>>
		<input type='hidden' name='memCode' value=<?php echo $recnumSearchMem[0]; ?>>
		<input type='submit' id='submit' value='บันทึกข้อมูลส่วนตัว'>&nbsp;
	</form>
			</td>
		</tr>
	</table>
	<br><br>
</body>
</html>
