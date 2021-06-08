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

<!DOCTYPE html>
<html>
<head>
	<title>รายการแบบฟอร์มขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์</title>
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
		
		#lookLab {
			background-color: #DBAC;
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

		

		#repeatLab
		{
			background-color: #FFA2AD;
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

		#printFinish
		{
			background-color: #FFA01E;
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

		.innerBlock{
			
			text-align:center;
		
		}

	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
		
		$(document).ready(function(){

			//----------------------------------------
			
			$('#signOut').click(function(){
				window.open('logout.php','_self');
			});
			

			$('#myTable').on('click','#lookLab',function(){
				
				row = $(this).attr('class');
				labCodeTxt = '#labCodeA'+row;
				labCode = $(labCodeTxt).val();
				statusLab = $('#statusLab').val(); 
				labStatus = $('#labStatus').val();
				pageNo = $('#page').val();
				
				window.open('AShowLabH.php?labCode='+labCode+'&statusLab='+statusLab+"&labStatus="+labStatus+'&pageNo='+pageNo,'_self');

			});	

			
			$('#myTable').on('click','#print',function(){
				
				row = $(this).attr('class');
				labCodeTxt = '#labCodeA'+row;
				labCode = $(labCodeTxt).val();
				
				window.open('HPrintLab.php?labCode='+labCode,'_self');

			});

			$('#myTable').on('click','#repeatLab',function(){
				
				row = $(this).attr('class');
				labCodeTxt = '#labCodeA'+row;
				labCode = $(labCodeTxt).val();
				statusLab = $('#statusLab').val();
				labStatus = $('#labStatus').val(); 
				pageNo = $('#page').val();

				window.open('AManageRepeatLab.php?labCode='+labCode+'&statusLab='+statusLab+"&labStatus="+labStatus+'&pageNo='+pageNo,'_self');

			});
			
			$('#myTable').on('click','#printFinish',function(){
				
				row = $(this).attr('class');
				labCodeTxt = '#labCodeA'+row;
				labCode = $(labCodeTxt).val();
				statusLab = $('#statusLab').val();
				labStatus = $('#labStatus').val(); 
				pageNo = $('#page').val();

				window.open('APrintInvoice.php?labCode='+labCode+'&statusLab='+statusLab+"&labStatus="+labStatus+'&pageNo='+pageNo,'_self');

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
	
	<table id='myTables' width='100%' cellspacing='10' cellpadding='5' border='0'>
		<tr>
			<td colspan='3'><a href='Amain.php'> ระบบขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์ > เจ้าหน้าที่ห้องปฏิบัติการ</a> > เอกสารที่อนุมัติขอใช้ห้องปฏิบัติการจากผู้บริหาร</td>
		</tr>
		
		<tr>
			<td>

			<?php
				$statusLab = $_REQUEST['statusLab'];
				$labStatus = $_REQUEST['labStatus'];

				echo "<input type='hidden' id='statusLab' value='$statusLab' readonly>
					<input type='hidden' id='labStatus' value='$labStatus' readonly>
				";
				
			?>
				<table style='table-layout: fixed;border:none;' width='100%' border='0' cellpadding='10'>
					<tr>
						<td>สถานะแบบฟอร์ม : <a href='AGetLabH.php?statusLab=1&labStatus=0' align='center'>อนุมัติ</a>&nbsp;/&nbsp;<a href='AGetLabH.php?statusLab=2&labStatus=1' align='center'>ไม่อนุมัติ</a>&nbsp;/&nbsp;<a href='AGetLabH.php?statusLab=1&labStatus=1' align='center'>สิ้นสุดการอนุมัติ</a></td>
						<td></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<div align='center'>
					<h2>รายการแบบฟอร์มขอใช้ห้องปฏิบัติการวิเคราะห์อาหารสัตว์</h2>
				</div>


	<table id='myTable' align='center' cellpadding='5' border='0' width='100%'>
		
		<tr bgColor='b4b4b4'>
			<th width='7%'>ลำดับที่</th>
			<th width='20%'>ชื่อผู้ขอใช้ / ชื่องานวิจัย</th>
			<th width='7%'>เลขที่.ปีงบ</th>
			<th width='10%'>ปี/เดือน/วัน</th>
			<th width='7%'>สถานะเอกสาร</th>
			<th colspan='2' width='49%'>จัดการแบบฟอร์ม</th>
			<!--<th>รหัสเอกสาร</th>-->
		</tr>


		<?php
			require('connectDB.php');

			//-------------------------
			$sqlShowAnaList = "select * from lab where offCode='$memCode' and send='1' and (teaStatus='1' or teaStatus='0') and  (offStatus='1' or offStatus='0' ) and boStatus='$statusLab'and labStatus='$labStatus' ";
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
						
			//---
			
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
							window.open('AGetLabH.php?statusLab=$statusLab&labStatus=$labStatus&pageNo=$previousPage','_self');
						  </script>";
				}
							
			}
			if($numRowShowAnalist == '0')
			{
				echo "<tr align='center' bgColor='EBF5FF'><td colspan='6'>ไม่พบข้อมูล</td></tr>";
			}
						
			$s = $numRowShowAnalist-$pageStart+1;
			
			while($recnumSearchLab = mysqli_fetch_array($resultShowAnaList))
			{
				$s--;
				$text ='';				
				
				if($s%2==0)
				{
					$text .= "<tr bgColor='#D2FFD2'>"; 	
				}
				else
				{
					$text .= "<tr bgColor='#F0FFF0'>";
				}

				$statusTxt = 'รออนุมัติ';
				$colorStatusTxt = 'black';

				if($recnumSearchLab[16] == '1')
				{
					$statusTxt = 'อนุมัติ';
					$colorStatusTxt = 'green';
				}

				if($recnumSearchLab[16] == '2')
				{
					$statusTxt = 'ไม่อนุมัติ';
					$colorStatusTxt = 'red';
				}

				$subText = $recnumSearchLab[9];

				if(mb_strlen($subText,'utf-8') > 20)
				{
					$subText = mb_strimwidth($recnumSearchLab[9],0,20)."...";	
				}
	
				echo	$text."
						<td align='center'>$s</td>
						<td><span title='$recnumSearchLab[9]'>$subText</span></td>
						<td align='center'>$recnumSearchLab[2].$recnumSearchLab[3]</td>
						<td align='center'>$recnumSearchLab[4]</td>";
						
					if($statusLab=='1' && $labStatus=='1')
					{
						echo "<td style='color:green;' align='center'>เสร็จสิ้น</td>";
					}else
					{
						echo "<td style='color:".$colorStatusTxt.";' align='center'>".$statusTxt."</td>";
					}
							
						
				
				echo	"		
						<td class='innerBlock'>
							<button id='lookLab' class='$s'>ตรวจสอบข้อมูล</button>&nbsp;&nbsp;|&nbsp;
							<button id='print' class='$s'>พิมพ์เอกสาร</button>
							
						";	
				
						if($statusLab=='1')
						{

							if($labStatus=='1')
							{
								echo "&nbsp;&nbsp;|&nbsp;
									<button id='repeatLab' class='$s' disabled style='background-color:#e7e7e7;'>วิเคราะห์เพิ่มเติม</button>&nbsp;&nbsp;|&nbsp;
									<button id='printFinish' class='$s'>พิมพ์ใบแจ้งหนี้</button>
									
									";

							}else
							{
								echo "&nbsp;&nbsp;|&nbsp;
									<button id='repeatLab' class='$s'>วิเคราะห์เพิ่มเติม</button>&nbsp;&nbsp;|&nbsp;
									<button id='printFinish' class='$s'>พิมพ์ใบแจ้งหนี้</button>
							";
							}
							
						}
						
						if($statusLab=='2')
						{
							if($labStatus=='1')
							{
								echo "
								&nbsp;&nbsp;|&nbsp;
								<button id='repeatLab' class='$s' disabled style='background-color:#e7e7e7;'>วิเคราะห์เพิ่มเติม</button>&nbsp;&nbsp;|&nbsp;<button id='printFinish' disabled style='background-color:#e7e7e7;'  class='$s'>พิมพ์ใบแจ้งหนี้</button>
								";
							}
						}

				echo	"	
						</td>
						
						<td>
							<input type='hidden' id='labCodeA$s' value='$recnumSearchLab[0]' readonly>
							<input type='hidden' id='sendYet$s' value='$recnumSearchLab[25]' readonly>
						</td>
					</tr>";
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
					echo "<a href='AGetLabH.php?statusLab=$statusLab&labStatus=$labStatus&pageNo=$previousPage'><<</a>";
				}
				for($i=1;$i<=$totalPage;$i++)
				{
					$page1 = $pageNo-2;
					$page2 = $pageNo+2;
					if($i!=$pageNo && $i>=$page1 && $i <= $page2)
					{
						echo "[&nbsp;<a href='AGetLabH.php?statusLab=$statusLab&labStatus=$labStatus&pageNo=$i'>$i</a>&nbsp;]";
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
					echo "<a href='AGetLabH.php?statusLab=$statusLab&labStatus=$labStatus&pageNo=$nextPage'>>></a>";
				}
				?>
			</td>
		</tr>
		
		<!--- -->

	</table>
	<br><br>			
</body>
</html>