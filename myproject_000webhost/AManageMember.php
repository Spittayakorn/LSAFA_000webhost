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
	<title>จัดการรายการจัดการสมาชิก</title>
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

		#btDelAna {
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
		
		#btEditAna {
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

		#myTable {
			border: 1px solid black;
			border-collapse: separate;
			border-radius: 5px;
			padding:10px;
		}


	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
		$(document).ready(function(){

			$('#signOut').click(function(){
				window.open('logout.php','_self');
			});
			
			$('#tbAnalysis').on('click','#btEditAna',function(){
				
				//ดูรหัสในตารางแต่ละแถวที่เลือก
				analysis = $(this).closest('tr');
				anaCode = analysis.find('td:eq(0)').text();
				anaCodeTxt = '#'+anaCode;
				anaCode = $(anaCodeTxt).attr('class'); 		
				page= $('#page').val();
					
				window.open("AEditMember.php?memCode="+anaCode+'&pageNo='+page,'_self');
					
			});

			$('#tbAnalysis').on('click','#btDelAna',function(){
			
				delItem = confirm('ต้องการลบข้อมูลนี้หรือไม่');
				if(delItem)
				{
				
					//ดูรหัสในตารางแต่ละแถวที่เลือก
					analysis = $(this).closest('tr');
					anaCode = analysis.find('td:eq(0)').text();
					anaCodeTxt = '#'+anaCode;
					anaCode = $(anaCodeTxt).attr('class'); 		
					page= $('#page').val();
					
					window.open("ADelMember.php?anaCode="+anaCode+'&pageNo='+page,'_self');
					
				}
				
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
			<td colspan='3'><a href='Amain.php'> ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ > เจ้าหน้าที่ห้องปฏิบัติการ</a> > จัดการสมาชิก</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<div align='center'>
					<h2>จัดการสมาชิก</h2>
				</div>

				<table border='1' id='tbAnalysis' align='center' cellpadding='10' width='100%'>
					<tr align='right'>
						<td colspan='6'><a href='AAddMember.php'>เพิ่มสมาชิก</a></td>
					</tr>
					
					<tr>
						<th width='7%'>ลำดับที่</th>
						<th width='20%'>ชื่อสมาชิก</th>
						<th width='10%'>สถานะสมาชิก</th>
						<th width='20%'>ภาควิชา</th>
						<th width='20%'>คณะ</th>
						<th width='20%'>จัดการสมาชิก</th>
					</tr>
		
					<?php
						require('connectDB.php');

						$sqlShowAnaList = "select memCode,name,facName,depName,memlevel from member,department,faculty where member.depCode = department.depCode and department.facCode=faculty.facCode";
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
						
						
						$sqlShowAnaList .= " order by memLevel desc limit $pageStart,$perPage;";
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
									window.open('AManageMember.php?pageNo=$previousPage ','_self');
								</script>";
							}
							
						}

						if($numRowShowAnalist == '0')
						{
							echo "<tr align='center' bgColor='EBF5FF'><td colspan='3'>กรุณาเพิ่มสมาชิก</td></tr>";
						}
						$level = '';
						$s = $numRowShowAnalist-$pageStart+1;

						while($recnumShowAnalist = mysqli_fetch_array($resultShowAnaList))
						{
							switch($recnumShowAnalist[4])
							{
								case '1' : $level = 'นักศึกษา'; break;
								case '2' : $level = 'อาจารย์'; break;
								case '3' : $level = 'เจ้าหน้าที่'; break;
								case '4' : $level = 'ผู้บริหาร'; break;
							}

							$s--;

							if($recnumShowAnalist[0] ==$memCode )
							{
								echo "<tr>
									<td><div id = '$s' class='$recnumShowAnalist[0]' align='center'>$s</div></td>
									<td>$recnumShowAnalist[1]</td>
									<td>$level</td>
									<td>$recnumShowAnalist[3]</td>
									<td>$recnumShowAnalist[2]</td>
									<td style='text-align:center;'>
										<button id='btDelAna' disabled style='background-color:#e7e7e7;'>ลบสมาชิก</button>&nbsp;&nbsp;|&nbsp;
										<button id='btEditAna'>แก้ไขสมาชิก</button>
									</td>
								</tr>";
							}else
							{
								echo "<tr>
									<td><div id = '$s' class='$recnumShowAnalist[0]' align='center'>$s</div></td>
									<td>$recnumShowAnalist[1]</td>
									<td>$level</td>
									<td>$recnumShowAnalist[3]</td>
									<td>$recnumShowAnalist[2]</td>
									<td style='text-align:center;'>
										<button id='btDelAna' >ลบสมาชิก</button>&nbsp;&nbsp;|&nbsp;
										<button id='btEditAna'>แก้ไขสมาชิก</button>
									</td>
								</tr>";
							}
								
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
					echo "<a href='AManageMember.php?pageNo=$previousPage '><<</a>";
				}
				for($i=1;$i<=$totalPage;$i++)
				{
					$page1 = $pageNo-2;
					$page2 = $pageNo+2;
					if($i!=$pageNo && $i>=$page1 && $i <= $page2)
					{
						echo "[&nbsp;<a href='AManageMember.php?pageNo=$i'>$i</a>&nbsp;]";
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
					echo "<a href='AManageMember.php?pageNo=$nextPage'>>></a>";
				}
				?>
			</td>
		</tr>
		<!--- -->
	</table>
	<br><br>
</body>
</html>