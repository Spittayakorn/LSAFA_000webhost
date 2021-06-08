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
	<title>ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ - ภาควิชาสัตวศาสตร์ คณะทรัพยากรธรรมชาติ </title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
			border:1px solid black;
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

		#myTable {
			border: 1px solid black;
			border-collapse: separate;
			border-radius: 5px;
			padding:10px;
		}
		
		#fixTB,#fixTB td {
			table-layout: fixed;
			width : 100%;
			border-collapse: separate;
			border-radius: 20px;
			border:0px;
		}
		
	</style>

	<script>
		$(document).ready(function(){
			
			$('#signOut').click(function(){
				window.open('logout.php','_self');
			});
		});
	
	</script>
</head>
<body>
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

	<table id='myTable' width='100%' cellspacing='10' cellpadding='5'>
		<tr>
			<td colspan='3'>ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ > อาจารย์</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<table id='fixTB' align='center' cellpadding='20' border='1'>
					<tr>		
						<td bgColor="#a0a0a0" style="color:white;">ขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์</td>
					</tr>
					<tr valign='top'>		
						<td height='200'>
							<ul>
								<a href="TManageLab.php?statusLab=0">
									<li style='margin-bottom:10px'>
										เอกสารขอใช้ห้องปฏิบัติการจากนักศึกษา
									</li>
								</a>
							</ul>
						</td>
					</tr>	
				</table>
			</td>
			<td>
				<table id='fixTB' align='center' cellpadding='20' border='1'>
					<tr>		
						<td bgColor="#a0a0a0" style="color:white;">จัดการข้อมูลส่วนตัว</td>
					</tr>
					<tr valign='top'>		
						<td height='200'>
							<ul>
								
								<a href='TEditMember.php'>
									<li style='margin-bottom:10px'>
										จัดการข้อมูลส่วนตัว
									</li>
								</a>
							</ul>
						</td>
					</tr>	
				</table>
			</td>
		</tr>
	</table>
	<br><br>

</body>
</html>