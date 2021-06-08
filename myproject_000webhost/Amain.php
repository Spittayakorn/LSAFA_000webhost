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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
			<td colspan='3'>ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ > เจ้าหน้าที่ห้องปฏิบัติการ</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<table id='fixTB' align='center' cellpadding='20' border='1'>
					<tr>		
						<td bgColor="#a0a0a0" style="color:white;">จัดการข้อมูลขอใช้ห้องปฏิบัติการ</td>
					</tr>
					<tr valign='top'>		
						<td height='200'>
							<ul>
								<a href='AManageAnalysis.php?pageNo=1'>
									<li style='margin-bottom:10px'>
										จัดการรายการค่าวิเคราะห์
									</li>
								</a>
								<a href='AManageSimple.php?pageNo=1'>
									<li style='margin-bottom:10px'>
										จัดการชนิดตัวอย่าง
									</li>
								</a>
								<a href='AManageObj.php?pageNo=1'>
									<li style='margin-bottom:10px'>
										จัดการประเภทวัตถุประสงค์
									</li>
								</a>
								
								<a href='AManageCat.php?pageNo=1'>
									<li style='margin-bottom:10px'>
										จัดการประเภทนักวิจัย
									</li>
								</a>

								<a href='AManageServiceCharge.php'>
									<li style='margin-bottom:10px'>
										จัดการอัตราค่าบริการ
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
						<td bgColor="#a0a0a0" style="color:white;">ขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์</td>
					</tr>
					<tr valign='top'>		
						<td height='200'>
							<ul>
								<a href='AManageLab.php'>
									<li style='margin-bottom:10px'>
										ขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์
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
						<td bgColor="#a0a0a0" style="color:white;">จัดการสมาชิก</td>
					</tr>
					<tr valign='top'>		
						<td height='200'>
							<ul>
								<a href='AManageMember.php'>
									<li style='margin-bottom:10px'>
										จัดการสมาชิก
									</li>
								</a>
							
								<a href='AEditProfile.php'>
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
		<tr>
			
			<td>
				<table id='fixTB' align='center' cellpadding='20' border='1'>
					<tr>		
						<td bgColor="#a0a0a0" style="color:white;">เอกสารขอใช้ห้องปฏิบัติการจากอาจารย์</td>
					</tr>
					<tr valign='top'>		
						<td height='200'>
							<ul>
								<a href='AGetLabT.php?statusLab=0'>
									<li style='margin-bottom:10px'>
										เอกสารขอใช้ห้องปฏิบัติการจากอาจารย์ที่อนุมัติ
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
						<td bgColor="#a0a0a0" style="color:white;">เอกสารขอใช้ห้องปฏิบัติการจากผู้บริหาร</td>
					</tr>
					<tr valign='top'>		
						<td height='200'>
							<ul>
								<a href='AGetLabH.php?statusLab=1&labStatus=0'>
									<li style='margin-bottom:10px'>
										เอกสารอนุมัติ/ไม่อนุมัติขอใช้ห้องปฏิบัติการจากผู้บริหาร
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
						<td bgColor="#a0a0a0" style="color:white;">รายงานต่าง ๆ</td>
					</tr>
					<tr valign='top'>		
						<td height='200'>
							<ul>
							<?php
								
								echo '<a href="AExpenseReport.php?sDate=1998-01-01&lDate='.date("Y-m-d").'&typeG=line">';
							?>
								
									<li style='margin-bottom:10px'>
										รายงานค่าใช้จ่าย
									</li>
								</a>
							</ul>
							<ul>
							<?php
								
								echo '<a href="ANumberLabReport.php?sDate=1998-01-01&lDate='.date("Y-m-d").'&typeG=line">';
							?>
									<li style='margin-bottom:10px'>
										รายงานจำนวนเอกสารขอใช้ห้องปฏิบัติการแบ่งตามประเภทนักวิจัย
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