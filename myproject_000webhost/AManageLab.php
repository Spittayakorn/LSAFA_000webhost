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
	<title>จัดการรายการขอใช้ห้องปฏิบัติการ</title>
	<meta charset='UTF-8'>
		
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

		#sendMail {
			background-color: #F389EF;
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
		
		#editLab {
			background-color: #73EAA8;
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

		#delLab {
			background-color: #CD1039;
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

		#print {
			background-color: #FFC81E;
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

		#status {
			background-color: blue;
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


		#myTables {
			border: 1px solid black;
			border-collapse: separate;
			border-radius: 5px;
			padding:10px;
		}

		#myTable{
			border:none;
		}

	</style>

	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
		
		$(document).ready(function(){
			
			//----------------------------------------
			
			$('#signOut').click(function(){
				window.open('logout.php','_self');
			});

			$('#tbAnalysis').on('click','#editLab',function(){
				
				row = $(this).attr('class');
				labCodeTxt = '#'+row;
				labCode = $(labCodeTxt).attr('class');
				
				window.open('AEditLab.php?labCode='+labCode,'_self');

			});

			$('#tbAnalysis').on('click','#delLab',function(){

				delItem = confirm('ต้องการลบข้อมูลนี้หรือไม่');
				if(delItem)
				{	
					row = $(this).attr('class');
					labCodeTxt = '#'+row;
					labCode = $(labCodeTxt).attr('class');
					
					window.open('ADelLab.php?labCode='+labCode,'_self');
				
				}
			});	
			

			$('#tbAnalysis').on('click','#print',function(){
				
				row = $(this).attr('class');
				labCodeTxt = '#'+row;
				labCode = $(labCodeTxt).attr('class');
				
				window.open('APrintLab.php?labCode='+labCode,'_self')

			});

			$('#tbAnalysis').on('click','#sendMail',function(){
				
				sendItem = confirm('ท่านต้องการส่งอีเมล์นี้หรือไม่');

				if(sendItem)
				{
					
					row = $(this).attr('class');
					labCodeTxt = '#'+row;
					labCode = $(labCodeTxt).attr('class');
					dates = $('#dates').val();
					
					window.open('ASendmail.php?labCode='+labCode+'&dates='+dates,'_self')
				
				}

			});
			
			//-----------ปุ่ม ตรวจสอบสถานะ
			$('#tbAnalysis').on('click','#status',function(){
				
				row = $(this).attr('class');
				labCodeTxt = '#'+row;
				labCode = $(labCodeTxt).attr('class');
				
				window.open('AShowStatus.php?labCode='+labCode,'_self');

			});

			//------------ตรวจสอบสถานะ
			
			//setInterval ให้ดึงค่าทุก ๆ วิ
			setInterval(function(){
				
				$.get("getTime.php",function(data,status){
					if(status=='success')
					{
						$('#dates').val(data.years+"-"+data.month+"-"+data.day+" "+data.hour+":"+data.minute+":"+data.second);
					}
										
				});
			},100);
			
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
			<td colspan='3'><a href='Amain.php'> ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ > เจ้าหน้าที่ห้องปฏิบัติการ</a> > รายการแบบฟอร์มขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์</td>
		</tr>

		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<div align='center'>
					<h2>จัดการรายการขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์</h2><input type='hidden' id='dates'>
				</div>
				
				<table  id='tbAnalysis' align='center' cellpadding='5' width='100%' border='1' style='border:none;'>
					<tr align='right'>
						<td colspan='5'><a href='AAddlab.php'>ขอใช้ห้องปฏิบัติการ</a></td>
					</tr>
					
					<tr bgColor='b4b4b4'>
						<th width='7%'>ลำดับที่</th>
						<th width='20%'>ชื่อผู้ขอใช้ / ชื่องานวิจัย</th>
						<th width='10%'>เลขที่.ปีงบ</th>
						<th width='20%'>วัน/เดือน/ปี</th>
						<th colspan='2' width='40%'>จัดการแบบฟอร์ม</th>
						<!--<th>รหัสเอกสาร</th>-->
					</tr>
		
					<?php
						require('connectDB.php');

						$sqlShowAnaList = "select * from lab where memCode='$memCode'";
						$resultShowAnaList = mysqli_query($con,$sqlShowAnaList);

						if($resultShowAnaList==null)
						{
							echo "คำสั่งผิด";
						}
						
						$numRowShowAnalist = mysqli_num_rows($resultShowAnaList);
						//---
						$perPage = 10;
						
						if(isset($_REQUEST['pageNo']))
						{
							$pageNo = $_REQUEST['pageNo'];
						}else
						{
							$pageNo = 1;
						}
						
						echo "<input type='hidden' id='page' value='$pageNo'>";
						$nextPage = $pageNo+1;
						$previousPage = $pageNo-1;

						$pageStart = ($perPage*$pageNo)-$perPage;

						if($pageStart>=$numRowShowAnalist)
						{
							$totalPage = 1;
						
						}else
						{
							if(($numRowShowAnalist%$perPage)==0)
							{
								$totalPage = ($numRowShowAnalist/$perPage);
							}else
							{
								$totalPage = ($numRowShowAnalist/$perPage)+1;
								$totalPage = (int)$totalPage;
							}
						}
						
						
						$sqlShowAnaList .= " order by labDate desc limit $pageStart,$perPage;";
						$resultShowAnaList = mysqli_query($con,$sqlShowAnaList);

						if($resultShowAnaList==null)
						{
							echo "คำสั่งผิด";
						}
						
						//---
						$numRowReal = mysqli_num_rows($resultShowAnaList);
						if($numRowReal == 0)
						{
							if($pageNo =='1')
							{
							}else
							{
								echo "<script>
									window.open('AManageLab.php?pageNo=$previousPage ','_self');
								</script>";
							}
							
						}
						if($numRowShowAnalist == '0')
						{
							echo "<tr align='center' bgColor='EBF5FF'><td colspan='5'>กรุณาเพิ่มขอใช้ห้องปฏิบัติการ</td></tr>";
						}
						
						$s = $numRowShowAnalist-$pageStart+1;
						
						while($recnumSearchLab = mysqli_fetch_array($resultShowAnaList))
						{
							$s--;
							
						?>
						<tr>
							<?php
								
								$subText = $recnumSearchLab[9];

								if(mb_strlen($subText,'utf-8') > 20)
								{
									$subText = mb_strimwidth($recnumSearchLab[9],0,20)."...";	
								}
							
							echo "<td align='center'><div id='$s' class='$recnumSearchLab[0]'>$s</div></td>
							<td><span title='$recnumSearchLab[9]'>$subText</span></td>
							<td align='center'>$recnumSearchLab[2].$recnumSearchLab[3]</td>
							<td align='center'>$recnumSearchLab[4]</td>
							<td style='text-align:center;'>";

							if($recnumSearchLab[21]=='1' && $recnumSearchLab[16]=='2')
							{
								echo "<button id='delLab' class='$s'>ลบ</button>&nbsp;&nbsp;|&nbsp;
									<button id='editLab' class='$s' style='background-color: #e7e7e7;'  disabled>แก้ไข</button>&nbsp;&nbsp;|&nbsp;
									<button id='sendMail' class='$s' style='background-color: #e7e7e7;'  disabled>ส่งเอกสาร</button>&nbsp;&nbsp;|&nbsp;";
								
							}else
							{
								
								if(($recnumSearchLab[25]=='1'&& $recnumSearchLab[16]=='0') || ($recnumSearchLab[25]=='1'&& $recnumSearchLab[16]=='1'))
								{
									echo "<button id='delLab' class='$s' style='background-color: #e7e7e7;'  disabled>ลบ</button>&nbsp;&nbsp;|&nbsp;
									<button id='editLab' class='$s' style='background-color: #e7e7e7;'  disabled>แก้ไข</button>&nbsp;&nbsp;|&nbsp;
									<button id='sendMail' class='$s' style='background-color: #e7e7e7;'  disabled>ส่งเอกสาร</button>&nbsp;&nbsp;|&nbsp;";		
						
								
								}else
								{
									echo "<button id='delLab' class='$s'>ลบ</button>&nbsp;&nbsp;|&nbsp;
											<button id='editLab' class='$s'>แก้ไข</button>&nbsp;&nbsp;|&nbsp;
											<button id='sendMail' class='$s'>ส่งเอกสาร</button>&nbsp;&nbsp;|&nbsp;";
								}
								
							}
						?>
								
								<button id='print' class=<?php echo $s; ?>>พิมพ์เอกสาร</button>&nbsp;&nbsp;|&nbsp;
								<button id='status' class=<?php echo $s; ?>>ตรวจสอบข้อมูล</button>
							</td>		
						</tr>	
							
					<?php	
						}
					?>
				</table>
			</td>
		</tr>
		<!--- -->
		<tr>
			<td align='center'>
				ข้อมูลทั้งหมด&nbsp;<?php echo $numRowShowAnalist; ?>&nbsp;รายการ&nbsp;หน้าที่ <?php echo $pageNo?>&nbsp;จาก&nbsp;
				<?php

				if($previousPage)
				{
					echo "<a href='AManageLab.php?pageNo=$previousPage '><<</a>";
				}
				for($i=1;$i<=$totalPage;$i++)
				{
					$page1 = $pageNo-2;
					$page2 = $pageNo+2;
					if($i!=$pageNo && $i>=$page1 && $i <= $page2)
					{
						echo "[&nbsp;<a href='AManageLab.php?pageNo=$i'>$i</a>&nbsp;]";
					}else
					{
						if($i==$pageNo)
						{
							echo "&nbsp;$i&nbsp;";
						}
						
					}
				}
				
				if($pageNo != $totalPage)
				{
					echo "<a href='AManageLab.php?pageNo=$nextPage'>>></a>";
				}
				?>
			</td>
		</tr>
		
		<!--- -->
	</table>
	<br><br>
</body>
</html>